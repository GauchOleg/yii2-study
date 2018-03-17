<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$blog = $dataProvider->getModels();
?>

<?=
    \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_one',
    ]);
?>

