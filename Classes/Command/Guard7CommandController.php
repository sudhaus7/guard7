<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 26.04.18
 * Time: 15:04
 */

namespace SUDHAUS7\Guard7\Command;
use SUDHAUS7\Guard7\Tools\Keys;
use SUDHAUS7\Guard7\Tools\Storage;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Mvc\Controller\CommandController;



class Guard7CommandController extends  CommandController {
    /**
     * Lock all data of a table
     *
     * @param int $pid 'UID of a Folder
     * @param string $table Table to lock
     * @param null $includeFiles Lock referenced files as well
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function locktableCommand ($pid,$table,$includeFiles=false) {
        $filerefconfig = [];
    
        if ( $includeFiles ) {
            foreach ( $GLOBALS['TCA'][$table]['columns'] as $col => $config ) {
                if ( $config['config']['type'] == 'inline' && isset($config['config']['foreign_table']) && $config['config']['foreign_table'] == 'sys_file_reference' ) {
                    $filerefconfig[] = $col;
                }
            }
        }
    
        /** @var DatabaseConnection $connection */
        $connection = $GLOBALS['TYPO3_DB'];
        
        $ts = BackendUtility::getPagesTSconfig($pid);
        if ( isset($ts['tx_sudhaus7guard7.']) ) {
            if ( isset($ts['tx_sudhaus7guard7.'][$table . '.']) && isset($ts['tx_sudhaus7guard7.'][$table . '.']['fields']) ) {
                $res = $connection->exec_SELECTquery('*', $table, 'pid='.$pid);
                
                while ( $row = $connection->sql_fetch_assoc($res) ) {
                    $pubkeys = Keys::collectPublicKeys($table, $row['uid'], $pid, false);
            
                    $fieldArray = [];
                    $vaultfields = GeneralUtility::trimExplode(',',
                        $ts['tx_sudhaus7guard7.'][$table . '.']['fields']);
                    foreach ( $vaultfields as $f ) {
                        $fieldArray[$f] = $row[$f];
                    }
                    $fieldArray = Storage::lockRecord($table, $row['uid'], $vaultfields, $fieldArray, $pubkeys);
                    
                    $connection->exec_UPDATEquery($table, 'uid='.$row['uid'], $fieldArray);
                    $this->output->outputLine('locking ' . $row['username']);
            
                    if ( $includeFiles ) {
                        foreach ( $filerefconfig as $reffield ) {
                            //if ($row[$reffield] > 0) {
                    
                            $resref = $connection->exec_SELECTquery('*', 'sys_file_reference', sprintf('tablenames="%s" and fieldname="%s" and uid_foreign="%d"',$table,$reffield,$row['uid']));
                            
                            while ( $ref = $connection->sql_fetch_assoc($resref) ) {
                                $sysfile = $connection->exec_SELECTgetSingleRow('*', 'sys_file', 'uid='.$ref['uid_local']);
                                $ret = Storage::lockFile(PATH_site . '/fileadmin' . $sysfile['identifier'], $pubkeys);
                                $this->output->outputLine('locking file ' . $sysfile['identifier']);
                            }
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Unlock all Data of a table
     *
     * @param int $pid UID of a Folder
     * @param string $table Table to lock
     * @param string $keyfile File with a Masterkey (PEM)
     * @param string $password Password for masterkey
     * @param bool $includeFiles Unlock referenced files as well
     */
    public function unlocktableCommand ($pid,$table,$keyfile,$password='',$includeFiles=false) {
        $key = \file_get_contents($keyfile);
        /** @var DatabaseConnection $connection */
        $connection = $GLOBALS['TYPO3_DB'];
        $filerefconfig = [];
        if ( $includeFiles ) {
            foreach ( $GLOBALS['TCA'][$table]['columns'] as $col => $config ) {
                if ( $config['config']['type'] == 'inline' && isset($config['config']['foreign_table']) && $config['config']['foreign_table'] == 'sys_file_reference' ) {
                    $filerefconfig[] = $col;
                }
            }
        }

        $ts = BackendUtility::getPagesTSconfig($pid);
        if ( isset($ts['tx_sudhaus7guard7.']) ) {
            if ( isset($ts['tx_sudhaus7guard7.'][$table . '.']) && isset($ts['tx_sudhaus7guard7.'][$table . '.']['fields']) ) {
                $res = $connection->exec_SELECTquery('*', $table, 'pid='.$pid);
                while ( $row = $connection->sql_fetch_assoc($res) ) {
                    $fieldArray = [];
                    $vaultfields = GeneralUtility::trimExplode(',',
                        $ts['tx_sudhaus7guard7.'][$table . '.']['fields']);
                    foreach ( $vaultfields as $f ) {
                        $fieldArray[$f] = $row[$f];
                    }
                    $fieldArray = Storage::unlockRecord($table, $fieldArray, $key, $row['uid'], $password);
                    $connection->exec_UPDATEquery($table, 'uid='.$row['uid'], $fieldArray);
                    //$this->output->outputLine('unlocking ' . $row['']);
                
                    if ( $includeFiles ) {
                        foreach ( $filerefconfig as $reffield ) {
                            //if ($row[$reffield] > 0) {
                            $resref = $connection->exec_SELECTquery('*', 'sys_file_reference', sprintf('tablenames="%s" and fieldname="%s" and uid_foreign="%d"',$table,$reffield,$row['uid']));
    
                            while ( $ref = $connection->sql_fetch_assoc($resref) ) {
                                $sysfile = $connection->exec_SELECTgetSingleRow('*', 'sys_file', 'uid='.$ref['uid_local']);
                                $ret = Storage::unlockFile(PATH_site . '/fileadmin' . $sysfile['identifier'], $key, $password);
                                $this->output->outputLine('unlocking file ' . $sysfile['identifier']);
                            }
                        }
                    }
                }
            }
        }
    }
}
