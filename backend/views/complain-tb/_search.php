<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ComplainTbSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complain-tb-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_complain') ?>

    <?= $form->field($model, 'id_unit') ?>

    <?= $form->field($model, 'date_complain') ?>

    <?= $form->field($model, 'complain') ?>

    <?= $form->field($model, 'solution') ?>

    <?php // echo $form->field($model, 'staff') ?>

    <?php // echo $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
