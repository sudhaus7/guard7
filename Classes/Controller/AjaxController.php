<?php

declare(strict_types=1);

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

namespace Sudhaus7\Guard7\Controller;

use function json_encode;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sudhaus7\Guard7\Adapter\ConfigurationAdapter;
use SUDHAUS7\Guard7Core\Exceptions\KeyNotReadableException;
use SUDHAUS7\Guard7Core\Exceptions\WrongKeyPassException;
use SUDHAUS7\Guard7Core\Factory\KeyFactory;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AjaxController
 */
final class AjaxController
{

    /**
     * @var string
     */
    private const PASSWORD = 'password';

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    public function storeKeyInGlobal(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $post = $request->getParsedBody();
        if (isset($post['key'])) {
            $GLOBALS['BE_USER']->setAndSaveSessionData('privatekey', $post['key']);
        }

        $response->getBody()->write(json_encode([ 'ok' =>1]));
        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @throws KeyNotReadableException
     * @throws WrongKeyPassException
     */
    public function createNewKeypair(ServerRequestInterface $request): Response
    {

        /** @var ConfigurationAdapter $configuration */
        $configuration = GeneralUtility::makeInstance(ConfigurationAdapter::class);

        /** @var array $body */
        $body = $request->getParsedBody();

        if (isset($body['size'])) {
            $configuration->setKeySize((int)$body['size']);
        }

        if (isset($body['method'])) {
            $configuration->setDefaultMethod($body['method']);
        }

        $password = null;
        if (isset($body[self::PASSWORD]) && !empty($body[self::PASSWORD])) {
            $password = $body[self::PASSWORD];
        }

        $key = KeyFactory::newKey($configuration, $password);
        $key->unlock($password);

        $payload = [
            'private'=>$key->getKey(),
            'public'=>$key->getPublicKey(),
        ];
        $response = GeneralUtility::makeInstance(Response::class);
        $response->getBody()->write(json_encode($payload, JSON_THROW_ON_ERROR));
        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    public function ajaxData(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        /** @var ServerRequest $request */
        $get = $request->getQueryParams();
        $table = $get['table'];
        $idlist = $get['uids'];

        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_guard7_domain_model_data');

        $query = $connection->createQueryBuilder();
        $query->select(['tablename', 'tableuid', 'fieldname', 'secretdata'])
              ->from('tx_guard7_domain_model_data');

        $fields = $GLOBALS['TCA'][$table]['ctrl']['label'];
        $fields .= ',' . $GLOBALS['TCA'][$table]['ctrl']['label_alt'];
        $fields = trim($fields, ',');
        $fields = "'" . str_replace(',', "','", $fields) . "'";

        $query->andWhere($query->expr()->in('tableuid', $idlist));
        $query->andWhere($query->expr()->in('fieldname', $fields));
        $query->andWhere($query->expr()->eq('tablename', $query->createNamedParameter($table)));

        $result = $query->execute();
        $data = $result->fetchAllAssociative();

        $response->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR));
        return $response;
    }
}
