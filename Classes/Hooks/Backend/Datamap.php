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

namespace Sudhaus7\Guard7\Hooks\Backend;

use Sudhaus7\Guard7\SealException;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;
use Sudhaus7\Guard7\Tools\Encoder;
use Sudhaus7\Guard7\Tools\Keys;
use Sudhaus7\Guard7\Tools\Storage;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class Datamap implements SingletonInterface
{
    private array $insertCache = [];

    /**
     * @var string
     */
    private const FIELDNAME = 'fieldname';

    /**
     * @var string
     */
    private const FE_USERS = 'fe_users';

    /**
     * @var string
     */
    private const PASSWORD = 'password';

    /**
     * @var string
     */
    private const TX_GUARD7_PUBLICKEY = 'tx_guard7_publickey';

    /**
     * @var string
     */
    private const TYPO3_CONF_VARS = 'TYPO3_CONF_VARS';

    /**
     * @var string
     */
    private const EXTCONF = 'EXTCONF';

    /**
     * @var string
     */
    private const GUARD7 = 'guard7';

    /**
     * @var string
     */
    private const FIELDS = 'fields';

    /**
     * @param $status
     * @param $table
     * @param $id
     * @param $fieldArray
     * @param DataHandler $pObj
     */
    public function processDatamap_afterDatabaseOperations($status, $table, $id, &$fieldArray, DataHandler &$pObj): void
    {
        if ($status === 'new' && (isset($this->insertCache[$table]) && isset($this->insertCache[$table][$id]) && is_array($this->insertCache[$table][$id]))) {
            $newid = $pObj->substNEWwithIDs[$id];
            /** @var Connection $connection */
            $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_guard7_domain_model_data');
            foreach ($this->insertCache[$table][$id] as $data) {
                $connection->insert('tx_guard7_domain_model_data', [
                    'tablename' => $table,
                    'tableuid' => $newid,
                    self::FIELDNAME => $data[self::FIELDNAME],
                    'secretdata' => $data['encoded'],
                ]);
                $insertid = $connection->lastInsertId();
                Storage::updateKeyLog($insertid, $data['pubkeys']);
            }
        }
    }

    /**
     * @param $incomingFieldArray
     * @param $table
     * @param $id
     * @param DataHandler $pObj
     */
    public function processDatamap_preProcessFieldArray(&$incomingFieldArray, $table, $id, DataHandler &$pObj): void
    {
        if ($table == self::FE_USERS) {
            if (strpos($id, 'NEW') !== false) {
                $password = $incomingFieldArray[self::PASSWORD];
                $keypair = Keys::createKey($password);
                $incomingFieldArray[self::TX_GUARD7_PUBLICKEY] = $keypair['public'];
                $incomingFieldArray['tx_guard7_privatekey'] = $keypair['private'];
            } elseif (strpos($incomingFieldArray[self::PASSWORD], 'rsa:') === false) {
                $tmprec = BackendUtility::getRecord(self::FE_USERS, $id);
                if ($tmprec[self::PASSWORD] != $incomingFieldArray[self::PASSWORD]) {
                    $signature_old = Keys::getChecksum($tmprec[self::TX_GUARD7_PUBLICKEY]);
                    Storage::markForReencode($signature_old);

                    $password = $incomingFieldArray[self::PASSWORD];
                    $keypair = Keys::createKey($password);
                    $incomingFieldArray[self::TX_GUARD7_PUBLICKEY] = $keypair['public'];
                    $incomingFieldArray['tx_guard7_privatekey'] = $keypair['private'];
                }
            }
        }
    }

    /**
     * @param $status
     * @param $table
     * @param $id
     * @param $fieldArray
     * @param DataHandler $pObj
     * @throws SealException
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     */
    public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, DataHandler &$pObj): void
    {

        //fieldArray['pid']
        //	$pObj->substNEWwithIDs

        if ($status === 'new') {
            $vaultfields = $this->getTableFields($table, $fieldArray['pid']);
            if (!empty($vaultfields)) {
                $fieldArray = $this->handeInsert($table, $id, $fieldArray, $vaultfields);
            }
        }

        if ($status === 'update') {
            $extraPubkeys = [];
            if ($table === self::FE_USERS && !empty($fieldArray[self::TX_GUARD7_PUBLICKEY])) {
                $extraPubkeys[] = $fieldArray[self::TX_GUARD7_PUBLICKEY];
            }

            $pid = $pObj->getPID($table, $id);
            $vaultfields = $this->getTableFields($table, $pid);
            if (!empty($vaultfields)) {
                $pubkeys = Helper::collectPublicKeys($table, $id, $pid, false, $extraPubkeys);
                $fieldArray = Storage::lockRecord($table, $id, $vaultfields, $fieldArray, $pubkeys);
            }
        }
    }

    /**
     * @param $table
     * @param $id
     * @param $fieldArray
     * @return array
     * @throws SealException
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     */
    private function handeInsert($table, $id, $fieldArray, array $vaultfields): array
    {
        $extraPubkeys = [];
        if ($table === self::FE_USERS && !empty($fieldArray[self::TX_GUARD7_PUBLICKEY])) {
            $extraPubkeys[] = $fieldArray[self::TX_GUARD7_PUBLICKEY];
        }

        $pubkeys = Helper::collectPublicKeys($table, 0, $fieldArray['pid'], false, $extraPubkeys);

        if (!isset($this->insertCache[$table])) {
            $this->insertCache[$table] = [];
        }

        $this->insertCache[$table][$id] = [];

        foreach ($fieldArray as $fieldname => $value) {
            if (in_array($fieldname, $vaultfields) && strlen($value) > 0) {
                $fieldArray[$fieldname] = '&#128274;';
                //$fieldArray[$fieldname] = '&#128274;'; // 🔒
                $encoder = new Encoder($value, $pubkeys);
                $this->insertCache[$table][$id][] = [
                    self::FIELDNAME => $fieldname,
                    'encoded' => $encoder->run(),
                    'pubkeys' => $pubkeys,
                ];
                unset($encoder);
            }
        }

        return $fieldArray;
    }

    /**
     * @param $table
     * @param $pid
     * @param $tmp
     * @return string[]
     */
    private function getTableFields($table, $pid): array
    {
        $ts = BackendUtility::getPagesTSconfig($pid);
        $vaultfields = [];
        if (isset($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7]) && !empty($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7])) {
            foreach ($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7] as $config) {
                if ($config['tableName'] === $table) {
                    $vaultfields = GeneralUtility::trimExplode(',', $config[self::FIELDS], true);
                }
            }
        }

        if (isset($ts['tx_sudhaus7guard7.'])) {
            $tablekey = $table . '.';
            if (isset($ts['tx_sudhaus7guard7.'][$tablekey]) && isset($ts['tx_sudhaus7guard7.'][$tablekey][self::FIELDS])) {
                $tmpfields = GeneralUtility::trimExplode(',', $ts['tx_sudhaus7guard7.'][$tablekey][self::FIELDS], true);
                if (!empty($tmpfields)) {
                    $vaultfields = array_merge($vaultfields, $tmpfields);
                }
            }
        }

        return $vaultfields;
    }
}
