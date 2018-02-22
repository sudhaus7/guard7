<?php

if (!defined('TYPO3_MODE')) die();
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService('datavault', 'auth', \SUDHAUS7\Datavault\Services\Datavault::class, [
	'title' => 'Datavault FE User Key Unlock',
	'description' => 'Unlocks Private Keys stored in the FE User Data',
	'subtype' => 'processLoginDataFE',
	'available' => true,
	'priority' => 25,
	// tx_svauth_sv1 has 50, t3sec_saltedpw has 55. This service must have higher priority!
	'quality' => 25,
	// tx_svauth_sv1 has 50. This service must have higher quality!
	'os' => '',
	'exec' => '',
	// Do not put a dependency on openssh here or service loading will fail!
	'className' => \SUDHAUS7\Datavault\Services\Datavault::class,
]);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['initFEuser'][$_EXTKEY]=\SUDHAUS7\Datavault\Hooks\Backend\FeLogin::class.'->handle';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['password_changed'][$_EXTKEY] = \SUDHAUS7\Datavault\Frontend\Userchangepassword::class.'->handle';


/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */

$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
	\SUDHAUS7\Datavault\Tools\Keys::class,
	'collectPublicKeys_fe_users',
	\SUDHAUS7\Datavault\Hooks\Backend\SignalHandler::class,
	'FeuserFetchkey',
	false
);
