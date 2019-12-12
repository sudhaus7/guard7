<?php

if (!defined('TYPO3_MODE')) {
    die();
}
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    'guard7',
    'auth',
    \SUDHAUS7\Guard7\Services\Guard7::class,
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
        'className' => \SUDHAUS7\Guard7\Services\Guard7::class,
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


/**
 * Format:
 * $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'][]=[
 *  'className'=>\Vendor\Ext\Domain\Model\Mymodel::class, //optional used when persisting Extbase Models
 *  'tableName'=>'tx_my_table',
 *  'fields'=>'name,email,phone'
 * ];
 *
 */
if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] = [];
}
