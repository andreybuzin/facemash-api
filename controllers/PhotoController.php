<?php

namespace app\controllers;

use app\models\Photo;
use app\models\Versus;
use yii\db\Expression;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use Yii;

class PhotoController extends ActiveController
{
    public $modelClass = 'app\models\Photo';
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

    public function actionGetPhotos()
    {
        $facemashId = (int)\Yii::$app->request->post('facemash_id');
        $photo = Photo::getPair($facemashId);

        return $photo == null ? [
                'id1' => 0,
                'link1' => '',
                'person1' => '',
                'id2' => 0,
                'link2' => '',
                'person2' => ''
            ] :
            $photo;
    }

    public function actionGetRating()
    {
        return Photo::find()
        ->where([
            'facemash_id' => (int)Yii::$app->request->post('facemash_id')
        ])->orderBy([
            'rank' => SORT_DESC
        ])->all();
    }

    public function actionClearPersons()
    {
        $facemashId = (int)Yii::$app->request->post('facemash_id');
        $countRows = Photo::deletePhotos($facemashId);
        
        return $countRows;
    }

}
