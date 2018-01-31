<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 15:22
 */

namespace SUDHAUS7\Datavault\Tools;


class Keys {



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
