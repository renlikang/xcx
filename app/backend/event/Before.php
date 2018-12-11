<?php

namespace backend\event;

use yii\base\Component;
use yii\base\Event;
use Yii;
use yii\web\ForbiddenHttpException;

class Before extends Component
{
    public static function index(Event $event)
    {
        self::checkRoute();
        return true;
    }

    private static function checkRoute()
    {
        if(Yii::$app->getUser()->getIsGuest() && Yii::$app->controller->id != 'login') {
            throw new ForbiddenHttpException("必须登录用户才能访问");
        }

        return true;
    }
}