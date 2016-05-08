<?php

use yii\helpers\Html;
use frontend\widgets\Alert;
use yii\widgets\ActiveForm;

$this->title = "Change Password";
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['profile/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
  <div class="box-center-special">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3>Change Password</h3>
        </div>
        <div class="box-body">
          <?= Alert::widget() ?>

          <?php $form = ActiveForm::begin(); ?>

          <?= $form->field($user, 'currentPassword')->passwordInput(['placeholder' => 'Current Password']) ?>
          <?= $form->field($user, 'newPassword')->passwordInput(['placeholder' => 'New Password']) ?>
          <?= $form->field($user, 'newPasswordConfirm')->passwordInput(['placeholder' => 'Confirm New Password']) ?>

          <div class="form-group">
              <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
          </div>

          <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
  </div>
</div>