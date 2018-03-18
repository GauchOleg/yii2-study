<?php

namespace common\modules\blog\controllers;

use common\models\ImageManager;
use Yii;
use common\modules\blog\models\Blog;
use common\modules\blog\models\BlogSearch;
use yii\base\DynamicModel;
use yii\base\Response;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-image' => ['POST'],
                    'sort-image' => ['POST'],
                    'save-img' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Blog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::find()->with('tags')->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDeleteImg() {
        if (($model = ImageManager::findOne(Yii::$app->request->post('key'))) and $model->delete()) {
            return true;
        } else {
            throw new NotFoundHttpException('The request page does not exist');
        }
    }

    public function actionSortImage($id) {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('sort');
            if ($post['oldIndex'] > $post['newIndex']) {
                $param = ['and', ['>=', 'sort', $post['newIndex']],['<','sort',$post['oldIndex']]];
                $counter = 1;
            } else {
                $param = ['and', ['<=', 'sort', $post['newIndex']],['>','sort',$post['oldIndex']]];
                $counter = -1;
            }
            ImageManager::updateAllCounters(['sort' => $counter], [
                'and', ['class' => 'blog', 'item_id' => $id],$param
            ]);
            ImageManager::updateAll(['sort' => $post['newIndex']],[
                'id' => $post['stack'][$post['newIndex']]['key']
            ]);
            return true;
        }
        throw new MethodNotAllowedHttpException();
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            ImageManager::updateAllCounters(
                ['sort' => -1],[
                'and',
                    ['class' => 'blog', 'item_id' => $this->item_id], ['>', 'sort', $this->sort]
            ]);
            return true;
        } else {
            return false;
        }
    }

    public function actionSaveImg() {
        $this->enableCsrfValidation = false;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $dir = Yii::getAlias('@images') . '/' . $post['ImageManager']['class'] . '/';
            $start = strpos($dir,'uploads');
            $dir = substr($dir,$start);

            if (!file_exists($dir)) {
                FileHelper::createDirectory($dir);
            }

            $result_link = Url::home(true) . $dir;
            $file = UploadedFile::getInstanceByName('ImageManager[attachment]');

            $model = new ImageManager();
            $model->name = strtotime('now') . '_' . Yii::$app->security->generateRandomString(6) . '.' . $file->extension;
            $model->alt = strtotime('now') . '_' . Yii::$app->security->generateRandomString(6) . '.' . $file->extension;
            $model->load($post);
            if ($model->validate()) {
                $model->save();
            }

            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError('file'),
                ];
            } else {
                if ($file->saveAs($dir . $model->name)) {
                    /* resize image */
                    $imagic = Yii::$app->image->load($dir . $model->name);
                    $imagic->resize(800, NULL, Yii\image\drivers\Image::PRECISE)->save($dir. $model->name, 85);
                    /* resize image end */
                    $result = [
                        'filelink' => $result_link . $model->name,
                        'filename' => $model->name,
                    ];
                } else {
                    $result = [
                        'error' => 'Ошибка'
                    ];
                }
            }
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $result;
        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }
    }

    public function actionSaveRedactorImg($sub = 'main') {
        $this->enableCsrfValidation = false;
        if (Yii::$app->request->isPost) {
            $dir = Yii::getAlias('@images') . '/' . $sub . '/';
            $start = strpos($dir,'uploads');
            $dir = substr($dir,$start);

            if (!file_exists($dir)) {
                FileHelper::createDirectory($dir);
            }

            $result_link = Url::home(true) . $dir;
            $file = UploadedFile::getInstanceByName('file');
            $model = new DynamicModel(compact('file'));
//            $model->addRule('file','image')->validate();

            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError('file'),
                ];
            } else {
                $model->file->name = strtotime('now') . '_' . Yii::$app->security->generateRandomString(6) . '.' . $model->file->extension;
                if ($model->file->saveAs($dir . $model->file->name)) {
                    /* resize image */
                    $imagic = Yii::$app->image->load($dir . $model->file->name);
                    $imagic->resize(800, NULL, Yii\image\drivers\Image::PRECISE)->save($dir. $model->file->name, 85);
                    /* resize image end */
                    $result = [
                        'filelink' => $result_link . $model->file->name,
                        'filename' => $model->file->name,
                    ];
                } else {
                    $result = [
                        'error' => Yii::t('vova07/imperavi', 'ERROR_CAN_NOT_UPLOAD_FILE')
                    ];
                }
            }
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $result;
        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }
    }
}
