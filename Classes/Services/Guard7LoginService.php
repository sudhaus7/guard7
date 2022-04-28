<?php

/*
 * This file is part of the TYPO3 project.
 * (c) 2022 B-Factor GmbH
 *          Sudhaus7
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 * @copyright 2022 B-Factor GmbH https://b-factor.de/
 * @author Frank Berger <fberger@b-factor.de>
 */

namespace Sudhaus7\Guard7\Services;

use TYPO3\CMS\Core\Authentication\AbstractAuthenticationService;

final class Guard7LoginService extends AbstractAuthenticationService
{
    public function processLoginData(array &$loginData, $passwordTransmissionStrategy): void
    {
        $GLOBALS['guard7_temp_pass'] = $loginData['uident_text'];
    }

    public function init(): bool
    {
        return true;
    }
}
