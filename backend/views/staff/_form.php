<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-body">
                    <?= Alert::widget() ?>
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly'=>!$model->isNewRecord]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'newPasswordConfirm')->passwordInput(['placeholder' => 'Confirm Password']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'status')->dropDownList(array(10 => 'ACTIVE', 20 => 'INACTIVE')) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        <?php /*= Html::submitButton('Create', ['class' => 'btn btn-success'])*/ ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
