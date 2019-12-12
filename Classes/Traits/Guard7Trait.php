<?php


namespace SUDHAUS7\Guard7\Traits;

use SUDHAUS7\Guard7\Tools\Helper;
use SUDHAUS7\Guard7\Tools\Keys;
use SUDHAUS7\Guard7\Tools\Storage;

trait Guard7Trait
{
    
    /**
     * @var bool
     */
    private $_needsPersisting = false;

    final public function _hasNeedForPersisting()
    {
        return $this->_needsPersisting;
    }
    
    final public function _removeNeedForPersisting()
    {
        $this->_needsPersisting = false;
    }
    
    public function _isNew()
    {
        $isNew = parent::_isNew();
        if ($isNew) {
            $this->_needsPersisting = true;
        } else {
            // we hijack this function, as it is called just before persisting an object. We actually don't care if it is new..
            $table = Helper::getModelTable($this);
            $fields = Helper::getModelFields($this, $table);
            $pubKeys = Keys::collectPublicKeys($table, 0, (int)$this->getPid(), true);
            Storage::lockModel($this, $fields, $pubKeys, false);
        }
        return $isNew;
    }
    
    /**
     * @param null $privateKey
     * @param null $password
     * @throws \SUDHAUS7\Guard7\MissingKeyException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     */
    public function _unlock($privateKey=null, $password=null)
    {
        $table = Helper::getModelTable($this);
        Storage::unlockModel($this, $table, $privateKey, $password);
    }
}
