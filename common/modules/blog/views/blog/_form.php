<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use common\modules\blog\models\Tag;

/* @var $this yii\web\View */
/* @var $model \common\modules\blog\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin([
            'options' => [
                'encrypt' => 'multipart/from-data',
            ]
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'text')->widget(\vova07\imperavi\Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'imageUpload' => \yii\helpers\Url::to(['site/save-redactor-img', 'sub' => 'blog']),
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]);?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id')->dropDownList($model->getStatusList()) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?php
    echo $form->field($model, 'tags')->widget(\kartik\select2\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(Tag::find()->all(),'id','name'),
        'language' => 'RU',
        'options' => ['placeholder' => 'Выбрать тег','multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ]);
    ?>

<!--    --><?php
//    echo $form->field($model, 'file')->widget(FileInput::classname(), [
//        'options' => ['accept' => 'image/*'],
//    ]);
//    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= FileInput::widget([
        'name' => 'ImageManager[attachment]',
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'deleteUrl' => \yii\helpers\Url::to(['/blog/delete-img']),
            'initialPreview' => $model->imageLinks,
            'initialPreviewAsData' => true,
            'overwriteInitial' => false,
            'initialPreviewConfig' => $model->imageLinksData,
            'uploadUrl' => \yii\helpers\Url::to(['/site/save-img']),
            'uploadExtraData' => [
                'ImageManager[class]' => $model->formName(),
                'ImageManager[item_id]' => $model->id,
            ],
            'maxFileCount' => 10
        ],
        'pluginEvents' => [
            'filesorted' => new \yii\web\JsExpression('function(event, params){
                  $.post("'.\yii\helpers\Url::toRoute(["/blog/sort-image","id"=>$model->id]).'",{sort: params});
            }')
        ]
    ]) ?>

</div>
