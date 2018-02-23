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
use TYPO3\CMS\Recordlist\RecordList;

class PageRenderer  {

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
				$this->handleEditDocumentController($parameters, $pageRenderer);
			}

			if ($class == RecordList::class) {
				$this->handleRecordList( $parameters, $pageRenderer);
			}
		}

		//$pageRenderer->

	}

	private function handleRecordList(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer) {

		/** @var RecordList $controller */
		$controller =  $GLOBALS['SOBE'];

		$ts = BackendUtility::getPagesTSconfig( $controller->id );
		if ( isset( $ts['tx_sudhaus7datavault.'] ) && is_array($ts['tx_sudhaus7datavault.']) && !empty($ts['tx_sudhaus7datavault.'])) {
			$data = [];
			foreach($ts['tx_sudhaus7datavault.'] as $table=>$config) {
				$table = trim($table,'.');
				/** @var Connection $connection */
				$connection = GeneralUtility::makeInstance( ConnectionPool::class )
				                            ->getConnectionForTable( $table );

				$res = $connection->select( [ 'uid' ],	$table, [ 'pid' => $controller->id, 'deleted' => 0] );
				$uids = $res->fetchAll();
				if (!empty($uids)) {
					$idlist = [];
					foreach ($uids as $a) $idlist[]=$a['uid'];

					$fields = $GLOBALS['TCA'][$table]['ctrl']['label'];
					$fields.= ','. $GLOBALS['TCA'][$table]['ctrl']['label_alt'];
					$fields = trim($fields,',');
					$fields = "'".str_replace(',',"','",$fields)."'";

					$connection = GeneralUtility::makeInstance( ConnectionPool::class )
					                            ->getConnectionForTable( 'tx_datavault_domain_model_data' );
					$query = $connection->createQueryBuilder();
					$query->select(...[ 'tablename', 'tableuid', 'fieldname', 'secretdata' ])
					      ->from( 'tx_datavault_domain_model_data');



					$query->andWhere( $query->expr()->in('tableuid',$idlist));
					$query->andWhere( $query->expr()->in('fieldname',$fields ));
					$query->andWhere( $query->expr()->eq('tablename',$query->createNamedParameter($table)));
					$result = $query->execute();
					$subdata   = $result->fetchAll();
					$data = array_merge($data,$subdata);

				}

			}
			if (!empty($data)) {
				$pageRenderer->loadRequireJsModule( 'TYPO3/CMS/Datavault/List' );
				$pageRenderer->addJsInlineCode( __METHOD__,
					'var sudhaus7datavaultdata = ' . json_encode( $data ) . ';' );
			}
		}


	}
	private function handleEditDocumentController(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer) {
		$this->editconf = $GLOBALS['SOBE']->editconf;
		$this->controller =  $GLOBALS['SOBE'];
		if (!empty($this->editconf)) {

			foreach ($this->editconf as $table=>$config) {

				if (\in_array( 'edit', $config)) {


					$idlist = GeneralUtility::trimExplode( ',', array_keys( $config )[0], true );
					$id     = array_shift( $idlist );
					$rec    = BackendUtility::getRecord( $table, $id, 'uid,pid' );

					$ts = BackendUtility::getPagesTSconfig( $rec['pid'] );
					if ( isset( $ts['tx_sudhaus7datavault.'] ) && isset( $ts['tx_sudhaus7datavault.'][ $table . '.' ] ) ) {


						$fields = GeneralUtility::trimExplode( ',',
							$ts['tx_sudhaus7datavault.'][ $table . '.' ]['fields'], true );
						/** @var Connection $connection */
						$connection = GeneralUtility::makeInstance( ConnectionPool::class )
						                            ->getConnectionForTable( 'tx_datavault_domain_model_data' );

						$result = $connection->select( [ 'tablename', 'tableuid', 'fieldname', 'secretdata' ],
							'tx_datavault_domain_model_data', [ 'tablename' => $table, 'tableuid' => $id ] );
						$data   = $result->fetchAll();
						$pageRenderer->loadRequireJsModule( 'TYPO3/CMS/Datavault/Main' );
						$pageRenderer->addJsInlineCode( __METHOD__,
							'var sudhaus7datavaultdata = ' . json_encode( $data ) . ';' );

					}
				}

				//$record = BackendUtility::getRecord( $table, $uid)

			}

		}
	}
}
