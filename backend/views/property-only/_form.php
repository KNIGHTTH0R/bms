<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\PropertyManagement;

/* @var $this yii\web\View */
/* @var $model backend\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
            <!-- left column -->            
    <div class="col-md-9">          


    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
      <!-- general form elements -->
        <div class="box-body">
            <div class="row">
              <div class="form-group">
                <div class="col-md-6">
                        <?php
                        $propOwner=ArrayHelper::map(\backend\models\PropertyOwner::find()->asArray()->all(), 'id', 'name');
                        echo $form->field($model, 'property_owner_id')->dropDownList($propOwner, 
                                 ['prompt'=>'-Choose a Property Owner-'
                                  
                                ])->label('Property Owner'); 
                     
                        ?>
                </div>
                <div class="col-md-6">
                        <?php
                        echo $form->field($model, 'property_management_id')
                            ->dropDownList(
                                 ArrayHelper::map(\backend\models\PropertyManagement::find()->asArray()->all(), 'id', 'name'),
                                ['prompt'=>'-Select Property Management-', 'id'=>'propman']

                            )->label('Property Management');
                        ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'code')->textInput(['placeholder' => 'Code For Property']) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Property Name']) ?>
                </div>

                <div class="col-md-12">
                            <h3 style="margin-top:0px">Address</h3>
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'address[building_name]')->textInput(['placeholder'=>'Building Name'])->label('Building Name') ?>
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'address[street]')->textInput(['placeholder'=>'Street'])->label('Street') ?>
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'address[city]')->textInput(['placeholder'=>'City'])->label('City') ?>
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'address[Province]')->textInput(['placeholder'=>'Province'])->label('Province') ?>
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'address[contry]')->textInput(['placeholder'=>'Country'])->label('Country') ?>
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'address[postal_code]')->textInput(['placeholder'=>'Postal Code','type'=>'number'])->label('Postal Code') ?>
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'address[phone]')->textInput(['placeholder'=>'Phone','type'=>'number'])->label('Phone') ?>
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'address[fax]')->textInput(['placeholder'=>'Fax','type'=>'number'])->label('Fax') ?>
                        </div>
                        
                        <div class="col-md-12">
                            <?= $form->field($model, 'address[email]')->textInput(['placeholder'=>'Email','type'=>'email'])->label('Email') ?>
                        </div>


                

                <div class="col-md-6">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
                </div>

            <?php ActiveForm::end(); ?>

</div>
    </div>
</div>
</div>
