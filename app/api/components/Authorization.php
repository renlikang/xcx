<?php

namespace api\components;

use yii\base\Component;
use Yii;
use yii\web\ForbiddenHttpException;

class Authorization extends Component
{
    public function init() {
        var_dump(2);
        if ($token = Yii::$app->request->headers['authorization']) {
            var_dump(1);exit;
            Yii::$app->user->loginByAccessToken($token);
        }
        exit;
    }
}