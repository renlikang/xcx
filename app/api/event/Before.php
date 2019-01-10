<?php
/**
 * @author rlk
 */

namespace api\event;

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

    public static function checkRoute()
    {
        $controllerId = Yii::$app->controller->id;
        $actionId = Yii::$app->controller->action->id;
        if (self::needLogin($controllerId, $actionId)) {
            var_dump(222222);exit;
            if (Yii::$app->getUser()->getIsGuest()) {
                throw new ForbiddenHttpException("必须登录用户才能访问");
            }
        }
    }

    public static function needLogin($controllerId, $actionId)
    {
        if(isset(Yii::$app->params['permissionRoute']['guest'][$controllerId])) {
            if (in_array('*', Yii::$app->params['permissionRoute']['guest'][$controllerId])) {
                return false;
            }
            elseif (in_array($actionId, Yii::$app->params['permissionRoute']['guest'][$controllerId])) {
                return false;
            }
        }

        return true;
    }
}