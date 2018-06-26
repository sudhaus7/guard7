<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 22.02.18
 * Time: 18:01
 */

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
return [
    
    'ctrl' => [
        'title' => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:tx_guard7_domain_model_data',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'searchFields' => 'tablename,',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('sudhaus7_newspage') . 'Configuration/TCA/tx_guard7_domain_model_data.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('sudhaus7_newspage') . 'Resources/Public/Icons/tx_guard7_domain_model_data.png',
    ],
    'interface' => [
        'showRecordFieldList' => 'tablename, tableuid, fieldname,secretdata,needsreencode',
    ],
    'types' => [
        '1' => ['showitem' => 'tablename, tableuid, fieldname,secretdata,needsreencode'],
    ],
    'columns' => [
        
        'tablename' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:tx_guard7_domain_model_data.tablename',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'tableuid' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:tx_guard7_domain_model_data.tableuid',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'fieldname' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:tx_guard7_domain_model_data.fieldname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'secretdata' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:tx_guard7_domain_model_data.secretdata',
            'config' => [
                'type' => 'text',
            ],
        ],
        'needsreencode' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:tx_guard7_domain_model_data.needsreencode',
            'config' => [
                'type' => 'check',
                'default' => '0'
            ],
        ],
    ],
];
