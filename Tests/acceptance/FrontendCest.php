<?php


class FrontendCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function siteWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Welcome');
        $I->see('&#128274;');
    }
    
    public function detailWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('read more');
        $I->see('test');
        $I->see('🔒');
    }
    
    public function loginIsPossible(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->fillField('user','testuser');
        $I->fillField('pass','testuser');
        $I->click('Login');
        $I->see('You are logged in');
    }
    
    public function canCreateComment(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->fillField('user','testuser');
        $I->fillField('pass','testuser');
        $I->click('Login');
        $I->see('You are logged in');
        $I->amOnPage('/');
        $I->click('read more');
        $I->see('test');
        $I->fillField('#newcommentor', 'testcomment');
        $I->fillField('#newcomment', 'testcomment');
        $I->click('#savenewcomment');
        $I->amOnPage('/');
        $I->click('read more');
        $I->see('testcomment');
    }
    
    public function commentIsEncrypted(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('read more');
        $I->dontSee('testcomment');
    }
}
