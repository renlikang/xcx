<?php

namespace common\models\content;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property string $md5TagName 标签名称（md5）
 * @property string $tagName 标签名称
 */
class TagModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
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
            [['md5TagName'], 'required'],
            [['md5TagName'], 'string', 'max' => 32],
            [['tagName'], 'string', 'max' => 255],
            [['md5TagName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'md5TagName' => 'Md5 Tag Name',
            'tagName' => 'Tag Name',
        ];
    }
}