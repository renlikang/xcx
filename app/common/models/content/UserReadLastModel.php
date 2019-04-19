<?php

namespace common\models\content;

use Yii;

/**
 * This is the model class for table "user_read_last".
 *
 * @property int $uid 用户ID
 * @property string $preArticleType 上次文章类型
 * @property string $articleType 现在的文章类型
 * @property string $cTime 添加时间
 * @property string $uTime 更新时间
 * @property int $deleteFlag 删除标识:0正常，1删除
 */
class UserReadLastModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_read_last';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
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
            [['uid', 'preArticleType', 'articleType'], 'required'],
            [['uid', 'deleteFlag'], 'integer'],
            [['cTime', 'uTime'], 'safe'],
            [['preArticleType', 'articleType'], 'string', 'max' => 255],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'preArticleType' => 'Pre Article Type',
            'articleType' => 'Article Type',
            'cTime' => 'C Time',
            'uTime' => 'U Time',
            'deleteFlag' => 'Delete Flag',
        ];
    }
}