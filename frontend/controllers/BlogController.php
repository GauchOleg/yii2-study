<?php
/**
 * Created by PhpStorm.
 * User: developer-pc
 * Date: 04.03.2018
 * Time: 13:05
 */

namespace frontend\controllers;


use common\models\Blog;
use yii\base\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class BlogController extends Controller {

    public function actionIndex() {
        $blogs = Blog::find()->with('author')->where(['status_id' => 1])->orderBy('sort');

        $dataProvider = new ActiveDataProvider([
            'query' => $blogs,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        return $this->render('all',compact('dataProvider'));
    }

    public function actionOne($url) {

        if ($blog = Blog::find()->where(['url' => $url])->one()) {
            return $this->render('one',compact('blog'));
        } else {
            throw new NotFoundHttpException();
        }

    }
}