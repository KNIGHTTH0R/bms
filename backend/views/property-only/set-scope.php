<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Property;
?>

<div class="row">
    <div class="col-md-9">
    <?php $form = ActiveForm::begin(); ?>
    	<div class="box box-primary">
    		<div class="box-body">
    			<div class="row">
    				<div class="form-group">
    					<div class="col-md-12">
    					<?php
                        	$props=ArrayHelper::map(\backend\models\Property::find()->asArray()->all(), 'id', 'name');
                        	echo $form->field($model, 'property_id')->dropDownList($props, 
                                 ['prompt'=>'-Choose a Property-'])->label('Property'); 
                        ?>
    					</div>
    					<div class="col-md-12">
							<div class="form-group">
							    <?= Html::submitButton('Set Scope', ['class' => 'btn btn-success']) ?>
							</div>
				  		</div>
    				</div>
    			</div>
    		</div>
    	</div>
     <?php ActiveForm::end(); ?>
    </div>
</div>