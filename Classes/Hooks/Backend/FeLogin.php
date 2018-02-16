<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 16.02.18
 * Time: 17:07
 */

namespace SUDHAUS7\Datavault\Hooks\Backend;


use SUDHAUS7\Datavault\Tools\Keys;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class FeLogin {


	public function handle($ar) {

		/** @var TypoScriptFrontendController $pObj */
		$pObj = $ar['pObj'];

		if (isset($GLOBALS['datavault_temp_pass'])) {

			if (!empty($pObj->fe_user->user['tx_datavault_privatekey'])) {
				try {
					$privkey = Keys::unlockKeyToPem( $pObj->fe_user->user['tx_datavault_privatekey'],
						$GLOBALS['datavault_temp_pass'] );
					$pObj->fe_user->setSessionData( 'tx_datavault_privatekey', $privkey);
				} catch(\Exception $e) {

				}

			}
			unset($GLOBALS['datavault_temp_pass']);

		}

	}

}
