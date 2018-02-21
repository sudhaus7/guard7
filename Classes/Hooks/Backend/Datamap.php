<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 14:38
 */

namespace SUDHAUS7\Datavault\Hooks\Backend;


use SUDHAUS7\Datavault\Tools\Keys;
use SUDHAUS7\Datavault\Tools\Storage;
use TYPO3\CMS\Core\Database\Connection;
use SUDHAUS7\Datavault\Tools\Encoder;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Backend;
use TYPO3\CMS\Rsaauth\RsaAuthService;
use TYPO3\CMS\Rsaauth\RsaEncryptionDecoder;

class Datamap implements SingletonInterface {

	protected $insertCache = [];

	/**
	 * @param $status
	 * @param $table
	 * @param $id
	 * @param $fieldArray
	 * @param \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
	 */
	public function processDatamap_afterDatabaseOperations($status, $table, $id, &$fieldArray, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {

		if ($status == 'new') {
			if (isset($this->insertCache[$table]) && isset($this->insertCache[$table][$id]) && is_array($this->insertCache[$table][$id])) {
				$newid = $pObj->substNEWwithIDs[$id];
				/** @var Connection $connection */
				$connection = GeneralUtility::makeInstance(ConnectionPool::class)
				                            ->getConnectionForTable('tx_sudhaus7datavault_data');
				foreach ($this->insertCache[$table][$id] as $data) {

					$connection->insert( 'tx_sudhaus7datavault_data', ['tablename'=>$table,'tableuid'=>$newid,'fieldname'=>$data['fieldname'],'secretdata'=>$data['encoded']]);
					$insertid = $connection->lastInsertId();
					Storage::updateKeyLog( $insertid, $data['pubkeys']);

				}
			}
		}
	}

	/**
	 * @param $incomingFieldArray
	 * @param $table
	 * @param $id
	 * @param \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
	 */
	public function processDatamap_preProcessFieldArray(&$incomingFieldArray, $table, $id, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {

		if ($table=='fe_users') {
			if (strpos($id,'NEW') !== false) {
				$password                                      = $incomingFieldArray['password'];
				$keypair                                       = Keys::createKey( $password );
				$incomingFieldArray['tx_datavault_publickey']  = $keypair['public'];
				$incomingFieldArray['tx_datavault_privatekey'] = $keypair['private'];
			} else if (strpos($incomingFieldArray['password'],'rsa:')===false) {
				$tmprec = BackendUtility::getRecord( 'fe_users', $id);
				if ($tmprec['password'] != $incomingFieldArray['password']) {

					$signature_old = Keys::getChecksum( $tmprec['tx_datavault_publickey'] );
					Storage::markForReencode( $signature_old);

					$password                                      = $incomingFieldArray['password'];
					$keypair                                       = Keys::createKey( $password );
					$incomingFieldArray['tx_datavault_publickey']  = $keypair['public'];
					$incomingFieldArray['tx_datavault_privatekey'] = $keypair['private'];
				}
			}
		}

	}

	/**
	 * @param $status
	 * @param $table
	 * @param $id
	 * @param $fieldArray
	 * @param \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
	 *
	 * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
	 * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
	 */
	public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {

		if ($status == 'new') {
		//	$pObj->substNEWwithIDs


			$ts = BackendUtility::getPagesTSconfig( $fieldArray['pid']);
			if (isset($ts['tx_sudhaus7datavault.'])) {
				if ( isset( $ts['tx_sudhaus7datavault.'][ $table . '.' ] ) && isset( $ts['tx_sudhaus7datavault.'][ $table . '.' ]['fields'] ) ) {
					$pubkeys = Keys::collectPublicKeys($table, $fieldArray['pid'],false);

					if (!isset($this->insertCache[$table])) $this->insertCache[$table] = [];
					$this->insertCache[$table][$id] = [];

					$vaultfields = GeneralUtility::trimExplode( ',',
						$ts['tx_sudhaus7datavault.'][ $table . '.' ]['fields'] );
					foreach ($fieldArray as $fieldname=>$value) {
						if ( in_array( $fieldname, $vaultfields ) ) {
							if (strlen($value) > 0) {
								$fieldArray[ $fieldname ] = '&#128274;';
								//$fieldArray[$fieldname] = '&#128274;'; // 🔒
								$encoder  = new Encoder( $value, $pubkeys );
								$this->insertCache[ $table ][ $id ][] = ['fieldname'=>$fieldname,'encoded'=>$encoder->run(),'pubkeys'=>$pubkeys];
								unset( $encoder );
							}
						}
					}
				}
			}

		}

		if ($status == 'update') {

			$ts = BackendUtility::getPagesTSconfig( $pObj->getPID( $table, $id));

			if (isset($ts['tx_sudhaus7datavault.'])) {
				if (isset($ts['tx_sudhaus7datavault.'][$table.'.']) && isset($ts['tx_sudhaus7datavault.'][$table.'.']['fields'])) {
					$pubkeys = Keys::collectPublicKeys($table,  $pObj->getPID( $table, $id),false);
					$vaultfields = GeneralUtility::trimExplode( ',', $ts['tx_sudhaus7datavault.'][$table.'.']['fields']);
					$fieldArray = Storage::lockRecord( $table, $id, $vaultfields, $fieldArray, $pubkeys);
				}
			}
		}

	}
}
