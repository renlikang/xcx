<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $uid
 * @property string $appKey appKey
 * @property int $appType  1 2
 * @property string $nickName
 * @property string $imgUrl
 * @property string $openId openId
 * @property string $unionid unionid
 * @property string $cTime
 * @property string $uTime
 * @property int $deleteFlag :01
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['appType', 'deleteFlag'], 'integer'],
            [['cTime', 'uTime'], 'safe'],
            [['appKey'], 'string', 'max' => 64],
            [['nickName'], 'string', 'max' => 255],
            [['imgUrl'], 'string', 'max' => 1000],
            [['openId', 'unionid'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'appKey' => 'App Key',
            'nickName' => 'Nick Name',
            'imgUrl' => 'Img Url',
            'cTime' => 'C Time',
            'uTime' => 'U Time',
            'deleteFlag' => 'Delete Flag',
        ];
    }

    public static function findIdentity($uid)
    {
        return static::findOne(['uid' => $uid, 'deleteFlag' => 0]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
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