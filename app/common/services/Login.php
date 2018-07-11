<?php
/**
 * @author rlk
 */

namespace api\service;

use common\components\Helper;
use common\components\rbac\Rule;
use common\models\User;
use common\models\UserLogin;
use common\models\UserModel;
use function foo\func;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;

class Login
{
    public function login($appKey, $appType, $openId, $averImage, $name, $sessionKey, $unionId, $expire = 3600 * 24)
    {
        $model = UserModel::findOne(['appKey' => $appKey, 'appType' => $appType, 'openId' => $openId]);
        if(!$model) {
            $model = $this->registered($appKey, $appType, $openId, $averImage, $name, $sessionKey, $unionId);
        }

        if(Yii::$app->user->login($model)) {
            return ['user' => $model];
        }

        throw new Exception('登录失败', 101);

    }

    public function registered($appKey, $appType, $openId, $averImage, $name, $sessionKey, $unionId)
    {
        $model = new UserModel;
        $model->appKey = $appKey;
        $model->appType = $appType;
        $model->openId = $openId;
        $model->nickName = $name;
        $model->unionid = $unionId;
        if(!$model->save()) {
            Yii::error($model->errors, __CLASS__.'::'.__FUNCTION__);
            throw new Exception('登录失败', 101);
        }

        $file = Yii::$app->oss->uploadUrlImage($averImage);
        $imgUrl = Yii::$app->params['staticUrl'].'/'.$file['key'];
        $model = UserModel::findOne($model->uid);
        $model->imgUrl = $imgUrl;
        if(!$model->save()) {
            Yii::error($model->errors, __CLASS__.'::'.__FUNCTION__);
        }

        return UserModel::findOne($model->uid);
    }


    /**
     * 登出
     * @param $token
     */
    public static function loginOut($token)
    {
        Yii::$app->user->logout();
    }
}