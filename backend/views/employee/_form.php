<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-form">

<div class="row">
            <!-- left column -->            
    <div class="col-md-8">   
      <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
    <div class="box box-primary">
              <!-- general form elements -->
        
        <div class="box-body" style="padding:30px 20px 20px 20px">
            <div class="row">
              
                <div class="col-md-4">    
                    <?= $form->field($model, 'nip')->textInput()?>
                </div>

                <div class="col-md-5">

                    <?= $form->field($model, 'name_employee')->textInput(['maxlength' => true])->label('Nama Karyawan') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">                   
                    

                    <?= $form->field($model, 'file')->widget(FileInput::className(), [
                                'options' => ['accept' => 'image/*'],
                                'pluginOptions' => [
                                    'showUpload' => false,
                                    'showRemove' => false,
                                    'browseClass' => 'btn btn-primary',
                                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                    'browseLabel' => 'Pilih Foto',
                                    'allowedFileExtensions' => ['jpg', 'jpeg', 'gif', 'png']
                                ]
                            ]);?>
                </div>
            </div>
                
        
             <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'email_employee')->textInput(['maxlength' => true])->label('Email Karyawan') ?>
                </div>                
                <div class="col-md-6">
                    <?= $form->field($model, 'phone_employee')->textInput()->label('No Tlp.') ?>
                </div>
            </div>

            <div class="row">
              
                <div class="col-md-12">    
                    <?= $form->field($model, 'address_employee')->textarea(['rows' => 6])->label('Alamat') ?>
                </div>
              
            </div>
                
            <div class="row">
              
                <div class="col-md-2">    
                    <?= $form->field($model, 'gender')->dropDownList(['m' => 'Male', 'f' => 'Female',], ['prompt'=>'Select..'])->label('L/P'); ?>
                </div>
                
                <div class="col-md-3">
                    <?= $form->field($model, 'religion')->textInput(['maxlength' => true])->label('Agama') ?>
                </div>
                
                <div class="col-md-3">
                    <?= $form->field($model, 'pob')->textInput(['maxlength' => true])->label('Tempat lahir') ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, "dob")->widget(DatePicker::classname(), ['options' => ['placeholder' => 'Tanggal Lahir ...'],'pluginOptions' => ['autoclose' => true, 'format' => 'dd-mm-yyyy']])->label('Tanggal Lahir'); ?>
                </div>
            </div>
             <div class="row">
              
                <div class="col-md-4">    
                  <?= $form->field($model, 'section')->textInput(['maxlength' => true])->label('Bagian') ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'position')->textInput(['maxlength' => true])->label('Jabatan') ?>
                </div>    

                <div class="col-md-4">
                    <?php
                        $groupEmp=ArrayHelper::map(\backend\models\EmployeeGroup::find()->asArray()->all(), 'idgroup', 'group_name');
                        echo $form->field($model, 'idgroup')->dropDownList($groupEmp, 
                                 ['prompt'=>'-Pilih Golongan-'
                                  
                                ])->label('Golongan'); 
                     
                        ?>
                    
                </div>

            </div>
            <div class="row">
                
                <div class="col-md-4">
                    
                    <?= $form->field($model, 'work_status')->dropDownList(['Pegawai Tetap' => 'Pegawai Tetap', 'Pegawai Kontrak' => 'Pegawai Kontrak',], ['prompt'=>'Pilih Status Kepegawaian'])->label('Status Pegawai') ?>
                </div>

                <div class="col-md-4">                   

                    <?= $form->field($model, 'marital_status')->dropDownList(['Single' => 'Single', 'Menikah' => 'Menikah', 'Janda' => 'Janda', 'Duda' => 'Duda'], ['prompt'=>'Pilih Status Pernikahan']) ?>
                </div>

                <div class="col-md-4">                   
                    <?= $form->field($model, 'start_work')->widget(DatePicker::classname(), ['options' => ['placeholder' => 'Tanggal Mulai Bekerja'],'pluginOptions' => ['autoclose' => true, 'format' => 'dd-mm-yyyy']])->label('Mulai Bekerja'); ?>
                </div>

            </div>

            <div class="row">

                <div class="col-md-4">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

            </div>
          
                <?php ActiveForm::end(); ?>

</div>
