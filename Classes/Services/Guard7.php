<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 16.02.18
 * Time: 16:48
 */

namespace SUDHAUS7\Guard7\Services;

class Guard7 extends \TYPO3\CMS\Sv\AuthenticationService
{
    public function processLoginData(array &$loginData, $passwordTransmissionStrategy)
    {
        $GLOBALS['guard7_temp_pass'] = $loginData['uident_text'];
    }

    public function init()
    {
        return true;
    }
}
