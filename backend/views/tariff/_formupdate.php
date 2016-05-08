<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\Helpers\ArrayHelper;
use backend\models\Property;

/* @var $this yii\web\View */
/* @var $model backend\models\Tariff */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <!-- left column -->            
    <div class="col-md-9">          
        <?php $form = ActiveForm::begin(); ?>
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group">

                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'tariff_name')->textInput(['placeholder'=>'ex : Electricity 2015 1200'])->label('Tariff Name'); 
                             ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $propOwner=ArrayHelper::map(\backend\models\Property::find()->asArray()->all(), 'id', 'name');
                            echo $form->field($model, 'property_id')->dropDownList($propOwner, 
                                     ['prompt'=>'-Choose a Property-'])->label('Property'); 
                            ?>
                        </div>   
                    </div>
                 

                    <div class="row">
                        <div class="col-md-9">
                            <?php $typeCharge=ArrayHelper::map(\backend\models\TypeCharge::find()->asArray()->all(), 'name_type', 'name_type'); ?>
                            <?= $form->field($model, 'type')->dropDownList($typeCharge, 
                                     ['prompt'=>'-Choose a type-'])->label('Type'); 
                             ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'meter_unit')->dropDownList($options['meter_unit'], 
                                     ['prompt'=>'-None-'])->label('Meter unit');
                             ?>
                        </div>
                    </div>

                    <div class="row elec-details">
                        
                        <div class="col-md-12">
                            <label>Constanta :</label>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'formula[elec][tdl]')->textInput(['maxlength' => true, 
                                'placeholder' => 'TDL', 'value'=>$json->tdl])->label('Tarif Dasar Listrik [TDL]') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'formula[elec][pju]')->textInput(['maxlength' => true,
                                'placeholder' => 'PJU'])->label('Penerangan Jalan Umum [PJU]') ?>
                        </div>

                        <div class="col-md-12">
                            <label>Variables :</label>
                            <ul>
                                <li>Pemakaian / Usage [<b>W</b>]</li>
                            </ul>
                        </div>
                                               

                        <div class="col-md-12">

                            <?= $form->field($model, 'formula[elec][formula]')->textInput(['maxlength' => true,
                                'value' => '(TDL * W) + (TDL * W * PJU)'])->label('Formula') ?>
                        </div>
                    </div>

                    <div class="row water-details">
                        
                        <div class="col-md-12">
                            <?= $form->field($model, 'formula[water][tdl]')->textInput(['maxlength' => true, 
                                'placeholder' => 'TDA'])->label('Tarif Dasar Air [TDA]') ?>
                            <?= $form->field($model, 'formula[water][pju]')->textInput(['value' => '0', 'type'=>'hidden'])->label(false) ?>
                        </div>

                        <div class="col-md-12">
                            <label>Variables :</label>
                            <ul>
                                <li>Pemakaian / Usage [<b>W</b>]</li>
                            </ul>
                        </div>
                        
                        <div class="col-md-12">
                            <?= $form->field($model, 'formula[water][formula]')->textInput(['maxlength' => true,
                                'value' => '(TDA * W)'])->label('Formula') ?>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-12">
                        <?= $form->field($model, 'recurring')->checkbox() ?>
                        </div>
                        <div class="col-md-10 recur-details">
                            <?= $form->field($model, 'recur_period')->dropDownList($options['recur_period'], 
                                     ['prompt'=>'-Choose a recur period-'])->label('Recurring interval'); 
                             ?>
                        </div>
                    </div>

                    <div class="row recur-details">
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'recur_date')->textInput(['maxlength' => true, 
                                'placeholder' => 'Date Number e.q. 1,2,3 (csv)']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'recur_month')->textInput(['maxlength' => true,
                                'placeholder' => 'Month Number e.q. 1,2,3 (csv)']) ?>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-2">
                            <?= $form->field($model, 'tax')->checkbox() ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'tax_formula[percent]')->textInput(['placeholder'=>'%'])->label('Tax value') ?>
                        </div>
                        <div class="col-md-7">
                            <?= $form->field($model, 'tax_formula[formula]')->textInput()
                                ->label('Tax Formula') ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <?= $form->field($model, 'admin_charge')->checkbox() ?>
                        </div>
                        <div class="col-md-10">
                            <?= $form->field($model, 'admin_formula[value]')->textInput(['placeholder'=>'Nominal']) ?>
                            <?= $form->field($model, 'progressive')->textInput(['type'=>'hidden', 'value'=>false])->label(false) ?>
                            <?= $form->field($model, 'penalty')->textInput(['type'=>'hidden', 'value'=>false])->label(false) ?>
                        </div>
                        
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php 
    $this->registerJs('
        if(document.getElementsByTagName("title")[0].innerHTML=="Create Tariff"){
               $(window).load(function(){
               $(".elec-details, .water-details, .sf-details, .sc-details, .internet-details, .tv-details").hide();
        }) 
        }
        

        $("#tariff-recurring").bind("change", function () {
            if (this.checked) {
                $(".recur-details").show();
            } else {
                $(".recur-details").hide();
            }
        });

    
        if ($("#tariff-recurring").prop("checked")) {
            $(".recur-details").show();
        } else {
            $(".recur-details").hide();
        }

        $("#tariff-type").on("change", function() {
            if(this.value=="ELECTRICITY"){
                $(".elec-details").show();
                $(".water-details").hide();
                $(".sf-details").hide();
                $(".sc-details").hide();
                $(".internet-details").hide();

            }else if(this.value=="WATER"){
                $(".water-details").show();
                $(".elec-details").hide();
                $(".sf-details").hide();
                $(".sc-details").hide();
                $(".internet-details").hide();
                $(".tv-details").hide();
            }
            else if(this.value=="SINKINGFUND"){
                $(".water-details").hide();
                $(".elec-details").hide();
                $(".sf-details").show();
                $(".sc-details").hide();
                $(".internet-details").hide();
                $(".tv-details").hide();
            }
            else if(this.value=="SERVICECHARGE"){
                $(".water-details").hide();
                $(".elec-details").hide();
                $(".sf-details").hide();
                $(".sc-details").show();
                $(".internet-details").hide();
                $(".tv-details").hide();
            }
            else if(this.value=="INTERNET"){
                $(".water-details").hide();
                $(".elec-details").hide();
                $(".sf-details").hide();
                $(".sc-details").hide();
                $(".internet-details").show();
                $(".tv-details").hide();
            }
            else if(this.value=="TV"){
                $(".water-details").hide();
                $(".elec-details").hide();
                $(".sf-details").hide();
                $(".sc-details").hide();
                $(".internet-details").hide();
                $(".tv-details").show();
            }
          
        })

    ');

?> 

<?php /*
<div class="tariff-form">

    

    

    

    

    

   

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
*/ ?>