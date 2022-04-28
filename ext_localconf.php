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

$guard7ExtensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get('guard7');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    'guard7',
    'auth',
    \Sudhaus7\Guard7\Services\Guard7LoginService::class,
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
        'className' => \Sudhaus7\Guard7\Services\Guard7LoginService::class,
    ]
);
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['initFEuser'][ 'guard7' ] = \Sudhaus7\Guard7\Hooks\Backend\FeLogin::class . '->handle';
if ($guard7ExtensionConfiguration['populatebeuserprivatekeytofrontend']) {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/index_ts.php']['postBeUser']['guard7'] = \Sudhaus7\Guard7\Hooks\Backend\FeLogin::class . '->handleBeUser';
}

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['password_changed'][ 'guard7' ] = \Sudhaus7\Guard7\Hooks\Frontend\Userchangepassword::class . '->handle';

/** @var Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
    \Sudhaus7\Guard7\Tools\Keys::class,
    'collectPublicKeys_fe_users',
    \Sudhaus7\Guard7\Hooks\Backend\SignalHandler::class,
    'FeuserFetchkey',
    false
);

$signalSlotDispatcher->connect(
    \TYPO3\CMS\Extbase\Persistence\Generic\Backend::class,
    'afterPersistObject',
    \Sudhaus7\Guard7\Hooks\Frontend\AfterPersistHandler::class,
    'handle',
    false
);

if ($guard7ExtensionConfiguration['destroyencodeddataondelete'] === true) {
    $signalSlotDispatcher->connect(
        \TYPO3\CMS\Extbase\Persistence\Generic\Backend::class,
        'afterRemoveObject',
        \Sudhaus7\Guard7\Hooks\Frontend\AfterRemoveHandler::class,
        'handle',
        false
    );
}

$signalSlotDispatcher->connect(
    \TYPO3\CMS\Extbase\Persistence\Generic\Backend::class,
    'afterGettingObjectData',
    \Sudhaus7\Guard7\Hooks\Frontend\AfterGettingObjectDataHandler::class,
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
