<?php


namespace SUDHAUS7\Guard7\Tools;


use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

final class AddLoggedInFrontendUserPublicKeySingleton implements SingletonInterface
{
    private $list = [];
    
    public function add(AbstractEntity $o)
    {
        if (!$this->has($o)) {
            $this->list[]=$o;
        }
    }
    
    public function has(AbstractEntity $o)
    {
        return \in_array($o, $this->list, true);
    }
    
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
