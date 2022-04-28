<?php

/*
 * This file is part of the TYPO3 project.
 * (c) 2022 B-Factor GmbH
 *          Sudhaus7
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 * @copyright 2022 B-Factor GmbH https://b-factor.de/
 * @author Frank Berger <fberger@b-factor.de>
 */

namespace Sudhaus7\Guard7\Commands;

use function file_get_contents;
use PDO;
use Sudhaus7\Guard7\Tools\Storage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class DbunlocktableCommand extends Command
{
    /**
     * @var string
     */
    private const KEYFILE = 'keyfile';

    /**
     * @var string
     */
    private const PID = 'pid';

    /**
     * @var string
     */
    private const PASSWORD = 'password';

    /**
     * @var string
     */
    private const INCLUDE_FILES = 'includeFiles';

    /**
     * @var string
     */
    private const CONFIG = 'config';

    /**
     * @var string
     */
    private const UID = 'uid';

    protected function configure(): void
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
                self::KEYFILE,
                self::KEYFILE,
                InputOption::VALUE_REQUIRED,
                'File with a Masterkey (PEM)'
            )
            ->addOption(
                self::PID,
                self::PID,
                InputOption::VALUE_OPTIONAL,
                'UID of a Folder'
            )
            ->addOption(
                self::PASSWORD,
                'p',
                InputOption::VALUE_OPTIONAL,
                'Password for masterkey'
            )
            ->addOption(
                self::INCLUDE_FILES,
                self::INCLUDE_FILES,
                InputOption::VALUE_NONE,
                'Unlock referenced files as well'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $table = $input->getOption('table');
        $pid = (int)$input->getOption(self::PID);
        $keyfile = $input->getOption(self::KEYFILE);
        $key = file_get_contents($keyfile);
        $password = $input->hasOption(self::PASSWORD) ? $input->getOption(self::PASSWORD) : null;
        $lockFiles = $input->hasOption(self::INCLUDE_FILES);
        $filerefconfig = [];
        if ($lockFiles) {
            foreach ($GLOBALS['TCA'][$table]['columns'] as $col => $config) {
                if ($config[self::CONFIG]['type'] == 'inline' && isset($config[self::CONFIG]['foreign_table']) && $config[self::CONFIG]['foreign_table'] == 'sys_file_reference') {
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
            $where[self::PID] = $pid;
        }

        $count = $connection->count(self::UID, $table, $where);
        $res = $connection->select(['*'], $table, $where);
        $counter = 1;
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $output->write("\rUnlocking Record " . $counter . ' of ' . $count['xcount']);

            $config = $this->getConfig($row[self::PID], $table);
            if ($config) {
                $fieldArray = [];
                $vaultfields = GeneralUtility::trimExplode(',', $config['fields']);
                foreach ($vaultfields as $f) {
                    $fieldArray[$f] = $row[$f];
                }

                $fieldArray = Storage::unlockRecord($table, $fieldArray, $key, $password, $row[self::UID]);
                $connection->update($table, $fieldArray, [self::UID => $row[self::UID]]);

                if ($lockFiles) {
                    foreach ($filerefconfig as $reffield) {
                        //if ($row[$reffield] > 0) {

                        $resref = $connection->select(['*'], 'sys_file_reference', [
                            'tablenames' => $table,
                            'fieldname' => $reffield,
                            'uid_foreign' => $row[self::UID],
                        ]);
                        while ($ref = $resref->fetch(PDO::FETCH_ASSOC)) {
                            $sysfile = $connection->select(['*'], 'sys_file', [self::UID => $ref['uid_local']])->fetch(PDO::FETCH_ASSOC);
                            $ret = Storage::unlockFile(Environment::getPublicPath() . '/' . '/fileadmin' . $sysfile['identifier'], $key, $password);
                            //  $output->writeln(['unlocking file ' . $sysfile['identifier']]);
                        }
                    }
                }
            }

            ++$counter;
        }
    }

    public array $configcache = [];

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
