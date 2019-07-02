<?php


namespace SUDHAUS7\Guard7\Domain\Model;

use SUDHAUS7\Guard7\Tools\Helper;
use SUDHAUS7\Guard7\Tools\Keys;
use SUDHAUS7\Guard7\Tools\Storage;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

abstract class Guard7AbstractEntity extends AbstractEntity
{
    public function _isNew()
    {
        // we hijack this function, as it is called just before persisting an object. We actually don't care if it is new..
        $table = Helper::getModelTable($this);
        $fields = Helper::getModelFields($this, $table);
        $pubKeys = Keys::collectPublicKeys($table, 0, (int)$this->getPid(), true);
        Storage::lockModel($this, $fields, $pubKeys, false);
        
        return parent::_isNew();
    }
    
    /**
     * @param $privateKey
     * @param null $password
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     */
    public function _unlock($privateKey, $password=null)
    {
        $table = Helper::getModelTable($this);
        Storage::unlockModel($this, $table, $privateKey, $password);
    }
}
