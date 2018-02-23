<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 16.02.18
 * Time: 13:34
 */

namespace SUDHAUS7\Datavault\Controller;
use SUDHAUS7\Datavault\Domain\Repository\DataRepository;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Lang\LanguageService;

class ModuleController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * Backend Template Container
	 *
	 * @var string
	 */
	protected $defaultViewObjectName = BackendTemplateView::class;

	/**
	 * @var string
	 */
	protected $moduleName = 'system_Sudhaus7DatavaultModule';

	/**
	 * BackendTemplateContainer
	 *
	 * @var BackendTemplateView
	 */
	protected $view;

	/**
	 * @var \SUDHAUS7\Datavault\Domain\Repository\DataRepository
	 * @inject
	 */
	protected $dataRepository;

	/**
	 * ModuleController constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->db = $GLOBALS['TYPO3_DB'];
		$this->moduleUri = BackendUtility::getModuleUrl($this->moduleName);
	}
	public function indexAction() {

		$iconFactory = $this->view->getModuleTemplate()->getIconFactory();
		$docHeader = $this->view->getModuleTemplate()->getDocHeaderComponent();
		$buttonBar = $docHeader->getButtonBar();


		$buttonBar->addButton( $buttonBar->makeLinkButton()
			->setHref( $this->uriBuilder->uriFor('createkey'))
			->setShowLabelText( $this->getLanguageService()->sL( 'LLL:EXT:datavault/Resources/Private/Language/locallang.xml:module.action.createkey'))
			->setIcon( $iconFactory->getIcon('key', Icon::SIZE_SMALL))
			->setTitle( $this->getLanguageService()->sL( 'LLL:EXT:datavault/Resources/Private/Language/locallang.xml:module.action.createkey')),
			ButtonBar::BUTTON_POSITION_LEFT);

		$buttonBar->addButton( $buttonBar->makeLinkButton()
		                                 ->setHref( $this->uriBuilder->uriFor('listrencode'))
		                                 ->setShowLabelText( $this->getLanguageService()->sL( 'LLL:EXT:datavault/Resources/Private/Language/locallang.xml:module.action.listrencode'))
		                                 ->setIcon( $iconFactory->getIcon('key', Icon::SIZE_SMALL))
		                                 ->setTitle( $this->getLanguageService()->sL( 'LLL:EXT:datavault/Resources/Private/Language/locallang.xml:module.action.listrencode')),
			ButtonBar::BUTTON_POSITION_LEFT);




		$this->view->assign('reenocenum',$this->dataRepository->findByNeedsreencode(1)->count());



	}
	public function createkeyAction() {
		$iconFactory = $this->view->getModuleTemplate()->getIconFactory();
		$docHeader = $this->view->getModuleTemplate()->getDocHeaderComponent();
		$buttonBar = $docHeader->getButtonBar();

		$btn = $buttonBar->makeLinkButton();
		$btn->setHref( $this->uriBuilder->uriFor('index'))
		    ->setShowLabelText( 'Back')
			->setIcon( $iconFactory->getIcon('actions-view-go-back', Icon::SIZE_SMALL))
		    ->setTitle('Back');
		$buttonBar->addButton( $btn, ButtonBar::BUTTON_POSITION_LEFT);
	}
	/**
	 * Returns the language service
	 * @return LanguageService
	 */
	protected function getLanguageService()
	{
		return $GLOBALS['LANG'];
	}
}
