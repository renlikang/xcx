<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
define('YII_ENV_DEV', true);

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=mysql;dbname=old_base',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'driverName' => 'mysql',
        ],

        'redis' => [
            'class' => 'common\components\Redis',
            'hostname' => '127.0.0.1',
            'password' => '',
            'port' => '6379',
            'database' => 1,
            'socketClientFlags' => STREAM_CLIENT_CONNECT
        ],
        'login_redis' => [
            'class' => 'common\components\Redis',
            'hostname' => '127.0.0.1',
            'port' => '6379',
            'database' => 2,
            'socketClientFlags' => STREAM_CLIENT_CONNECT
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];