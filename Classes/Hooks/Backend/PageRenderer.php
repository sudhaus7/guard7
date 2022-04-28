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

namespace Sudhaus7\Guard7\Hooks\Backend;

use PDO;
use TYPO3\CMS\Recordlist\Controller\RecordListController;
use Sudhaus7\Guard7\Adapter\ConfigurationAdapter;
use Sudhaus7\Guard7\Tools\Helper;
use Sudhaus7\Guard7\Tools\PrivatekeySingleton;
use TYPO3\CMS\Backend\Controller\EditDocumentController;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use function implode;
use function in_array;

final class PageRenderer
{
    public array $editconf = [];

    /**
     * @var EditDocumentController
     */
    public $controller;

    /**
     * @var string
     */
    private const USEJAVASCRIPTDECODINGINBACKEND = 'usejavascriptdecodinginbackend';

    /**
     * @var string
     */
    private const SOBE = 'SOBE';

    /**
     * @var string
     */
    private const UID = 'uid';

    /**
     * @var string
     */
    private const PID = 'pid';

    /**
     * @var string
     */
    private const TCA = 'TCA';

    /**
     * @var string
     */
    private const CTRL = 'ctrl';

    /**
     * @var string
     */
    private const LABEL = 'label';

    /**
     * @var string
     */
    private const TX_GUARD7_DOMAIN_MODEL_DATA = 'tx_guard7_domain_model_data';

    /**
     * @var string
     */
    private const TABLENAME = 'tablename';

    /**
     * @var string
     */
    private const TABLEUID = 'tableuid';

    /**
     * @var string
     */
    private const FIELDNAME = 'fieldname';

    /**
     * @var string
     */
    private const SECRETDATA = 'secretdata';

    /**
     * @var string
     */
    private const IDENTIFIER = 'identifier';

    /**
     * @var string
     */
    private const METHOD = 'method';

    /**
     * wrapper function called by hook (\TYPO3\CMS\Core\Page\PageRenderer->render-preProcess)
     *
     * @param array $parameters An array of available parameters
     * @param \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer The parent object that triggered this hook
     */
    public function addJSCSS(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer): void
    {

        // Add language labels for ExtDirect
        $pageRenderer->addInlineLanguageLabelArray([
            'guard7_usekeytounlock'  => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:usekeytounlock',
            'guard7_providepassword'  => 'LLL:EXT:guard7/Resources/Private/Language/locallang.xlf:providepassword',
        ]);

        $configadapter = GeneralUtility::makeInstance(ConfigurationAdapter::class);

        if (!$configadapter->extensionConfig[self::USEJAVASCRIPTDECODINGINBACKEND]) {
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

        if ($GLOBALS[self::SOBE]) {
            $class = get_class($GLOBALS[self::SOBE]);

            if ($class == EditDocumentController::class) {
                $this->handleEditDocumentController($parameters, $pageRenderer);
            }

            if ($class == RecordListController::class) {
                $this->handleRecordListLight($parameters, $pageRenderer);
            }
        }
    }

    public function postRender(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer): void
    {
        $configadapter = GeneralUtility::makeInstance(ConfigurationAdapter::class);

        if (!$configadapter->extensionConfig[self::USEJAVASCRIPTDECODINGINBACKEND]) {
            return;
        }

        if ($GLOBALS[self::SOBE]) {
            $class = get_class($GLOBALS[self::SOBE]);

            if ($class == RecordListController::class) {
                //$this->handleRecordList( $parameters, $pageRenderer);
            }
        }
    }

    private function handleRecordListLight(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer): void
    {

        /** @var RecordListController $controller */
        $controller = $GLOBALS[self::SOBE];

        $tables = Helper::getAllGuard7Tables($controller->id);
        if (!empty($tables)) {
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Guard7/List');
            $pageRenderer->addJsInlineCode(
                __METHOD__,
                'var sudhaus7guard7tables = ' . json_encode($tables, JSON_THROW_ON_ERROR) . ';var sudhaus7guard7data_DISABLED = false;'
            );
        }
    }

    /**
     * @param array $parameters
     * @param \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer
     */
    private function handleRecordList(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer): void
    {
        $configadapter = GeneralUtility::makeInstance(ConfigurationAdapter::class);
        if (!$configadapter->extensionConfig[self::USEJAVASCRIPTDECODINGINBACKEND]) {
            return;
        }

        /** @var RecordListController $controller */
        $controller = $GLOBALS[self::SOBE];

        $tables = Helper::getAllGuard7Tables($controller->id);
        if (!empty($tables)) {
            $data = [];
            foreach ($tables as $table) {
                $table = trim($table, '.');

                /** @var Connection $connection */
                $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                    ->getConnectionForTable($table);

                $res = $connection->select([self::UID], $table, [self::PID => $controller->id]);
                $uids = $res->fetchAll();
                if (!empty($uids)) {
                    $idlist = [];
                    foreach ($uids as $a) {
                        $idlist[] = $a[self::UID];
                    }

                    $fields = $GLOBALS[self::TCA][$table][self::CTRL][self::LABEL];
                    $fields .= ',' . $GLOBALS[self::TCA][$table][self::CTRL]['label_alt'];
                    $fields = trim($fields, ',');
                    $fields = "'" . str_replace(',', "','", $fields) . "'";

                    $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                        ->getConnectionForTable(self::TX_GUARD7_DOMAIN_MODEL_DATA);
                    $query = $connection->createQueryBuilder();
                    $query->select([
                        self::TABLENAME,
                        self::TABLEUID,
                        self::FIELDNAME,
                        self::SECRETDATA,
                    ])
                        ->from(self::TX_GUARD7_DOMAIN_MODEL_DATA);

                    $query->andWhere($query->expr()->in(self::TABLEUID, $idlist));
                    $query->andWhere($query->expr()->in(self::FIELDNAME, $fields));
                    $query->andWhere($query->expr()->eq(self::TABLENAME, $query->createNamedParameter($table)));
                    $result = $query->execute();
                    $subdata = $result->fetchAll();
                    $data = array_merge($data, $subdata);
                }
            }

            if (!empty($data)) {
                $pageRenderer->loadRequireJsModule('TYPO3/CMS/Guard7/List');
                $pageRenderer->addJsInlineCode(
                    __METHOD__,
                    'var sudhaus7guard7data = ' . json_encode($data, JSON_THROW_ON_ERROR) . ';var sudhaus7guard7data_DISABLED = false;'
                );
            }
        }
    }

    /**
     * @param array $parameters
     * @param \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer
     */
    private function handleEditDocumentController(array $parameters, \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer): void
    {
        $this->editconf = $GLOBALS[self::SOBE]->editconf;
        $this->controller = $GLOBALS[self::SOBE];

        if (!empty($this->editconf)) {
            foreach ($this->editconf as $table => $config) {
                if ( in_array('edit', $config)) {
                    $idlist = GeneralUtility::trimExplode(',', array_keys($config)[0], true);
                    $id = array_shift($idlist);
                    $rec = BackendUtility::getRecord($table, $id, '*');

                    if (Helper::tableIsGuard7Element($table, $rec[self::PID])) {
                        $data = [

                        ];

                        //$fields = GeneralUtility::trimExplode( ',',$ts['tx_sudhaus7guard7.'][ $table . '.' ]['fields'], true );

                        /** @var Connection $connection */
                        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                            ->getConnectionForTable(self::TX_GUARD7_DOMAIN_MODEL_DATA);

                        $result = $connection->select(
                            [
                                self::TABLENAME,
                                self::TABLEUID,
                                self::FIELDNAME,
                                self::SECRETDATA,
                            ],
                            self::TX_GUARD7_DOMAIN_MODEL_DATA,
                            [
                                self::TABLENAME => $table,
                                self::TABLEUID => $id,
                            ]
                        );

                        while ($row = $result->fetch( PDO::FETCH_ASSOC)) {
                            $identifier = sprintf('[data-formengine-input-name="data[%s][%d][%s]"]', $row[self::TABLENAME], $row[self::TABLEUID], $row[self::FIELDNAME]);
                            $data[] = [
                                self::IDENTIFIER => $identifier,
                                self::METHOD => 'val',
                                self::SECRETDATA => $row[self::SECRETDATA],
                            ];
                        }

                        /**
                         * Handle / prepare IRRE
                         */
                        $tcafields = GeneralUtility::trimExplode(',', $GLOBALS[self::TCA][$table]['types'][0]['showitem'], true);

                        foreach ($tcafields as $field) {
                            if ($GLOBALS[self::TCA][$table]['columns'][$field]['config']['type'] === 'inline') {
                                $reltable = $GLOBALS[self::TCA][$table]['columns'][$field]['config']['foreign_table'];
                                $config['irre'][] = [
                                    'table' => $reltable,
                                    'field' => $field,
                                ];
                                $config['fields'][$reltable] = Helper::getFields($reltable, $rec[self::PID]);

                                $label = $GLOBALS[self::TCA][$reltable][self::CTRL][self::LABEL];
                                if ($GLOBALS[self::TCA][$reltable][self::CTRL]['label_alt_force']) {
                                    $label .= ',' . $GLOBALS[self::TCA][$reltable][self::CTRL]['label_alt'];
                                }

                                $labelfields = GeneralUtility::trimExplode(',', $label, true);
                                $labels = [];

                                if (!empty($rec[$field])) {
                                    $query = $connection->createQueryBuilder();
                                    $irreres = $query->select([
                                        self::TABLENAME,
                                        self::TABLEUID,
                                        self::FIELDNAME,
                                        self::SECRETDATA,
                                    ])
                                        ->from(self::TX_GUARD7_DOMAIN_MODEL_DATA)
                                        ->andWhere($query->expr()->eq(self::TABLENAME, $query->createNamedParameter($reltable)))
                                        ->andWhere($query->expr()->in(self::TABLEUID, GeneralUtility::trimExplode(',', $rec[$field], true)))
                                        ->addOrderBy(self::TABLEUID, 'ASC')
                                        ->execute();

                                    while ($row = $irreres->fetch( PDO::FETCH_ASSOC)) {
                                        // $data[]=$row;

                                        if (in_array($row[self::FIELDNAME], $labelfields, true)) {
                                            $labels[$row[self::TABLEUID]][] = $row[self::SECRETDATA];
                                        }

                                        $identifier = sprintf('[data-formengine-input-name="data[%s][%d][%s]"]', $row[self::TABLENAME], $row[self::TABLEUID], $row[self::FIELDNAME]);
                                        $data[] = [
                                            self::IDENTIFIER => $identifier,
                                            self::METHOD => 'val',
                                            self::SECRETDATA => $row[self::SECRETDATA],
                                        ];
                                    }
                                }

                                if (!empty($labels)) {
                                    foreach ($labels as $id => $label) {
                                        $identifier = sprintf('#data-%d-%s-%d-%s-%s-%d_label', $rec[self::PID], $table, $rec[self::UID], $field, $reltable, $id);
                                        $data[] = [
                                            self::IDENTIFIER => $identifier,
                                            self::METHOD => self::LABEL,
                                            self::SECRETDATA => implode('|', $label),
                                        ];
                                    }
                                }
                            }
                        }

                        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Guard7/Main');
                        $pageRenderer->addJsInlineCode(
                            __METHOD__,
                            'var sudhaus7guard7data = ' . json_encode($data, JSON_THROW_ON_ERROR) . ';var sudhaus7guard7data_DISABLED = false;'
                        );
                    }
                }
            }
        }
    }
}
