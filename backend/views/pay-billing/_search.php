<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PayBillingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pay-billing-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'unit_code') ?>

    <?= $form->field($model, 'unit_charge_value_id') ?>

    <?= $form->field($model, 'total_charge') ?>

    <?php // echo $form->field($model, 'total_pay') ?>

    <?php // echo $form->field($model, 'balance_value') ?>

    <?php // echo $form->field($model, 'status_pay') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
