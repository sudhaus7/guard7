<?php


namespace SUDHAUS7\Guard7\Tools;


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
            return Keys::getChecksum($this->key);
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
