<?php

namespace app\models\content;

use Yii;

/**
 * This is the model class for table "tag_map".
 *
 * @property string $md5TagName 标签名称
 * @property int $mapId 映射ID
 */
class TagMapModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag_map';
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
            [['md5TagName', 'mapId'], 'required'],
            [['mapId'], 'integer'],
            [['md5TagName'], 'string', 'max' => 32],
            [['md5TagName', 'mapId'], 'unique', 'targetAttribute' => ['md5TagName', 'mapId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'md5TagName' => 'Md5 Tag Name',
            'mapId' => 'Map ID',
        ];
    }
}