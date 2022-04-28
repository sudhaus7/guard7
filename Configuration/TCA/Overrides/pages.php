<?php

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
    die();
}

call_user_func(function (): void {
    ExtensionManagementUtility::registerPageTSConfigFile(
        'guard7',
        'Configuration/PageTSconfig/page.t3s',
        'Seitendefinitionen Guard7'
    );

    ExtensionManagementUtility::registerPageTSConfigFile(
        'guard7',
        'Configuration/PageTSconfig/feuser.typoscript',
        'Guard7: Encrypted FE-User Data '
    );
});
