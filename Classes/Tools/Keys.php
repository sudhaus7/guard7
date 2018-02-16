<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 15:22
 */

namespace SUDHAUS7\Datavault\Tools;


class Keys {


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
		return ['private'=>$privatekey,'public'=>$publickey];

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
