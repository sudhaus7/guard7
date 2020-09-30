<?php


namespace SUDHAUS7\Guard7\Tools;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class AddLoggedInFrontendUserPublicKeySingleton
 *
 * @package SUDHAUS7\Guard7\Tools
 */
final class FrontendUserPublicKeySingleton implements SingletonInterface
{
    /**
     * @var array
     */
    private $list = [];
    
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
    public function has(AbstractEntity $entity):bool
    {
        return \in_array($entity, $this->list, true);
    }
    
    /**
     * @param AbstractEntity $entity
     */
    public function remove(AbstractEntity $entity):void
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
