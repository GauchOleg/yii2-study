<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
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
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionRole() {

//        $admin = Yii::$app->authManager->createRole('admin');
//        $admin->description = 'Администратор';
//        Yii::$app->authManager->add($admin);
//
//        $user = Yii::$app->authManager->createRole('user');
//        $user->description = 'Пользователь';
//        Yii::$app->authManager->add($user);
//
//        $ban = Yii::$app->authManager->createRole('banned');
//        $ban->description = 'Тварь';
//        Yii::$app->authManager->add($ban);
//
//        $manager = Yii::$app->authManager->createRole('manager');
//        $manager->description = 'Менеджер';
//        Yii::$app->authManager->add($manager);

//        $permit = Yii::$app->authManager->createPermission('canAdmin');
//        $permit->description = 'Право на на вход в адимнку';
//        Yii::$app->authManager->add($permit);

//        $role_a = Yii::$app->authManager->getRole('admin');
//        $role_m = Yii::$app->authManager->getRole('manager');
//        $permission = Yii::$app->authManager->getPermission('canAdmin');
//        Yii::$app->authManager->addChild($role_a, $permission);
//        Yii::$app->authManager->addChild($role_m, $permission);

//        $userRole = Yii::$app->authManager->getRole('admin');
//        Yii::$app->authManager->assign($userRole, Yii::$app->user->getId());

        return 'ready';
    }
}
