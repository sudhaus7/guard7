<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 07.04.18
 * Time: 15:14
 */

namespace SUDHAUS7\Guard7\Install;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class UpgradeFromDatavault {
	public function onInstall( $extname ) {
		if ( $extname == 'guard7' ) {

			/** @var Connection $connection */
			$connection = GeneralUtility::makeInstance( ConnectionPool::class )
			                            ->getConnectionForTable( 'tx_guard7_signatures' );

			$res = $connection->executeQuery( 'show tables like "tx_datavault_domain_model_data"' );
			$row = $res->fetch( \PDO::FETCH_NUM );
			if ( isset( $row[0] ) && $row[0] == 'tx_datavault_domain_model_data' ) {
				$connection->executeQuery( 'INSERT IGNORE INTO tx_guard7_domain_model_data SELECT * FROM tx_datavault_domain_model_data' );
				$connection->executeQuery( 'DROP TABLE tx_datavault_domain_model_data' );
			}

			$res = $connection->executeQuery( 'show tables like "tx_sudhaus7datavault_signatures"' );
			$row = $res->fetch( \PDO::FETCH_NUM );
			if ( isset( $row[0] ) && $row[0] == 'tx_sudhaus7datavault_signatures' ) {
				$connection->executeQuery( 'INSERT IGNORE INTO tx_guard7_signatures SELECT * FROM tx_sudhaus7datavault_signatures' );
				$connection->executeQuery( 'DROP TABLE tx_sudhaus7datavault_signatures' );
			}


			$res = $connection->executeQuery( 'show columns from fe_users like "tx_datavault_privatekey"' );
			$row = $res->fetch( \PDO::FETCH_NUM );
			if ( isset( $row[0] ) && $row[0] == 'tx_datavault_privatekey' ) {
				$connection->executeQuery( 'UPDATE fe_users SET tx_guard7_privatekey=tx_datavault_privatekey' );
				$connection->executeQuery( 'ALTER TABLE fe_users DROP tx_datavault_privatekey' );
			}


			$res = $connection->executeQuery( 'show columns from fe_users like "tx_datavault_publickey"' );
			$row = $res->fetch( \PDO::FETCH_NUM );
			if ( isset( $row[0] ) && $row[0] == 'tx_datavault_publickey' ) {
				$connection->executeQuery( 'UPDATE fe_users SET tx_guard7_publickey=tx_datavault_publickey' );
				$connection->executeQuery( 'ALTER TABLE fe_users DROP tx_datavault_publickey' );
			}
		}
	}

}
