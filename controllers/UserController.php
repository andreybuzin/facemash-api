<?php

namespace app\controllers;

use app\models\Photo;
use app\models\UserPhoto;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use Yii;
use yii\web\Response;
use yii\web\UploadedFile;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

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

    public function actionAddGirl()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = Yii::$app->request->post();

        $photo = new Photo();
        $photo->person = $post['person'];
        $photo->facemash_id = $post['facemash_id'];
        $photoFile = UploadedFile::getInstanceByName('photo');
        
        if ($photoFile != null) {
            $photo->link = $photo->upload($photoFile);
            if ($photo->save()) {
                if (!Yii::$app->user->isGuest) {
                    $userPhoto = new UserPhoto();
                    $userPhoto->user_id = Yii::$app->user->id;
                    $userPhoto->photo_id = $photo->id;
                    $userPhoto->save();
                }
                return true;
            }
        }

        return false;
    }
}
