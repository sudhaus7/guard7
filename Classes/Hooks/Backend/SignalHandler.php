<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 16:39
 */

namespace SUDHAUS7\Guard7\Hooks\Backend;


use TYPO3\CMS\Backend\Controller\EditDocumentController;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SignalHandler {


	/**
	 * @param EditDocumentController $cntrl
	 */
	public function EditDocumentInit($cntrl) {

		$mypagerenderer = GeneralUtility::makeInstance( PageRenderer::class );
		$mypagerenderer->editconf = $cntrl->editconf;
		$mypagerenderer->controller = $cntrl;

	}


	public function FeuserFetchkey($keys,$uid,$pid) {
		if (substr($uid,0,3)!='NEW' && $uid > 0) {
            /** @var DatabaseConnection $connection */
            $connection = $GLOBALS['TYPO3_DB'];
            $row = $connection->exec_SELECTgetSingleRow('tx_guard7_publickey', 'fe_users', 'uid='.$uid);
			if ( $row && ! empty( $row['tx_guard7_publickey'] ) ) {
				$keys[] = $row['tx_guard7_publickey'];
			}
		}
		return [$keys,$uid,$pid];
	}

}
