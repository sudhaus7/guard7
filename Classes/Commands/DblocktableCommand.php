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

use function array_values;
use PDO;
use Sudhaus7\Guard7\Tools\Helper;
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
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

final class DblocktableCommand extends Command
{
    /**
     * @var string
     */
    private const PID = 'pid';

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
        $this->setDescription('Lock all Datafields for a table and pid')
            ->setHelp('call it like this typo3/sysext/core/bin/typo3 guard7:db:lock --pid=123 --table=fe_users')
            ->addOption(
                'table',
                't',
                InputOption::VALUE_REQUIRED,
                'Table to lock'
            )
            ->addOption(
                self::PID,
                self::PID,
                InputOption::VALUE_OPTIONAL,
                'UID of a Folder'
            )
            ->addOption(
                self::INCLUDE_FILES,
                self::INCLUDE_FILES,
                InputOption::VALUE_NONE,
                'Lock referenced files as well'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $table = $input->getOption('table');
        $pid = (int)$input->getOption(self::PID);
        $lockFiles = $input->hasOption(self::INCLUDE_FILES);

        $filerefconfig = [];

        if ($lockFiles) {
            foreach ($GLOBALS['TCA'][$table]['columns'] as $col => $config) {
                if ($config[self::CONFIG]['type'] == 'inline' && isset($config[self::CONFIG]['foreign_table']) && $config[self::CONFIG]['foreign_table'] == 'sys_file_reference') {
                    $filerefconfig[] = $col;
                }
            }
        }

        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable($table);

        $where = [];
        if ($pid > 0) {
            $where[self::PID] = $pid;
        }

        $count = $connection->count(self::UID, $table, $where);
        $res = $connection->select(['*'], $table, $where);

        $output->write("\nStart locking (get a coffee, this can take a while..)", true);
        $counter = 1;
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $config = $this->getConfig($row[self::PID], $table);
            if ($config) {
                $keys = [];
                if (isset($config['publicKeys.']) && !empty($config['publicKeys.'])) {
                    $keys = array_values($config['publicKeys.']);
                }

                $pubkeys = Helper::collectPublicKeys($table, $row[self::UID], $pid, false, $keys);

                $fieldArray = [];
                $vaultfields = GeneralUtility::trimExplode(',', $config['fields']);
                foreach ($vaultfields as $f) {
                    $fieldArray[$f] = $row[$f];
                }

                $fieldArray = Storage::lockRecord($table, $row[self::UID], $vaultfields, $fieldArray, $pubkeys);
                $connection->update($table, $fieldArray, [self::UID => $row[self::UID]]);
                $output->write("\rLocking Record " . $counter . ' of ' . $count['xcount']);

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
                            Storage::lockFile(Environment::getPublicPath() . '/' . '/fileadmin' . $sysfile['identifier'], $pubkeys);
                        }
                    }
                }
            }

            ++$counter;
        }

        $output->write("\nDone", true);
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

        $tablefield = $table . '.';
        if (isset($this->configcache[$pid][$tablefield]['fields'])) {
            return $this->configcache[$pid][$tablefield];
        }

        return false;
    }
}
