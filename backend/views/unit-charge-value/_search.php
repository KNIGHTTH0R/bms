<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UnitChargeValueSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-charge-value-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'unit_charge_id') ?>

    <?= $form->field($model, 'value_charge') ?>

    <?= $form->field($model, 'value_tax') ?>

    <?php // echo $form->field($model, 'value_admin') ?>

    <?php // echo $form->field($model, 'value_penalty') ?>

    <?php // echo $form->field($model, 'detail') ?>

    <?php // echo $form->field($model, 'charge_date') ?>

    <?php // echo $form->field($model, 'overdue')->checkbox() ?>

    <?php // echo $form->field($model, 'due_date') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'month') ?>

    <?php // echo $form->field($model, 'year') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
