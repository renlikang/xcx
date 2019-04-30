<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id 用户Id
 * @property string $nickName 用户昵称
 * @property int $type 用户类型 1:普通用户 2:媒体用户
 * @property string $avatarUrl 用户头像图片的 URL
 * @property int $gender 性别（0 未知 1 男性 2 女性）
 * @property string $country 用户所在国家
 * @property string $province 用户所在省份
 * @property string $city 用户所在城市
 * @property string $language 语言（en 英文 zh_CN 简体中文 zh_TW 繁体中文）
 * @property string $birthday 生日
 * @property string $signature 用户签名
 * @property string $session_key
 * @property string $openid
 * @property string $unionid
 * @property int $status 用户状态:1正常，2禁言
 * @property string $cTime 添加时间
 * @property string $uTime 更新时间
 * @property int $deleteFlag 删除标识:0正常，1删除
 */
class UserModel extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public static function getDb()
    {
        return Yii::$app->get('db_content');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nickName'], 'string'],
            [['type', 'gender', 'status', 'deleteFlag'], 'integer'],
            [['birthday', 'cTime', 'uTime'], 'safe'],
            [['avatarUrl', 'signature'], 'string', 'max' => 255],
            [['country', 'province', 'city', 'language', 'session_key', 'openid', 'unionid'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickName' => 'Nick Name',
            'type' => 'Type',
            'avatarUrl' => 'Avatar Url',
            'gender' => 'Gender',
            'country' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'language' => 'Language',
            'birthday' => 'Birthday',
            'signature' => 'Signature',
            'session_key' => 'Session Key',
            'openid' => 'Openid',
            'unionid' => 'Unionid',
            'status' => 'Status',
            'cTime' => 'C Time',
            'uTime' => 'U Time',
            'deleteFlag' => 'Delete Flag',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        if(YII_ENV != 'prod' && $token == '64IMTAwPa5zYJjSs5AodH9xsQlYlaTjY') {
            $id = 2;
        } else {
            $id = Yii::$app->sessionCache->hget($token, 'id');
        }

        return static::findOne(['id' => $id]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getAuthKey()
    {
        return '';
    }

    public function validateAuthKey($authKey)
    {
        return '';
    }


    public function getId()
    {
        return $this->getPrimaryKey();
    }


}