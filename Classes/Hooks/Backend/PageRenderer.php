<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 31.01.18
 * Time: 16:25
 */

namespace SUDHAUS7\Guard7\Hooks\Backend;

use SUDHAUS7\Guard7\Tools\Helper;
use SUDHAUS7\Guard7\Tools\PrivatekeySingleton;
use TYPO3\CMS\Backend\Controller\EditDocumentController;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Recordlist\RecordList;

class PageRenderer
{
    public $editconf = [];
    
    /**
     * @var EditDocumentController
     */
    public $controller = null;
    
    /**
     * wrapper function called by hook (\TYPO3\CMS\Core\Page\PageRenderer->render-preProcess)
     *
     * @param array $parameters An array of available parameters
     * @param \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer The parent object that triggered this hook
     */
    public function addJSCSS(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer)
    {
    
        // Add language labels for ExtDirect
        $pageRenderer->addInlineLanguageLabelArray([
            'guard7_usekeytounlock'  => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:usekeytounlock',
            'guard7_providepassword'  => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:providepassword',
        ], true);
    
    
        $extensionConfig = Helper::getExtensionConfig();
        if (!$extensionConfig['usejavascriptdecodinginbackend']) {
            $key = $GLOBALS['BE_USER']->getSessionData('privatekey');
            $privateKey = GeneralUtility::makeInstance(PrivatekeySingleton::class);
            if (!empty($key)) {
                $privateKey->setKey($key);
            } else {
                $privateKey->setKey();
            }
            $pageRenderer->addJsInlineCode(
                __METHOD__,
                'var sudhaus7guard7data_DISABLED = true;'
            );
            return;
        }
        
        if ($GLOBALS['SOBE']) {
            $class = get_class($GLOBALS['SOBE']);
            
            if ($class == EditDocumentController::class) {
                $this->handleEditDocumentController($parameters, $pageRenderer);
            }
            
            if ($class == RecordList::class) {
                $this->handleRecordListLight($parameters, $pageRenderer);
            }
        }
    }
    
    public function postRender(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer)
    {
        $extensionConfig = Helper::getExtensionConfig();
        if (!$extensionConfig['usejavascriptdecodinginbackend']) {
            return;
        }
        if ($GLOBALS['SOBE']) {
            $class = get_class($GLOBALS['SOBE']);
            
            if ($class == RecordList::class) {
                //$this->handleRecordList( $parameters, $pageRenderer);
            }
        }
    }
    
    private function handleRecordListLight(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer)
    {
        
        /** @var RecordList $controller */
        $controller = $GLOBALS['SOBE'];
    
        $tables = Helper::getAllGuard7Tables($controller->id);
        if (!empty($tables)) {
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Guard7/List');
            $pageRenderer->addJsInlineCode(
                __METHOD__,
                'var sudhaus7guard7tables = ' . json_encode($tables) . ';var sudhaus7guard7data_DISABLED = false;'
            );
        }
    }
    
    /**
     * @param array $parameters
     * @param \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer
     */
    private function handleRecordList(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer)
    {
        $extensionConfig = Helper::getExtensionConfig();
        if (!$extensionConfig['usejavascriptdecodinginbackend']) {
            return;
        }
        
        /** @var RecordList $controller */
        $controller = $GLOBALS['SOBE'];
        
        $tables = Helper::getAllGuard7Tables($controller->id);
        if (!empty($tables)) {
            $data = [];
            foreach ($tables as $table) {
                $table = trim($table, '.');
                
                /** @var Connection $connection */
                $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                    ->getConnectionForTable($table);
                
                $res = $connection->select(['uid'], $table, ['pid' => $controller->id]);
                $uids = $res->fetchAll();
                if (!empty($uids)) {
                    $idlist = [];
                    foreach ($uids as $a) {
                        $idlist[] = $a['uid'];
                    }
                    
                    $fields = $GLOBALS['TCA'][$table]['ctrl']['label'];
                    $fields .= ',' . $GLOBALS['TCA'][$table]['ctrl']['label_alt'];
                    $fields = trim($fields, ',');
                    $fields = "'" . str_replace(',', "','", $fields) . "'";
                    
                    $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                        ->getConnectionForTable('tx_guard7_domain_model_data');
                    $query = $connection->createQueryBuilder();
                    $query->select(...[
                        'tablename',
                        'tableuid',
                        'fieldname',
                        'secretdata'
                    ])
                        ->from('tx_guard7_domain_model_data');
                    
                    
                    $query->andWhere($query->expr()->in('tableuid', $idlist));
                    $query->andWhere($query->expr()->in('fieldname', $fields));
                    $query->andWhere($query->expr()->eq('tablename', $query->createNamedParameter($table)));
                    $result = $query->execute();
                    $subdata = $result->fetchAll();
                    $data = array_merge($data, $subdata);
                }
            }
            if (!empty($data)) {
                $pageRenderer->loadRequireJsModule('TYPO3/CMS/Guard7/List');
                $pageRenderer->addJsInlineCode(
                    __METHOD__,
                    'var sudhaus7guard7data = ' . json_encode($data) . ';var sudhaus7guard7data_DISABLED = false;'
                );
            }
        }
    }
    
    /**
     * @param array $parameters
     * @param \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer
     */
    private function handleEditDocumentController(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer)
    {
        $this->editconf = $GLOBALS['SOBE']->editconf;
        $this->controller = $GLOBALS['SOBE'];
        
        
        if (!empty($this->editconf)) {
            foreach ($this->editconf as $table => $config) {
                if (\in_array('edit', $config)) {
                    $idlist = GeneralUtility::trimExplode(',', array_keys($config)[0], true);
                    $id = array_shift($idlist);
                    $rec = BackendUtility::getRecord($table, $id, '*');
                    
                    if (Helper::tableIsGuard7Element($table, $rec['pid'])) {
                        $data = [
                        
                        ];
                        
                        //$fields = GeneralUtility::trimExplode( ',',$ts['tx_sudhaus7guard7.'][ $table . '.' ]['fields'], true );
                        
                        /** @var Connection $connection */
                        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                            ->getConnectionForTable('tx_guard7_domain_model_data');
                        
                        $result = $connection->select(
                            [
                                'tablename',
                                'tableuid',
                                'fieldname',
                                'secretdata'
                            ],
                            'tx_guard7_domain_model_data',
                            [
                                'tablename' => $table,
                                'tableuid' => $id
                            ]
                        );
                        
                        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
                            $identifier = sprintf('[data-formengine-input-name="data[%s][%d][%s]"]', $row['tablename'], $row['tableuid'], $row['fieldname']);
                            $data[] = [
                                'identifier' => $identifier,
                                'method' => 'val',
                                'secretdata' => $row['secretdata']
                            ];
                        }
                        
                        /**
                         * Handle / prepare IRRE
                         */
                        $tcafields = GeneralUtility::trimExplode(',', $GLOBALS['TCA'][$table]['types'][0]['showitem'], true);
                        
                        foreach ($tcafields as $field) {
                            if ($GLOBALS['TCA'][$table]['columns'][$field]['config']['type'] === 'inline') {
                                $reltable = $GLOBALS['TCA'][$table]['columns'][$field]['config']['foreign_table'];
                                $config['irre'][] = [
                                    'table' => $reltable,
                                    'field' => $field
                                ];
                                $config['fields'][$reltable] = Helper::getFields($reltable, $rec['pid']);
                                
                                
                                $label = $GLOBALS['TCA'][$reltable]['ctrl']['label'];
                                if ($GLOBALS['TCA'][$reltable]['ctrl']['label_alt_force']) {
                                    $label .= ',' . $GLOBALS['TCA'][$reltable]['ctrl']['label_alt'];
                                }
                                $labelfields = GeneralUtility::trimExplode(',', $label, true);
                                $labels = [];
                                
                                if (!empty($rec[$field])) {
                                    $query = $connection->createQueryBuilder();
                                    $irreres = $query->select(...[
                                        'tablename',
                                        'tableuid',
                                        'fieldname',
                                        'secretdata'
                                    ])
                                        ->from('tx_guard7_domain_model_data')
                                        ->andWhere($query->expr()->eq('tablename', $query->createNamedParameter($reltable)))
                                        ->andWhere($query->expr()->in('tableuid', GeneralUtility::trimExplode(',', $rec[$field], true)))
                                        ->addOrderBy('tableuid', 'ASC')
                                        ->execute();
                                    
                                    while ($row = $irreres->fetch(\PDO::FETCH_ASSOC)) {
                                        // $data[]=$row;
                                        
                                        if (in_array($row['fieldname'], $labelfields, true)) {
                                            $labels[$row['tableuid']][] = $row['secretdata'];
                                        }
            
                                        $identifier = sprintf('[data-formengine-input-name="data[%s][%d][%s]"]', $row['tablename'], $row['tableuid'], $row['fieldname']);
                                        $data[] = [
                                            'identifier' => $identifier,
                                            'method' => 'val',
                                            'secretdata' => $row['secretdata']
                                        ];
                                    }
                                }
                                if (!empty($labels)) {
                                    foreach ($labels as $id => $label) {
                                        $identifier = sprintf('#data-%d-%s-%d-%s-%s-%d_label', $rec['pid'], $table, $rec['uid'], $field, $reltable, $id);
                                        $data[] = [
                                            'identifier' => $identifier,
                                            'method' => 'label',
                                            'secretdata' => \implode('|', $label)
                                        ];
                                    }
                                }
                            }
                        }
                        
                        
                        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Guard7/Main');
                        $pageRenderer->addJsInlineCode(
                            __METHOD__,
                            'var sudhaus7guard7data = ' . json_encode($data) . ';var sudhaus7guard7data_DISABLED = false;'
                        );
                    }
                }
            }
        }
    }
}
