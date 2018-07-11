<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_record".
 *
 * @property int $recordId
 * @property int $uid
 * @property string $title
 * @property string $memo
 * @property string $address
 * @property string $imgUrl
 * @property string $cTime
 * @property int $deleteFlag :01
 */
class UserRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'deleteFlag'], 'integer'],
            [['memo', 'address'], 'string'],
            [['cTime'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['imgUrl'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'recordId' => 'Record ID',
            'uid' => 'Uid',
            'title' => 'Title',
            'memo' => 'Memo',
            'address' => 'Address',
            'imgUrl' => 'Img Url',
            'cTime' => 'C Time',
            'deleteFlag' => 'Delete Flag',
        ];
    }
}