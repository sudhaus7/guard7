<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 22:39
 */

namespace SUDHAUS7\Guard7\Controller;


use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ToolbarController implements ToolbarItemInterface {

	/**
	 * @var array
	 */
	protected $extConfig;
	/**
	 * @var IconFactory
	 * @inject
	 * @api
	 */
	protected $iconFactory;


	public function __construct() {
		$this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
		$pageRenderer = $this->getPageRenderer();
		$pageRenderer->loadRequireJsModule( 'TYPO3/CMS/Guard7/Toolbar' );
		$pageRenderer->addCssFile( '../' . ExtensionManagementUtility::siteRelPath( 'guard7' ) . 'Resources/Public/Css/styles.css' );

	}
	public function checkAccess() {
		return true;
	}

	public function getItem() {
		$opendocsMenu   = array();
		$opendocsMenu[] = '<span class="t3-icon fa fa-lock" title="Guard7">' . '</span>';
		return implode(LF, $opendocsMenu);
	}

	public function hasDropDown() {
		return true;
	}

	public function getDropDown() {
		$dropdown = [];
		$dropdown[]='<ul class="dropdown-list">';

		$dropdown[]='<li class="clearKey"><button >Schlüssel löschen</button></li>';

		$dropdown[]='<li class="newkey-elem"><textarea name="newkey"></textarea><br/><button>Schlüssel aktivieren</button></li>';

		$dropdown[]='</ul>';
		return implode(LF,$dropdown);
	}

	public function getAdditionalAttributes() {
		return array();
	}

	public function getIndex() {
		return 5;
	}
	/**
	 * Returns current PageRenderer
	 *
	 * @return PageRenderer
	 */
	protected function getPageRenderer()
	{
		return GeneralUtility::makeInstance(PageRenderer::class);
	}

}
