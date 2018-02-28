<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 15:29
 */

namespace SUDHAUS7\Datavault\Tools;


use SUDHAUS7\Datavault\UnlockException;
use SUDHAUS7\Datavault\WrongkeypassException;

/**
 * Class Decoder
 * @package SUDHAUS7\Datavault\Tools
 */
class Decoder {
	/**
	 * @param $data
	 * @param $key
	 * @param null $password
	 *
	 * @return mixed
	 * @throws UnlockException
	 * @throws WrongkeypassException
	 */
	public static function decode($data,$key,$password=null) {
		$privkey = Keys::unlockKey( $key, $password);
		list($method,$b64_iv,$b64_envkeys,$b64_secret) = explode(':',$data);
		$keyhash = Keys::getChecksum( openssl_pkey_get_details($privkey)['key']);
		$iv = base64_decode( $b64_iv);
		$envkeys = json_decode( base64_decode( $b64_envkeys ),true);
		$envkey = base64_decode( $envkeys[$keyhash]);

		if (!\openssl_open(base64_decode( $b64_secret),$open,$envkey,$privkey,$method,$iv)) {
			\openssl_free_key( $privkey );
			throw new UnlockException('Data not unlockable');
		}
		\openssl_free_key( $privkey );
		return $open;

	}
}
