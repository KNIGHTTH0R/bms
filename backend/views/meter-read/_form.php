<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\Helpers\ArrayHelper;
use backend\models\Property;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\MeterRead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <!-- left column -->            
    <div class="col-md-9">          

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
            <div class="box-body">
                <div class="form-group">

                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'type')->dropDownList($options['type'], 
                                     ['prompt'=>'-Choose a type-'])->label('Type'); 
                             ?>
                        </div>

                        <div class="col-md-4">
                            <?php
                            $meterNumber=ArrayHelper::map(\backend\models\UnitMeter::find()->asArray()->all(), 'id', 'meter_number');
                            echo $form->field($model, 'unit_meter_id')->dropDownList($meterNumber, 
                                     ['prompt'=>'-Choose Meter Number-'])->label('Meter Number'); 
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?= $form->field($model, 'date_read')->widget(DatePicker::classname(), ['options' => ['placeholder' => 'Enter Date Read'],'pluginOptions' => ['autoclose' => true, 'format' => 'dd-mm-yyyy']]) ?>
                        </div>
                    
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'prev_value')->textInput() ?>
                        </div>
                        
                        <div class="col-md-4">
                            <?= $form->field($model, 'cur_value')->textInput() ?>
                        </div>

                        <div class="col-md-4">
                            <?= $form->field($model, 'status')->dropDownList($options['status'], 
                                     ['prompt'=>'-Choose a Status-'])->label('Status'); 
                             ?>
                        </div>
                    </div>
                                        
                    <div class="row">    
                       <div class="col-md-12"> 
                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            </div>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

</div>
