<?php
namespace Page\Acceptance;

class Backendlogin
{
    // include url of current page
    public static $URL = '/typo3/';
    
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    
    public static $usernameField = '#t3-username';
    public static $passwordField = '#t3-password';
    public static $formSubmitButton = '#t3-login-submit';
    /**
     * @var \AcceptanceTester;
     */
    protected $acceptanceTester;
    
    public function __construct(\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }
    
    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }
    
    public function login($name,$password)
    {
        $I = $this->acceptanceTester;
   //     if ($I->loadSessionSnapshot('login')) {
   //         return;
    //    }
        $I->amOnPage(self::$URL);
        $I->fillField(self::$usernameField,$name);
        $I->fillField(self::$passwordField,$password);
        $I->click(self::$formSubmitButton);
      //  $I->saveSessionSnapshot('login');
    
    }

}
