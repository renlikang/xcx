<?php
return [
    'adminEmail' => 'admin@example.com',
    'apidoc'=>[
        'scan_dir'=>[
            'api/controllers',
            'api/actions',
        ]
    ],

    'permissionRoute' => [
        'guest' => [
            'login' => ['*'],
            'index' => ['*'],
            'comment' => ['index'],
            'activity' => ['*'],
            'article' =>['list']
        ],
    ],
];
