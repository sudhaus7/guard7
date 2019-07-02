<?php


namespace Domain\Model;


interface Guard7Interface
{
    public function _hasNeedForPersisting();
    public function _hasBeenForPersisted();
    public function _unlock($privateKey, $password=null);
    
}
