<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\models\UnitCharge;

/* @var $this yii\web\View */
/* @var $model backend\models\Unit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
            <!-- left column -->            
    <div class="col-md-9">   
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
        
        <div class="box box-primary">
                  <!-- general form elements -->
            
            <div class="box-body">
                <div class="form-group">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'code')->textInput(['placeholder' => 'Unit Code']) ?>
                        </div>

                        <div class="col-md-3">
                            <?= $form->field($model, 'unit_floor')->textInput(['placeholder' => 'Unit floor']) ?>
                        </div>

                        <div class="col-md-3">
                            <?= $form->field($model, 'unit_num')->textInput(['placeholder' => 'Unit Number']) ?>
                        </div>
                        <div class="col-md-2">
                            <?= $form->field($model, 'isoccupied')->checkbox(['style'=>'margin-top:30px; margin-left:10px'], false)->label('Already Occupied ?') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                                <?php
                                $dataCategory=ArrayHelper::map(\backend\models\Building::find()->asArray()->all(), 'id', 'name');
                                echo $form->field($model, 'building_id')->dropDownList($dataCategory, 
                                         ['prompt'=>'-Choose a Building-',
                                          'onchange'=>'
                                            $.post("index.php?r=unit/lists&id='.'"+$(this).val(), function( data ) {
                                              $( "select#unitType" ).html( data );
                                            });'
                                        ])->label('Building'); 
                             
                                ?>
                        </div>

                        <div class="col-md-6">
                                <?php
                                echo $form->field($model, 'unit_type_id')
                                    ->dropDownList(
                                         ArrayHelper::map(\backend\models\UnitType::find()->asArray()->all(), 'id', 'name'),
                                        ['prompt'=>'-Select Unit Type-', 'id'=>'unitType']

                                    )->label('Unit Type');
                                ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                                <?php
                                $dataOwner=ArrayHelper::map(\backend\models\Person::find()->asArray()->all(), 'id', 'name');
                                echo $form->field($model, 'owner_id')->dropDownList($dataOwner, 
                                         ['prompt'=>'-Choose a Owner-'])->label('Owner'); 
                             
                                ?>
                        </div>

                        <div class="col-md-4">
                                <?php
                                $dataOwner2=ArrayHelper::map(\backend\models\Person::find()->asArray()->all(), 'id', 'name');
                                echo $form->field($model, 'tenant_id')->dropDownList($dataOwner2, 
                                         ['prompt'=>'-Choose a Tenant-'])->label('Tenant'); 
                             
                                ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'va')->textInput(['placeholder' => 'Virtual Account Number']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'space_size')->textInput(['placeholder' => 'Space Size']) ?>
                        </div>

                        <div class="col-md-4">
                            <?= $form->field($model, 'space_unit')->textInput(['placeholder' => 'in m2']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'power')->dropDownList($model->powerList, 
                                    ['prompt' => 'Choose Electric Power'])->label('Power') ?>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-6">    
                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            </div>
                        </div>    
                    </div> -->

                    <div class="row">
                             <div class="panel-body">
                             <?php DynamicFormWidget::begin([
                                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                'widgetBody' => '.container-items', // required: css class selector
                                'widgetItem' => '.item', // required: css class
                                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                                'min' => 1, // 0 or 1 (default 1)
                                'insertButton' => '.add-item', // css class
                                'deleteButton' => '.remove-item', // css class
                                'model' => $modelUc[0],
                                'formId' => 'dynamic-form',
                                'formFields' => [
                                    'unit_id',
                                    'tariff_id',
                                    'bill_to',
                                    'type',
                                    'group_bill',
                                    'unit_meter_id',
                                    
                                ],
                            ]); ?>

                            <div class="container-items"><!-- widgetContainer -->
                            <?php foreach ($modelUc as $i => $modelUc): ?>
                                
                                <div class="item panel panel-default"><!-- widgetBody -->
                                    <div class="panel-heading">
                                        <h3 class="panel-title pull-left">Unit Charge</h3>
                                        <div class="pull-right">
                                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                            // necessary for update action.
                                            if (! $modelUc->isNewRecord) {
                                                echo Html::activeHiddenInput($modelUc, "[{$i}]id");
                                            }
                                        ?>
                                    <div class="row">
                                
                                    <div class="col-sm-6">
                                        
                                        <?php
                                            $dataTypeCharge=ArrayHelper::map(\backend\models\TypeCharge::find()->asArray()->all(), 'name_type', 'name_type');
                                            echo $form->field($modelUc, "[{$i}]type")->dropDownList($dataTypeCharge, 
                                                     ['prompt'=>'-Choose Type Charge-'
                                                    ])->label('Type Of Charge'); 
                                         
                                            ?>
                                    </div>    
                                        <div class="col-sm-6">
                                        
                                    
                                        <?php
                                            $dataTariff=ArrayHelper::map(\backend\models\Tariff::find()->asArray()->all(), 'id', 'tariff_name');
                                            echo $form->field($modelUc, "[{$i}]tariff_id")->dropDownList($dataTariff, 
                                                     ['prompt'=>'-Choose Tariff-'])->label('Tariff'); 
                                         
                                        ?>
                                    </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?= $form->field($modelUc, "[{$i}]meter_number")->textInput(['placeholder'=>'leave blank if dont have meter number']) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?= $form->field($modelUc, "[{$i}]group_bill")->textInput(['placeholder'=>'A-Z']) ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?php
                                                    $dataOwner2=ArrayHelper::map(\backend\models\Person::find()->asArray()->all(), 'id', 'name');
                                                    echo $form->field($modelUc, "[{$i}]bill_to")->dropDownList($dataOwner2, 
                                                             ['prompt'=>'-Choose a Owner-'])->label('Bill To'); 
                                                 
                                                 ?>
                                            </div>
                                            
                                        </div><!-- .row -->
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <?php DynamicFormWidget::end(); ?>
                             
                            </div>
                                    <div class="col-md-12">
                                            <?= Html::submitButton('Submit', ['class'=> 'btn btn-primary']) ;?>

                                    </div>
                                

                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>