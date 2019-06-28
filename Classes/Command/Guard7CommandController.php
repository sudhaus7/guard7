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

class Guard7CommandController extends CommandController
{
    
    /**
     * Lock all data of a table
     *
     * @param $table
     * @param int $pid
     * @param bool $includeFiles
     * @throws \SUDHAUS7\Guard7\SealException
     */
    public function locktableCommand($table, $pid=0, $includeFiles=false)
    {
        $filerefconfig = [];
    
        if ($includeFiles) {
            foreach ($GLOBALS['TCA'][$table]['columns'] as $col => $config) {
                if ($config['config']['type'] == 'inline' && isset($config['config']['foreign_table']) && $config['config']['foreign_table'] == 'sys_file_reference') {
                    $filerefconfig[] = $col;
                }
            }
        }
    
        $this->output("\nStart locking (get a coffee, this can take a while..)\n");
        /** @var DatabaseConnection $connection */
        $connection = $GLOBALS['TYPO3_DB'];

        if ($pid && $pid>0) {
            $count = $connection->exec_SELECTgetSingleRow('count(uid) as xcount', $table, 'pid='.$pid);
            $res = $connection->exec_SELECTquery('*', $table, 'pid=' . $pid);
        } else {
            $count = $connection->exec_SELECTgetSingleRow('count(uid) as xcount', $table, '1=1');
            $res = $connection->exec_SELECTquery('*', $table, '1=1');
        }
        $counter = 1;
        while ($row = $connection->sql_fetch_assoc($res)) {
            $config = $this->getConfig($row['pid'], $table);
            $this->output("\rLocking Record ".$counter." of ".$count['xcount']);
            if ($config) {
                $keys = [];
                if (isset($config['publicKeys.']) && !empty($config['publicKeys.'])) {
                    $keys = \array_values($config['publicKeys.']);
                }
                $pubkeys = Keys::collectPublicKeys($table, $row['uid'], $row['pid'], false, $keys);
    
                $fieldArray = [];
                $vaultfields = GeneralUtility::trimExplode(',', $config['fields']);
                foreach ($vaultfields as $f) {
                    $fieldArray[$f] = $row[$f];
                }
                $fieldArray = Storage::lockRecord($table, $row['uid'], $vaultfields, $fieldArray, $pubkeys);
    
                $connection->exec_UPDATEquery($table, 'uid=' . $row['uid'], $fieldArray);
               
    
                if ($includeFiles) {
                    foreach ($filerefconfig as $reffield) {
                        //if ($row[$reffield] > 0) {
            
                        $resref = $connection->exec_SELECTquery('*', 'sys_file_reference', sprintf('tablenames="%s" and fieldname="%s" and uid_foreign="%d"', $table, $reffield, $row['uid']));
            
                        while ($ref = $connection->sql_fetch_assoc($resref)) {
                            $sysfile = $connection->exec_SELECTgetSingleRow('*', 'sys_file', 'uid=' . $ref['uid_local']);
                            $ret = Storage::lockFile(PATH_site . '/fileadmin' . $sysfile['identifier'], $pubkeys);
                            //$this->output->outputLine('locking file ' . $sysfile['identifier']);
                        }
                    }
                }
            }
            $counter++;
        }
    }
    
    public $configcache = [];
    
    /**
     * @param $pid
     * @param $table
     * @return bool|mixed
     */
    private function getConfig($pid, $table)
    {
        if (!isset($this->configcache[$pid])) {
            $ts = BackendUtility::getPagesTSconfig($pid);
            if (isset($ts['tx_sudhaus7guard7.'])) {
                $this->configcache[$pid]=$ts['tx_sudhaus7guard7.'];
            }
        }
        if (isset($this->configcache[$pid]) && isset($this->configcache[$pid][$table.'.'])  && isset($this->configcache[$pid][$table . '.']['fields'])) {
            return $this->configcache[$pid][$table.'.'];
        }
        return false;
    }
    
    /**
     * Unlock all Data of a table
     *
     * @param string $table Table to lock
     * @param string $keyfile File with a Masterkey (PEM)
     * @param int $pid UID of a Folder
     * @param string $password Password for masterkey
     * @param bool $includeFiles Unlock referenced files as well
     */
    public function unlocktableCommand($table, $keyfile, $pid=0, $password='', $includeFiles=false)
    {
        $key = \file_get_contents($keyfile);
        /** @var DatabaseConnection $connection */
        $connection = $GLOBALS['TYPO3_DB'];
        $filerefconfig = [];
        if ($includeFiles) {
            foreach ($GLOBALS['TCA'][$table]['columns'] as $col => $config) {
                if ($config['config']['type'] == 'inline' && isset($config['config']['foreign_table']) && $config['config']['foreign_table'] == 'sys_file_reference') {
                    $filerefconfig[] = $col;
                }
            }
        }
    
        $this->output("\nStart unlocking\n");
        if ($pid && $pid > 0) {
            $count = $connection->exec_SELECTgetSingleRow('count(uid) as xcount', $table, 'pid='.$pid);
            $res = $connection->exec_SELECTquery('*', $table, 'pid=' . $pid);
        } else {
            $count = $connection->exec_SELECTgetSingleRow('count(uid) as xcount', $table, '1=1');
    
            $res = $connection->exec_SELECTquery('*', $table, '1=1');
        }
        $counter = 1;
        while ($row = $connection->sql_fetch_assoc($res)) {
            $config = $this->getConfig($row['pid'], $table);
            $this->output("\rUnlocking Record ".$counter." of ".$count['xcount']);
            if ($config) {
                $fieldArray = [];
                $vaultfields = GeneralUtility::trimExplode(',', $config['fields'], true);
                foreach ($vaultfields as $f) {
                    $fieldArray[$f] = $row[$f];
                }
                $fieldArray = Storage::unlockRecord($table, $fieldArray, $key, $row['uid'], $password);
                $connection->exec_UPDATEquery($table, 'uid=' . $row['uid'], $fieldArray);
                //$this->output->outputLine('unlocking ' . $row['']);
                
                if ($includeFiles) {
                    foreach ($filerefconfig as $reffield) {
                        //if ($row[$reffield] > 0) {
                        $resref = $connection->exec_SELECTquery('*', 'sys_file_reference', sprintf('tablenames="%s" and fieldname="%s" and uid_foreign="%d"', $table, $reffield, $row['uid']));
            
                        while ($ref = $connection->sql_fetch_assoc($resref)) {
                            $sysfile = $connection->exec_SELECTgetSingleRow('*', 'sys_file', 'uid=' . $ref['uid_local']);
                            $ret = Storage::unlockFile(PATH_site . '/fileadmin' . $sysfile['identifier'], $key, $password);
                            $this->output->outputLine('unlocking file ' . $sysfile['identifier']);
                        }
                    }
                }
            }
            $counter++;
        }
        $this->output("\r\nUnlocking Done\n");
    }
}
