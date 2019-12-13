<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 16.02.18
 * Time: 13:34
 */

namespace SUDHAUS7\Guard7\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Lang\LanguageService;

class ModuleController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    
    /**
     * Backend Template Container
     *
     * @var string
     */
    protected $defaultViewObjectName = BackendTemplateView::class;
    
    /**
     * @var string
     */
    protected $moduleName = 'system_Sudhaus7Guard7Module';
    
    /**
     * BackendTemplateContainer
     *
     * @var BackendTemplateView
     */
    protected $view;
    
    /**
     * @var \SUDHAUS7\Guard7\Domain\Repository\DataRepository
     * @inject
     */
    protected $dataRepository;
    
    /**
     * ModuleController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->db = $GLOBALS['TYPO3_DB'];
        $this->moduleUri = BackendUtility::getModuleUrl($this->moduleName);
    }
    
    public function indexAction()
    {
        $iconFactory = $this->view->getModuleTemplate()->getIconFactory();
        $docHeader = $this->view->getModuleTemplate()->getDocHeaderComponent();
        $buttonBar = $docHeader->getButtonBar();
        
        
        $buttonBar->addButton(
            $buttonBar->makeLinkButton()
            ->setHref($this->uriBuilder->uriFor('createkey'))
            ->setShowLabelText($this->getLanguageService()
                ->sL('LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:module.action.createkey'))
            ->setIcon($iconFactory->getIcon('key', Icon::SIZE_SMALL))
            ->setTitle($this->getLanguageService()
                ->sL('LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:module.action.createkey')),
            ButtonBar::BUTTON_POSITION_LEFT
        
        
        );
        
        $buttonBar->addButton(
            $buttonBar->makeLinkButton()
            ->setHref($this->uriBuilder->uriFor('listrencode'))
            ->setShowLabelText($this->getLanguageService()
                ->sL('LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:module.action.listrencode'))
            ->setIcon($iconFactory->getIcon('key', Icon::SIZE_SMALL))
            ->setTitle($this->getLanguageService()
                ->sL('LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:module.action.listrencode')),
            ButtonBar::BUTTON_POSITION_LEFT
        
        );
        $this->view->assign('reenocenum', $this->dataRepository->findByNeedsreencode(1)->count());
    }
    
    /**
     * Returns the language service
     *
     * @return LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }
    
    public function createkeyAction()
    {
        $iconFactory = $this->view->getModuleTemplate()->getIconFactory();
        $docHeader = $this->view->getModuleTemplate()->getDocHeaderComponent();
        $buttonBar = $docHeader->getButtonBar();
        
        $btn = $buttonBar->makeLinkButton();
        $btn->setHref($this->uriBuilder->uriFor('index'))
            ->setShowLabelText('Back')
            ->setIcon($iconFactory->getIcon('actions-view-go-back', Icon::SIZE_SMALL))
            ->setTitle('Back');
        $buttonBar->addButton($btn, ButtonBar::BUTTON_POSITION_LEFT);
    }
    
    
    public function storeKeyInGlobal(ServerRequestInterface $request, ResponseInterface $response)
    {
        $post = $request->getParsedBody();
        if (isset($post['key']) && !empty($post['key'])) {
            $GLOBALS['BE_USER']->setSessionData('privatekey', $post['key']);
        }
        
        $response->getBody()->write(\json_encode(['ok'=>1]));
        return $response;
    }
    
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function ajaxData(ServerRequestInterface $request, ResponseInterface $response)
    {
        
        /** @var ServerRequest $request */
        $get = $request->getQueryParams();
        $table = $get['table'];
        $idlist = $get['uids'];

        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_guard7_domain_model_data');
        
        $query = $connection->createQueryBuilder();
        $query->select(...[
            'tablename',
            'tableuid',
            'fieldname',
            'secretdata'
        ])->from('tx_guard7_domain_model_data');
        
        $fields = $GLOBALS['TCA'][$table]['ctrl']['label'];
        $fields .= ',' . $GLOBALS['TCA'][$table]['ctrl']['label_alt'];
        $fields = trim($fields, ',');
        $fields = "'" . str_replace(',', "','", $fields) . "'";
        
        $query->andWhere($query->expr()->in('tableuid', $idlist));
        $query->andWhere($query->expr()->in('fieldname', $fields));
        $query->andWhere($query->expr()->eq('tablename', $query->createNamedParameter($table)));
        
        $result = $query->execute();
        $data = $result->fetchAll();
    
    
        $response->getBody()->write(\json_encode($data));
        return $response;
        //$response->addContent('data', \json_encode($data));
    }
}
