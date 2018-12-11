<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'index/index',
    'modules' => [
        'apidoc' => [
            'class' => 'daodao97\apidoc\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],

        'user' => [
            'identityClass' => 'common\models\admin\AdminModel',
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'authTimeout' => 2592000,
            'enableSession' => true,
        ],

        'session' => [
            'class' => 'yii\web\CacheSession',
            'timeout' => 2592000,
            'cookieParams' => [
                'httponly' => true,
            ],
            'cache' => 'sessionCache',
        ],
//        'log' => [
//            'traceLevel' => 3,
//            'targets' => [
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning'],
//                ],
//            ],
//        ],
//        'errorHandler' => [
//            'errorAction' => 'site/error',
//        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
