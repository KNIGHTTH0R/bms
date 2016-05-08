<?php

use yii\helpers\Html;
use frontend\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Upload Excell';

  $errors = array_filter($rowData); 
  if(!empty($errors)) {
?>
<div class="row">
<div class="col-md-12">
  <?php $form = ActiveForm::begin(['action'=>'index.php?r=coa/upload-coa', 'id'=>'coa2']); ?>
  <div class="box box-primary">
    <div class="box-header">
      <?= Html::submitButton('<i class="fa fa-plus"></i> Add', ['class' => 'btn btn-warning btn-sm']) ?>
    </div>
    <div class="box-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Type</th>
            <th>Code</th>
            <th>Name</th>
            <th>D/C</th>
            <th>Parent</th>
            <th><div class="checkbox" id="checkCoa"><label><input type="checkbox" name="coaall" id="selectAll">Check All</label></div></th>
          </tr>
        </thead>
        <tbody>
           <?php foreach ($rowData as $dataRow) {?>
            <tr>
              <td><?= $dataRow[0][0] ?></td>
              <td><?= $dataRow[0][1] ?></td>
              <td><?= $dataRow[0][2] ?></td>
              <td><?= $dataRow[0][3] ?></td>
              <td><?= $dataRow[0][4] ?></td>
              <td><input class="coaInput" type="checkbox" name="bulkcoa[]" value="<?= $dataRow[0][0] . '_' . $dataRow[0][1] . '_' . $dataRow[0][2] .'_' . $dataRow[0][3] . '_' . $dataRow[0][4] ?>"></td>
            </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>
</div>

<?php
$script = <<< JS
  $(function(){
    $("#selectAll").change(function(){
      $(".coaInput").prop('checked', $(this).prop("checked"));
    });
  });
JS;
$this->registerJs($script);
?>
<?php } ?>