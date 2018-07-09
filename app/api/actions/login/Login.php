<?php
/**
 * @author rlk
 */

namespace api\actions\login;

use api\actions\BaseAction;
use Yii;

class Login extends BaseAction
{
    /**
     * @SWG\Post(
     *     path="/login/wx-applets",
     *     tags={"微信小程序"},
     *     summary="微信小程序登录接口",
     *     description="",
     *     produces={"application/json"},
     *     @SWG\Parameter(in = "formData",name = "code",description = "code",required = true,type = "string"),
     *     @SWG\Parameter(in = "formData",name = "encryptedData",description = "加密体",required = true,type = "string"),
     *     @SWG\Parameter(in = "formData",name = "iv",description = "偏移量",required = true,type = "string"),
     *     @SWG\Response(response = 200,description = " success"),
     *     @SWG\Response(response = 100,description = " 用户名不存在"),
     *     @SWG\Response(response = 101,description = " 用户名或者密码错误"),
     * )
     *
     */
    public function run()
    {
        try {
            $code = Yii::$app->request->post('code');
            $iv = Yii::$app->request->post('iv');
            $encryptedData = Yii::$app->request->post('encryptedData');
            $data = Yii::$app->wx->getSessionKeyAndOpenId($code);
            $sessionKey = $data["session_key"];
            $data = Yii::$app->wx->decryptData($iv, $sessionKey, $encryptedData);
            if(!strstr($data['avatarUrl'], 'oss-cn-shanghai') && $data['avatarUrl']) {
                $data['avatarUrl'] = Yii::$app->oss->updateUrlImage($data['avatarUrl']);
            }
            $data = (new Login())->wxApplets($data['openId'], $data['avatarUrl'], $data['nickName'], $sessionKey);
            return ['code' => 200, 'message' => "success", 'data' => ['token' => $data['token'], 'user' => $data['user'], 'expire' => intval(intval($data['time'])/2) + time()]];
        } catch (Exception $e) {
            return ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }
    }
}