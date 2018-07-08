<?php
/**
 * @author rlk
 */

namespace api\service;

use common\components\Helper;
use common\components\rbac\Rule;
use common\models\User;
use common\models\UserLogin;
use function foo\func;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;

class Login
{
    const WX = 1;
    const WX_APPLETS = 2;
    private $letter = [
        'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
        'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
    ];


    public function wxApplets($openId, $averImage, $name, $sessionKey, $expire = 3600 * 24 * 365)
    {
        $user = UserLogin::findOne(['login_name' => $openId, 'login_type' => self::WX_APPLETS]);
        if(!$user) {
            $user = $this->registeredByAuth($openId, self::WX_APPLETS, ['nick_name' => $name, 'avatar_img' => $averImage]);
        } else {
            $user = User::findOne($user->uid);
        }

        if($user->deleteFlag == 1) {
            throw new Exception('该账号已被封，如有需要请联系客服', 102);
        }
        $token = $this->setTokenByApplets($openId, $sessionKey, $user, $expire);
        return ['token' => $token, 'user' => $user, 'time' => $expire];
    }

    public function setTokenByApplets($loginKey, $sessionKey, User $user, $expire = 30 * 24 * 3600)
    {
        $token = md5($loginKey. time()). md5($sessionKey . rand(99,9999));
        $user = $user->toArray();
        $user['login_time'] = time();
        $user['login_type'] = self::WX_APPLETS;
        $user['session_key'] = $sessionKey;
        $redis = Yii::$app->login_redis;
        $redis->set($token, $user);
        if(YII_ENV != 'prod') {
            $expire = 3600;
        }
        $redis->expire($token, $expire);
        return $token;
    }


    /**
     * 设置登录key
     * @param $key
     * @param $type
     * @param $params
     * @return User
     */
    public function registeredByAuth($key, $type, $params)
    {
        $user = new User;
        foreach ($params as $k => $v) {
            $user->$k = $params[$k];
        }

        $oldName = $params['nick_name'];
        $params['nick_name'] = base64_encode(Helper::setChar($params['nick_name']));
        if(User::find()->where(['nick_name' => $params['nick_name']])->exists())
        {
            $nickName = function ($name) {
                while ($ret = true) {
                    $randName = $this->getLettrtRand(4);
                    $ret = User::find()->where(['nick_name' => User::encrypt($name . $randName)])->exists();
                    if (!$ret) {
                        return $name . $randName;
                    }
                }
            };

            $user->nick_name = $nickName($oldName);
        }

        $user->status = User::NORMAL;
        if($user->save()) {
            $model = new UserLogin;
            $model->login_name = $key;
            $model->login_type = $type;
            $model->uid = $user->uid;
            $model->save();
        } else {
            Yii::error(Json::encode($user->errors), __CLASS__.'::'.__FUNCTION__);
        }

        return User::findOne($user->uid);
    }

    /**
     * 注册用户
     * @param $tel
     * @return User
     * @throws Exception
     */
    public function registered($tel)
    {
        $model = new User;
        $nick_name = function($tel){
            while ($ret = true) {
                $nick_name = $this->getLettrtRand() . substr($tel,-4);
                $ret = User::find()->where(['nick_name' => User::encrypt($nick_name)])->exists();
                if(!$ret) {
                    return $nick_name;
                }
            }
        };

        $model->nick_name = $nick_name($tel);
        $model->tel = $tel;
        $model->status = User::NORMAL;
        if(!$model->save()) {
            throw new Exception('注册失败，请重新使用手机号登录', 102);
        }

        return User::findOne($model->uid);
    }

    /**
     * 获取随机字母
     * @param int $length
     * @return string
     */
    public function getLettrtRand($length = 6)
    {
        $ret = '';
        for($i=0; $i<$length; $i++) {
            $rand = rand(0,51);
            $ret .= $this->letter[$rand];
        }

        return $ret;
    }

    /**
     * 登出
     * @param $token
     */
    public static function loginOut($token)
    {
        Yii::$app->login_redis->del($token);
        Yii::$app->user->logout();
    }
}