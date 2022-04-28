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

use Sudhaus7\Guard7\Controller\AjaxController;

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
return [

    'guard7_backend_list_data' => [
        'path' => '/guard7/backend/list/data',
        'target' => AjaxController::class . '::ajaxData',
    ],

    'guard7_backend_storekeyinglobal' => [
        'path' => '/guard7/backend/storekey',
        'target' => AjaxController::class . '::storeKeyInGlobal',
    ],

    'guard7_create_new_keypair' => [
        'path' => '/guard7/backend/createkey',
        'target' =>AjaxController::class . '::createNewKeypair',
    ],

];
