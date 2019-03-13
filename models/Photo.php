<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\Url;
use app\models\Versus;

/**
 * This is the model class for table "{{%photo}}".
 *
 * @property integer $id
 * @property string $link
 * @property string $person
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%photo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link', 'person'], 'required'],
            [['link', 'person'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Link',
            'person' => 'Person',
        ];
    }

    public function upload($file)
    {
        $name = md5(date('d.m.Y h:i:s')) . '.' . $file->extension;
        $path = Yii::getAlias("@webroot/uploads/photos/{$name}");
        if ($file->saveAs($path)) {
            return $name;
        }
        return null;
    }


    public static function getPair($facemashId = null)
    {
        return self::find()
            ->select([
                'id1' => 'ph1.id',
                'link1' => 'ph1.link',
                'person1' => 'ph1.person',
                'id2' => 'ph2.id',
                'link2' => 'ph2.link',
                'person2' => 'ph2.person',
            ])
            ->from('{{%photo}} ph1')
            ->innerJoin('{{%photo}} ph2', 'ph1.id < ph2.id')
            ->leftJoin(
                '{{%versus}} vs',
                'CONCAT(ph1.id, "," ,ph2.id) = CONCAT(photo1_id, ",", photo2_id)'
            )
            ->where([
                'vs.photo1_id' => null,
                'vs.photo2_id' => null,
                'ph1.facemash_id' => $facemashId,
                'ph2.facemash_id' => $facemashId
            ])
            ->orderBy(new Expression('rand()'))
            ->limit(1)
            ->asArray()
            ->one();
    }

    public static function checkLastVotes($photoId1, $photoId2)
    {
        $userId = null;
        if (!\Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
        }

        $versus = Versus::find()->where([
            'user_id' => $userId,
            'photo1_id' => $photoId1,
            'photo2_id' => $photoId2
        ])->one();

        if ($versus != null) {
            return true;
        }

        return false;
    }

    public static function deletePhotos($facemashId)
    {
        $dir = Url::to("@webroot/uploads/photos");
        $photos = Photo::find()->where(['facemash_id' => $facemashId])->all();
        foreach ($photos as $photo) {
            $file = $dir . '/' . $photo->link;
            if (is_file($file)) {
                unlink($file);
            }
        }
        $countVersusRows = Versus::deleteAll(['facemash_id' => $facemashId]);
        $countPhotosRows = Photo::deleteAll(['facemash_id' => $facemashId]);

        return $countVersusRows+$countPhotosRows;
    }
}
