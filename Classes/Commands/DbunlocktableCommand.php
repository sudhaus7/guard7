<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 26.02.18
 * Time: 16:28
 */

namespace SUDHAUS7\Guard7\Commands;

use SUDHAUS7\Guard7\Tools\Storage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DbunlocktableCommand extends Command
{
    public function configure()
    {
        $this->setDescription('Unlock all Datafields for a table and pid')
            ->setHelp('call it like this typo3/sysext/core/bin/typo3 guard7:db:unlock --pid=123 --table=fe_users --keyfile=/path/to/key.pem')
            ->addOption(
                'table',
                't',
                InputOption::VALUE_REQUIRED,
                'Table to lock'
            )
            ->addOption(
                'keyfile',
                'keyfile',
                InputOption::VALUE_REQUIRED,
                'File with a Masterkey (PEM)'
            )
            ->addOption(
                'pid',
                'pid',
                InputOption::VALUE_OPTIONAL,
                'UID of a Folder'
            )
            ->addOption(
                'password',
                'p',
                InputOption::VALUE_OPTIONAL,
                'Password for masterkey'
            )
            ->addOption(
                'includeFiles',
                'includeFiles',
                InputOption::VALUE_NONE,
                'Unlock referenced files as well'
            );
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $table = $input->getOption('table');
        $pid = (int)$input->getOption('pid');
        $keyfile = $input->getOption('keyfile');
        $key = \file_get_contents($keyfile);
        $password = $input->hasOption('password') ? $input->getOption('password') : null;
        $lockFiles = $input->hasOption('includeFiles');
        $filerefconfig = [];
        if ($lockFiles) {
            foreach ($GLOBALS['TCA'][$table]['columns'] as $col => $config) {
                if ($config['config']['type'] == 'inline' && isset($config['config']['foreign_table']) && $config['config']['foreign_table'] == 'sys_file_reference') {
                    $filerefconfig[] = $col;
                }
            }
        }
    
        $output->write("\nStart unlocking (get a coffee, this can take a while..)", true);
        
        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable($table);
        $where = [];
        if ($pid > 0) {
            $where['pid'] = $pid;
        }
    
        $count = $connection->count('uid', $table, $where);
        $res = $connection->select(['*'], $table, $where);
        $counter = 1;
        while ($row = $res->fetch(\PDO::FETCH_ASSOC)) {
            $output->write("\rUnlocking Record " . $counter . " of " . $count['xcount']);
        
        
            $config = $this->getConfig($row['pid'], $table);
            if ($config) {
                $fieldArray = [];
                $vaultfields = GeneralUtility::trimExplode(',', $config['fields']);
                foreach ($vaultfields as $f) {
                    $fieldArray[$f] = $row[$f];
                }
                $fieldArray = Storage::unlockRecord($table, $fieldArray, $key, $password, $row['uid']);
                $connection->update($table, $fieldArray, ['uid' => $row['uid']]);
                
                
                if ($lockFiles) {
                    foreach ($filerefconfig as $reffield) {
                        //if ($row[$reffield] > 0) {
                    
                        $resref = $connection->select(['*'], 'sys_file_reference', [
                            'tablenames' => $table,
                            'fieldname' => $reffield,
                            'uid_foreign' => $row['uid']
                        ]);
                        while ($ref = $resref->fetch(\PDO::FETCH_ASSOC)) {
                            $sysfile = $connection->select(['*'], 'sys_file', ['uid' => $ref['uid_local']])->fetch(\PDO::FETCH_ASSOC);
                            $ret = Storage::unlockFile(PATH_site . '/fileadmin' . $sysfile['identifier'], $key, $password);
                            //  $output->writeln(['unlocking file ' . $sysfile['identifier']]);
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
                $this->configcache[$pid] = $ts['tx_sudhaus7guard7.'];
            }
        }
        if (isset($this->configcache[$pid][$table . '.']['fields'])) {
            return $this->configcache[$pid][$table . '.'];
        }
        return false;
    }
}
