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
        $I->wait(2);
        $I->see('Generate a new Keypair with 2048 bytes');
        $I->click('Generate a new Keypair with 2048 bytes');
    /*
        $I->waitForElementChange('//textarea[@name="publickey"]', function(WebDriverElement $el) {
            return $el->isDisplayed();
        }, 1000);
    */
        $I->wait(5);
    
        
        assert(strpos($I->grabValueFrom('textarea[name=publickey]'), '-----BEGIN PUBLIC KEY-----')!==false);
        
        assert(strpos($I->grabValueFrom('textarea[name=privatekey]'), '-----BEGIN RSA PRIVATE KEY-----')!==false);
     
        $I->click('Generate a new Keypair with 4096 bytes (more secure, but slower)');
        /*
        $I->waitForElementChange('//textarea[@name="publickey"]', function(WebDriverElement $el) {
            return $el->isDisplayed();
        }, 1000);
        */
        $I->wait(5);
    
        assert(strpos($I->grabValueFrom('textarea[name=publickey]'), '-----BEGIN PUBLIC KEY-----')!==false);
    
        assert(strpos($I->grabValueFrom('textarea[name=privatekey]'), '-----BEGIN RSA PRIVATE KEY-----')!==false);
        //$I->seeInField('publickey', '-----BEGIN PUBLIC KEY-----');
        //$I->seeInField('privatekey', '-----BEGIN RSA PRIVATE KEY-----');
    
    
        $I->fillField('//input[@name="password"]', 'test');
        $I->click('Generate a new Keypair with 2048 bytes');
    
        /*
        $I->waitForElementChange('//textarea[@name="publickey"]', function(WebDriverElement $el) {
            return $el->isDisplayed();
        }, 1000);
        */
        $I->wait(5);
        assert(strpos($I->grabValueFrom('textarea[name=publickey]'), '-----BEGIN PUBLIC KEY-----')!==false);
    
        assert(strpos($I->grabValueFrom('textarea[name=privatekey]'), '-----BEGIN ENCRYPTED PRIVATE KEY-----')!==false);
       // $I->seeInField('publickey', '-----BEGIN PUBLIC KEY-----');
        //$I->seeInField('privatekey', '-----BEGIN ENCRYPTED PRIVATE KEY-----');
    
    
    }
}
