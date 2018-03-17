<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\modules\blog\models\Blog;
/* @var $this yii\web\View */
/* @var $searchModel \common\modules\blog\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'text:ntext',
            [
                'attribute' => 'url',
                'format' => 'raw'
            ],
//            'url',
            [
                'attribute' => 'status_id',
                'filter' => Blog::STATUS_LIST,
                'value' => 'statusName',
            ],
            'smallImage:image',
            [
                'attribute' => 'tag',
                'format' => 'raw'
            ],
//            'status_id',
            //'sort',
            'date_create',
            'date_update',
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'options' => [
            'class' => 'table-responsive'
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
