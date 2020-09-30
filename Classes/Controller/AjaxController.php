<?php
declare(strict_types=1);

namespace SUDHAUS7\Guard7\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SUDHAUS7\Guard7\Adapter\ConfigurationAdapter;
use SUDHAUS7\Guard7Core\Factory\KeyFactory;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AjaxController
{
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
}
