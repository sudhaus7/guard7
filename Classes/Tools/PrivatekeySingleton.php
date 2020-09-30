<?php


namespace SUDHAUS7\Guard7\Tools;

use SUDHAUS7\Guard7Core\Service\ChecksumService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PrivatekeySingleton
 *
 * @package SUDHAUS7\Guard7\Tools
 */
final class PrivatekeySingleton implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * @var null|string
     */
    private $key = null;
    
    /**
     * @return string|null
     */
    public function getKey()
    {
        return $this->key;
    }
    
    /**
     * @param null|string $key
     */
    public function setKey($key = null)
    {
        $this->key = $key;
    }
    
    /**
     * @return string|null
     */
    public function checksum()
    {
        if ($this->hasKey()) {
            /** @var ChecksumService $checksumService */
            $checksumService = GeneralUtility::makeInstance(ChecksumService::class);
            return $checksumService->calculate($this->key);
        }
        return null;
    }
    
    /**
     * @return bool
     */
    public function hasKey()
    {
        return $this->key === null;
    }
}
