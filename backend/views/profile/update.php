<?php

use yii\helpers\Html;
use frontend\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model backend\models\ProfileUser */

$this->title = 'Update ' .  $model->user->username . "'s Profile";
$this->params['breadcrumbs'][] = ['label' => 'Profile Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profile-user-update">

  <?= Alert::widget() ?>
  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>
        
</div>
