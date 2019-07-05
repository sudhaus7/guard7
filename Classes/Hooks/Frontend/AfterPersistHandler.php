<?php


namespace SUDHAUS7\Guard7\Hooks\Frontend;



use SUDHAUS7\Guard7\Domain\Model\Guard7Interface;
use SUDHAUS7\Guard7\Tools\Helper;
use SUDHAUS7\Guard7\Tools\Keys;
use SUDHAUS7\Guard7\Tools\Storage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class AfterPersistHandler
{
    public function handle(AbstractEntity $object)
    {
        //if(property_exists($object,'_needsPersisting')) {
        if ($object instanceof Guard7Interface) {
            if ($object->_hasNeedForPersisting()) {
                $table = Helper::getModelTable($object);
                $fields = Helper::getModelFields($object, $table);
                $pubKeys = Keys::collectPublicKeys($table, 0, (int)$object->getPid(), true);
                Storage::lockModel($object, $fields, $pubKeys, false);
                $om = GeneralUtility::makeInstance(ObjectManager::class);
                $pm = $om->get(PersistenceManager::class);
                $object->_removeNeedForPersisting();
                $pm->add($object);
                $pm->persistAll();
            }
        }
        return [$object];
    }
}
