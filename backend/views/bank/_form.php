<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Coa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coa-form">
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
        <div class="box-header with-border">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-12">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Bank Name') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <?= $form->field($model, 'bank_acc_number')->textInput(['maxlength' => true])->label('Account Number') ?>
                </div>
                <div class="col-md-6">
                <?= $form->field($model, 'bank_acc_name')->textInput(['maxlength' => true])->label('Account Name') ?>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> Create' : '<i class="fa fa-edit"></i> Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        </div>
    </div>
</div>
</div>
