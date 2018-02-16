<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 16.02.18
 * Time: 16:48
 */

namespace SUDHAUS7\Datavault\Services;


class Datavault extends \TYPO3\CMS\Sv\AuthenticationService {

	public function processLoginData(array &$loginData, $passwordTransmissionStrategy) {
		$GLOBALS['datavault_temp_pass'] = $loginData['uident_text'];
	}

	public function init() {
		return true;
	}
}
