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

class Helper {
    
    
    public static function getTsConfig($pid, $table = null) {
        if ( !isset($GLOBALS['__METHOD__' . '-CACHE']) ) $GLOBALS['__METHOD__' . '-CACHE'] = [];
        if ( !isset($GLOBALS['__METHOD__' . '-CACHE'][$pid]) ) {
            $ts = BackendUtility::getPagesTSconfig($pid);
            if ( isset($ts['tx_sudhaus7guard7.']) ) {
                // if ( isset($ts['tx_sudhaus7guard7.'][$table.'.']) && !empty($ts['tx_sudhaus7guard7.'][$table.'.'])) {
                $GLOBALS['__METHOD__' . '-CACHE'][$pid] = $ts['tx_sudhaus7guard7.'];
                //$GLOBALS['__METHOD__'.'-CACHE'][$table.'-'.$pid] = GeneralUtility::trimExplode(',', $ts['tx_sudhaus7guard7.'][$table.'.']['fields'],true)
                //}
            }
        }
        if ( $table ) {
            return isset($GLOBALS['__METHOD__' . '-CACHE'][$pid][$table . '.']) ? $GLOBALS['__METHOD__' . '-CACHE'][$pid][$table . '.'] : [];
        }
        return isset($GLOBALS['__METHOD__' . '-CACHE'][$pid]) ? $GLOBALS['__METHOD__' . '-CACHE'][$pid] : [];
    }
    
    /**
     * @param $table
     * @param $pid
     * @return array
     */
    public static function getTsConfigCustom($pid, $table = null) {
        if ( !isset($GLOBALS['__METHOD__' . '-CACHE']) ) $GLOBALS['__METHOD__' . '-CACHE'] = [];
        if ( !isset($GLOBALS['__METHOD__' . '-CACHE'][$pid]) ) {
            $rootline = GeneralUtility::makeInstance(RootlineUtility::class, $pid, '', null);
            try {
                $rl = $rootline->get();
            } catch ( \RuntimeException $ex ) {
                return [];
            }
            
            ksort($rl);
            //tsconfig_includes
            $code = $GLOBALS['TYPO3_CONF_VARS']['BE']['defaultPageTSconfig'];
            foreach ( $rl as $p ) {
                
                if ( trim($p['tsconfig_includes']) ) {
                    $includeTsConfigFileList = GeneralUtility::trimExplode(',', $p['tsconfig_includes'], true);
                    // Traversing list
                    foreach ( $includeTsConfigFileList as $key => $includeTsConfigFile ) {
                        if ( StringUtility::beginsWith($includeTsConfigFile, 'EXT:') ) {
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
                                if ( file_exists($includeTsConfigFileAndPath) ) {
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
            if ( isset($ts['tx_sudhaus7guard7.']) ) {
                // if ( isset($ts['tx_sudhaus7guard7.'][$table.'.']) && !empty($ts['tx_sudhaus7guard7.'][$table.'.'])) {
                $GLOBALS['__METHOD__' . '-CACHE'][$pid] = $ts['tx_sudhaus7guard7.'];
                //$GLOBALS['__METHOD__'.'-CACHE'][$table.'-'.$pid] = GeneralUtility::trimExplode(',', $ts['tx_sudhaus7guard7.'][$table.'.']['fields'],true)
                //}
            }
        }
        if ( $table ) {
            return isset($GLOBALS['__METHOD__' . '-CACHE'][$pid][$table . '.']) ? $GLOBALS['__METHOD__' . '-CACHE'][$pid][$table . '.'] : [];
        }
        return isset($GLOBALS['__METHOD__' . '-CACHE'][$pid]) ? $GLOBALS['__METHOD__' . '-CACHE'][$pid] : [];
    }
    
    public static function getTsPubkeys($pid, $table = null) {
        $ts = self::getTsConfig($pid);
        $ret = [];
        
        if ( isset($ts['generalPublicKeys.']) && !empty($ts['generalPublicKeys.']) ) {
            foreach ( $ts['generalPublicKeys.'] as $key ) {
                $ret[] = $key;
            }
        }
        if ( $table ) {
            if ( isset($ts[$table . '.']) && isset($ts[$table . '.']['publicKeys.']) && is_array($ts[$table . '.']['publicKeys.']) ) {
                foreach ( $ts[$table . '.']['publicKeys.'] as $key ) {
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
    public static function getFields($table, $pid) {
        $ts = self::getTsConfig($pid, $table);
        return isset($ts['fields']) ? GeneralUtility::trimExplode(',', $ts['fields'], true) : [];
    }
    
    /**
     * @param AbstractEntity $obj
     * @return array
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     */
    public static function getModelFields(AbstractEntity $obj) {
        $class = \get_class($obj);
        $dataMapper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper::class);
        $table = $dataMapper->getDataMap($class)->getTableName();
        return self::getFields($table, $obj->getPid());
    }
}
