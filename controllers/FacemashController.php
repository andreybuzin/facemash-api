<?php

namespace app\controllers;

use app\models\Facemash;
use app\models\Photo;
use yii\rest\ActiveController;
use yii\base\Exception;
use Yii;

class FacemashController extends ActiveController
{
    public $modelClass = 'app\models\Facemash';

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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreateFacemash()
    {
        $post = Yii::$app->request->post();
        $facemash = new Facemash();
        $facemash->name = $post['facemash-name'];
        if ($facemash->save()) {
            return $facemash->id;
        }

        return null;
    }

    public function actionFacemash()
    {
        $id = Yii::$app->request->post('id');
        $photo = Photo::getPhotos($id);

        return $photo == null ? [
            'id1' => 0, 
            'link1' => '', 
            'person1' => '', 
            'id2' => 0, 
            'link2' => '', 
            'person2' => 
            ''] 
            : $photo;
    }

    public function actionGetFacemashes()
    {
        return Facemash::find()->orderBy(['id' => SORT_DESC])->all();
    }

    public function actionDeleteFacemash()
    {
        $facemashId = (int)Yii::$app->request->post('facemash_id');
        Photo::deletePhotos($facemashId);
        $facemash = Facemash::findOne($facemashId);
        if ($facemash) {
            return $facemash->delete();
        }

        return false;
    }

    public function actionEditFacemash()
    {
        $id = (int)Yii::$app->request->post('facemash_id');
        $name = \Yii::$app->request->post('name');
        $facemash = Facemash::findOne($id);
        if ($facemash) {
            $facemash->name=$name;
            return $facemash->save();
        }
        
        return false;
    }
}
