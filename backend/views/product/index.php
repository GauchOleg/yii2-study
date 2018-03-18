<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'title',
            'cost',
//            'type_id',
            'text:ntext',
//            'sklad_id',
            [
                'attribute' => 'sklad_id',
                'value' => 'skladName',
                'filter' => \common\models\Sklad::getList(),
            ],
            [
                'attribute' => 'sklad_name',
                'value' => 'skladName',
//                'filter' => \common\models\Sklad::getList(),
            ],
            [
                'attribute' => 'type_id',
                'value' => 'typeName',
                'filter' => \common\models\Product::getTypeList(),
            ],
            [
                'attribute' => 'date',
                'format' => 'date',
                'value' => 'date',
                'filter' => ''
            ],
            'date:date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>
