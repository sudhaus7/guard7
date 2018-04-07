<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 16:39
 */

namespace SUDHAUS7\Guard7\Hooks\Backend;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Backend\Controller\EditDocumentController;
use TYPO3\CMS\Backend\Utility\BackendUtility;
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
			/** @var Connection $connection */
			$connection = GeneralUtility::makeInstance(ConnectionPool::class)
			                            ->getConnectionForTable('fe_users');
			$row        = $connection->select( [ 'tx_guard7_publickey' ], 'fe_users', [ 'uid' => $uid ] )
			                         ->fetch( \PDO::FETCH_ASSOC );
			if ( $row && ! empty( $row['tx_guard7_publickey'] ) ) {
				$keys[] = $row['tx_guard7_publickey'];
			}
		}
		return [$keys,$uid,$pid];
	}

}
