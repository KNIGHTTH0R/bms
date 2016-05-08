<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeGroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idgroup') ?>

    <?= $form->field($model, 'group_name') ?>

    <?= $form->field($model, 'basic_salary') ?>

    <?= $form->field($model, 'overtime_value') ?>

    <?= $form->field($model, 'transport_value') ?>

    <?php // echo $form->field($model, 'meal_allow') ?>

    <?php // echo $form->field($model, 'allowance1') ?>

    <?php // echo $form->field($model, 'allowance2') ?>

    <?php // echo $form->field($model, 'allowance3') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
