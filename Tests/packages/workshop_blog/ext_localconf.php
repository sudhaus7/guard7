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

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'WorkshopBlog',
    'List',
    [
        \WORKSHOP\WorkshopBlog\Controller\ListController::class => 'index',
    ],
    [
        \WORKSHOP\WorkshopBlog\Controller\ListController::class => 'index',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'WorkshopBlog',
    'Latest',
    [
        \WORKSHOP\WorkshopBlog\Controller\LatestController::class=>'index',
    ],
    [
        \WORKSHOP\WorkshopBlog\Controller\LatestController::class=>'index',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'WorkshopBlog',
    'Detail',
    [

        \WORKSHOP\WorkshopBlog\Controller\DetailController::class=>'detail,savecomment',
    ],
    [

        \WORKSHOP\WorkshopBlog\Controller\DetailController::class=>'detail,savecomment',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] = [];
}

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'][] = [
    'className'=>\WORKSHOP\WorkshopBlog\Domain\Model\Blog::class,
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
