<?php

use backend\assets\AppNewAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\PropertyManagement;



/* @var $this yii\web\View */
/* @var $model backend\models\UnitType */
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
                        
                        <?= $form->field($model, 'code')->textInput(['placeholder'=>'Code For Unit Type']) ?>
                </div>
                <div class="col-md-6">

                        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Name For Unit Type']) ?>
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
