<?php
declare(strict_types=1);

namespace SUDHAUS7\Guard7\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SUDHAUS7\Guard7\Adapter\ConfigurationAdapter;
use SUDHAUS7\Guard7Core\Factory\KeyFactory;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AjaxController
 *
 * @package SUDHAUS7\Guard7\Controller
 */
class AjaxController
{
    
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function storeKeyInGlobal(ServerRequestInterface $request, ResponseInterface $response)
    {
        $post = $request->getParsedBody();
        if (isset($post['key'])) {
            $GLOBALS['BE_USER']->setAndSaveSessionData('privatekey', $post['key']);
        }
        
        $response->getBody()->write(\json_encode(['ok'=>1]));
        return $response;
    }
    
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \SUDHAUS7\Guard7Core\Exceptions\KeyNotReadableException
     * @throws \SUDHAUS7\Guard7Core\Exceptions\WrongKeyPassException
     */
    public function createNewKeypair(ServerRequestInterface $request): ResponseInterface
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
        if (isset($body['password']) && !empty($body['password'])) {
            $password = $body['password'];
        }
        
        $key = KeyFactory::newKey($configuration, $password);
        $key->unlock($password);
        $payload = [
            'private'=>$key->getKey(),
            'public'=>$key->getPublicKey()
        ];
        $response = GeneralUtility::makeInstance(Response::class);
        $response->getBody()->write(\json_encode($payload));
        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
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
    }
}
