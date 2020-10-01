<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 16.02.18
 * Time: 17:07
 */

namespace SUDHAUS7\Guard7\Hooks\Backend;

use SUDHAUS7\Guard7\Adapter\ConfigurationAdapter;
use SUDHAUS7\Guard7\Tools\PrivatekeySingleton;
use SUDHAUS7\Guard7Core\Factory\KeyFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class FeLogin
{
    public function handle($parameters)
    {
        
        /** @var TypoScriptFrontendController $pObj */
        $pObj = $parameters['pObj'];
        /** @var ConfigurationAdapter $configadapter */
        $configadapter = GeneralUtility::makeInstance(ConfigurationAdapter::class);
        if (isset($GLOBALS['guard7_temp_pass'])) {
            if (!empty($pObj->fe_user->user['tx_guard7_privatekey'])) {
                try {
                    
                    
                    
                    $privateKey = KeyFactory::readFromString($configadapter, $pObj->fe_user->user['tx_guard7_privatekey'])
                        ->export($GLOBALS['guard7_temp_pass'])
                        ->getKey();
                    
                    $GLOBALS['TSFE']->fe_user->setKey('user', 'tx_guard7_privatekey', $privateKey);
                    $GLOBALS['TSFE']->fe_user->storeSessionData('guard7');
                    
                    
                    //$pObj->fe_user->setAndSaveSessionData( 'tx_guard7_privatekey', $privkey);
                } catch (\SUDHAUS7\Guard7Core\Exceptions\WrongKeyPassException $exception) {
                    //msg user
                } catch (\SUDHAUS7\Guard7Core\Exceptions\KeyNotReadableException $exception) {
                    // msg user
                }
            }
            unset($GLOBALS['guard7_temp_pass']);
        }

        if ($configadapter->config['populatefeuserprivatekeytofrontend']) {
            $key = $GLOBALS['TSFE']->fe_user->getKey('user', 'tx_guard7_privatekey');
            $privateKey = GeneralUtility::makeInstance(PrivatekeySingleton::class);
            if (!empty($key)) {
                $privateKey->setKey($key);
            } else {
                $privateKey->setKey(null);
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
