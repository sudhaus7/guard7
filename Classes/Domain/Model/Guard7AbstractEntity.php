<?php


namespace SUDHAUS7\Guard7\Domain\Model;

use SUDHAUS7\Guard7\Interfaces\Guard7Interface;
use SUDHAUS7\Guard7\Tools\Keys;
use SUDHAUS7\Guard7\Traits\Guard7Trait;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

abstract class Guard7AbstractEntity extends AbstractEntity implements Guard7Interface
{
}
