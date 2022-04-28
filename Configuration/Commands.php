<?php

use Sudhaus7\Guard7\Commands\DblocktableCommand;
use Sudhaus7\Guard7\Commands\DbunlocktableCommand;
use Sudhaus7\Guard7\Commands\CreatekeypairCommand;
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
    'guard7:db:lock' => [
        'class' => DblocktableCommand::class,
    ],
    'guard7:db:unlock' => [
        'class' => DbunlocktableCommand::class,
    ],
    'guard7:createkeypair' => [
        'class' => CreatekeypairCommand::class,
    ],
    //'guard7:file:lock' => [
    //	'class' => Sudhaus7\Guard7\Commands\FilelockCommand::class
    //],
    /*	'guard7:db:listdirty' => [
            'class' => Sudhaus7\Guard7\Commands\DblistdirtyCommand::class
        ],
        'guard7:db:repairdirty' => [
            'class' => Sudhaus7\Guard7\Commands\DbrepairdirtyCommand::class
        ]*/
];
