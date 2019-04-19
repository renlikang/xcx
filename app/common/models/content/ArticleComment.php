<?php

namespace common\models\content;

use Yii;

/**
 * This is the model class for table "article_comment".
 *
 * @property int $commentId 评论ID
 * @property int $articleId 内容ID
 * @property int $parentId 父ID
 * @property int $uid 用户ID
 * @property string $content 评论内容
 * @property string $cTime 添加时间
 * @property string $uTime 更新时间
 * @property int $deleteFlag 删除标识:0正常，1删除
 */
class ArticleComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_comment';
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
            [['articleId', 'parentId', 'uid', 'deleteFlag'], 'integer'],
            [['content'], 'string'],
            [['cTime', 'uTime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'commentId' => 'Comment ID',
            'articleId' => 'Article ID',
            'parentId' => 'Parent ID',
            'uid' => 'Uid',
            'content' => 'Content',
            'cTime' => 'C Time',
            'uTime' => 'U Time',
            'deleteFlag' => 'Delete Flag',
        ];
    }
}