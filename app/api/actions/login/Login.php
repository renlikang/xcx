<?php
/**
 * @author rlk
 */

namespace api\actions\login;

use api\actions\BaseAction;
use common\components\WXBizDataCrypt;
use common\models\UserModel;
use Yii;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
/**
 * @SWG\Post(
 *     path="/login/wx",
 *     tags={"基础功能"},
 *     summary="用户登录",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *     @SWG\Parameter(in = "header",name = "Authorization",description = "用户Token",required = false, type = "integer"),
 *     @SWG\Parameter(in = "formData",name = "nickName",description = "用户昵称", type = "string"),
 *     @SWG\Parameter(in = "formData",name = "avatarUrl",description = "用户头像图片的 URL", type = "string"),
 *     @SWG\Parameter(in = "formData",name = "gender",description = "性别（0 未知 1 男性 2 女性）", type = "integer"),
 *     @SWG\Parameter(in = "formData",name = "country",description = "用户所在国家", type = "string"),
 *     @SWG\Parameter(in = "formData",name = "province",description = "用户所在省份", type = "string"),
 *     @SWG\Parameter(in = "formData",name = "city",description = "用户所在城市", type = "string"),
 *     @SWG\Parameter(in = "formData",name = "language",description = "语言（en 英文 zh_CN 简体中文 zh_TW 繁体中文）", type = "string"),
 *     @SWG\Parameter(in = "formData",name = "birthday",description = "生日", type = "string"),
 *     @SWG\Parameter(in = "formData",name = "signature",description = "用户签名", type = "string"),
 *     @SWG\Parameter(in = "formData",name = "code",description = "微信小程序登陆code", required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "encryptedData",description = "包括敏感数据在内的完整用户信息的加密数据", required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "iv",description = "加密算法的初始向量", required = true, type = "string"),
 *     @SWG\Response(response = 200,description = " success"),
 *     @SWG\Response(response = 400,description = " bad request"),
 *     @SWG\Response(response = 500,description = " server error"),
 * )
 */
class Login extends BaseAction
{
    public function run()
    {
        $code = Yii::$app->request->post('code');
        $encryptedData = Yii::$app->request->post('encryptedData');
        $iv = Yii::$app->request->post('iv');

        if (empty($code) || !$encryptedData || !$iv) {
            throw new BadRequestHttpException("参数错误");
        }

        $session = self::code2Session($code);
        $openid = $session['openid'];
        @$unionid = $session['unionid'];
        $session_key = $session['session_key'];
        $appid = Yii::$app->params['appid'];
        $crypt = new WXBizDataCrypt($appid, $session_key);
        $result = $crypt->decryptData($encryptedData, $iv, $data);
        if ($result != 200 && $result != 0 ) {
            Yii::error($result, __CLASS__.'::'.__FUNCTION__);
            throw new BadRequestHttpException("解密失败");
        }
        if ($user = UserModel::findOne(["openid" => $openid])) {
            $isNewUser = ($user->nickName and $user->unionid) ? false : true;
            if ($user->unionid == null) {
                $user->unionid = $unionid;
            }
            $user->session_key = $session_key;
            $user->save();

            if ($user->errors) {
                Yii::error("用户更新失败" . json_encode($user->errors), __CLASS__.'::'.__FUNCTION__);
                throw new BadRequestHttpException("用户更新失败");
            }
        } else {
            $isNewUser = true;
            $user = new UserModel;
            $user->openid = $openid;
            $user->unionid = $unionid;
            $user->session_key = $session_key;
            $user->save();

            if ($user->errors) {
                Yii::error("用户创建失败" . json_encode($user->errors), __CLASS__.'::'.__FUNCTION__);
                throw new BadRequestHttpException("用户创建失败");
            }
        }

        $token = Yii::$app->security->generateRandomString();
        $userInfo = [
            'id' => $user->id,
            'token' => $token,
            'is_new' => $isNewUser,
            'expire' => time() + 7*24*60*60
        ];

        foreach ($userInfo as $key => $value) {
            Yii::$app->sessionCache->hset($token, $key, $value);
        }
        Yii::$app->sessionCache->expire($token, 7*24*60*60);

        return $userInfo;
    }

    public static function code2Session($code)
    {
        $appid = Yii::$app->params['appid'];
        $appsecret = Yii::$app->params['appsecret'];
        $client = new \GuzzleHttp\Client();
        $res = $client->request("GET", "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$appsecret}&js_code={$code}&grant_type=authorization_code");
        $content = Json::decode($res->getBody()->getContents(), true);
        if (isset($content["errcode"])) {
            Yii::error("微信 API 返回错误:" . json_encode($content), __CLASS__.'::'.__FUNCTION__);
            throw new \Exception("微信 API 返回错误:" . json_encode($content));
        } else {
            return $content;
        }
    }
}