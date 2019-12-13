<?php


namespace SUDHAUS7\Guard7\Hooks\Frontend;


use SUDHAUS7\Guard7\Interfaces\Guard7Interface;
use SUDHAUS7\Guard7\Tools\Helper;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class AfterRemoveHandler {
    public function handle(AbstractEntity $object)
    {
        //if(property_exists($object,'_needsPersisting')) {
        if ($object instanceof Guard7Interface) {
            $this->cleanup($object);
        } elseif (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'])) {
            $classname = get_class($object);
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['guard7'] as $config) {
                if (isset($config['className']) && $config['className'] === $classname) {
                    $this->cleanup($object);
                }
            }
        }
        return [$object];
    }
    private function cleanup(AbstractEntity $object) {
        $table = Helper::getModelTable($object);
        /** @var Connection $connection */
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tx_guard7_domain_model_data');

        $connection->delete('tx_guard7_domain_model_data', ['tableuid'=>$object->getUid(),'tablename'=>$table]);

    }
}
