<?php

namespace app\controllers;

use app\models\Facemash;
use app\models\Photo;
use app\models\Versus;
use yii\rest\ActiveController;
use Yii;

class VersusController extends ActiveController
{
    public $modelClass = 'app\models\Versus';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];
        return $behaviors;
    }

    public function actionSetNewLike()
    {
        $post = \Yii::$app->request->post();
        $winnerIsChoosed = Photo::checkLastVotes($post['photo1_id'], $post['photo2_id']);
        if ($winnerIsChoosed) {
            return 1;
        }

        $versus = new Versus();

        // меньший идентификатор всегда первый
        if ($post['photo1_id'] < $post['photo2_id']) {
            $versus->photo1_id = $post['photo1_id'];
            $versus->photo2_id = $post['photo2_id'];
        } else {
            $versus->photo1_id = $post['photo2_id'];
            $versus->photo2_id = $post['photo1_id'];
        }

        $versus->winner_id = $post['winner_id'];
        $versus->facemash_id = $post['facemash_id'];
        if (Yii::$app->user->isGuest) {
            $versus->user_id = \Yii::$app->user->id;
        }
        $versus->save();
        $versus->setElo($versus->photo1_id, $versus->photo2_id, $versus->winner_id);
        
        return $versus::getCountLikes($versus->winner_id);
    }

    public function actionClearVotes()
    {
        Photo::updateAll(
            ['rank' => 0],
            ['facemash_id' => \Yii::$app->request->post('facemash_id')]
        );
        
        return Versus::deleteAll([
            'user_id' => \Yii::$app->user->getId(),
            'facemash_id' => \Yii::$app->request->post('facemash_id')
        ]);
    }
}
