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

use SUDHAUS7\Guard7Core\Service\ChecksumService;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PrivatekeySingleton
 */
final class PrivatekeySingleton implements SingletonInterface
{
    private ?string $key = null;

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string|null $key
     */
    public function setKey($key = null): void
    {
        $this->key = $key;
    }

    /**
     * @return string|null
     */
    public function checksum(): ?string
    {
        if ($this->hasKey()) {
            /** @var ChecksumService $checksumService */
            $checksumService = GeneralUtility::makeInstance(ChecksumService::class);
            return $checksumService->calculate($this->key);
        }

        return null;
    }

    public function hasKey(): bool
    {
        return $this->key === null;
    }
}
