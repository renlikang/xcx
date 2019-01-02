<?php
if (YII_ENV == 'dev') {
    return [
        'appid' => 'wx78717a7a86f51ae9',
        'appsecret' => '63c6828e7d37a3b5288414c4cf92d5e2'
    ];
} elseif (YII_ENV == 'test') {
    return [
        'appid' => 'wx78717a7a86f51ae9',
        'appsecret' => '63c6828e7d37a3b5288414c4cf92d5e2'
    ];
} elseif (YII_ENV == 'prod') {
    return [
        'appid' => 'wx05b3618541f14ba1',
        'appsecret' => 'cfee799bb956a6f68290146e0207324c'
    ];
}