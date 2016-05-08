<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\models\PayBilling;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\UnitChargeValue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-charge-value-form">
<?php $form = ActiveForm::begin(); ?>
<div class="col-md-8">   
           <div class="box box-primary" style="margin-left:-15px; padding-left:10px;"> 
            <div class="box-body">
            <h4>Invoice Number : <?= $model->inv_number; ?></h4>
            <?php
            $total=0;
            $totalAdmin=0;
            foreach ($modelpay as $modelpay) {
                        $total += $modelpay->total_charge;
                        $totalAdmin +=$modelpay->unitChargeValue->value_admin;
                    }
            echo '<div class="row"><div class="col-md-2" style="font-weight:bold; color:red; font-size:14px">'.$model->inv_number.'</div><div class="col-md-8">'.$form->field($model, "status_pay")->checkbox(['label'=>'Pay', 'class'=>'paybox']).'</div></div>';
            echo '<div class="row pay-detail"><div class="col-md-2">'.$form->field($model, "total_charge")->textInput(['value' => number_format($total,0,',','.'), 'readonly' => true])->label('Total Value Charge').'</div>';
                        
                        echo '<div class="col-md-2">'.$form->field($modelTambah, "value_admin")->textInput(['value'=>number_format($totalAdmin,0,',','.'), 'placeholder'=>'0', 'readonly'=>true])->label('Total Value Admin').'</div>';

                        echo '<div class="col-md-2">'.$form->field($modelTambah, "value_charge")->textInput(['id'=>'tp','value'=>number_format($totalAdmin+$total,0,',','.'), 'readonly'=>true])->label('Must be Paid').'</div>';

                        echo '<div class="col-md-2">'.$form->field($model, "total_pay")->textInput(['id'=>'number', 'value'=>0, 'placeholder'=>'0'])->label('Value Pay').$form->field($model, "id")->hiddenInput(['value'=>$model->id])->label(false).$form->field($model, "type")->hiddenInput(['value'=>$model->type])->label(false).$form->field($model, "unit_code")->hiddenInput(['value'=>$model->unit_code])->label(false).'</div>';
                        
                        echo '<div class="col-md-3">'.$form->field($model, "jenis_pembayaran")->dropDownList($options['payMetod'],['prompt'=>'-Choose Pay Metod-','onchange'=>'
                                            $.post("index.php?r=bill-inv/lists&id='.'"+$(this).val(), function( data ) {
                                              $( "select.jenpem" ).html( data );
                                            });'])->label('Pay Metod').'</div>';
                        
                        $dataBank=ArrayHelper::map(\backend\models\Coa::find()->asArray()->all(), 'code', 'name');
                        echo '<div class="col-md-4">'.$form->field($model, "coa_code")->dropDownList($dataBank, 
                                         ['prompt'=>'- Choose COA -', 'class'=>'jenpem'])->label('Select COA').'</div>';
                        if($dataDeposit==null){
                            $totalWithDep=$totalAdmin+$total;
                            if($totalWithDep<0){
                                    $totalWithDep=0;
                            }else{
                                $totalWithDep=$totalWithDep;
                            }
                            $totalAll=$totalAdmin+$total;    
                                echo '<div class="col-md-2">'.$form->field($model, "status_receipt")->textInput(['value'=>number_format(0,0,',','.'), 'readonly'=>true])->label('Your Deposit').'</div>';                            

                        }else{
                            $totalWithDep=($totalAdmin+$total)-$dataDeposit->deposit_value;
                            if($totalWithDep<0){
                                    $totalWithDep=0;
                            }else{
                                $totalWithDep=$totalWithDep;
                            }
                            $totalAll=$totalAdmin+$total;    
                                echo '<div class="col-md-2">'.$form->field($dataDeposit, "deposit_value")->textInput(['value'=>number_format($dataDeposit->deposit_value,0,',','.'), 'readonly'=>true, 'id'=>'dep'])->label('Your Deposit').
                                $form->field($dataDeposit, "unit_id")->hiddenInput(['value'=>$dataDeposit->unit_id])->label(false).'</div>';                            
                                echo '<div class="col-md-2" style="font-weight:bold; color:red; font-size:14px">'.$form->field($dataDeposit, "explan")->checkbox(['label'=>'Use Deposit', 'class'=>'depcek', 'style'=>'margin-top:30px']).'</div>';
                        }
                        
                        echo '</div><hr />';
                        if($dataDeposit==null){
                            $this->registerJs('                       
                        $(window).load(function(){
                            $(".pay-detail, .sumbit").hide();
                        })

                        $(".depcek").bind("change", function () {
                            if (this.checked) {
                                $("#tp").val('.$totalWithDep.');
                       
                            }else{
                                $("#tp").val('.$totalAll.');
                            }
                        });

                        $(".paybox").bind("change", function () {
                            if (this.checked) {
                                $(".pay-detail, .sumbit").show();
                            } else {
                                $(".pay-detail").hide();
                            }
                        });

                        $("#number").keyup(function(event) {
                               // skip for arrow keys
                               if(event.which >= 37 && event.which <= 40) return;
                               // format number
                               $(this).val(function(index, value) {
                                     return value
                                    .replace(/\D/g, "")
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                                    ;
                               });
                        });
                    ');
                        }else{
                            $this->registerJs('                       
                        $(window).load(function(){
                            $(".pay-detail, .sumbit").hide();
                        })

                        $(".depcek").bind("change", function () {
                            if (this.checked) {
                                $("#tp").val('.$totalWithDep.');
                                $("#dep").val('.$dataDeposit->deposit_value.');
                            }else{
                                $("#tp").val('.$totalAll.');
                            }
                        });

                        $(".paybox").bind("change", function () {
                            if (this.checked) {
                                $(".pay-detail, .sumbit").show();
                            } else {
                                $(".pay-detail").hide();
                            }
                        });

                        $("#number").keyup(function(event) {
                               // skip for arrow keys
                               if(event.which >= 37 && event.which <= 40) return;
                               // format number
                               $(this).val(function(index, value) {
                                     return value
                                    .replace(/\D/g, "")
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                                    ;
                               });
                        });
                    ');
                        }

                        
            ?>
              

    <div class="form-group sumbit">
        <?= Html::submitButton() ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>