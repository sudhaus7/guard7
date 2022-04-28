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

if (!defined('TYPO3_MODE')) {
    die();
}

//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY,'Configuration/TypoScript/','B-Factor Template');
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][]    = \Sudhaus7\Guard7\Hooks\Backend\Datamap::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = Sudhaus7\Guard7\Hooks\Backend\PageRenderer::class . '->addJSCSS';
//$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = Sudhaus7\Guard7\Hooks\Backend\PageRenderer::class.'->postRender';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'Guard7',
    'system',
    'guard7',
    'top',
    [\Sudhaus7\Guard7\Controller\ModuleController::class => 'index,createkey,listrencode'],
    [
        'access' => 'user,group',
        'icon' => 'EXT:guard7/Resources/Public/Icons/locked.svg',
        'labels' => 'LLL:EXT:guard7/Resources/Private/Language/locallang_mod.xlf',
    ]
);

/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
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

/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'cdnkey',
    \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
    [
        'name' => 'cdnkey',
        //'spinning' => true
    ]
);
$iconRegistry->registerIcon(
    'key',
    \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
    [
        'name' => 'key',
        //'spinning' => true
    ]
);
$iconRegistry->registerIcon(
    'lock',
    \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
    [
        'name' => 'lock',
        //'spinning' => true
    ]
);
$iconRegistry->registerIcon(
    'lock-open',
    \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
    [
        'name' => 'lock-open',
        //'spinning' => true
    ]
);

if (TYPO3_MODE === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][] = \Sudhaus7\Guard7\Controller\ToolbarController::class;
}
