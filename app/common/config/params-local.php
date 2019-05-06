<?php
if (YII_ENV == 'dev') {
    return [
        'appid' => 'wx2f06e42b7389715b',
        'appsecret' => '73dca7f64e79785c3081ae4b4d520241'
    ];
} elseif (YII_ENV == 'test') {
    return [
        'appid' => 'wx2f06e42b7389715b',
        'appsecret' => '73dca7f64e79785c3081ae4b4d520241'
    ];
} elseif (YII_ENV == 'prod') {
    return [
        'appid' => 'wx05b3618541f14ba1',
        'appsecret' => 'cfee799bb956a6f68290146e0207324c'
    ];
}