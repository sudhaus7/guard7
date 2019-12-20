<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 16.02.18
 * Time: 17:07
 */

namespace SUDHAUS7\Guard7\Hooks\Backend;

use SUDHAUS7\Guard7\KeyNotReadableException;
use SUDHAUS7\Guard7\Tools\Helper;
use SUDHAUS7\Guard7\Tools\Keys;
use SUDHAUS7\Guard7\Tools\PrivatekeySingleton;
use SUDHAUS7\Guard7\WrongKeyPassException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class FeLogin
{
    public function handle($ar)
    {
        
        /** @var TypoScriptFrontendController $pObj */
        $pObj = $ar['pObj'];
        
        if (isset($GLOBALS['guard7_temp_pass'])) {
            if (!empty($pObj->fe_user->user['tx_guard7_privatekey'])) {
                try {
                    $privkey = Keys::unlockKeyToPem(
                        $pObj->fe_user->user['tx_guard7_privatekey'],
                        $GLOBALS['guard7_temp_pass']
                    );
                    $GLOBALS['TSFE']->fe_user->setKey('user', 'tx_guard7_privatekey', $privkey);
                    $GLOBALS['TSFE']->fe_user->storeSessionData('guard7');
                    
                    
                    //$pObj->fe_user->setAndSaveSessionData( 'tx_guard7_privatekey', $privkey);
                } catch (WrongKeyPassException $e) {
                } catch (KeyNotReadableException $e) {
                }
            }
            unset($GLOBALS['guard7_temp_pass']);
        }
    
        $extConfig = Helper::getExtensionConfig();
        
        if ($extConfig['populatefeuserprivatekeytofrontend']) {
            $key = $GLOBALS['TSFE']->fe_user->getKey('user','tx_guard7_privatekey');
            $privateKey = GeneralUtility::makeInstance(PrivatekeySingleton::class);
            if (!empty($key)) {
                $privateKey->setKey($key);
            } else {
                $privateKey->setKey();
            }
        }
        
    }
    public function handleBeUser($ar)
    {
        
        if (isset($ar['BE_USER'])) {
            $key = $ar['BE_USER']->getSessionData('privatekey');
            $privateKey = GeneralUtility::makeInstance(PrivatekeySingleton::class);
            if (!empty($key)) {
                $privateKey->setKey($privateKey);
            }
        }
    }
}
