<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Dropdown;
use backend\models\Coa;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\date\DatePicker;
use kartik\widgets\Select2;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\Jurnal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jurnal-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'date')->widget(DatePicker::className(), [
                                'options' => ['placeholder' => 'Enter date ...'],
                                'removeButton' => false,
                                'pluginOptions' =>[
                                'autoclose' => true,
                                'format' => 'dd-m-yyyy',
                                'todayHighlight' => true
                            ]]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'ref')->textInput(['placeholder'=>'Ref. No.', 'maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <?= $form->field($model, 'description')->textInput(['placeholder'=>'Description','maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?=$form->field($model, 'status')->dropDownList($model->getStatus(), ['prompt' => '-- Status --']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end row -->
    <div class="row">
        <div class="content">
            <div class="panel panel-default">
                <div class="panel-heading"><h4><i class="glyphicon glyphicon-usd"></i> Add Journal</h4></div>
                <div class="panel-body">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 4, // the maximum times, an element can be cloned (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelJurnalChild[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'id_coa',
                            'debit',
                            'credit',
                            'status',
                        ],
                    ]); ?>

                    <div class="container-items"><!-- widgetContainer -->
                        <?php foreach ($modelJurnalChild as $i => $modelJurnalChild): ?>
                            <div class="item panel panel-default"><!-- widgetBody -->
                                <div class="panel-heading">
                                    <div class="pull-right">
                                        <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        // necessary for update action.
                                        if (! $modelJurnalChild->isNewRecord) {
                                            echo Html::activeHiddenInput($modelJurnalChild, "[{$i}]id");
                                        }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <?php /*echo $form->field($modelJurnalChild, "[{$i}]id_coa")->widget(Select2::classname(), [
                                                    'data' => ArrayHelper::map(Coa::find()->where(['not', ['parent_id'=>null]])->all(), 'id', 'name'),
                                                    'options' => ['placeholder' => 'Select COA ...'],
                                                    'pluginOptions' => [
                                                        'allowClear' => true,
                                                    ],
                                                ])*/
                                            ?>
                                            <?php $data = ArrayHelper::map(Coa::find()->where(['not', ['parent_id'=>null]])->all(), 'id', 'name');
                                                echo $form->field($modelJurnalChild, "[{$i}]id_coa")->dropDownList($data, 
                                                    ['prompt'=>'-- Select COA --']
                                                    //['prompt'=>'-- Select COA --', 'onchange'=>'$.post("index.php?r=jurnal/lists&id='.'"+$(this).val(), function( data ) {$( "select#jurnalchild-'.$i.'-dc'.'" ).html( data ); });']
                                                );
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($modelJurnalChild, "[{$i}]description")->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <?= $form->field($modelJurnalChild, "[{$i}]dc")->dropDownList(['D'=>'DEBIT','C'=>'CREDIT']) ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?= $form->field($modelJurnalChild, "[{$i}]amount", [
                                                'template' => '{label}<div class="input-group">
                                                <span class="input-group-addon">Rp</span>{input}</div><div class="help-block"></div>'
                                            ])->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div><!-- .row -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php DynamicFormWidget::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!--End Row-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::button('Cancel', ['class'=>'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
