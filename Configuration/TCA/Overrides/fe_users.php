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
call_user_func(
    function (): void {
        //$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['guard7']);

        $languageFilePrefix = 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:';
        $tempColumns = [
            'tx_guard7_publickey' => [

                'exclude' => 0,
                'label'   => $languageFilePrefix . 'fe_users.tx_guard7_publickey',
                'config' => [
                    'type' => 'text',
                ],
            ],
            'tx_guard7_privatekey' => [

                'exclude' => 0,
                'label'   => $languageFilePrefix . 'fe_users.tx_guard7_privatekey',
                'config' => [
                    'type' => 'text',
                ],
            ],

        ];
        ExtensionManagementUtility::addTCAcolumns('fe_users', $tempColumns);
        ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'tx_guard7_publickey');
        ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'tx_guard7_privatekey');
    }
);
