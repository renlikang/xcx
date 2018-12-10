<?php

namespace backend\event;

use yii\base\Component;
use yii\base\Event;
use Yii;
use yii\web\HttpException;

class Before extends Component
{
    public static function index(Event $event)
    {
        self::checkRoute();
        return true;
    }

    private static function checkRoute()
    {
        var_dump(Yii::$app->getUser()->getIsGuest() );exit;
        if(Yii::$app->getUser()->getIsGuest() && Yii::$app->controller->id != 'login') {
            throw new HttpException(403, null, 403);
        }

        return true;
    }
}