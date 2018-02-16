<?php

if (!defined('TYPO3_MODE')) die();

//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY,'Configuration/TypoScript/','B-Factor Template');
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = \SUDHAUS7\Datavault\Hooks\Backend\Datamap::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = SUDHAUS7\Datavault\Hooks\Backend\PageRenderer::class.'->addJSCSS';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule('SUDHAUS7.' . $_EXTKEY, 'system',	'datavault',	'top',
	array('Module' => 'index,createkey'),
	array(
		'access' => 'user,group',
		'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/locked.svg',
		'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
	)
);


/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
/*
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
	\TYPO3\CMS\Backend\Controller\EditDocumentController::class,
	'initAfter',
	\SUDHAUS7\Datavault\Hooks\Backend\SignalHandler::class,
	'EditDocumentInit',
	true
);
*/


if (TYPO3_MODE === 'BE') {
	$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][] = \SUDHAUS7\Datavault\Controller\ToolbarController::class;
}
