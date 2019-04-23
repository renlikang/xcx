<?php

namespace common\models\content;

use Yii;

/**
 * This is the model class for table "article_praise".
 *
 * @property int $praiseId 点赞ID
 * @property int $articleId 内容ID
 * @property int $uid 用户ID
 * @property string $cTime 添加时间
 * @property string $uTime 更新时间
 * @property int $deleteFlag 删除标识:0正常，1删除
 */
class ArticlePraiseModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_praise';
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
            [['articleId'], 'required'],
            [['articleId', 'uid', 'deleteFlag'], 'integer'],
            [['cTime', 'uTime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'praiseId' => 'Praise ID',
            'articleId' => 'Article ID',
            'uid' => 'Uid',
            'cTime' => 'C Time',
            'uTime' => 'U Time',
            'deleteFlag' => 'Delete Flag',
        ];
    }
}