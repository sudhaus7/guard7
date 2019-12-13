<?php


namespace SUDHAUS7\Guard7\Hooks\Backend;

use TYPO3\CMS\Backend\Utility\BackendUtility;

class Guard7BackendUtility extends BackendUtility
{
    public static function getRecord($table, $uid, $fields = '*', $where = '', $useDeleteClause = true)
    {
        $row = parent::getRecord($table, $uid, $fields, $where, $useDeleteClause);
        return $row;
    }
    
    public static function getRecordsByField($theTable, $theField, $theValue, $whereClause = '', $groupBy = '', $orderBy = '', $limit = '', $useDeleteClause = true, $queryBuilder = null)
    {
        $rows = parent::getRecordsByField($theTable, $theField, $theValue, $whereClause, $groupBy, $orderBy, $limit, $useDeleteClause, $queryBuilder);
        return $rows;
    }
}
