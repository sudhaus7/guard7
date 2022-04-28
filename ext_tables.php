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

use Sudhaus7\Guard7\Controller\ModuleController;
use Sudhaus7\Guard7\Controller\ToolbarController;
use Sudhaus7\Guard7\Hooks\Backend\Datamap;
use TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

if (!defined('TYPO3_MODE')) {
    die();
}

//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY,'Configuration/TypoScript/','B-Factor Template');
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][]    = Datamap::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = Sudhaus7\Guard7\Hooks\Backend\PageRenderer::class . '->addJSCSS';
//$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = Sudhaus7\Guard7\Hooks\Backend\PageRenderer::class.'->postRender';

ExtensionUtility::registerModule(
    'Guard7',
    'system',
    'guard7',
    'top',
    [ ModuleController::class => 'index,createkey,listrencode'],
    [
        'access' => 'user,group',
        'icon' => 'EXT:guard7/Resources/Public/Icons/locked.svg',
        'labels' => 'LLL:EXT:guard7/Resources/Private/Language/locallang_mod.xlf',
    ]
);

/** @var Dispatcher $signalSlotDispatcher */
/*
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
    \TYPO3\CMS\Backend\Controller\EditDocumentController::class,
    'initAfter',
    \Sudhaus7\Guard7\Hooks\Backend\SignalHandler::class,
    'EditDocumentInit',
    true
);
*/

/** @var IconRegistry $iconRegistry */
$iconRegistry = GeneralUtility::makeInstance( IconRegistry::class);
$iconRegistry->registerIcon(
    'cdnkey',
    FontawesomeIconProvider::class,
    [
        'name' => 'cdnkey',
        //'spinning' => true
    ]
);
$iconRegistry->registerIcon(
    'key',
    FontawesomeIconProvider::class,
    [
        'name' => 'key',
        //'spinning' => true
    ]
);
$iconRegistry->registerIcon(
    'lock',
    FontawesomeIconProvider::class,
    [
        'name' => 'lock',
        //'spinning' => true
    ]
);
$iconRegistry->registerIcon(
    'lock-open',
    FontawesomeIconProvider::class,
    [
        'name' => 'lock-open',
        //'spinning' => true
    ]
);

if (TYPO3_MODE === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][] = ToolbarController::class;
}
