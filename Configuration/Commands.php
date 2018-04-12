<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 26.02.18
 * Time: 16:27
 */
return [
    'guard7:db:lock'   => [
        'class' => SUDHAUS7\Guard7\Commands\DblocktableCommand::class,
    ],
    'guard7:db:unlock' => [
        'class' => SUDHAUS7\Guard7\Commands\DbunlocktableCommand::class,
    ],
    //'guard7:file:lock' => [
    //	'class' => SUDHAUS7\Guard7\Commands\FilelockCommand::class
    //],
    /*	'guard7:db:listdirty' => [
            'class' => SUDHAUS7\Guard7\Commands\DblistdirtyCommand::class
        ],
        'guard7:db:repairdirty' => [
            'class' => SUDHAUS7\Guard7\Commands\DbrepairdirtyCommand::class
        ]*/
];
