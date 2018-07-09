<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "attachment".
 *
 * @property int $attachment_id
 * @property int $uid
 * @property string $attachment_url url
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'attachment_url'], 'required'],
            [['uid'], 'integer'],
            [['attachment_url'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'attachment_id' => 'Attachment ID',
            'uid' => 'Uid',
            'attachment_url' => 'Attachment Url',
        ];
    }
}
