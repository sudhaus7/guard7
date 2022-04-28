<?php

use Sudhaus7\Guard7\Hooks\Backend\FeLogin;
use Sudhaus7\Guard7\Hooks\Backend\SignalHandler;
use Sudhaus7\Guard7\Hooks\Frontend\AfterGettingObjectDataHandler;
use Sudhaus7\Guard7\Hooks\Frontend\AfterPersistHandler;
use Sudhaus7\Guard7\Hooks\Frontend\AfterRemoveHandler;
use Sudhaus7\Guard7\Hooks\Frontend\Userchangepassword;
use Sudhaus7\Guard7\Services\Guard7LoginService;
use Sudhaus7\Guard7\Tools\Keys;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Backend;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

if (!defined('TYPO3_MODE')) {
    die();
}

$guard7ExtensionConfiguration = GeneralUtility::makeInstance( ExtensionConfiguration::class)->get('guard7');

ExtensionManagementUtility::addService(
    'guard7',
    'auth',
    Guard7LoginService::class,
    [
        'title' => 'Guard7 FE User Key Unlock',
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
        'className' => Guard7LoginService::class,
    ]
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['initFEuser'][ 'guard7' ] = FeLogin::class . '->handle';
if ($guard7ExtensionConfiguration['populatebeuserprivatekeytofrontend']) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/index_ts.php']['postBeUser']['guard7'] = FeLogin::class . '->handleBeUser';
}

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['password_changed'][ 'guard7' ] = Userchangepassword::class . '->handle';

/** @var Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher = GeneralUtility::makeInstance( Dispatcher::class);
$signalSlotDispatcher->connect(
    Keys::class,
    'collectPublicKeys_fe_users',
    SignalHandler::class,
    'FeuserFetchkey',
    false
);

$signalSlotDispatcher->connect(
    Backend::class,
    'afterPersistObject',
    AfterPersistHandler::class,
    'handle',
    false
);

if ($guard7ExtensionConfiguration['destroyencodeddataondelete'] === true) {
    $signalSlotDispatcher->connect(
        Backend::class,
        'afterRemoveObject',
        AfterRemoveHandler::class,
        'handle',
        false
    );
}

$signalSlotDispatcher->connect(
    Backend::class,
    'afterGettingObjectData',
    AfterGettingObjectDataHandler::class,
    'handle',
    false
);

/**
 * Format:
 * $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'][]=[
 *  'className'=>\Vendor\Ext\Domain\Model\Mymodel::class, //optional used when persisting Extbase Models
 *  'tableName'=>'tx_my_table',
 *  'fields'=>'name,email,phone'
 * ];
 */
if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] = [];
}
