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
use TYPO3\CMS\Backend\Controller\EditDocumentController;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class SignalHandler
{

    /**
     * @var string
     */
    private const TX_GUARD7_PUBLICKEY = 'tx_guard7_publickey';

    public function EditDocumentInit(EditDocumentController $cntrl): void
    {
        $mypagerenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $mypagerenderer->editconf = $cntrl->editconf;
        $mypagerenderer->controller = $cntrl;
    }

    /**
     * @return mixed[]
     */
    public function FeuserFetchkey($keys, $uid, $pid): array
    {
        if (substr($uid, 0, 3) != 'NEW' && $uid > 0) {
            /** @var Connection $connection */
            $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('fe_users');
            $row = $connection->select([self::TX_GUARD7_PUBLICKEY], 'fe_users', ['uid' => $uid])
                ->fetch( PDO::FETCH_ASSOC);
            if ($row && !empty($row[self::TX_GUARD7_PUBLICKEY])) {
                $keys[] = $row[self::TX_GUARD7_PUBLICKEY];
            }
        }

        return [
            $keys,
            $uid,
            $pid,
        ];
    }
}
