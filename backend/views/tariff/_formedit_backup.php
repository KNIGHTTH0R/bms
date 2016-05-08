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
                            <?= $form->field($model, 'type')->dropDownList($options['type'], 
                                     ['prompt'=>'-Choose a type-', 'id'=>'tariffType'])->label('Type'); 
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
                                'placeholder' => 'PJU', 'value'=>$json->pju])->label('Penerangan Jalan Umum [PJU]') ?>
                        </div>

                        <div class="col-md-12">
                            <label>Variables :</label>
                            <ul>
                                <li>Pemakaian / Usage [<b>W</b>]</li>
                            </ul>
                        </div>
                        
                        
                        <?php
                            if($model->type=='ELECTRICITY'){
                                echo '<div class="col-md-12">';
                                echo $form->field($model, 'formula[elec][formula]')->textInput(['maxlength' => true,
                                'value'=>$json->formula])->label('Formula');
                                echo '</div>';
                            }

                        ?>

                            
                        
                    </div>

                    <div class="row water-details">
                        
                        <div class="col-md-12">
                            <?= $form->field($model, 'formula[water][tdl]')->textInput(['maxlength' => true, 
                                'placeholder' => 'TDA', 'value'=>$json->tdl])->label('Tarif Dasar Air [TDA]') ?>
                            <?= $form->field($model, 'formula[water][pju]')->textInput(['value' => '0', 'type'=>'hidden'])->label(false) ?>
                        </div>

                        <div class="col-md-12">
                            <label>Variables :</label>
                            <ul>
                                <li>Pemakaian / Usage [<b>W</b>]</li>
                            </ul>
                        </div>
                        <?php
                            if($model->type=='WATER'){
                                echo '<div class="col-md-12">';
                                echo $form->field($model, 'formula[water][formula]')->textInput(['maxlength' => true,
                                'value'=>$json->formula])->label('Formula');
                                echo '</div>';
                            }

                        ?>
                    </div>

                    <div class="row sf-details">
                        
                        <div class="col-md-12">
                            <?= $form->field($model, 'formula[sf][tdl]')->textInput(['maxlength' => true, 
                                'placeholder' => 'Nominal', 'value'=>$json->tdl])->label('Tariff') ?>
                            <?= $form->field($model, 'formula[sf][pju]')->textInput(['value' => '0', 'type'=>'hidden'])->label(false) ?>
                        </div>

                    </div>

                    <div class="row sc-details">
                        
                        <div class="col-md-12">
                            <?= $form->field($model, 'formula[sc][tdl]')->textInput(['maxlength' => true, 
                                'placeholder' => 'Nominal', 'value'=>$json->tdl])->label('Tariff') ?>
                            <?= $form->field($model, 'formula[sc][pju]')->textInput(['value' => '0', 'type'=>'hidden'])->label(false) ?>
                        </div>

                    </div>

                    <div class="row internet-details">
                        
                        <div class="col-md-12">
                            <?= $form->field($model, 'formula[internet][tdl]')->textInput(['maxlength' => true, 
                                'placeholder' => 'Nominal', 'value'=>$json->tdl])->label('Tariff') ?>
                            <?= $form->field($model, 'formula[internet][pju]')->textInput(['value' => '0', 'type'=>'hidden'])->label(false) ?>
                        </div>

                    </div>

                    <div class="row tv-details">
                        
                        <div class="col-md-12">
                            <?= $form->field($model, 'formula[tv][tdl]')->textInput(['maxlength' => true, 
                                'placeholder' => 'Nominal', 'value'=>$json->tdl])->label('Tariff') ?>
                            <?= $form->field($model, 'formula[tv][pju]')->textInput(['value' => '0', 'type'=>'hidden'])->label(false) ?>
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
        $(window).load(function(){
            if(document.getElementById("tariffType").value=="ELECTRICITY"){
                $(".water-details, .sf-details, .sc-details, .internet-details, .tv-details").hide();
            }
            else if(document.getElementById("tariffType").value=="WATER"){
                $(".elec-details, .sf-details, .sc-details, .internet-details, .tv-details").hide();    
            }
            else if(document.getElementById("tariffType").value=="SINKINGFUND"){
                $(".elec-details, .water-details, .sc-details, .internet-details, .tv-details").hide();    
            }
            else if(document.getElementById("tariffType").value=="SERVICECHARGE"){
                $(".elec-details, .water-details, .sf-details, .internet-details, .tv-details").hide();    
            }
            else if(document.getElementById("tariffType").value=="INTERNET"){
                $(".elec-details, .water-details, .sc-details, .sf-details, .tv-details").hide();    
            }
            else if(document.getElementById("tariffType").value=="TV"){
                $(".elec-details, .water-details, .sc-details, .internet-details, .sf-details").hide();    
            }

            if ($("#tariff-recurring").value("checked")) {
                $(".recur-details").show();
            } else {
                $(".recur-details").hide();
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