<?php


return [
    'ctrl' => [
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'default_sortby' => 'date DESC',
        'adminOnly' => false,
        'rootLevel' => 0,
        'iconfile' => 'EXT:workshop_blog/Resources/Public/Icons/Extension.svg',
        'enablecolumns' => [
            'disabled' => 'hidden'
        ],
        'title' => 'Blogentry',
        'searchFields' => 'hidden,date,title,teaser,bodytext'
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden,date,title,teaser,bodytext'
    ],
    'palettes' => [],
    'types' => [
        1 => [
            'showitem' => 'hidden,date,title,teaser,bodytext'
        ]
    ],
    'columns' => [
        'tstamp' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'Visible',
            'config' => [
                'type' => 'check',
                //'renderType' => 'checkboxToggle',
                'default' => 1,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ]
        ],
        'title' => [
            'label' => 'Title',
            'config' => [
                'type' => 'input'
            ]
        ],
        'date' => [
            'label' => 'Date',
            'config' => [
                'type' => 'input',
                'eval' => 'datetime'
            ]
        ],

        'teaser' => [
            'label' => 'Teaser',
            'config' => [
                'type' => 'text'
            ]
        ],

        'bodytext' => [
            'label' => 'Content',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ]
        ],


    ]
];
