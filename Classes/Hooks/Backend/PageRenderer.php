<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 16:25
 */

namespace SUDHAUS7\Guard7\Hooks\Backend;


use TYPO3\CMS\Backend\Controller\EditDocumentController;
use TYPO3\CMS\Backend\Utility\BackendUtility;

use TYPO3\CMS\Core\Database\DatabaseConnection;
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
				$this->handleRecordListLight( $parameters, $pageRenderer);

			}
		}

		//$pageRenderer->

	}
	public function postRender( array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer ) {
		if ($GLOBALS['SOBE']) {
			$class = get_class($GLOBALS['SOBE']);

			if ($class == RecordList::class) {

		//		$this->handleRecordList( $parameters, $pageRenderer);
			}
		}
	}

	private function handleRecordListLight(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer) {

		/** @var RecordList $controller */
		$controller =  $GLOBALS['SOBE'];

		$ts = BackendUtility::getPagesTSconfig( $controller->id );
		if ( isset( $ts['tx_sudhaus7guard7.'] ) && is_array( $ts['tx_sudhaus7guard7.'] ) && ! empty( $ts['tx_sudhaus7guard7.'] ) ) {
			$data = [];
			$tmp  = array_keys( $ts['tx_sudhaus7guard7.'] );
			foreach ($tmp as $t) {
				$data[]=trim($t,'.');
			}

			if (!empty($data)) {
				$pageRenderer->loadRequireJsModule( 'TYPO3/CMS/Guard7/List' );
				$pageRenderer->addJsInlineCode( __METHOD__,
					'var sudhaus7guard7tables = ' . json_encode( $data ) . ';' );
			}
		}


	}
	private function handleRecordList(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer) {

		/** @var RecordList $controller */
		$controller =  $GLOBALS['SOBE'];

		$ts = BackendUtility::getPagesTSconfig( $controller->id );
		if ( isset( $ts['tx_sudhaus7guard7.'] ) && is_array( $ts['tx_sudhaus7guard7.'] ) && ! empty( $ts['tx_sudhaus7guard7.'] ) ) {
			$data = [];
			foreach ( $ts['tx_sudhaus7guard7.'] as $table => $config ) {
				$table = trim($table,'.');
                /** @var DatabaseConnection $connection */
                $connection = $GLOBALS['TYPO3_DB'];
                
                $uids = $connection->exec_SELECTgetRows( 'uid' ,	$table,  'pid='.$controller->id );
				
				if (!empty($uids)) {
					$idlist = [];
					foreach ($uids as $a) $idlist[]=$a['uid'];

					$fields = $GLOBALS['TCA'][$table]['ctrl']['label'];
					$fields.= ','. $GLOBALS['TCA'][$table]['ctrl']['label_alt'];
					$fields = trim($fields,',');
					$fields = "'".str_replace(',',"','",$fields)."'";
                    
                    
                    /** @var DatabaseConnection $connection */
                    $connection = $GLOBALS['TYPO3_DB'];
                    $where = [
                        'tableuid in ('.implode(',',$idlist).')',
                        'fieldname in ("'.implode('","',$fields).'")',
                        'tablename = "'.$table.'"',
                    ];
                    $subdata = $connection->exec_SELECTgetRows('tablename,tableuid,fieldname,secretdata', 'tx_guard7_domain_model_data', implode(' AND ',$where));
					
					
					$data = array_merge($data,$subdata);

				}

			}
			if (!empty($data)) {
				$pageRenderer->loadRequireJsModule( 'TYPO3/CMS/Guard7/List' );
				$pageRenderer->addJsInlineCode( __METHOD__,
					'var sudhaus7guard7data = ' . json_encode( $data ) . ';' );
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
					$rec    = BackendUtility::getRecord( $table, $id, '*' );

					$ts = BackendUtility::getPagesTSconfig( $rec['pid'] );
					if ( isset( $ts['tx_sudhaus7guard7.'] ) && isset( $ts['tx_sudhaus7guard7.'][ $table . '.' ] ) ) {


						$fields = GeneralUtility::trimExplode( ',',$ts['tx_sudhaus7guard7.'][ $table . '.' ]['fields'], true );
                        
                        $config = [
                            'table'=>$table,
                            'fields'=>[
                                $table=>$fields
                            ],
                            'irre'=>[]
                        ];
                        
                        $data = [
                        
                        ];
                        
                        /** @var DatabaseConnection $connection */
                        $connection = $GLOBALS['TYPO3_DB'];

                        $res = $connection->exec_SELECTquery('tablename,tableuid,fieldname,secretdata' , 'tx_guard7_domain_model_data', sprintf('tablename = "%s" and tableuid=%d',$table,$id));
                        
                        while($row = $connection->sql_fetch_assoc($res)) {
                            $identifier = sprintf('[data-formengine-input-name="data[%s][%d][%s]"]',$row['tablename'],$row['tableuid'],$row['fieldname']);
                            $data[] = ['identifier'=>$identifier,'method'=>'val','secretdata'=>$row['secretdata']];
                        }
                        
						$pageRenderer->loadRequireJsModule( 'TYPO3/CMS/Guard7/Main' );
                        
                        
                        /**
                         * Handle / prepare IRRE
                         */
                        $tcafields = GeneralUtility::trimExplode(',', $GLOBALS['TCA'][$table]['types'][0]['showitem'],true);
                        
                        foreach ($tcafields as $field) {
                            if ($GLOBALS['TCA'][$table]['columns'][$field]['config']['type']=='inline') {
                                $reltable = $GLOBALS['TCA'][$table]['columns'][$field]['config']['foreign_table'];
                                $config['irre'][]=['table'=>$reltable,'field'=>$field];
                                $config['fields'][$reltable] = GeneralUtility::trimExplode( ',',$ts['tx_sudhaus7guard7.'][ $reltable . '.' ]['fields'], true );
                                
                               
                                
                           
                                $label = $GLOBALS['TCA'][$reltable]['ctrl']['label'];
                                if ($GLOBALS['TCA'][$reltable]['ctrl']['label_alt_force']) $label .= ','. $GLOBALS['TCA'][$reltable]['ctrl']['label_alt'];
                                $labelfields = GeneralUtility::trimExplode(',', $label,true);
                                $labels = [];
                                $irreres = $connection->exec_SELECTquery('tablename,tableuid,fieldname,secretdata' , 'tx_guard7_domain_model_data', sprintf('tablename = "%s" and tableuid in (%s)',$reltable,$rec[$field]),'','tableuid asc');
                                while($row = $connection->sql_fetch_assoc($irreres)) {
                                   // $data[]=$row;
    
                                    if (in_array($row['fieldname'],$labelfields)) {
                                        $labels[$row['tableuid']][]=$row['secretdata'];
                                    }
                                    
                                    $identifier = sprintf('[data-formengine-input-name="data[%s][%d][%s]"]',$row['tablename'],$row['tableuid'],$row['fieldname']);
                                    $data[] = ['identifier'=>$identifier,'method'=>'val','secretdata'=>$row['secretdata']];
                                    
                                }
                                if (!empty($labels)) {
                                    foreach ($labels as $id=>$label) {
                                        $identifier = sprintf('#data-%d-%s-%d-%s-%s-%d_label',$rec['pid'],$table,$rec['uid'],$field,$reltable,$id);
                                        $data[] = ['identifier'=>$identifier,'method'=>'label','secretdata'=>\implode('|', $label)];
                                    }
        
                                }
                                
                            }
                           
                        }
						
						$pageRenderer->addJsInlineCode( __METHOD__,
							'var sudhaus7guard7data = ' . json_encode( $data ) . '; var sudhaus7guard7config = ' . json_encode( $config ) . ';' );

					}
				}

				//$record = BackendUtility::getRecord( $table, $uid)

			}

		}
	}
}
