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

namespace Sudhaus7\Guard7\Hooks\Backend;

use SUDHAUS7\Guard7Core\Exceptions\WrongKeyPassException;
use SUDHAUS7\Guard7Core\Exceptions\KeyNotReadableException;
use Sudhaus7\Guard7\Adapter\ConfigurationAdapter;
use Sudhaus7\Guard7\Tools\PrivatekeySingleton;
use SUDHAUS7\Guard7Core\Factory\KeyFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

final class FeLogin
{
    /**
     * @var string
     */
    private const GUARD7_TEMP_PASS = 'guard7_temp_pass';

    /**
     * @var string
     */
    private const TX_GUARD7_PRIVATEKEY = 'tx_guard7_privatekey';

    /**
     * @var string
     */
    private const TSFE = 'TSFE';

    public function handle($parameters): void
    {

        /** @var TypoScriptFrontendController $pObj */
        $pObj = $parameters['pObj'];
        /** @var ConfigurationAdapter $configadapter */
        $configadapter = GeneralUtility::makeInstance(ConfigurationAdapter::class);
        if (isset($GLOBALS[self::GUARD7_TEMP_PASS])) {
            if (!empty($pObj->fe_user->user[self::TX_GUARD7_PRIVATEKEY])) {
                try {
                    $privateKey = KeyFactory::readFromString($configadapter, $pObj->fe_user->user[self::TX_GUARD7_PRIVATEKEY])
                        ->export($GLOBALS[self::GUARD7_TEMP_PASS])
                        ->getKey();

                    $GLOBALS[self::TSFE]->fe_user->setKey('user', self::TX_GUARD7_PRIVATEKEY, $privateKey);
                    $GLOBALS[self::TSFE]->fe_user->storeSessionData('guard7');

                    //$pObj->fe_user->setAndSaveSessionData( 'tx_guard7_privatekey', $privkey);
                } catch (WrongKeyPassException $wrongKeyPassException) {
                    //msg user
                } catch (KeyNotReadableException $keyNotReadableException) {
                    // msg user
                }
            }

            unset($GLOBALS[self::GUARD7_TEMP_PASS]);
        }

        if ($configadapter->config['populatefeuserprivatekeytofrontend']) {
            $key = $GLOBALS[self::TSFE]->fe_user->getKey('user', self::TX_GUARD7_PRIVATEKEY);
            $privateKey = GeneralUtility::makeInstance(PrivatekeySingleton::class);
            if (!empty($key)) {
                $privateKey->setKey($key);
            } else {
                $privateKey->setKey(null);
            }
        }
    }

    public function handleBeUser($ar): void
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
