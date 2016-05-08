<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\UnitCharge */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
            <!-- left column -->            
    <div class="col-md-9">   


    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-primary">
              <!-- general form elements -->
        
            <div class="box-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                             <?php
                                $dataCategory=ArrayHelper::map(\backend\models\Unit::find()->asArray()->all(), 'id', 'code');
                                echo $form->field($model, 'unit_id')->dropDownList($dataCategory, 
                                         ['prompt'=>'-Choose a Unit-',
                                         'onchange'=>'
                                            $.post("index.php?r=unit-charge/lists&id='.'"+$(this).val(), function( data ) {
                                              $( "select#unitcharge-unit_meter_id" ).html( data );
                                            });
                                            $.post("index.php?r=unit-charge/plists&id='.'"+$(this).val(), function( data ) {
                                              $( "select#unitcharge-bill_to" ).html( data );
                                            });'
                                          
                                        ])->label('Unit'); 
                             
                                ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                                $dataCategory=ArrayHelper::map(\backend\models\UnitMeter::find()->asArray()->all(), 'id', 'meter_number');
                                echo $form->field($model, 'unit_meter_id')->dropDownList($dataCategory, 
                                         ['prompt'=>'-Choose a Unit Meter Id-'
                                         
                                        ])->label('Unit Meter Number'); 
                             
                                ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?php
                                $dataTariff=ArrayHelper::map(\backend\models\Tariff::find()->asArray()->all(), 'id', 'tariff_name');
                                echo $form->field($model, 'tariff_id')->dropDownList($dataTariff, 
                                         ['prompt'=>'-Choose a Tariff Id-'

                                         
                                        ])->label('Tariff ID'); 
                             
                                ?>
                        </div>

                        <div class="col-md-4">
                            <?php
                                $dataBillto=ArrayHelper::map(\backend\models\Person::find()->asArray()->all(), 'id', 'name');
                                echo $form->field($model, 'bill_to')->dropDownList($dataBillto, 
                                         ['prompt'=>'-Choose Owner or Tenant-'
                                         
                                        ])->label('Bill To'); 
                             
                                ?>
                        </div>

                        <div class="col-md-4">
                            <?php
                                
                                echo $form->field($model, 'group_bill')->textInput(['placeholder'=>'Char A-Z'])->label('Group Billing'); 
                             
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>