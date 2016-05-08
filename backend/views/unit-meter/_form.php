<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\UnitMeter */
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
                        $dataCategory=ArrayHelper::map(\backend\models\Unit::find()->asArray()->all(), 'id', 'code');
                        echo $form->field($model, 'unit_id')->dropDownList($dataCategory, 
                                 ['prompt'=>'-Choose a Unit-'
                                  
                                ])->label('Unit'); 
                     
                        ?>
                </div>


                <div class="col-md-6">
				    <?php echo $form->field($model, 'type')->dropDownList(['Electricity' => 'Electricity', 'Water' => 'Water'], ['prompt'=>'Select Type Charge']); ?>

                </div>

                <div class="col-md-12">
				    <?= $form->field($model, 'meter_number')->textInput(['maxlength' => true])->label('Number Meter') ?>
                </div>

                </div>

                    <div class="form-group">
                        <div class="col-md-12">
				            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
				    </div>
                

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>