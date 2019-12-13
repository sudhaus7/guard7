<?php

return [

    'guard7_backend_list_data' => [
        'path' => '/guard7/backend/list/data',
        'target' => \SUDHAUS7\Guard7\Controller\ModuleController::class . '::ajaxData'
    ],

    'guard7_backend_storekeyinglobal' => [
        'path' => '/guard7/backend/storekey',
        'target' => \SUDHAUS7\Guard7\Controller\ModuleController::class . '::storeKeyInGlobal'
    ],


];
