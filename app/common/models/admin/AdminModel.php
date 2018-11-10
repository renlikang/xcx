<?php

namespace app\models\admin;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property int $aid 管理者ID
 * @property string $username 用户名
 * @property string $password 密码
 * @property int $type 1:正常账户 2：授权账户
 * @property int $status 1:启用 0:禁用
 * @property string $cTime 添加时间
 * @property string $uTime 更新时间
 * @property int $deleteFlag 删除标识:0正常，1删除
 */
class AdminModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_admin');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['type', 'status', 'deleteFlag'], 'integer'],
            [['cTime', 'uTime'], 'safe'],
            [['username'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aid' => 'Aid',
            'username' => 'Username',
            'password' => 'Password',
            'type' => 'Type',
            'status' => 'Status',
            'cTime' => 'C Time',
            'uTime' => 'U Time',
            'deleteFlag' => 'Delete Flag',
        ];
    }
}