<?php

if (!defined('TYPO3_MODE')) {
    die();
}
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    'guard7',
    'auth',
    \SUDHAUS7\Guard7\Services\Guard7::class,
    [
        'title'       => 'Guard7 FE User Key Unlock',
        'description' => 'Unlocks Private Keys stored in the FE User Data',
        'subtype'     => 'processLoginDataFE',
        'available'   => true,
        'priority'    => 25,
    // tx_svauth_sv1 has 50, t3sec_saltedpw has 55. This service must have higher priority!
        'quality'     => 25,
    // tx_svauth_sv1 has 50. This service must have higher quality!
        'os'          => '',
        'exec'        => '',
    // Do not put a dependency on openssh here or service loading will fail!
        'className'   => \SUDHAUS7\Guard7\Services\Guard7::class,
    ]
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['initFEuser'][ $_EXTKEY ] = \SUDHAUS7\Guard7\Hooks\Backend\FeLogin::class . '->handle';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['password_changed'][ $_EXTKEY ] = \SUDHAUS7\Guard7\Hooks\Frontend\Userchangepassword::class . '->handle';


/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */

$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
    \SUDHAUS7\Guard7\Tools\Keys::class,
    'collectPublicKeys_fe_users',
    \SUDHAUS7\Guard7\Hooks\Backend\SignalHandler::class,
    'FeuserFetchkey',
    false
);
$signalSlotDispatcher->connect(
    \TYPO3\CMS\Extbase\Persistence\Generic\Backend::class,
    'afterPersistObject',
    \SUDHAUS7\Guard7\Hooks\Frontend\AfterPersistHandler::class,
    'handle',
    false
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = \SUDHAUS7\Guard7\Command\Guard7CommandController::class;


if (TYPO3_MODE === 'BE') {
    $class      = \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class;
    $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($class);
    $dispatcher->connect(
        \TYPO3\CMS\Extensionmanager\Service\ExtensionManagementService::class,
        'hasInstalledExtensions',
        \SUDHAUS7\Guard7\Install\UpgradeFromDatavault::class,
        'onInstall'
    );
}


