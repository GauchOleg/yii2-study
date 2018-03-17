<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\modules\blog\models\Blog */

$this->title = 'Update Blog: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="blog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<!--    --><?php //if (!empty($model->tags)) :?>
<!--    <div class="well">-->
<!--        <p>--><?//= (count($model->tags) > 1) ? 'Теги: ' : 'Тег: '?><!-- </p>-->
<!--        --><?php //$i = 1; foreach ($model->tags as $one) :?>
<!--            --><?//= $i . ') ' .$one->name . '<br>'?>
<!--        --><?php //$i++; endforeach; ?>
<!--    </div>-->
<!--    --><?php //endif; ?>

</div>
