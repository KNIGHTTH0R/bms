<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\JurnalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jurnal-search">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Journal Search</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <?php $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                    ]); ?>

                    <div class="row">
                        <div class="col-md-8">
                            <?php echo '<label class="control-label">Date Range</label>' ?>
                            <?= DatePicker::widget([
                                'name' => 'from_date',
                                'type' => DatePicker::TYPE_RANGE,
                                'name2' => 'to_date',
                                'options' => ['placeholder' => 'Start date ...'],
                                'options2' => ['placeholder' => 'End date ...'],
                                'pluginOptions'=>[
                                    'autoclose' => true,
                                    'format'=>'dd-M-yyyy'
                                ]
                            ])?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'ref') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'code') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'description') ?>
                        </div>
                        <?php //echo $form->field($model, 'id') ?>

                        <?php //echo $form->field($model, 'debit') ?>

                        <?php //echo $form->field($model, 'credit') ?>

                        <?php //echo $form->field($model, 'created_at') ?>

                        <?php //echo $form->field($model, 'updated_at') ?>

                        <?php // echo $form->field($model, 'created_by') ?>

                        <?php // echo $form->field($model, 'updated_by') ?>

                        <?php // echo $form->field($model, 'date') ?>

                        <?php // echo $form->field($model, 'status') ?>

                        <?php // echo $form->field($model, 'ref') ?>

                        <?php // echo $form->field($model, 'code') ?>
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                                <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>