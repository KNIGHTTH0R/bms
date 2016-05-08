<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-group-form">
<div class="row">
            <!-- left column -->            
    <div class="col-md-8">   
      <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
              <!-- general form elements -->
        
        <div class="box-body" style="padding:30px 20px 20px 20px">
        
            <div class="row">
                <div class="col-md-4">    
                    <?= $form->field($model, 'group_name')->textInput(['maxlength' => true])->label('Nama Golongan') ?>
                </div>

                <div class="col-md-4">    
                    <?= $form->field($model, 'basic_salary')->textInput()->label('Gaji Pokok') ?>
                </div>

                <div class="col-md-4">    
                    <?= $form->field($model, 'overtime_value')->textInput()->label('Upah Lembur') ?>
                </div>

            </div>

            <div class="row">
                
                <div class="col-md-6">
                    <?= $form->field($model, 'transport_value')->textInput()->label('Uang Transport') ?>        
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'meal_allow')->textInput()->label('Uang Makan') ?>
                </div>
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
