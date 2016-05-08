<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use frontend\widgets\Alert;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\widgets\ActiveForm;

$this->title = 'Upload Excell';
?>
<?php /*= Html::button('<i class="fa fa-plus"></i> Upload', ['value'=>'Upload', 'class' => 'btn btn-success btn-xs', 'id'=>'modalButton']) */?>
<div class="row">
<div class="col-md-4">
  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
  <div class="box box-primary box-solid">
    
    <div class="box-header with-border">
      <h3 class="box-title">Upload Excel File (*.xls)</h3>
    </div>
    <div class="box-body">
      <?= Alert::widget() ?>
      <?php
        echo FileInput::widget([
            'name' => 'fileupload',
                'pluginOptions' => [
                'showCaption' => true,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary',
                'browseLabel' =>  'Select File',
                'mainClass' => 'input-group-sm'
            ],
            'options' => ['accept' => 'application/vnd.ms-excel'],
        ]);
      ?>
    </div>
    <div class="box-footer">
      <?= Html::submitButton('<i class="fa fa-cloud-upload"></i> Upload', ['class' => 'btn btn-success btn-sm']) ?>
    </div>
    
  </div>
  <?php ActiveForm::end(); ?>
</div>
</div>