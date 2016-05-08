<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PersonAddressSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-address-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'person_id') ?>

    <?= $form->field($model, 'postal_code') ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'for_billing')->checkbox() ?>

    <?php // echo $form->field($model, 'for_letternotif')->checkbox() ?>

    <?php // echo $form->field($model, 'building') ?>

    <?php // echo $form->field($model, 'street') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'province') ?>

    <?php // echo $form->field($model, 'country') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
