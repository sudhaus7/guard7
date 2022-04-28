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

namespace Sudhaus7\Guard7\Hooks\Frontend;

use Exception;
use Sudhaus7\Guard7\Interfaces\Guard7Interface;
use Sudhaus7\Guard7\Tools\Helper;
use Sudhaus7\Guard7\Tools\Storage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

final class AfterPersistHandler
{
    /**
     * @param AbstractEntity $object
     * @return AbstractEntity[]
     */
    public function handle(AbstractEntity $object): array
    {
        if ($object instanceof Guard7Interface) {
            $this->dopersist($object);
        } elseif (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
            $classname = get_class($object);
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] as $config) {
                if (isset($config['className']) && $config['className'] === $classname) {
                    $this->dopersist($object);
                }
            }
        }

        return [$object];
    }

    /**
     * @param AbstractEntity $object
     */
    private function dopersist(AbstractEntity $object): void
    {
        try {
            $table = Helper::getModelTable($object);
            $fields = Helper::getModelFields($object, $table);
            $pubKeys = Helper::collectPublicKeysForModel($object, false);
            Storage::lockModel($object, $fields, $pubKeys, false);
            if ($object->_isDirty()) {
                $objectmanager = GeneralUtility::makeInstance(ObjectManager::class);
                $persistencemanager = $objectmanager->get(PersistenceManager::class);
                $persistencemanager->add($object);
                $persistencemanager->persistAll();
            }
        } catch (Exception $exception) {
            // we ignore this
        }
    }
}
