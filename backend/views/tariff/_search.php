<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TariffSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tariff-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'property_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'recurring')->checkbox() ?>

    <?= $form->field($model, 'recur_period') ?>

    <?php // echo $form->field($model, 'recur_date') ?>

    <?php // echo $form->field($model, 'recur_month') ?>

    <?php // echo $form->field($model, 'progressive')->checkbox() ?>

    <?php // echo $form->field($model, 'meter_unit') ?>

    <?php // echo $form->field($model, 'formula') ?>

    <?php // echo $form->field($model, 'progressive_formula') ?>

    <?php // echo $form->field($model, 'tax')->checkbox() ?>

    <?php // echo $form->field($model, 'tax_formula') ?>

    <?php // echo $form->field($model, 'admin_charge')->checkbox() ?>

    <?php // echo $form->field($model, 'admin_formula') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'penalty')->checkbox() ?>

    <?php // echo $form->field($model, 'penalty_formula') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
