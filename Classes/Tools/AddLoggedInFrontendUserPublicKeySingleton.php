<?php


namespace SUDHAUS7\Guard7\Tools;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Class AddLoggedInFrontendUserPublicKeySingleton
 *
 * @package SUDHAUS7\Guard7\Tools
 */
final class AddLoggedInFrontendUserPublicKeySingleton implements SingletonInterface
{
    /**
     * @var array
     */
    private $list = [];
    
    /**
     * @param AbstractEntity $o
     */
    public function add(AbstractEntity $o)
    {
        if (!$this->has($o)) {
            $this->list[]=$o;
        }
    }
    
    /**
     * @param AbstractEntity $o
     * @return bool
     */
    public function has(AbstractEntity $o)
    {
        return \in_array($o, $this->list, true);
    }
    
    /**
     * @param AbstractEntity $o
     */
    public function remove(AbstractEntity $o)
    {
        if ($this->has($o)) {
            foreach ($this->list as $k=>$e) {
                if ($e === $o) {
                    unset($this->list[$k]);
                }
            }
        }
    }
}
