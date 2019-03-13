<?php

namespace app\models;

use Yii;
use Zelenin\Elo\Player;
use Zelenin\Elo\Match;

/**
 * This is the model class for table "{{%versus}}".
 *
 * @property integer $id
 * @property integer $photo1_id
 * @property integer $photo2_id
 * @property integer $user_id
 * @property integer $winner_id
 *
 * @property User $user
 */
class Versus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%versus}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['photo1_id', 'photo2_id', 'winner_id'], 'required'],
            [['photo1_id', 'photo2_id', 'user_id', 'winner_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo1_id' => 'Photo1 ID',
            'photo2_id' => 'Photo2 ID',
            'user_id' => 'User ID',
            'winner_id' => 'Winner ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public static function getCountLikes($playerId)
    {
        return self::find()->where(['winner_id' => $playerId])->count();
    }

    public function setElo($player1_id, $player2_id, $winner_id)
    {
        $photo1 = Photo::find()->where([
            'id' => $player1_id
        ])->one();
        $photo2 = Photo::find()->where([
            'id' => $player2_id
        ])->one();

        $player1 = new Player($photo1->rank);
        $player2 = new Player($photo2->rank);

        $match = new Match($player1, $player2);
        if ($player1_id === $winner_id) {
            $a = 1;
            $b = 0;
        } else {
            $a = 0;
            $b = 1;
        }
        $match->setScore($a, $b)
            ->setK(24)
            ->count();

        $photo1->rank = $match->getPlayer1()->getRating();
        $photo2->rank = $match->getPlayer2()->getRating();

        if ($photo1->save() && $photo2->save()) {
            return true;
        }

        return false;
    }
}
