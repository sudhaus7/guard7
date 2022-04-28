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

namespace Sudhaus7\Guard7\Tools;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use Sudhaus7\Guard7\Adapter\ConfigurationAdapter;
use Sudhaus7\Guard7\Interfaces\Guard7Interface;
use SUDHAUS7\Guard7Core\Service\ChecksumService;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Exception;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;
use function array_merge;
use function class_implements;
use function get_class;

final class Helper
{
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
    private const TABLE_NAME = 'tableName';

    /**
     * @var string
     */
    private const FIELDS = 'fields';

    /**
     * @var string
     */
    private const CLASS_NAME = 'className';

    /**
     * @var string
     */
    private const TSFE = 'TSFE';

    /**
     * @var string
     */
    private const MASTERKEYPUBLIC = 'masterkeypublic';

    /**
     * @var string
     */
    private const TX_GUARD7_PUBLICKEY = 'tx_guard7_publickey';

    /**
     * @param $pid
     * @param null $table
     * @return array|mixed
     */
    public static function getTsConfig($pid, $table = null)
    {
        $cacheKey = __METHOD__ . '-CACHE';
        if (!isset($GLOBALS[$cacheKey])) {
            $GLOBALS[$cacheKey] = [];
        }

        if (!isset($GLOBALS[$cacheKey][$pid])) {
            $pageTs = BackendUtility::getPagesTSconfig($pid);
            if (isset($pageTs['tx_sudhaus7guard7.'])) {
                $GLOBALS[$cacheKey][$pid] = $pageTs['tx_sudhaus7guard7.'];
            }
        }

        if ($table !== null) {
            return $GLOBALS[$cacheKey][$pid][$table . '.'] ?? [];
        }

        return $GLOBALS[$cacheKey][$pid] ?? [];
    }

    /**
     * @param $pid
     * @param null $table
     * @return array
     */
    public static function getTsPublicKeys($pid, $table = null): array
    {
        $pageTs = self::getTsConfig($pid);
        $ret = [];

        if (isset($pageTs['generalPublicKeys.']) && !empty($pageTs['generalPublicKeys.'])) {
            foreach ($pageTs['generalPublicKeys.'] as $key) {
                $ret[] = $key;
            }
        }

        if ($table) {
            $tabledot = $table . '.';
            if (isset($pageTs[$tabledot]['publicKeys.']) && is_array($pageTs[$tabledot]['publicKeys.'])) {
                foreach ($pageTs[$tabledot]['publicKeys.'] as $key) {
                    $ret[] = $key;
                }
            }
        }

        return $ret;
    }

    /**
     * @return array
     */
    public static function getFields(string $table, int $pid = 0): array
    {
        $fields = [];
        if (!empty($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7])) {
            foreach ($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7] as $config) {
                if (isset($config[self::TABLE_NAME]) && $config[self::TABLE_NAME] === $table) {
                    $myfields = $config[self::FIELDS];
                    if (!is_array($myfields)) {
                        $myfields =  GeneralUtility::trimExplode(',', $myfields, true);
                    }

                    if (!empty($myfields)) {
                        $fields = $myfields;
                    }
                }
            }
        }

        if ($pid > 0) {
            $pageTS = self::getTsConfig($pid, $table);
            if (isset($pageTS[self::FIELDS])) {
                $myfields = GeneralUtility::trimExplode(',', $pageTS[self::FIELDS], true);
                if (!empty($myfields)) {
                    $fields = array_merge($fields, $myfields);
                }
            }
        }

        return $fields;
    }

    /**
     * @param AbstractEntity $obj
     * @param null $table
     * @return array
     * @throws Exception
     */
    public static function getModelFields(AbstractEntity $obj, $table = null): array
    {
        if ($table === null) {
            $table = self::getModelTable($obj);
        }

        return self::getFields($table, $obj->getPid());
    }

    /**
     * @param AbstractEntity $obj
     * @return string|null
     * @throws Exception
     */
    public static function getModelTable(AbstractEntity $obj): ?string
    {
        return self::getClassTable( get_class($obj));
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public static function getClassTable(string $class): ?string
    {
        $table = null;
        if (!empty($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7])) {
            foreach ($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7] as $config) {
                if (isset($config[self::CLASS_NAME]) && $config[self::CLASS_NAME] === $class && isset($config[self::TABLE_NAME]) && !empty($config[self::TABLE_NAME])) {
                    $table = $config[self::TABLE_NAME];
                }
            }
        }

        if ($table === null) {
            $om = GeneralUtility::makeInstance(ObjectManager::class);
            $dataMapper = $om->get(DataMapper::class);
            $table = $dataMapper->getDataMap($class)->getTableName();
        }

        return $table;
    }

    /**
     * @param $className
     * @return bool
     * @throws Exception
     */
    public static function classIsGuard7Element($className, $pid=0): bool
    {
        if (in_array(Guard7Interface::class, class_implements($className), true)) {
            return true;
        }

        if (!empty($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7])) {
            foreach ($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7] as $config) {
                if (isset($config[self::CLASS_NAME]) && $className === $config[self::CLASS_NAME]) {
                    return true;
                }
            }
        }

        if ($pid===0 && isset($GLOBALS[self::TSFE])) {
            $pid = $GLOBALS[self::TSFE]->id;
        }

        if ($pid > 0) {
            $table = self::getClassTable($className);
            if ($table !== null) {
                $ts = self::getTsConfig($pid, $table);
                return !empty($ts);
            }
        }

        return false;
    }

    public static function tableIsGuard7Element($tableName, $pid=0): bool
    {
        if (!empty($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7])) {
            foreach ($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7] as $config) {
                if (isset($config[self::TABLE_NAME]) && $tableName === $config[self::TABLE_NAME]) {
                    return true;
                }
            }
        }

        if ($pid===0 && isset($GLOBALS[self::TSFE])) {
            $pid = (int)$GLOBALS[self::TSFE]->id;
        }

        if ($pid > 0) {
            $ts = self::getTsConfig($pid, $tableName);
            return !empty($ts);
        }
    }

    /**
     * @return mixed[]
     */
    public static function getAllGuard7Tables($pid=0): array
    {
        $tables = [];
        if (!empty($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7])) {
            foreach ($GLOBALS[self::TYPO3_CONF_VARS][self::EXTCONF][self::GUARD7] as $config) {
                if (isset($config[self::TABLE_NAME])) {
                    $tables[]=$config[self::TABLE_NAME];
                }
            }
        }

        if ($pid===0 && isset($GLOBALS[self::TSFE])) {
            $pid = (int)$GLOBALS[self::TSFE]->id;
        }

        if ($pid > 0) {
            $ts = self::getTsConfig($pid);
            foreach ($ts as $tableName=>$config) {
                $tables[] = trim($tableName, '.');
            }
        }

        return $tables;
    }

    public static function checkLockedValue($value): bool
    {
        return $value === '&#128274;' || $value === '🔒';
    }

    /**
     * @throws Exception
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @param mixed[] $aPubkeys
     * @return mixed[]
     */
    public static function collectPublicKeysForModel(AbstractEntity $obj, bool $checkFEuser = false, array $aPubkeys = []): array
    {
        $class = get_class($obj);
        $table = Helper::getClassTable($class);
        $encodeStorage = GeneralUtility::makeInstance(FrontendUserPublicKeySingleton::class);

        if (!$checkFEuser && $encodeStorage->has($obj)) {
            $checkFEuser = true;
            $encodeStorage->remove($obj);
        }

        return self::collectPublicKeys($table, (int)$obj->getUid(), (int)$obj->getPid(), $checkFEuser, $aPubkeys);
    }

    /**
     * @param null $table
     * @param mixed $uid
     *
     * @return array
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @param mixed[] $aPubkeys
     */
    public static function collectPublicKeys($table = null, $uid = 0, int $pid = 0, bool $checkFEuser = false, array $aPubkeys = []): array
    {

        /** @var Dispatcher $signalSlotDispatcher */
        $signalSlotDispatcher = GeneralUtility::makeInstance(Dispatcher::class);

        /** @var ChecksumService $checksumService */
        $checksumService = GeneralUtility::makeInstance(ChecksumService::class);
        /** @var ConfigurationAdapter $configadapter */
        $configadapter = GeneralUtility::makeInstance(ConfigurationAdapter::class);

        $pubKeys = [];

        // Signal Global
        $keysFromSignalslot = [];
        [$keysFromSignalslot] = $signalSlotDispatcher->dispatch(__CLASS__, 'global', [$keysFromSignalslot, $uid, $pid]);

        // Signal Name by table for example: collectPublicKeys_fe_users
        [$keysFromSignalslot] = $signalSlotDispatcher->dispatch(__CLASS__, __FUNCTION__ . '_' . $table, [$keysFromSignalslot, $uid, $pid]);

        if (!empty($keysFromSignalslot)) {
            foreach ($keysFromSignalslot as $key) {
                $pubKeys[$checksumService->calculate($key)] = $key;
            }
        }

        if (!empty($aPubkeys)) {
            foreach ($aPubkeys as $key) {
                $pubKeys[$checksumService->calculate($key)] = $key;
            }
        }

        if (!empty($configadapter->config[self::MASTERKEYPUBLIC])) {
            $checksum = $checksumService->calculate($configadapter->config[self::MASTERKEYPUBLIC]);
            $pubKeys[$checksum] = $configadapter->config[self::MASTERKEYPUBLIC][self::MASTERKEYPUBLIC];
        }

        if ($pid > 0) {
            $tskeys = Helper::getTsPublicKeys($pid, $table);
            foreach ($tskeys as $key) {
                $pubKeys[$checksumService->calculate($key)] = $key;
            }
        }

        if ($checkFEuser && isset($GLOBALS[self::TSFE]) && GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('frontend.user', 'isLoggedIn') && (isset($GLOBALS[self::TSFE]->fe_user->user[self::TX_GUARD7_PUBLICKEY]) && !empty($GLOBALS[self::TSFE]->fe_user->user[self::TX_GUARD7_PUBLICKEY]))) {
            $pubKeys[$checksumService->calculate($GLOBALS[self::TSFE]->fe_user->user[self::TX_GUARD7_PUBLICKEY])] = $GLOBALS[self::TSFE]->fe_user->user[self::TX_GUARD7_PUBLICKEY];
        }

        return $pubKeys;
    }
}
