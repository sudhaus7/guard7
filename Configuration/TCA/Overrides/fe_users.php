<?php

call_user_func(
    function () {
        $tempColumns = [
            'tx_guard7_publickey' => [
                
                'exclude' => 0,
                'label' => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:fe_users.tx_guard7_publickey',
                'config' => [
                    'type' => 'text',
                ],
            ],
            'tx_guard7_privatekey' => [
                
                'exclude' => 0,
                'label' => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:fe_users.tx_guard7_privatekey',
                'config' => [
                    'type' => 'text',
                ],
            ],
        
        ];
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns("fe_users", $tempColumns);
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'tx_guard7_publickey');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'tx_guard7_privatekey');
    }
);
