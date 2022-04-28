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

final class FrontendCest
{
    /**
     * @var string
     */
    private const TESTUSER = 'testuser';

    /**
     * @var string
     */
    private const TEST_COMMENT_123 = 'test-comment-123';

    public function _before(AcceptanceTester $I): void
    {
    }

    public function _after(AcceptanceTester $I): void
    {
    }

    // tests
    public function siteWorks(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Welcome');
        $I->see('&#128274;');
    }

    public function detailWorks(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->click('read more');
        $I->see('test');
        $I->see('🔒');
    }

    public function loginIsPossible(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->fillField('user', self::TESTUSER);
        $I->fillField('pass', self::TESTUSER);
        $I->click('Login');
        $I->see('You are logged in');
    }

    public function canCreateComment(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->fillField('user', self::TESTUSER);
        $I->fillField('pass', self::TESTUSER);
        $I->click('Login');
        $I->see('You are logged in');
        $I->amOnPage('/');
        $I->click('read more');
        $I->see('test');
        $I->wait(1);
        $I->fillField('#newcommentor', self::TEST_COMMENT_123);
        $I->fillField('#newcomment', self::TEST_COMMENT_123);
        $I->wait(1);
        $I->click('#savenewcomment');
        $I->wait(1);
        $I->amOnPage('/');
        $I->click('read more');
        $I->wait(1);
        $I->see(self::TEST_COMMENT_123);
    }

    public function commentIsEncrypted(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->click('read more');
        $I->dontSee('testcomment');
    }
}
