<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DepositTbSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deposit-tb-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_deposit') ?>

    <?= $form->field($model, 'unit_id') ?>

    <?= $form->field($model, 'deposit_value') ?>

    <?= $form->field($model, 'explan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
