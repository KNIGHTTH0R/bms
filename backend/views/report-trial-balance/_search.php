<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\JurnalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-trial-balance-search">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Date Search</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <?php $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                ]); ?>
                <div class="box-body">
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
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                                <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
