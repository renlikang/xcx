<?php

namespace common\models\content;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $articleId 文章ID
 * @property int $authorId 作者ID
 * @property int $type 文章类型，1 PGC 2 爬虫 3 UGC
 * @property string $source 文章来源
 * @property string $title 标题
 * @property string $subTitle 副标题
 * @property string $summary 内容摘要
 * @property string $headImg 头图
 * @property string $endImg 尾图
 * @property array $content 内容
 * @property int $orderId 权重
 * @property int $status 状态 1:启用 0:禁用
 * @property string $cTime 添加时间
 * @property string $uTime 更新时间
 * @property int $deleteFlag 删除标识:0正常，1删除
 * @property int $isFeatured 编辑精选
 */
class ArticleModel extends \yii\db\ActiveRecord
{
    const PGC = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
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
            [['authorId'], 'required'],
            [['authorId', 'type', 'orderId', 'status', 'deleteFlag', 'isFeatured'], 'integer'],
            [['summary'], 'string'],
            [['content', 'cTime', 'uTime'], 'safe'],
            [['source'], 'string', 'max' => 32],
            [['title', 'subTitle'], 'string', 'max' => 255],
            [['headImg', 'headImg'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'articleId' => 'Article ID',
            'authorId' => 'Author ID',
            'type' => 'Type',
            'source' => 'Source',
            'title' => 'Title',
            'subTitle' => 'Sub Title',
            'summary' => 'Summary',
            'headImg' => 'Head Img',
            'endImg' => 'End Img',
            'content' => 'Content',
            'orderId' => 'Order ID',
            'status' => 'Status',
            'cTime' => 'C Time',
            'uTime' => 'U Time',
            'deleteFlag' => 'Delete Flag',
            'isFeatured' => 'Is Featured',
        ];
    }
}