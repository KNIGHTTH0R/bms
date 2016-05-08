<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\jui\DatePicker;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\ProfileUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-user-form">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'fullname')->textInput(['maxlength' => 100]) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'birthdate')->widget(DatePicker::className(), [
                                        'options' => ['placeholder' => 'Enter birth date ...'],
                                        'removeButton' => false,
                                        'pluginOptions' =>[
                                            'autoclose' => true,
                                            'format' => 'dd-m-yyyy',
                                            'todayHighlight' => true
                                    ]]); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'email')->textInput() ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'gender_id')->dropDownList($model->genderList, ['prompt' => 'Please Choose One']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-offset-6 col-md-6">
                                    <?php $title = isset($model->filename) && !empty($model->filename) ? $model->filename : 'Avatar'; ?>
                                    <?= Html::img($model->getImageUrl(), [
                                        'class' => 'img-thumbnail',
                                        'alt' => $title,
                                        'title' => $title
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'image')->widget(FileInput::className(), [
                                'options' => ['accept' => 'image/*'],
                                'pluginOptions' => [
                                    'showUpload' => false,
                                    'showRemove' => false,
                                    'browseClass' => 'btn btn-primary',
                                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                    'browseLabel' => 'Select Photo',
                                    'allowedFileExtensions' => ['jpg', 'jpeg', 'gif', 'png']
                                ]
                            ]);?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>