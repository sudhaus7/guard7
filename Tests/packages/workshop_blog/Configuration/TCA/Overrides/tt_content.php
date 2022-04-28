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
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

call_user_func(function (): void {
    ExtensionUtility::registerPlugin(
        'WorkshopBlog',
        'List',
        'Workshop Blog List',
        'EXT:workshop_blog/Resources/Public/Icons/Extension.svg'
    );
    ExtensionUtility::registerPlugin(
        'WorkshopBlog',
        'Latest',
        'Workshop Blog Latest',
        'EXT:workshop_blog/Resources/Public/Icons/Extension.svg'
    );
    ExtensionUtility::registerPlugin(
        'WorkshopBlog',
        'Detail',
        'Workshop Blog Detail',
        'EXT:workshop_blog/Resources/Public/Icons/Extension.svg'
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['workshopblog_list'] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue('workshopblog_list', 'FILE:EXT:workshop_blog/Configuration/Flexforms/Flexform.xml');

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['workshopblog_latest'] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue('workshopblog_latest', 'FILE:EXT:workshop_blog/Configuration/Flexforms/Flexform.xml');
});
