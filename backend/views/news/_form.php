<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $params = [
            'prompt' => 'Укажите язык',
            'options' => [
                // 'onchange'=>'this.form.submit()'
            ],
        ];
        echo $form->field($model, 'language_id', [
            'inputOptions' => [
                'onchange' => 'this.form.submit()',
                'class' => 'form-control',
            ],
        ])->dropDownList($languages, $params); 
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'article')->widget(CKEditor::className(), [
        'editorOptions' => [
            'present' => 'full',
            'inline' => false,
        ],
    ]); ?>

    <?= $form->field($model, 'images[]')->widget(FileInput::classname(), [
        'options' => [
            'accept' => 'image/*',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'initialPreview' => $images ?? [],
            'initialPreviewAsData' => true,
            'initialPreviewShowDelete' => true,
            'theme' => 'explorer-fa',
            'overwriteInitial' => false,
            'showRemove' => true,
            'maxFileSize' => 2800,
            'reversePreviewOrder' => true,
            'initialPreviewConfig' => $imagesPreviewConfig ?? [],
            'deleteUrl' => 'http://admin.blog.loc/news/delete-image',
            'uploadAsync' => false,
         ],
    ]); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?php
        $params = [
            'prompt' => 'Выберите категорию'
        ];
        echo $form->field($model, 'category_id')->dropDownList($categories, $params) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
