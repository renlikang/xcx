<?php

namespace common\models\content;

use Yii;

/**
 * This is the model class for table "user_read_record".
 *
 * @property int $uid 用户ID
 * @property int $articleId 文章ID
 * @property int $status 阅读状态 1：浏览 2：阅读
 * @property int $nums 浏览次数
 * @property string $cTime 添加时间
 * @property string $uTime 更新时间
 * @property int $deleteFlag 删除标识:0正常，1删除
 */
class UserReadRecordModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_read_record';
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
            [['uid', 'articleId'], 'required'],
            [['uid', 'articleId', 'status', 'nums', 'deleteFlag'], 'integer'],
            [['cTime', 'uTime'], 'safe'],
            [['uid', 'articleId'], 'unique', 'targetAttribute' => ['uid', 'articleId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'articleId' => 'Article ID',
            'status' => 'Status',
            'nums' => 'Nums',
            'cTime' => 'C Time',
            'uTime' => 'U Time',
            'deleteFlag' => 'Delete Flag',
        ];
    }
}