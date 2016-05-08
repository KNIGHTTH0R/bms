<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idemployee') ?>

    <?= $form->field($model, 'nip') ?>

    <?= $form->field($model, 'name_employee') ?>

    <?= $form->field($model, 'address_employee') ?>

    <?= $form->field($model, 'phone_employee') ?>

    <?php // echo $form->field($model, 'email_employee') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'religion') ?>

    <?php // echo $form->field($model, 'pob') ?>

    <?php // echo $form->field($model, 'dob') ?>

    <?php // echo $form->field($model, 'section') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'marital_status') ?>

    <?php // echo $form->field($model, 'work_status') ?>

    <?php // echo $form->field($model, 'start_work') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'idgroup') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
