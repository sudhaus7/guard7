<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 30.04.18
 * Time: 14:47
 */

namespace SUDHAUS7\Guard7\Tools;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Helper
{
    public static function getTsConfig($pid, $table = null)
    {
        $cacheKey = __METHOD__ . '-CACHE';
        if (!isset($GLOBALS[$cacheKey])) {
            $GLOBALS[$cacheKey] = [];
        }
        if (!isset($GLOBALS[$cacheKey][$pid])) {
            $ts = BackendUtility::getPagesTSconfig($pid);
            if (isset($ts['tx_sudhaus7guard7.'])) {
                // if ( isset($ts['tx_sudhaus7guard7.'][$table.'.']) && !empty($ts['tx_sudhaus7guard7.'][$table.'.'])) {
                $GLOBALS[$cacheKey][$pid] = $ts['tx_sudhaus7guard7.'];
                //$GLOBALS['__METHOD__'.'-CACHE'][$table.'-'.$pid] = GeneralUtility::trimExplode(',', $ts['tx_sudhaus7guard7.'][$table.'.']['fields'],true)
                //}
            }
        }
        if ($table !== null) {
            $tableKey = $table.'.';
            return isset($GLOBALS[$cacheKey][$pid][$tableKey]) ? $GLOBALS[$cacheKey][$pid][$tableKey] : [];
        }
        return isset($GLOBALS[$cacheKey][$pid]) ? $GLOBALS[$cacheKey][$pid] : [];
    }
    
    /**
     * @param $table
     * @param $pid
     * @return array
     */
    public static function getTsConfigCustom($pid, $table = null)
    {
        $cacheKey = __METHOD__ . '-CACHE';
        
        if (!isset($GLOBALS[$cacheKey])) {
            $GLOBALS[$cacheKey] = [];
        }
        if (!isset($GLOBALS[$cacheKey][$pid])) {
            $rootline = GeneralUtility::makeInstance(RootlineUtility::class, $pid, '', null);
            try {
                $rl = $rootline->get();
            } catch (\RuntimeException $ex) {
                return [];
            }
            
            ksort($rl);
            //tsconfig_includes
            $code = $GLOBALS['TYPO3_CONF_VARS']['BE']['defaultPageTSconfig'];
            foreach ($rl as $p) {
                if (trim($p['tsconfig_includes'])) {
                    $includeTsConfigFileList = GeneralUtility::trimExplode(',', $p['tsconfig_includes'], true);
                    // Traversing list
                    foreach ($includeTsConfigFileList as $key => $includeTsConfigFile) {
                        if (StringUtility::beginsWith($includeTsConfigFile, 'EXT:')) {
                            list($includeTsConfigFileExtensionKey, $includeTsConfigFilename) = explode(
                                '/',
                                substr($includeTsConfigFile, 4),
                                2
                            );
                            if (
                                (string)$includeTsConfigFileExtensionKey !== ''
                                && ExtensionManagementUtility::isLoaded($includeTsConfigFileExtensionKey)
                                && (string)$includeTsConfigFilename !== ''
                            ) {
                                $includeTsConfigFileAndPath = ExtensionManagementUtility::extPath($includeTsConfigFileExtensionKey) .
                                    $includeTsConfigFilename;
                                if (file_exists($includeTsConfigFileAndPath)) {
                                    $code .= "\n" . GeneralUtility::getUrl($includeTsConfigFileAndPath);
                                }
                            }
                        }
                    }
                }
                
                $code .= "\n" . $p['TSconfig'];
            }
            
            /** @var  TypoScriptParser $oTSparser */
            $oTSparser = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TypoScript\\Parser\\TypoScriptParser');
            $oTSparser->parse($code);
            $ts = $oTSparser->setup;
            if (isset($ts['tx_sudhaus7guard7.'])) {
                // if ( isset($ts['tx_sudhaus7guard7.'][$table.'.']) && !empty($ts['tx_sudhaus7guard7.'][$table.'.'])) {
                $GLOBALS[$cacheKey][$pid] = $ts['tx_sudhaus7guard7.'];
                //$GLOBALS['__METHOD__'.'-CACHE'][$table.'-'.$pid] = GeneralUtility::trimExplode(',', $ts['tx_sudhaus7guard7.'][$table.'.']['fields'],true)
                //}
            }
        }
        if ($table !== null) {
            $tableKey = $table.'.';
            return isset($GLOBALS[$cacheKey][$pid][$tableKey]) ? $GLOBALS[$cacheKey][$pid][$tableKey] : [];
        }
        return isset($GLOBALS[$cacheKey][$pid]) ? $GLOBALS[$cacheKey][$pid] : [];
    }
    
    public static function getTsPubkeys($pid, $table = null)
    {
        $ts = self::getTsConfig($pid);
        $ret = [];
        
        if (isset($ts['generalPublicKeys.']) && !empty($ts['generalPublicKeys.'])) {
            foreach ($ts['generalPublicKeys.'] as $key) {
                $ret[] = $key;
            }
        }
        if ($table) {
            if (isset($ts[$table . '.']) && isset($ts[$table . '.']['publicKeys.']) && is_array($ts[$table . '.']['publicKeys.'])) {
                foreach ($ts[$table . '.']['publicKeys.'] as $key) {
                    $ret[] = $key;
                }
            }
        }
        return $ret;
    }
    
    /**
     * @param string $table
     * @param int $pid
     * @return array
     */
    public static function getFields($table, $pid = 0)
    {
        $fields = [];
        if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] as $config) {
                if (isset($config['tableName']) && $config['tableName'] === $table) {
                    $myfields = $config['fields'];
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
            $ts = self::getTsConfig($pid, $table);
            if (isset($ts['fields'])) {
                $myfields = GeneralUtility::trimExplode(',', $ts['fields'], true);
                if (!empty($myfields)) {
                    $fields = \array_merge($fields, $myfields);
                }
            }
        }
        return $fields;
    }
    
    /**
     * @param AbstractEntity $obj
     * @param null $table
     * @return array
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     */
    public static function getModelFields(AbstractEntity $obj, $table = null)
    {
        if ($table === null) {
            $table = self::getModelTable($obj);
        }
        return self::getFields($table, $obj->getPid());
    }
    
    /**
     * @param AbstractEntity $obj
     * @return string
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     */
    public static function getModelTable(AbstractEntity $obj)
    {
        return self::getClassTable(\get_class($obj));
    }
    
    /**
     * @param string $class
     * @return string|null
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     */
    public static function getClassTable($class)
    {
        
        $table = null;
        if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] as $config) {
                if (isset($config['className']) && $config['className'] === $class && isset($config['tableName']) && !empty($config['tableName'])) {
                    $table = $config['tableName'];
                }
            }
        }
        
        if ($table === null) {
            $dataMapper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper::class);
            $table = $dataMapper->getDataMap($class)->getTableName();
        }
        return $table;
    }
    
    /**
     * @param $className
     * @return bool
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     */
    public static function classIsGuard7Element($className,$pid=0)
    {
        
        if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] as $config) {
                if(isset($config['className']) && $className === $config['className']) {
                    return true;
                }
            }
        }
    
        if ($pid===0) {
            if (isset($GLOBALS['TSFE'])) {
                $pid = $GLOBALS['TSFE']->id;
            }
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
    
    public static function tableIsGuard7Element($tableName,$pid=0)
    {
        if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] as $config) {
                if(isset($config['tableName']) && $tableName === $config['tableName']) {
                    return true;
                }
            }
        }
        if ($pid===0) {
            if (isset($GLOBALS['TSFE'])) {
                $pid = (int)$GLOBALS['TSFE']->id;
            }
        }
        if ($pid > 0) {
            $ts = self::getTsConfig($pid, $tableName);
            return !empty($ts);
        }
    }
    
    public static function getAllGuard7Tables($pid=0)
    {
        $tables = [];
        if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] as $config) {
                if(isset($config['tableName']) ) {
                    $tables[]=$config['tableName'];
                }
            }
        }
        
        if ($pid===0) {
            if (isset($GLOBALS['TSFE'])) {
                $pid = (int)$GLOBALS['TSFE']->id;
            }
        }
        if ($pid > 0) {
            $ts = self::getTsConfig($pid);
            foreach ($ts as $tableName=>$config) {
                $tables[] = trim($tableName, '.');
            }
        }
        return $tables;
    }
    
    public static function checkLockedValue($value)
    {
        return $value === '&#128274;' || $value === '🔒';
    }
    
    public static function getExtensionConfig()
    {
        $confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['guard7'], ['allowed_classes'=>[]]);
        return $confArr;
    }
}
