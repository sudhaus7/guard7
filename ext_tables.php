<?php

if (!defined('TYPO3_MODE')) {
    die();
}

//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY,'Configuration/TypoScript/','B-Factor Template');
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][]    = \SUDHAUS7\Guard7\Hooks\Backend\Datamap::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = SUDHAUS7\Guard7\Hooks\Backend\PageRenderer::class . '->addJSCSS';
//$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] = SUDHAUS7\Guard7\Hooks\Backend\PageRenderer::class.'->postRender';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'SUDHAUS7.' . $_EXTKEY,
    'system',
    'guard7',
    'top',
    array('Module' => 'index,createkey,listrencode'),
    array(
        'access' => 'user,group',
        'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/locked.svg',
        'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
    )
);


/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
/*
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
    \TYPO3\CMS\Backend\Controller\EditDocumentController::class,
    'initAfter',
    \SUDHAUS7\Guard7\Hooks\Backend\SignalHandler::class,
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
    $GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][] = \SUDHAUS7\Guard7\Controller\ToolbarController::class;
    
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
        'Guard7Backend::getListData',
        \SUDHAUS7\Guard7\Controller\ModuleController::class . '->ajaxData'
    );
}
