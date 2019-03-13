<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user_photo}}".
 *
 * @property integer $photo_id
 * @property integer $user_id
 */
class UserPhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_photo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['photo_id', 'user_id'], 'required'],
            [['photo_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'photo_id' => 'Photo ID',
            'user_id' => 'User ID',
        ];
    }
}
