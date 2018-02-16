<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 16.02.18
 * Time: 13:26
 */

namespace SUDHAUS7\Datavault\Hooks\Backend;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extensionmanager\ViewHelpers\Form\TypoScriptConstantsViewHelper;


class ExttemplateTextarea {
	/**
	 * Tag builder instance
	 *
	 * @var \TYPO3\CMS\Fluid\Core\ViewHelper\TagBuilder
	 */
	protected $tag = NULL;

	/**
	 * constructor of this class
	 */
	public function __construct() {
		$this->tag = GeneralUtility::makeInstance('TYPO3\\CMS\\Fluid\\Core\\ViewHelper\\TagBuilder');
	}

	/**
	 * render textarea for extConf
	 *
	 * @param array $parameter
	 * @param TypoScriptConstantsViewHelper $parentObject
	 * @return string
	 */
	public function render(array $parameter = array(), TypoScriptConstantsViewHelper $parentObject) {
		$this->tag->setTagName('textarea');
		$this->tag->forceClosingTag(TRUE);
		$this->tag->addAttribute('cols', 45);
		$this->tag->addAttribute('rows', 7);
		$this->tag->addAttribute('name', $parameter['fieldName']);
		$this->tag->addAttribute('id', 'em-' . $parameter['fieldName']);
		if ($parameter['fieldValue'] !== NULL) {
			$this->tag->setContent(trim($parameter['fieldValue']));
		}
		return $this->tag->render();
	}
}
