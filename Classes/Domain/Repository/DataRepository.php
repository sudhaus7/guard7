<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 22.02.18
 * Time: 17:59
 */

namespace SUDHAUS7\Guard7\Domain\Repository;


use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

class DataRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function initializeObject() {
		$defaultQuerySettings = $this->objectManager->get(Typo3QuerySettings::class);
		$defaultQuerySettings->setRespectStoragePage(false);
		$this->setDefaultQuerySettings($defaultQuerySettings);
	}
}
