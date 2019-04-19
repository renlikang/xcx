<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => 0,
            'flushInterval' => 1,
            'targets' => [
                [//错误日志，Yii::error("error occur", __CLASS__ . '::' . __FUNCTION__);
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '/opt/logs/oa-api/error.log',
                    'logVars' => [],
                    'prefix' => function () {
                        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        $uid = $user ? $user->getId(false) : '-';
                        $time = microtime(true);
                        $formatTime = date("Y-m-d H:i:s", $time) . "." . sprintf("%03d", ($time - floor($time)) * 1000);
                        $ip = \common\components\UtilLib::getUserHostIp();
                        return "[$formatTime] [$uid] [$ip]";
                    },
                    'exportInterval' => 1,
                    'enableRotation' => false,
                    'except' => ['yii\web\HttpException:404'],
                ],


                [//默认业务日志, 通常用来定位问题，记录API调用等, Yii::info("api call", __CLASS__ . '::' . __FUNCTION__);
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['app\*', 'common\*'],
                    'logFile' => '/opt/logs/oa-api/app.log',
                    'logVars' => [],
                    'prefix' => function () {
                        $user = Yii::$app->has('user', true) ? Yii::$app->get('user') : null;
                        $uid = $user ? $user->getId(false) : '-';
                        $time = microtime(true);
                        $formatTime = date("Y-m-d H:i:s", $time) . "." . sprintf("%03d", ($time - floor($time)) * 1000);
                        $ip = \common\components\UtilLib::getUserHostIp();
                        return "[$formatTime] [$uid] [$ip]";
                    },
                    'exportInterval' => 1,
                    'enableRotation' => false,
                ],

            ],
        ],


        'oss' => [
            'class' => 'common\components\OSS',
            'accessKey' => 'tjLiYtJyZ8d7L4DKO9koNNt3iiPVbCKcbcK2u-Jn',
            'secretKey' => 'urTJwiTY6MYgnUoez1Zc2j5V8oiP4g_VGILnHOqk',
            'bucket' => 'old-xcx',
        ],
    ],
];
