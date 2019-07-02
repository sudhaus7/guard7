<?php


namespace Hooks\Frontend;


use Domain\Model\Guard7Interface;
use SUDHAUS7\Guard7\Tools\Helper;
use SUDHAUS7\Guard7\Tools\Keys;
use SUDHAUS7\Guard7\Tools\Storage;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class AfterPersistHandler
{
    public function handle(AbstractEntity $object)
    {
        //if(property_exists($object,'_needsPersisting')) {
        if ($object instanceof Guard7Interface) {
            if ($object->_hasNeedForPersisting()) {
                $table = Helper::getModelTable($this);
                $fields = Helper::getModelFields($this, $table);
                $pubKeys = Keys::collectPublicKeys($table, 0, (int)$this->getPid(), true);
                Storage::lockModel($this, $fields, $pubKeys, false);
                
            }
        }
        return [$object];
    }
}
