<?php
/**
 * @author rlk
 */

namespace backend\actions\login;

use api\actions\BaseAction;
use Yii;
use yii\base\Exception;

class Login extends BaseAction
{
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