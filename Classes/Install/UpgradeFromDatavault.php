<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 07.04.18
 * Time: 15:14
 */

namespace SUDHAUS7\Guard7\Install;


use TYPO3\CMS\Core\Database\DatabaseConnection;

class UpgradeFromDatavault {
    public function onInstall($extname) {
        if ( $extname == 'guard7' ) {
            
            /** @var DatabaseConnection $connection */
            $connection = $GLOBALS['TYPO3_DB'];
            
            
            $res = $connection->admin_query('show tables like "tx_datavault_domain_model_data"');
            $row = $connection->sql_fetch_assoc($res);
            if ( isset($row[0]) && $row[0] == 'tx_datavault_domain_model_data' ) {
                $connection->admin_query('INSERT IGNORE INTO tx_guard7_domain_model_data SELECT * FROM tx_datavault_domain_model_data');
                $connection->admin_query('DROP TABLE tx_datavault_domain_model_data');
            }
            
            $res = $connection->admin_query('show tables like "tx_sudhaus7datavault_signatures"');
            $row = $connection->sql_fetch_row($res);
            if ( isset($row[0]) && $row[0] == 'tx_sudhaus7datavault_signatures' ) {
                $connection->admin_query('INSERT IGNORE INTO tx_guard7_signatures SELECT * FROM tx_sudhaus7datavault_signatures');
                $connection->admin_query('DROP TABLE tx_sudhaus7datavault_signatures');
            }
            
            
            $res = $connection->admin_query('show columns from fe_users like "tx_datavault_privatekey"');
            $row = $connection->sql_fetch_row($res);
            if ( isset($row[0]) && $row[0] == 'tx_datavault_privatekey' ) {
                $connection->admin_query('UPDATE fe_users SET tx_guard7_privatekey=tx_datavault_privatekey');
                $connection->admin_query('ALTER TABLE fe_users DROP tx_datavault_privatekey');
            }
            
            
            $res = $connection->admin_query('show columns from fe_users like "tx_datavault_publickey"');
            $row = $connection->sql_fetch_row($res);
            if ( isset($row[0]) && $row[0] == 'tx_datavault_publickey' ) {
                $connection->admin_query('UPDATE fe_users SET tx_guard7_publickey=tx_datavault_publickey');
                $connection->admin_query('ALTER TABLE fe_users DROP tx_datavault_publickey');
            }
        }
    }
    
}
