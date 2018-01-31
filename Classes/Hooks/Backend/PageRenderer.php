<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 16:25
 */

namespace SUDHAUS7\Datavault\Hooks\Backend;


use TYPO3\CMS\Backend\Controller\EditDocumentController;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PageRenderer implements SingletonInterface {

	var $editconf = [];

	/**
	 * @var EditDocumentController
	 */
	var $controller = null;

	/**
	 * wrapper function called by hook (\TYPO3\CMS\Core\Page\PageRenderer->render-preProcess)
	 *
	 * @param array $parameters An array of available parameters
	 * @param \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer The parent object that triggered this hook
	 */
	public function addJSCSS( array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer ) {

		if ($GLOBALS['SOBE']) {
			$class = get_class($GLOBALS['SOBE']);
			if ($class == EditDocumentController::class) {
				if (!empty($this->editconf)) {


					//foreach ($this->editconf as )

					//$pageTS = BackendUtility::getPagesTSconfig( );
					//$a = 1;



					foreach ($this->editconf as $table=>$config) {

						$idlist = GeneralUtility::trimExplode( ',', array_keys($config)[0],true);
						$id = array_shift($idlist);
						$rec = BackendUtility::getRecord($table, $id, 'uid,pid');

						$ts = BackendUtility::getPagesTSconfig( $rec['pid']);
						if (isset($ts['tx_sudhaus7datavault.']) && isset($ts['tx_sudhaus7datavault.'][$table.'.'])) {


							$fields = GeneralUtility::trimExplode( ',', $ts['tx_sudhaus7datavault.'][$table.'.']['fields'],true);
							/** @var Connection $connection */
							$connection = GeneralUtility::makeInstance(ConnectionPool::class)
							                            ->getConnectionForTable('tx_sudhaus7datavault_data');

							$result = $connection->select( ['tablename','tableuid','fieldname','secretdata'], 'tx_sudhaus7datavault_data',['tablename'=>$table,'tableuid'=>$id]);
							$data =$result->fetchAll();
							$pageRenderer->loadRequireJsModule('TYPO3/CMS/Datavault/Main');
							$pageRenderer->addJsInlineCode(__METHOD__, 'var sudhaus7datavaultdata = '.json_encode($data).';');

						}

						//$record = BackendUtility::getRecord( $table, $uid)

					}

				}
			}
		}

		//$pageRenderer->

	}
}
