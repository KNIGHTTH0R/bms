<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Person */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
            <!-- left column -->            
    <div class="col-md-7">   
      <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="box box-primary">
              <!-- general form elements -->
        
        <div class="box-body">
            <div class="row">
              <div class="form-group">
                     
                <div class="col-md-12">
                    <?= $form->field($model, 'name')->textInput() ?>
                </div>

                <div class="col-md-12">
                    <?= $form->field($model, 'is_company')->checkbox() ?>
                </div>

                <div class="col-md-12">
                    <?= $form->field($model, 'tax_reg')->textInput() ?>
                </div>

               
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsAdd[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'name',
                    'for_billing',
                    'for_letternotif',
                    'building',
                    'street',
                    'city',
                    'province',
                    'country',
                    'postal_code',
                    'phone',
                    'fax',
                    'person_id',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsAdd as $i => $modelAdd): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Address</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelAdd->isNewRecord) {
                                echo Html::activeHiddenInput($modelAdd, "[{$i}]id");
                            }
                        ?>
                        
                        <?= $form->field($modelAdd, "[{$i}]name")->dropDownList(['Home' => 'Home', 'Office' => 'Office', 'Other' => 'Other'], ['prompt'=>'Select Address Type'])->label('Address Type'); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelAdd, "[{$i}]for_billing")->checkbox() ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelAdd, "[{$i}]for_letternotif")->checkbox() ?>
                            </div>
                        </div><!-- .row -->
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelAdd, "[{$i}]building")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelAdd, "[{$i}]street")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelAdd, "[{$i}]city")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelAdd, "[{$i}]province")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelAdd, "[{$i}]country")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelAdd, "[{$i}]postal_code")->textInput() ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelAdd, "[{$i}]phone")->textInput(['type'=>'number']) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelAdd, "[{$i}]fax")->textInput(['type'=>'number']) ?>
                            </div>
                            <div class="col-sm-12">
                                <?= $form->field($modelAdd, "[{$i}]email")->textInput(['type'=>'email']) ?>
                            </div>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
             
            </div>
    

   

    
</div>
</div>
</div>
</div>
</div>
       <div class="col-md-5">   
           <div class="box box-primary"> 
            <div class="box-body">
            <div class="row">
              <div class="form-group">
                      
                <div class="col-md-6">
                    <?php echo $form->field($model, "detail_person[id_type]")->dropDownList(['KTP' => 'KTP', 'SIM' => 'SIM'], ['prompt'=>'Select Type ID'])->label('ID'); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, "detail_person[id_number]")->textInput(['placeholder'=>'ID Number'])->label('ID Number'); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, "detail_person[sex]")->dropDownList(['Male' => 'Male', 'Female' => 'Female',], ['prompt'=>'Select..'])->label('Sex'); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, "detail_person[salutation]")->textInput(['placeholder'=>'Mr/Mrs/Ms.. etc'])->label('Salutation'); ?>
                </div>

                <div class="col-md-12">   
                      <?= $form->field($model, "detail_person[dob]")->widget(DatePicker::classname(), ['options' => ['placeholder' => 'Enter event time ...'],'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']])->label('Date Of Birthday'); ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->field($model, "detail_person[nationality]")->textInput(['placeholder'=>'WNI / WNA'])->label('Nationality'); ?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->field($model, "detail_person[religion]")->textInput(['placeholder'=>'Religion'])->label('Religion'); ?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->field($model, "detail_person[marital_status]")->dropDownList(['Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced', 'Widowed' => 'Widowed', 'Separated' => 'Separated'], ['prompt'=>'Select Status'])->label('Marital Status'); ?>
                </div>

                
                <div class="col-md-12">
                    <h3>As Company</h3>
                </div>
                <div class="col-md-12">
                    <?php echo $form->field($model, "detail_person[contact_name]")->textInput()->label('Contact Name'); ?>
                </div>    
                <div class="col-md-12">
                    <?php echo $form->field($model, "detail_person[position]")->textInput()->label('Position'); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, "detail_person[id_type_comp]")->dropDownList(['KTP' => 'KTP', 'SIM' => 'SIM'], ['prompt'=>'Select Type ID']); ?>
                </div>    
                <div class="col-md-6">
                    <?php echo $form->field($model, "detail_person[id_number_comp]")->textInput(['placeholder'=>'ID Number'])->label('ID Number'); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, "detail_person[phone]")->textInput(['placeholder'=>'Phone Number','type'=>'number'])->label('Phone Number'); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, "detail_person[fax]")->textInput(['placeholder'=>'Fax Number','type'=>'number'])->label('Fax Number'); ?>
                </div>
                <div class="col-md-12">
                        <?= Html::submitButton($modelAdd->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
           </div>
        </div>
        </div>                      
       </div>
</div>
<?php ActiveForm::end(); ?>