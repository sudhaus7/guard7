<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 21.02.18
 * Time: 15:56
 */

namespace SUDHAUS7\Datavault\Hooks\Frontend;

use SUDHAUS7\Datavault\Tools\Keys;
use SUDHAUS7\Datavault\Tools\Storage;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class Userchangepassword
 * @package SUDHAUS7\Datavault\Frontend
 */
class Userchangepassword {

	/**
	 * @param $params
	 */
	public function handle($params) {

		/** @var Connection $connection */
		$connection = GeneralUtility::makeInstance(ConnectionPool::class)
		                            ->getConnectionForTable('fe_users');
		$user = $params['user'];
		$signature_old = Keys::getChecksum( $user['tx_datavault_publickey'] );
		Storage::markForReencode( $signature_old );

		$password = $params['newPassword'];
		$keypair = Keys::createKey( $password );
		$data = [];
		$data['tx_datavault_publickey']  = $keypair['public'];
		$data['tx_datavault_privatekey'] = $keypair['private'];
		$connection->update( 'fe_users', $data, ['uid'=>$user['uid']]);

	}
}
