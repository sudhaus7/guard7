<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 14:38
 */

namespace SUDHAUS7\Datavault\Hooks\Backend;


use TYPO3\CMS\Core\Database\Connection;
use SUDHAUS7\Datavault\Tools\Encoder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Datamap {
	public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {




		if ($status == 'update') {

			$ts = BackendUtility::getPagesTSconfig( $pObj->getPID( $table, $id));

			if (isset($ts['tx_sudhaus7datavault.'])) {
				if (isset($ts['tx_sudhaus7datavault.'][$table.'.']) && isset($ts['tx_sudhaus7datavault.'][$table.'.']['fields'])  && isset($ts['tx_sudhaus7datavault.'][$table.'.']['publicKeys.']) && is_array($ts['tx_sudhaus7datavault.'][$table.'.']['publicKeys.'])) {
					$vaultfields = GeneralUtility::trimExplode( ',', $ts['tx_sudhaus7datavault.'][$table.'.']['fields']);
					/** @var Connection $connection */
					$connection = GeneralUtility::makeInstance(ConnectionPool::class)
					                            ->getConnectionForTable('tx_sudhaus7datavault_data');

					foreach ($fieldArray as $fieldname=>$value) {
						if (in_array($fieldname,$vaultfields)) {
							$fieldArray[$fieldname] = '&#128274;';
							if ($value == '&#128274;' || $value == '🔒') {
								continue;
							}
							//TODO : Check for type in TCA, this assumes text

							$fieldArray[$fieldname] = '&#128274;'; // 🔒
							$encoder = new Encoder( $value, $ts['tx_sudhaus7datavault.'][$table.'.']['publicKeys.']);
							$encoded = $encoder->run();
							unset($encoder);
							$connection->delete( 'tx_sudhaus7datavault_data', ['tablename'=>$table,'tableuid'=>$id,'fieldname'=>$fieldname]);
							$connection->insert( 'tx_sudhaus7datavault_data', ['tablename'=>$table,'tableuid'=>$id,'fieldname'=>$fieldname,'secretdata'=>$encoded]);
						}
					}

				}
			}


		}

	}
}
