<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Unit;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\ComplainTb */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complain-tb-form">
    <div class="row">
            <!-- left column -->            
        <div class="col-md-8">   
            <?php $form = ActiveForm::begin(); ?>

            <div class="box box-primary">
              <!-- general form elements -->
        
                <div class="box-body" style="padding:30px 20px 20px 20px">
                <h3 class="box-title" style="margin-top:0px; margin-bottom:30px;"><?= Html::encode($this->title) ?></h3>
                    <div class="row">
                            <div class="col-md-6">

                                <?= $form->field($model, 'code_unit')->widget(\yii\jui\AutoComplete::classname(), [
                                    'clientOptions' => [
                                        'source' => $modelUnit
                                    ],
                                ])->textInput()->label('Unit') ?>
    

                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, "date_complain")->widget(DatePicker::classname(), ['options' => ['placeholder' => 'When Complain ...'],'pluginOptions' => ['autoclose' => true, 'format' => 'dd MM yyyy']])->label('Date Complain'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'complain')->textarea(['rows' => 6]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'solution')->textarea(['rows' => 6]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <?= $form->field($model, 'user_id')->hiddenInput(['maxlength' => 'true', 'value'=>Yii::$app->user->id])->label(false) ?>
                            <?= $form->field($model, 'status_complain')->dropDownList(['Solved' => 'Solved', 'On Progress'=>'On Progress', 'Not Solved' => 'Not Solved'], ['prompt'=>'Select Status...'])->label('Complain Status') ?>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                </div>
                            </div>

                        </div>
                            
                            

                            <?php ActiveForm::end(); ?>
                    
                </div>
            </div>
        </div>
    </div>

</div>
