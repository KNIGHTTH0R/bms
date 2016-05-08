<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PersonAddress */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="person-address-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'person_id')->textInput() ?>

    <?= $form->field($model, 'postal_code')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'phone')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fax')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'for_billing')->checkbox() ?>

    <?= $form->field($model, 'for_letternotif')->checkbox() ?>

    <?= $form->field($model, 'building')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'street')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'city')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'province')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'country')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
