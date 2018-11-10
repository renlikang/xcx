<?php
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');
defined('YII_ENV_DEV') or define('YII_ENV_DEV', false);

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=old_base',
            'username' => 'root',
            'password' => '3659900',
            'charset' => 'utf8',
            'driverName' => 'mysql',
        ],

        'db_admin' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=3307;dbname=woof_admin',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8mb4',
        ],

        'db_content' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=3307;dbname=woof_content',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8mb4',
        ],

        'redis' => [
            'class' => 'common\components\Redis',
            'hostname' => '127.0.0.1',
            'password' => '',
            'port' => '6379',
            'database' => 1,
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