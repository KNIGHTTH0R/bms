<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PersonAddress */

$this->title = 'Update Person Address: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Person Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="person-address-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
