<?php
/**
 * @author rlk
 */

namespace common\components;

use common\models\Books;
use common\models\BooksTags;
use common\models\BooksType;
use common\models\elasticsearch\WxForm;
use common\models\User;
use linslin\yii2\curl\Curl;
use yii\base\Component;
use yii\base\Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class Wx extends Component
{
    public $host;
    public $appId;
    public $secret;
    public $grant_type;
    public $templateId;

    const SEND_WX_FORM_ACCESS_TOKEN = "SEND.WX.FORM.ACCESS.TOKEN";

    public function getSessionKeyAndOpenId($code)
    {
        $curl = new Curl();
        $url = $this->host . '/sns/jscode2session?appid='.$this->appId.'&secret='.$this->secret.'&js_code='.$code.'&grant_type='.$this->grant_type;
        $curl->get($url);
        $data = $curl->response;
        if(!$data) {
            Yii::error(Json::encode($data), __CLASS__.'::'.__FUNCTION__);
            throw  new Exception('request fail', 100);
        }
        return Json::decode($data, true);
    }

    public function decryptData($iv, $sessionKey, $encryptedData)
    {
        $pc = new WXBizDataCrypt($this->appId, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );
        if ($errCode == 0) {
            return Json::decode($data, true);
        } else {
            Yii::error('解密失败：原因是：'.$errCode, __CLASS__.'::'.__FUNCTION__);
            throw new Exception('解密失败', $errCode);
        }
    }

    public function getMessageAccessToken()
    {
        if(Yii::$app->redis->get(self::SEND_WX_FORM_ACCESS_TOKEN)) {
            return Yii::$app->redis->get(self::SEND_WX_FORM_ACCESS_TOKEN);
        }

        $curl = new Curl();
        $url = $this->host . '/cgi-bin/token?grant_type=client_credential' . '&appid=' . $this->appId . '&secret=' . $this->secret;
        $curl->get($url);
        $data = $curl->response;
        if(!$data) {
            Yii::error(Json::encode($data), __CLASS__.'::'.__FUNCTION__);
            throw  new Exception('request fail', 100);
        }
        $data = Json::decode($data, true);
        Yii::$app->redis->set(self::SEND_WX_FORM_ACCESS_TOKEN, $data['access_token']);
        Yii::$app->redis->expire(self::SEND_WX_FORM_ACCESS_TOKEN, $data['expires_in'] - 100);
        return $data['access_token'];
    }

}