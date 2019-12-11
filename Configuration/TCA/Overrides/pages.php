<?php

if (!defined('TYPO3_MODE')) {
    die();
}

call_user_func(function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
        'guard7',
        'Configuration/PageTSconfig/page.t3s',
        'Seitendefinitionen Guard7'
    );
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
        'guard7',
        'Configuration/PageTSconfig/feuser.typoscript',
        'Guard7: Encrypted FE-User Data '
    );
});
