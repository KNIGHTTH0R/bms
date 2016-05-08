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
            <h4>Invoice Number : <?= $model2->inv_number; ?></h4>
            <?php
            $kalender = CAL_GREGORIAN;

                                    if($model2->tariffPeriod=='MONTH'){
                                        
                                        $jumbul = $model2->unitChargeValue->charge_month;
                                        $jumtah = $model2->unitChargeValue->charge_year;
                                        $hari = cal_days_in_month($kalender, $jumbul, $jumtah);
                                        
                                    }
                                    elseif($model2->tariffPeriod=='3MONTH'){
                                        $jumbul1 = $model2->unitChargeValue->charge_month;
                                        $jumbul2 = $model2->unitChargeValue->charge_month-1;
                                        $jumbul3 = $model2->unitChargeValue->charge_month-2;
                                        

                                        $jumtah = date('Y');
                                        $hari1 = cal_days_in_month($kalender, $jumbul1, $jumtah);
                                        $hari2 = cal_days_in_month($kalender, $jumbul2, $jumtah);
                                        $hari3 = cal_days_in_month($kalender, $jumbul3, $jumtah);
                                        
                                        $hari = $hari1+$hari2+$hari3;    
                                    }
                                    elseif($model2->tariffPeriod=='6MONTH'){
                                        $jumbul1 = $model2->unitChargeValue->charge_month;
                                        $jumbul2 = $model2->unitChargeValue->charge_month-1;
                                        $jumbul3 = $model2->unitChargeValue->charge_month-2;
                                        $jumbul4 = $model2->unitChargeValue->charge_month-3;
                                        $jumbul5 = $model2->unitChargeValue->charge_month-4;
                                        $jumbul6 = $model2->unitChargeValue->charge_month-5;
                                        

                                        $jumtah = date('Y');
                                        $hari1 = cal_days_in_month($kalender, $jumbul1, $jumtah);
                                        $hari2 = cal_days_in_month($kalender, $jumbul2, $jumtah);
                                        $hari3 = cal_days_in_month($kalender, $jumbul3, $jumtah);
                                        $hari4 = cal_days_in_month($kalender, $jumbul4, $jumtah);
                                        $hari5 = cal_days_in_month($kalender, $jumbul5, $jumtah);
                                        $hari6 = cal_days_in_month($kalender, $jumbul6, $jumtah);
                                        

                                        $hari = $hari1+$hari2+$hari3+$hari4+$hari5+$hari6;    
                                    }else if($model2->tariffPeriod=='YEAR'){

                                        $jumbul1 = $model2->unitChargeValue->charge_month;
                                        $jumbul2 = $model2->unitChargeValue->charge_month-1;
                                        $jumbul3 = $model2->unitChargeValue->charge_month-2;
                                        $jumbul4 = $model2->unitChargeValue->charge_month-3;
                                        $jumbul5 = $model2->unitChargeValue->charge_month-4;
                                        $jumbul6 = $model2->unitChargeValue->charge_month-5;
                                        $jumbul7 = $model2->unitChargeValue->charge_month-6;
                                        $jumbul8 = $model2->unitChargeValue->charge_month-7;
                                        $jumbul9 = $model2->unitChargeValue->charge_month-8;
                                        $jumbul10 = $model2->unitChargeValue->charge_month-9;
                                        $jumbul11 = $model2->unitChargeValue->charge_month-10;
                                        $jumbul12 = $model2->unitChargeValue->charge_month-11;
                                        

                                        $jumtah = date('Y');
                                        $hari1 = cal_days_in_month($kalender, $jumbul1, $jumtah);
                                        $hari2 = cal_days_in_month($kalender, $jumbul2, $jumtah);
                                        $hari3 = cal_days_in_month($kalender, $jumbul3, $jumtah);
                                        $hari4 = cal_days_in_month($kalender, $jumbul4, $jumtah);
                                        $hari5 = cal_days_in_month($kalender, $jumbul5, $jumtah);
                                        $hari6 = cal_days_in_month($kalender, $jumbul6, $jumtah);
                                        $hari7 = cal_days_in_month($kalender, $jumbul7, $jumtah);
                                        $hari8 = cal_days_in_month($kalender, $jumbul8, $jumtah);
                                        $hari9 = cal_days_in_month($kalender, $jumbul9, $jumtah);
                                        $hari10 = cal_days_in_month($kalender, $jumbul10, $jumtah);
                                        $hari11 = cal_days_in_month($kalender, $jumbul11, $jumtah);
                                        $hari12 = cal_days_in_month($kalender, $jumbul12, $jumtah);

                                        $hari = $hari1+$hari2+$hari3+$hari4+$hari5+$hari6+$hari7+$hari8+$hari9+$hari10+$hari11+$hari12;   
                                    }
                                    $newdate = strtotime('-'.$hari.' day',$model2->unitChargeValue->charge_date);

            ?>
            <p>Periode Pemakaian : <?= date('d F Y', $newdate).' s/d '. date('d F Y', $model2->unitChargeValue->charge_date-1) ?></p>
              <?php 
                    $noDetail = 0;
                	
                    foreach ($model as $index => $models) {
                        $noDetail++;
                        $totalCharge = $models->total_charge;
                        echo '<div class="row"><div class="col-md-2" style="font-weight:bold; color:red; font-size:14px">'.$models->type.'</div><div class="col-md-8">'.$form->field($models, "[$index]status_pay")->checkbox(['label'=>'Pay', 'class'=>'paybox'.$noDetail]).'</div></div>';
                		echo '<div class="row pay-detail'.$noDetail.'"><div class="col-md-2">'.$form->field($models, "[$index]total_charge")->textInput(['value' => number_format($totalCharge,0,',','.'), 'readonly' => true])->label('Value Charge').'</div>';
                        echo '<div class="col-md-2">'.$form->field($models, "[$index]total_pay")->textInput(['id'=>'number'.$noDetail, 'value'=>0, 'placeholder'=>'0'])->label('Value Pay').$form->field($models, "[$index]id")->hiddenInput(['value'=>$models->id])->label(false).$form->field($models, "[$index]type")->hiddenInput(['value'=>$models->type])->label(false).'</div>';
                        
                        echo '<div class="col-md-3">'.$form->field($models, "[$index]jenis_pembayaran")->dropDownList($options['payMetod'],['prompt'=>'-Choose Pay Metod-','onchange'=>'
                                            $.post("index.php?r=bill-inv/lists&id='.'"+$(this).val(), function( data ) {
                                              $( "select.jenpem'.$noDetail.'" ).html( data );
                                            });'])->label('Pay Metod').'</div>';
                        
                        $dataBank=ArrayHelper::map(\backend\models\Coa::find()->asArray()->all(), 'code', 'name');
                        echo '<div class="col-md-3">'.$form->field($models, "[$index]coa_code")->dropDownList($dataBank, 
                                         ['prompt'=>'- Choose COA -', 'class'=>'jenpem'.$noDetail])->label('Select COA').'</div>';
                        echo '</div><hr />';

                        $this->registerJs('                       
                        $(window).load(function(){
                            $(".pay-detail'.$noDetail.'").hide();
                        })

                        $(".paybox'.$noDetail.'").bind("change", function () {
                            if (this.checked) {
                                $(".pay-detail'.$noDetail.'").show();
                            } else {
                                $(".pay-detail'.$noDetail.'").hide();
                            }
                        });

                        $("#number'.$noDetail.'").keyup(function(event) {
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

    <div class="form-group">
        <?= Html::submitButton() ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>