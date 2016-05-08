<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TypeCharge */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="type-charge-form">
<div class="row">
    <!-- left column -->            
    <div class="col-md-9">          

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
            <div class="box-body">
                <div class="form-group">

                    <div class="row">
                        <div class="col-md-8">
					    	<?= $form->field($model, 'name_type')->textInput(['maxlength' => true]) ?>
					    </div>

					    <div class="col-md-4">
					    	<?= $form->field($model, 'code_type')->textInput(['maxlength' => true]) ?>
					    </div>
					 </div>
					 <div class="row">
					 <div class="col-md-12">

					    <div class="form-group">
					        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
					    </div>

					 </div>
					 </div>
				</div>
			</div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
