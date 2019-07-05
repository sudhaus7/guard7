<?php


namespace SUDHAUS7\Guard7\Domain\Model;


interface Guard7Interface
{
    public function _hasNeedForPersisting();
    public function _removeNeedForPersisting();
    public function _unlock($privateKey, $password=null);
}
