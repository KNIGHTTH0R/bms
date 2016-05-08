<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeTransaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idemployee')->textInput() ?>

    <?= $form->field($model, 'atten_day')->textInput() ?>

    <?= $form->field($model, 'overtime_day')->textInput() ?>

    <?= $form->field($model, 'debt_value')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
