<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProfileUser */

$this->title = 'Create Profile User for ' .  $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
