<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 15:29
 */

namespace SUDHAUS7\Guard7\Tools;

use SUDHAUS7\Guard7\MissingKeyException;
use SUDHAUS7\Guard7\UnlockException;
use SUDHAUS7\Guard7\WrongKeyPassException;

/**
 * Class Decoder
 * @package SUDHAUS7\Guard7\Tools
 */
class Decoder
{
    /**
     * @param $data
     * @param null $key
     * @param null $password
     * @return mixed
     * @throws MissingKeyException
     * @throws UnlockException
     * @throws WrongKeyPassException
     * @throws \SUDHAUS7\Guard7\KeyNotReadableException
     */
    public static function decode($data, $key = null, $password = null)
    {
        if ($key === null) {
            if (isset($GLOBALS['GUARD7_PRIVATEKEY'])) {
                $key = $GLOBALS['GUARD7_PRIVATEKEY'];
            } else {
                throw new MissingKeyException('No key provided', 1576156831);
            }
        }
        
        $privkey = Keys::unlockKey($key, $password);
        list($method, $b64_iv, $b64_envkeys, $b64_secret) = explode(':', $data);
        $keyhash = Keys::getChecksum(openssl_pkey_get_details($privkey)['key']);
        $iv = base64_decode($b64_iv);
        $envkeys = json_decode(base64_decode($b64_envkeys), true);
        $envkey = base64_decode($envkeys[$keyhash]);
        
        if (!\openssl_open(base64_decode($b64_secret), $open, $envkey, $privkey, $method, $iv)) {
            \openssl_free_key($privkey);
            throw new UnlockException('Data not unlockable');
        }
        \openssl_free_key($privkey);
        return $open;
    }
}
