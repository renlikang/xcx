<?php
/**
 * @author rlk
 */

namespace api\actions\login;

use api\actions\BaseAction;
use Yii;
use yii\base\Exception;

class Login extends BaseAction
{
    /**
     * @SWG\Post(
     *     path="/login/wx-applets",
     *     tags={"微信小程序"},
     *     summary="微信小程序登录接口",
     *     description="",
     *     produces={"application/json"},
     *     @SWG\Parameter(in = "formData",name = "appKey",description = "应用标识(我们可以自定义名称)",required = true,type = "string"),
     *     @SWG\Parameter(in = "formData",name = "appType",description = "应用类型(1：小程序 2：公众号)",required = true,type = "string"),
     *     @SWG\Parameter(in = "formData",name = "code",description = "小程序login后获取的code",required = true,type = "string"),
     *     @SWG\Parameter(in = "formData",name = "encryptedData",description = "加密体",required = true,type = "string"),
     *     @SWG\Parameter(in = "formData",name = "iv",description = "偏移量",required = true,type = "string"),
     *     @SWG\Response(response = 200,description = " success"),
     *     @SWG\Response(response = 101,description = " 登录失败"),
     * )
     *
     */
    public function run()
    {
        try {
            $code = Yii::$app->request->post('code');
            $iv = Yii::$app->request->post('iv');
            $encryptedData = Yii::$app->request->post('encryptedData');
            $appKey = Yii::$app->request->post('appKey');
            $appType = Yii::$app->request->post('appType');
            $data = Yii::$app->wx->getSessionKeyAndOpenId($code);
            $sessionKey = $data["session_key"];
            $data = Yii::$app->wx->decryptData($iv, $sessionKey, $encryptedData);
            $unionId = $data['unionid']??'';
            $data = (new \api\service\Login)->login($appKey, $appType, $data['openId'], $data['avatarUrl'], $data['nickName'], $sessionKey, $unionId);
            return ['code' => 200, 'message' => "success", 'data' => ['user' => $data['user']]];
        } catch (Exception $e) {
            return ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }
    }
}