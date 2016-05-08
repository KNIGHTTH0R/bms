<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Property;
/* @var $this yii\web\View */
/* @var $model backend\models\Building */
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


                  <div class="col-md-12">
                        <?php
                        $propOwner=ArrayHelper::map(\backend\models\Property::find()->asArray()->all(), 'id', 'name');
                        echo $form->field($model, 'property_id')->dropDownList($propOwner, 
                                 ['prompt'=>'-Choose a Property-'
                                  
                                ])->label('Property'); 
                     
                        ?>
                  </div>	

			      <div class="col-md-6">
			    	<?= $form->field($model, 'code_building')->textInput(['placeholder' => 'Building Code']) ?>
			      </div>

			      <div class="col-md-6">
			    	<?= $form->field($model, 'name')->textInput(['placeholder' => 'Building Name']) ?>
			      </div>

			      <div class="col-md-12">
			    	<?= $form->field($model, 'floor_num')->textInput(['type'=>'number']) ?>
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
