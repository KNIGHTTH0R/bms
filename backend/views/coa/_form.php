<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Coa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coa-form">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                        <?php $form = ActiveForm::begin(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'type')->dropDownList($model->coatypeList, ['prompt' => '-- Acc. Type --']); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'parent_id')->dropDownList($model->parentList, ['prompt' => '-- Parent --']); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'placeholder' => 'Leave blank to auto number']) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name of Coa']) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'debet_credit')->radioList($model->dk)->label(''); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>