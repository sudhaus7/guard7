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

namespace Page\Acceptance;

use AcceptanceTester;

final class Backendlogin
{
    // include url of current page
    public static string $URL = '/typo3/';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public static string $usernameField = '#t3-username';

    public static string $passwordField = '#t3-password';

    public static string $formSubmitButton = '#t3-login-submit';

    /**
     * @var AcceptanceTester;
     */
    private AcceptanceTester $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param): string
    {
        return static::$URL . $param;
    }

    public function login($name, $password): void
    {
        $I = $this->acceptanceTester;
        //     if ($I->loadSessionSnapshot('login')) {
        //         return;
        //    }
        $I->amOnPage(self::$URL);
        $I->fillField(self::$usernameField, $name);
        $I->fillField(self::$passwordField, $password);
        $I->click(self::$formSubmitButton);
        //  $I->saveSessionSnapshot('login');
    }
}
