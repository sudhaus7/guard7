<?php

return [

    'guard7_backend_list_data' => [
        'path' => '/guard7/backend/list/data',
        'target' => \SUDHAUS7\Guard7\Controller\AjaxController::class . '::ajaxData'
    ],

    'guard7_backend_storekeyinglobal' => [
        'path' => '/guard7/backend/storekey',
        'target' => \SUDHAUS7\Guard7\Controller\AjaxController::class . '::storeKeyInGlobal'
    ],

    'guard7_create_new_keypair' => [
        'path' => '/guard7/backend/createkey',
        'target' =>\SUDHAUS7\Guard7\Controller\AjaxController::class.'::createNewKeypair'
    ],
    
];
