<?php

if (!defined('TYPO3_MODE')) die();

call_user_func(function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
        'datavault',
        'Configuration/PageTSconfig/page.ts',
        'Seitendefinitionen B-Factor Template'
    );
});
