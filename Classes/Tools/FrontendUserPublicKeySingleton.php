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

namespace Sudhaus7\Guard7\Tools;

use function in_array;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class AddLoggedInFrontendUserPublicKeySingleton
 */
final class FrontendUserPublicKeySingleton implements SingletonInterface
{
    private array $list = [];

    /**
     * @param AbstractEntity $entity
     */
    public function add(AbstractEntity $entity): void
    {
        if (!$this->has($entity)) {
            $this->list[]=$entity;
        }
    }

    /**
     * @param AbstractEntity $entity
     * @return bool
     */
    public function has(AbstractEntity $entity): bool
    {
        return in_array($entity, $this->list, true);
    }

    /**
     * @param AbstractEntity $entity
     */
    public function remove(AbstractEntity $entity): void
    {
        if ($this->has($entity)) {
            foreach ($this->list as $k=>$e) {
                if ($e === $entity) {
                    unset($this->list[$k]);
                }
            }
        }
    }
}
