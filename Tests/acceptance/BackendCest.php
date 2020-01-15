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
    
    public function canSeeEncryptedContent(AcceptanceTester $I, \Page\Acceptance\Backendlogin $loginPage)
    {
        $loginPage->login('admin','adminadmin');
        $I->click('List');
        $I->wait(2);
        $I->see('User');
        $I->click('User');
        $I->switchToIFrame('#typo3-contentIframe');
        $I->wait(4);
        
        $I->see('Website User (1)');
        $I->click('Website User (1)');
        $I->wait(2);
        $I->see('🔒');
        
        $I->see('testuser');
        $I->click('testuser');
        $I->wait(2);
        $I->see('Personal Data');
        $I->click('Personal Data');
        $I->wait(2);
        
        $x = $I->grabAttributeFrom('input[data-formengine-input-name="data[fe_users][1][company]"]', 'placeholder');
        assert(false !== strpos( $x,'Activate your private key to view content'));
        
        
    }
    
    
    public function _canSeeDecryptedContent(AcceptanceTester $I, \Page\Acceptance\Backendlogin $loginPage)
    {
        $loginPage->login('admin','adminadmin');
    
        $I->wait(1);

        
        $I->click('//body/div[1]/div[2]/div[1]/ul[1]/li[1]/a');
    
        $I->fillField('textarea[name=newkey]', '-----BEGIN PRIVATE KEY-----
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
VDT6kGX96gj3JnCvFDy/iTZbCu+1duU=
-----END PRIVATE KEY-----');
        $I->click('Activate key');
        $I->wait(5);
        
        
        $I->click('List');
        $I->wait(2);
        $I->see('User');
        $I->click('User');
        $I->switchToIFrame('#typo3-contentIframe');
        $I->wait(4);
        
        $I->see('Website User (1)');
        $I->click('Website User (1)');
        $I->wait(4);
        $I->dontSee('🔒');
        
        $I->see('testuser');
        $I->click('testuser');
        $I->wait(4);
        $I->see('Personal Data');
        $I->click('Personal Data');
        $I->wait(4);
        
        $x = $I->grabAttributeFrom('input[data-formengine-input-name="data[fe_users][1][company]"]', 'placeholder');
        assert(false === strpos( $x,'Activate your private key to view content'));
        
        
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
