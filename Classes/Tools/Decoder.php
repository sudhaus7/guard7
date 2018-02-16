<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 15:29
 */

namespace SUDHAUS7\Datavault\Tools;


use TYPO3\CMS\Core\Exception;

class Decoder {
	/**
	 * @param $data
	 * @param $key
	 * @param null $password
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public static function decode($data,$key,$password=null) {
		if ($password) {
			if (!$privkey = openssl_pkey_get_private($key,$password)){
				throw new \Exception("Can not read Private Key (password given)");
			}
		} else {
			if (!$privkey = openssl_pkey_get_private($key)){
				throw new \Exception("Can not read Private Key");
			}
		}
		list($method,$b64_iv,$b64_envkeys,$b64_secret) = explode(':',$data);
		$keyhash = Keys::getChecksum( openssl_pkey_get_details($privkey)['key']);
		$iv = base64_decode( $b64_iv);
		$envkeys = json_decode( base64_decode( $b64_envkeys ),true);
		$envkey = base64_decode( $envkeys[$keyhash]);
		\openssl_open(base64_decode( $b64_secret),$open,$envkey,$privkey,$method,$iv);
		return $open;

	}
}
