<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MeterRead */

$this->title = 'Update Meter Read: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Meter Reads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="meter-read-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'options' => $options
    ]) ?>

</div>
