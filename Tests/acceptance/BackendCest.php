<?php

class BackendCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function canLogIn(AcceptanceTester $I, \Page\Acceptance\Backendlogin $loginPage)
    {
        $loginPage->login('admin','adminadmin');
        $I->see('Guard7 Testdb');
    }
    
    public function canAccessGuardModule(AcceptanceTester $I, \Page\Acceptance\Backendlogin $loginPage)
    {
        $loginPage->login('admin','adminadmin');
        $I->click('Guard7');
        
        
        $I->switchToIFrame('#typo3-contentIframe');
        $I->wait(2);
        $I->see('Generate a new Key');
        
    }
    public function canCreateKeyInGuardModule(AcceptanceTester $I, \Page\Acceptance\Backendlogin $loginPage)
    {
        $loginPage->login('admin','adminadmin');
        $I->click('Guard7');
        
        
        $I->switchToIFrame('#typo3-contentIframe');
        $I->wait(2);
        $I->see('Generate a new Key');
        $I->click('Generate a new Key');
        $I->see('Generate a new Keypair with 2048 bytes');
        $I->click('Generate a new Keypair with 2048 bytes');
        
        
    }
}
