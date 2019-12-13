<?php

if (!defined('TYPO3_MODE')) {
    die();
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'WORKSHOP.WorkshopBlog',
    'List',
    [
        'List' => 'index',
    ],
    [
        'List' => 'index',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'WORKSHOP.WorkshopBlog',
    'Latest',
    [
        'Latest'=>'index',
    ],
    [
        'Latest'=>'index',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'WORKSHOP.WorkshopBlog',
    'Detail',
    [

        'Detail'=>'detail,savecomment'
    ],
    [

        'Detail'=>'detail,savecomment'
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_PLUGIN
);

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] = [];
}

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'][] = [
    'className'=>\WORKSHOP\WorkshopBlog\Domain\Model\Blog::class,
    'tableName'=>'tx_workshopblog_domain_model_blog',
    'fields'=>'teaser,bodytext'
];
/* done with trait and pagets
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'][] = [
    'className'=>\WORKSHOP\WorkshopBlog\Domain\Model\Comment::class,
    'tableName'=>'tx_workshopblog_domain_model_comment',
    'fields'=>'commentor,comment'
];
*/
