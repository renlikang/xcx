<?php
/**
 * @author rlk
 */

namespace backend\actions\login;

use api\actions\BaseAction;
use common\models\admin\AdminModel;
use common\services\RetCode;
use Yii;
use yii\base\Exception;

class Login extends BaseAction
{
    /**
     * @SWG\Post(
     *     path="/login/index",
     *     tags={"基础功能"},
     *     summary="登录接口",
     *     description="",
     *     produces={"application/json"},
     *     @SWG\Parameter(in = "formData",name = "username",description = "登录名",required = true,default="admin", type = "string"),
     *     @SWG\Parameter(in = "formData",name = "password",description = "密码",required = true, default="9b256e2f", type = "string"),
     *     @SWG\Response(response = 200,description = " success"),
     *     @SWG\Response(response = 100,description = " 用户名不存在"),
     *     @SWG\Response(response = 101,description = " 用户名或者密码错误"),
     * )
     *
     */
    public function run()
    {
        if(Yii::$app->user->isGuest == false) {
            Yii::$app->user->logout();
        }

        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');
        $user = AdminModel::findByUsername($username);
        if(!$user) {
            return [
                'code' => 100,
                'message' => '用户名不存在',
            ];
        }

        if($user->validatePassword($password)) {
            Yii::$app->user->login($user);
            var_dump(Yii::$app->user->getIsGuest());exit;
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
