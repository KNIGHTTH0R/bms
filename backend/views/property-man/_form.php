<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PropertyManagement */
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
                        <?= $form->field($model, 'code')->textInput(['Placeholder' => 'code property management']) ?>
                      </div>

                      <div class="col-md-6">
                        <?= $form->field($model, 'name')->textInput(['Placeholder'=>'Property Management Name']) ?>
                      </div>

                      <div class="col-md-12">
                        <?= $form->field($model, 'tax_reg')->textInput(['Placeholder'=>'Tax Registration Number']) ?>
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

                      <div class="col-md-12">  
                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                      </div>

    <?php ActiveForm::end(); ?>

    </div>
    </div>
</div>
</div>
