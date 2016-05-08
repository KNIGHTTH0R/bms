<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UnitMeter */

$this->title = 'Update Unit Meter: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Unit Meters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="unit-meter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
