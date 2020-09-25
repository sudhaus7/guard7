<?php


namespace SUDHAUS7\Guard7\Traits;

use SUDHAUS7\Guard7\Tools\Helper;
use SUDHAUS7\Guard7\Tools\Keys;
use SUDHAUS7\Guard7\Tools\Storage;

/**
 * Trait Guard7Trait
 *
 * @package SUDHAUS7\Guard7\Traits
 */
trait Guard7Trait
{
    
    /**
     * @var bool
     */
    private $_needsPersisting = false;
    
    /**
     * @return bool
     */
    final public function _hasNeedForPersisting()
    {
        return $this->_needsPersisting;
    }
    
    /**
     *
     */
    final public function _removeNeedForPersisting()
    {
        $this->_needsPersisting = false;
    }
    
    /**
     * @return bool
     * @throws \SUDHAUS7\Guard7\SealException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
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
     * isDirty has to ignore our property
     * @param null $propertyName
     * @return bool
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception\TooDirtyException
     */
    public function _isDirty($propertyName = null)
    {
        if ($propertyName !== null) {
            if ($propertyName==='_needsPersisting') {
                return false;
            }
        }
        return parent::_isDirty($propertyName);
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
