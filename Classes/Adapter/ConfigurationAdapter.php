<?php


namespace SUDHAUS7\Guard7\Adapter;


use SUDHAUS7\Guard7Core\Interfaces\ConfigurationAdapterInterface;
use TYPO3\CMS\Core\SingletonInterface;


class ConfigurationAdapter implements ConfigurationAdapterInterface, SingletonInterface
{
    
    /**
     * @var array
     */
    public $config;
    
    /**
     * ConfigurationAdapter constructor.
     */
    public function __construct()
    {
        $this->config = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['guard7'], ['allowed_classes'=>[]]);
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
