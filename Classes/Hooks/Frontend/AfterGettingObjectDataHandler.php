<?php


namespace SUDHAUS7\Guard7\Hooks\Frontend;


use SUDHAUS7\Guard7\Tools\Helper;
use SUDHAUS7\Guard7\Tools\Storage;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class AfterGettingObjectDataHandler {
    
    /**
     * @param QueryInterface $query
     * @param $result
     * @return array
     */
    public function handle(QueryInterface $query, $result)
    {
        if (isset($GLOBALS['GUARD7_PRIVATEKEY']) && !empty($GLOBALS['GUARD7_PRIVATEKEY'])) {
            if ( !empty($result) ) {
                try {
                    if ( Helper::classIsGuard7Element($query->getType()) ) {
                        $table = Helper::getClassTable($query->getType());
                        foreach ($result as $idx=>$row) {
                            $result[$idx] = Storage::unlockRecord($table, $row, $GLOBALS['GUARD7_PRIVATEKEY']);
                        }
                    }
                } catch(\Exception $e) {
                    // ignore for now
                }
            }
        }
        return [$query,$result];
    }
}
