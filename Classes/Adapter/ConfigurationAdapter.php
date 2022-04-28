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

namespace Sudhaus7\Guard7\Adapter;

use SUDHAUS7\Guard7Core\Interfaces\ConfigurationAdapterInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class ConfigurationAdapter implements ConfigurationAdapterInterface, SingletonInterface
{

    /**
     * @var array
     */
    public $config = [];

    /**
     * ConfigurationAdapter constructor.
     */
    public function __construct()
    {
        $this->config = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('guard7');
    }

    /**
     * @return string
     */
    public function getDefaultMethod(): string
    {
        return $this->config['defaultmethod'];
    }

    /**
     * @return string
     */
    public function getCryptLibrary(): string
    {
        return $this->config['defaultcryptlibrary'];
    }

    public function getKeySize(): int
    {
        return $this->config['defaultkeysize'];
    }

    public function setKeySize(int $keysize): self
    {
        $this->config['defaultkeysize'] = $keysize;
        return $this;
    }

    public function setDefaultMethod(int $method): self
    {
        $this->config['defaultmethod'] = $method;
        return $this;
    }
}
