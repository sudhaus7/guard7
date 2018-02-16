<?php

call_user_func(
	function () {
		//$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['datavault']);


		$languageFilePrefix = 'LLL:EXT:datavault/Resources/Private/Language/locallang.xlf:';
		$tempColumns = [
			'tx_datavault_publickey'=>[

				'exclude'=>0,
				'label'=>$languageFilePrefix.'fe_users.tx_datavault_publickey',
				'config'=>[
					'type'=>'text',
				],
			],
			'tx_datavault_privatekey'=>[

				'exclude'=>0,
				'label'=>$languageFilePrefix.'fe_users.tx_datavault_privatekey',
				'config'=>[
					'type'=>'text',
				],
			],

		];
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns("fe_users",$tempColumns);
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users','tx_datavault_publickey');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users','tx_datavault_privatekey');
	}
);
