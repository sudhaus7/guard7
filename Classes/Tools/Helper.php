<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 30.04.18
 * Time: 14:31
 */

namespace SUDHAUS7\Guard7\Tools;


use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Helper {
    
    
    /**
     * @param string $table
     * @param int $pid
     * @return array
     */
    public static function getFields($table,$pid) {
        
        if (!isset($GLOBALS['__METHOD__'.'-CACHE'])) $GLOBALS['__METHOD__'.'-CACHE'] = [];
        if (!isset($GLOBALS['__METHOD__'.'-CACHE'][$table.'-'.$pid])) {
            $ts = BackendUtility::getPagesTSconfig($pid);
            if (isset($ts['tx_sudhaus7guard7.'])) {
                if ( isset($ts['tx_sudhaus7guard7.'][$table.'.']) && !empty($ts['tx_sudhaus7guard7.'][$table.'.'])) {
                    $GLOBALS['__METHOD__'.'-CACHE'][$table.'-'.$pid] = $ts['tx_sudhaus7guard7.'][$table.'.'];
                    //$GLOBALS['__METHOD__'.'-CACHE'][$table.'-'.$pid] = GeneralUtility::trimExplode(',', $ts['tx_sudhaus7guard7.'][$table.'.']['fields'],true)
                }
            }
        }
        return isset($GLOBALS['__METHOD__'.'-CACHE'][$table.'-'.$pid]['fields']) ? GeneralUtility::trimExplode(',',$GLOBALS['__METHOD__'.'-CACHE'][$table.'-'.$pid]['fields'],true) : [];
        
      
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
