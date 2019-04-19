<?php
/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2018/12/10
 * Time: 11:29 AM
 */

namespace backend\actions\login;


use backend\actions\BaseAction;
use common\models\admin\AdminModel;
use common\services\RetCode;
use Yii;
use yii\base\Exception;

class Test extends BaseAction
{
    public function run()
    {
        if(Yii::$app->user->isGuest == false) {
            Yii::$app->user->logout();
        }

        $username = Yii::$app->request->get('username');
        $password = Yii::$app->request->get('password');
        $user = AdminModel::findByUsername($username);
        if(!$user) {
            return [
                'code' => 100,
                'message' => '用户名不存在',
            ];
        }

        if($user->validatePassword($password)) {
            Yii::$app->user->login($user);
            Yii::info("login ", __CLASS__ . '::' . __FUNCTION__);
            $data = [
                'aid' => $user->aid,
                'username' => $user->username,
            ];
            return RetCode::response(RetCode::SUCCESS, $data);
        }

        return [
            'code' => 101,
            'message' => '用户名或者密码错误',
        ];
    }
}