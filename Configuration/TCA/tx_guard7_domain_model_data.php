<?php

use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
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

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

return [

    'ctrl' => [
        'title' => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:tx_guard7_domain_model_data',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'searchFields' => 'tablename,',
        'dynamicConfigFile' =>
            PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('guard7')) . 'Configuration/TCA/tx_guard7_domain_model_data.php',
        'iconfile' => PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath('guard7')) . 'Resources/Public/Icons/locked.svg',
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
                'eval' => 'trim',
            ],
        ],
        'tableuid' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:tx_guard7_domain_model_data.tableuid',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'fieldname' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:tx_guard7_domain_model_data.fieldname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
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
                'default' => '0',
            ],
        ],
    ],
];
