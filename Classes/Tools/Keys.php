<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 15:22
 */

namespace SUDHAUS7\Guard7\Tools;

use SUDHAUS7\Guard7\KeyNotReadableException;
use SUDHAUS7\Guard7\WrongKeyPassException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

class Keys
{
    
    
    /**
     * @param \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $obj
     * @param bool $checkFEuser
     * @param array $aPubkeys
     * @return array
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public static function collectPublicKeysForModel(\TYPO3\CMS\Extbase\DomainObject\AbstractEntity $obj, $checkFEuser = false, $aPubkeys = [])
    {
        $class = \get_class($obj);
        $table = Helper::getClassTable($class);
        $encodeStorage = GeneralUtility::makeInstance(AddLoggedInFrontendUserPublicKeySingleton::class);
    
        if (!$checkFEuser && $encodeStorage->has($obj)) {
            $checkFEuser = true;
            $encodeStorage->remove($obj);
        }
        
        return self::collectPublicKeys($table, (int)$obj->getUid(), (int)$obj->getPid(), $checkFEuser, $aPubkeys);
    }
    
    /**
     * @param null $table
     * @param mixed $uid
     * @param int $pid
     * @param bool $checkFEuser
     * @param array $aPubkeys
     *
     * @return array
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public static function collectPublicKeys($table = null, $uid = 0, $pid = 0, $checkFEuser = false, $aPubkeys = [])
    {

        /** @var Dispatcher $signalSlotDispatcher */
        $signalSlotDispatcher = GeneralUtility::makeInstance(Dispatcher::class);
        
        $confArr = Helper::getExtensionConfig();
        $pubKeys = [];
    
        // Signal Global
        $keysFromSignalslot = [];
        list($keysFromSignalslot) = $signalSlotDispatcher->dispatch(__CLASS__, 'global', [$keysFromSignalslot,$uid,$pid]);
       
        
        // Signal Name by table for example: collectPublicKeys_fe_users
        list($keysFromSignalslot) = $signalSlotDispatcher->dispatch(__CLASS__, __FUNCTION__.'_'.$table, [$keysFromSignalslot,$uid,$pid]);
        
        if (!empty($keysFromSignalslot)) {
            foreach ($keysFromSignalslot as $key) {
                $pubKeys[self::getChecksum($key)] = $key;
            }
        }
        if (!empty($aPubkeys)) {
            foreach ($aPubkeys as $key) {
                $pubKeys[self::getChecksum($key)] = $key;
            }
        }
        if (!empty($confArr['masterkeypublic'])) {
            $checksum = self::getChecksum($confArr['masterkeypublic']);
            $pubKeys[$checksum] = $confArr['masterkeypublic'];
        }
        if ($pid > 0) {
            $tskeys = Helper::getTsPubkeys($pid, $table);
            foreach ($tskeys as $key) {
                $pubKeys[self::getChecksum($key)] = $key;
            }
        }
        if ($checkFEuser && isset($GLOBALS['TSFE']) && $GLOBALS['TSFE']->loginUser) {
            if (isset($GLOBALS['TSFE']->fe_user->user['tx_guard7_publickey']) && !empty($GLOBALS['TSFE']->fe_user->user['tx_guard7_publickey'])) {
                $pubKeys[self::getChecksum($GLOBALS['TSFE']->fe_user->user['tx_guard7_publickey'])] = $GLOBALS['TSFE']->fe_user->user['tx_guard7_publickey'];
            }
        }
        return $pubKeys;
    }
    
    
    /**
     * @param null $password
     *
     * @return array
     */
    public static function createKey($password = null): array
    {
        $config = [
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];
        
        $res = \openssl_pkey_new($config);
        \openssl_pkey_export($res, $privatekey);
        $publickey = openssl_pkey_get_details($res);
        $publickey = $publickey["key"];
        if ($password) {
            \openssl_pkey_export($res, $privatekey, $password);
        }
        \openssl_free_key($res);
        return [
            'private' => $privatekey,
            'public' => $publickey
        ];
    }
    
    /**
     * @param $key
     * @param $password
     *
     * @return mixed
     * @throws KeyNotReadableException
     */
    public static function lockPrivatePemKey($key, $password)
    {
        if (!$privkey = openssl_pkey_get_private($key)) {
            throw new KeyNotReadableException("Can not read Private Key");
        }
        $ret = self::lockPrivateKey($privkey, $password);
        \openssl_free_key($privkey);
        return $ret;
    }
    
    /**
     * @param keyresource $key
     * @param $password
     * @return mixed
     */
    public static function lockPrivateKey($key, $password)
    {
        \openssl_pkey_export($key, $privatekey, $password);
        return $privatekey;
    }
    
    /**
     * @param $key
     * @param $password
     *
     * @return mixed
     * @throws KeyNotReadableException
     * @throws WrongKeyPassException
     */
    public static function unlockKeyToPem($key, $password)
    {
        $privkey = self::unlockKey($key, $password);
        openssl_pkey_export($privkey, $out);
        \openssl_free_key($privkey);
        return $out;
        //return $privkey;
    }
    
    /**
     * @param string $key
     * @param string|null $password
     *
     * @return bool|resource
     * @throws WrongKeyPassException
     * @throws KeyNotReadableException
     */
    public static function unlockKey($key, $password)
    {
        if ($password !== null) {
            if (!$privkey = openssl_pkey_get_private($key, $password)) {
                throw new WrongKeyPassException("Can not read Private Key (password given)");
            }
        } else {
            if (!$privkey = openssl_pkey_get_private($key)) {
                throw new KeyNotReadableException("Can not read Private Key");
            }
        }
        return $privkey;
        //return $privkey;
    }
    
    public static function getChecksum($key)
    {
        $key = trim($key);
        $a = explode("\n", $key);
        $core = '';
        $active = false;
        foreach ($a as $line) {
            $line = trim($line);
            
            if ($active && ($line == '-----END PUBLIC KEY-----' || $line == '-----END PRIVATE KEY-----' || $line == '-----END ENCRYPTED PRIVATE KEY-----')) {
                $active = false;
            }
            
            if ($active) {
                $core .= $line;
            }
            
            if (!$active && ($line == '-----BEGIN PUBLIC KEY-----' || $line == '-----BEGIN PRIVATE KEY-----' || $line == '-----BEGIN ENCRYPTED PRIVATE KEY-----')) {
                $active = true;
            }
        }
        return sha1($core);
    }
}
