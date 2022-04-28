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

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use WORKSHOP\WorkshopBlog\Controller\DetailController;
use WORKSHOP\WorkshopBlog\Controller\LatestController;
use WORKSHOP\WorkshopBlog\Controller\ListController;
use WORKSHOP\WorkshopBlog\Domain\Model\Blog;

if (!defined('TYPO3_MODE')) {
    die();
}

ExtensionUtility::configurePlugin(
    'WorkshopBlog',
    'List',
    [
        ListController::class => 'index',
    ],
    [
        ListController::class => 'index',
    ],
    ExtensionUtility::PLUGIN_TYPE_PLUGIN
);
ExtensionUtility::configurePlugin(
    'WorkshopBlog',
    'Latest',
    [
        LatestController::class=>'index',
    ],
    [
        LatestController::class=>'index',
    ],
    ExtensionUtility::PLUGIN_TYPE_PLUGIN
);
ExtensionUtility::configurePlugin(
    'WorkshopBlog',
    'Detail',
    [

        DetailController::class=>'detail,savecomment',
    ],
    [

        DetailController::class=>'detail,savecomment',
    ],
    ExtensionUtility::PLUGIN_TYPE_PLUGIN
);

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] = [];
}

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'][] = [
    'className'=> Blog::class,
    'tableName'=>'tx_workshopblog_domain_model_blog',
    'fields'=>'teaser,bodytext',
];
/* done with trait and pagets
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'][] = [
    'className'=>\WORKSHOP\WorkshopBlog\Domain\Model\Comment::class,
    'tableName'=>'tx_workshopblog_domain_model_comment',
    'fields'=>'commentor,comment'
];
*/
