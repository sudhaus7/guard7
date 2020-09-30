<?php


namespace SUDHAUS7\Guard7\Hooks\Frontend;

use SUDHAUS7\Guard7\Interfaces\Guard7Interface;
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
                $object->_removeNeedForPersisting();
                $this->dopersist($object);
            }
        } elseif (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
            $classname = get_class($object);
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] as $config) {
                if (isset($config['className']) && $config['className'] === $classname) {
                    $this->dopersist($object);
                }
            }
        }
        return [$object];
    }
    
    /**
     * @param AbstractEntity $object
     */
    private function dopersist(AbstractEntity $object)
    {
        try {
            $table = Helper::getModelTable($object);
            $fields = Helper::getModelFields($object, $table);
            $pubKeys = Helper::collectPublicKeysForModel($object, false);
            Storage::lockModel($object, $fields, $pubKeys, false);
            if ($object->_isDirty()) {
                $objectmanager = GeneralUtility::makeInstance(ObjectManager::class);
                $persistencemanager = $objectmanager->get(PersistenceManager::class);
                $persistencemanager->add($object);
                $persistencemanager->persistAll();
            }
        } catch (\Exception $e) {
        }
    }
}
