<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Coa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="coa-form">

    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="box-body">
                        <?php $form = ActiveForm::begin(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'parent_id')->dropDownList($model->parentList, ['prompt' => '-- Parent --']); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'type')->dropDownList($model->coatypeList, ['prompt' => '-- Acc. Type --']); ?>
                            </div>
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