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

namespace Sudhaus7\Guard7\Hooks\Frontend;

use Sudhaus7\Guard7\Adapter\ConfigurationAdapter;
use Sudhaus7\Guard7\Tools\Storage;
use SUDHAUS7\Guard7Core\Factory\KeyFactory;
use SUDHAUS7\Guard7Core\Service\ChecksumService;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class Userchangepassword
 */
final class Userchangepassword
{

    /**
     * @param $params
     */
    public function handle($params): void
    {

        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('fe_users');
        $user = $params['user'];
        /** @var ChecksumService $checksumService */
        $checksumService = GeneralUtility::makeInstance(ChecksumService::class);
        $signatureOld =  $checksumService->calculate($user['tx_guard7_publickey']);

        Storage::markForReencode($signatureOld);

        $password = $params['newPassword'];

        /** @var ConfigurationAdapter $configuration */
        $configuration = GeneralUtility::makeInstance(ConfigurationAdapter::class);
        $keypair = KeyFactory::newKey($configuration, $password);

        $data = [];
        $data['tx_guard7_publickey'] = $keypair->getPublicKey();
        $data['tx_guard7_privatekey'] = $keypair->getKey();
        $connection->update('fe_users', $data, ['uid' => $user['uid']]);
    }
}
