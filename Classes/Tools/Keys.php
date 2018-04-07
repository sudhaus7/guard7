<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 15:22
 */

namespace SUDHAUS7\Guard7\Tools;


use SUDHAUS7\Guard7\KeyNotReadableException;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use SUDHAUS7\Guard7\WrongKeyPassException;

class Keys {


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
	public static function collectPublicKeys ($table=null,$uid=0,$pid=0,$checkFEuser=false,$aPubkeys=[]) {


		$keysFromSignalslot = [];
		/** @var Dispatcher $signalSlotDispatcher */
		$signalSlotDispatcher = GeneralUtility::makeInstance( Dispatcher::class);

		// Signal Name for example: collectPublicKeys_fe_users
		list($keysFromSignalslot) = $signalSlotDispatcher->dispatch( __CLASS__, __FUNCTION__.'_'.$table,[$keysFromSignalslot,$uid,$pid]);

		$confArr = unserialize( $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['guard7'] );
		$pubKeys = [];
		if (!empty($keysFromSignalslot)) {
			foreach ($keysFromSignalslot as $key) {
				$pubKeys[ self::getChecksum( $key )] = $key;
			}
		}
		if (!empty($aPubkeys)) {
			foreach ($aPubkeys as $key) {
				$pubKeys[ self::getChecksum( $key )] = $key;
			}
		}
		if (!empty($confArr['masterkeypublic'])) {
			$checksum = self::getChecksum( $confArr['masterkeypublic']);
			$pubKeys[$checksum] = $confArr['masterkeypublic'];
		}
		if ($pid > 0) {
			$ts = BackendUtility::getPagesTSconfig( $pid );
			if ( isset( $ts['tx_sudhaus7guard7.'] ) ) {
				if ( isset( $ts['tx_sudhaus7guard7.']['generalPublicKeys.'] ) && ! empty( $ts['tx_sudhaus7guard7.']['generalPublicKeys.'] ) ) {
					foreach ( $ts['tx_sudhaus7guard7.']['generalPublicKeys.'] as $key ) {
						$pubKeys[ self::getChecksum( $key )] = $key;
					}
				}
				if ($table) {
					if ( isset( $ts['tx_sudhaus7guard7.'][ $table . '.' ] ) && isset( $ts['tx_sudhaus7guard7.'][ $table . '.' ]['publicKeys.'] ) && is_array( $ts['tx_sudhaus7guard7.'][ $table . '.' ]['publicKeys.'] ) ) {
						foreach ( $ts['tx_sudhaus7guard7.'][ $table . '.' ]['publicKeys.'] as $key ) {
							$pubKeys[ self::getChecksum( $key )] = $key;
						}
					}
				}
			}
		}
		if($checkFEuser && isset($GLOBALS['TSFE']) && $GLOBALS['TSFE']->loginUser) {
			if ( isset( $GLOBALS['TSFE']->fe_user->user['tx_guard7_publickey'] ) && ! empty( $GLOBALS['TSFE']->fe_user->user['tx_guard7_publickey'] ) ) {
				$pubKeys[ self::getChecksum( $GLOBALS['TSFE']->fe_user->user['tx_guard7_publickey'] ) ] = $GLOBALS['TSFE']->fe_user->user['tx_guard7_publickey'];
			}
		}
		return $pubKeys;
	}


	/**
	 * @param null $password
	 *
	 * @return array
	 */
	public static function createKey($password = null) : array {
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
			\openssl_pkey_export( $res, $privatekey, $password );
		}
		\openssl_free_key( $res);
		return ['private'=>$privatekey,'public'=>$publickey];
	}

	/**
	 * @param $key
	 * @param $password
	 *
	 * @return mixed
	 * @throws KeyNotReadableException
	 */
	public static function lockPrivatePemKey($key,$password) {
		if (!$privkey = openssl_pkey_get_private($key)){
			throw new KeyNotReadableException("Can not read Private Key");
		}
		$ret = self::lockPrivateKey( $privkey, $password);
		\openssl_free_key( $privkey);
		return $ret;
	}
	public static function lockPrivateKey($key,$password) {
		\openssl_pkey_export( $key, $privatekey, $password );
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
	public static function unlockKeyToPem($key,$password) {
		$privkey = self::unlockKey( $key, $password);
		openssl_pkey_export($privkey,$out);
		\openssl_free_key( $privkey);
		return $out;
		//return $privkey;
	}

	/**
	 * @param $key
	 * @param $password
	 *
	 * @return bool|resource
	 * @throws WrongKeyPassException
	 * @throws KeyNotReadableException
	 */
	public static function unlockKey($key,$password) {
		if ($password) {
			if (!$privkey = openssl_pkey_get_private($key,$password)){
				throw new WrongKeyPassException("Can not read Private Key (password given)");
			}
		} else {
			if (!$privkey = openssl_pkey_get_private($key)){
				throw new KeyNotReadableException("Can not read Private Key");
			}
		}
		return $privkey;
		//return $privkey;
	}

	public static function getChecksum($key) {
		$key = trim($key);
		$a = explode ("\n",$key);
		$core = '';
		$active = false;
		foreach ($a as $line) {
			$line = trim($line);

			if ($active && ($line=='-----END PUBLIC KEY-----' || $line=='-----END PRIVATE KEY-----' || $line=='-----END ENCRYPTED PRIVATE KEY-----')) {
				$active = false;
			}

			if ($active) {
				$core .= $line;
			}

			if (!$active && ($line=='-----BEGIN PUBLIC KEY-----' || $line=='-----BEGIN PRIVATE KEY-----' || $line=='-----BEGIN ENCRYPTED PRIVATE KEY-----')) {
				$active = true;
			}
		}
		return sha1($core);
	}
}
