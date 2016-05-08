<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UnitChargeValue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-charge-value-form">
<?php $form = ActiveForm::begin(); ?>
<div class="col-md-8">   
           <div class="box box-primary"> 
            <div class="box-body">
            <h4>Invoice Number : <?= $model2->inv_number; ?></h4>
              <?php 

                	foreach ($model as $models) {
                        $totalCharge = $models->value_charge+$models->value_admin;
                        echo '<div class="row"><h4 style="margin-left:15px">'.$models->type.'</h4>';
                		echo '<div class="col-md-4">'.$form->field($models, 'value_charge')->textInput(['value' => 'Rp. '.$totalCharge, 'readonly' => true])->label('Value Charge').'</div>';
                        echo '<div class="col-md-4">'.$form->field($models, 'value_pay')->textInput(['value' => $totalCharge])->label('Value Pay').'</div>';
                        echo '<div class="col-md-4">'.$form->field($models, 'status_pay')->dropDownList(['Paid' => 'Paid', 'Partially Paid' => 'Partially Paid', 'Not Yet' => 'Not Yet'], ['prompt'=>'Select Pay Status'])->label('Pay Status').'</div>';
                        echo '</div><hr />';



                	}

                ?>

    <div class="form-group">
        <?= Html::submitButton($models->isNewRecord ? 'Create' : 'Pay Process', ['class' => $models->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
