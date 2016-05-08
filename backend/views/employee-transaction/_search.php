<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeTransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-transaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_transaction') ?>

    <?= $form->field($model, 'idemployee') ?>

    <?= $form->field($model, 'atten_day') ?>

    <?= $form->field($model, 'overtime_day') ?>

    <?= $form->field($model, 'debt_value') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
