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

use Sudhaus7\Guard7\Interfaces\Guard7Interface;
use Sudhaus7\Guard7\Tools\Helper;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

final class AfterRemoveHandler
{
    /**
     * @return AbstractEntity[]
     */
    public function handle(AbstractEntity $object): array
    {
        if ($object instanceof Guard7Interface) {
            $this->cleanup($object);
        } elseif (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
            $classname = get_class($object);
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] as $config) {
                if (isset($config['className']) && $config['className'] === $classname) {
                    $this->cleanup($object);
                }
            }
        }

        return [$object];
    }

    private function cleanup(AbstractEntity $object): void
    {
        $table = Helper::getModelTable($object);
        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_guard7_domain_model_data');

        $connection->delete('tx_guard7_domain_model_data', ['tableuid'=>$object->getUid(), 'tablename'=>$table]);
    }
}
