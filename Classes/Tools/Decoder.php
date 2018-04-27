<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 15:29
 */

namespace SUDHAUS7\Guard7\Tools;


use SUDHAUS7\Guard7\UnlockException;
use SUDHAUS7\Guard7\WrongKeyPassException;

/**
 * Class Decoder
 * @package SUDHAUS7\Guard7\Tools
 */
class Decoder {
	/**
	 * @param $data
	 * @param $key
	 * @param null $password
	 *
	 * @return mixed
	 * @throws UnlockException
	 * @throws WrongKeyPassException
	 */
	public static function decode($data,$key,$password=null) {
		$privkey = Keys::unlockKey( $key, $password);
		list($method,$b64_iv,$b64_envkeys,$b64_secret) = explode(':',$data);
		$keyhash = Keys::getChecksum( openssl_pkey_get_details($privkey)['key']);
		
		$envkeys = json_decode( base64_decode( $b64_envkeys ),true);
		$envkey = base64_decode( $envkeys[$keyhash]);
        var_dump(PHP_MAJOR_VERSION);
        if (PHP_MAJOR_VERSION < 7) {
            if (!\openssl_open(base64_decode( $b64_secret),$open,$envkey,$privkey,$method)) {
                \openssl_free_key( $privkey );
                throw new UnlockException('Data not unlockable');
            }
        } else {
            $iv = base64_decode( $b64_iv);
            if (!\openssl_open(base64_decode( $b64_secret),$open,$envkey,$privkey,$method,$iv)) {
                \openssl_free_key( $privkey );
                throw new UnlockException('Data not unlockable');
            }
        }
		
		
		\openssl_free_key( $privkey );
		return $open;

	}
}
