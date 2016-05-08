<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UnitCharge */

$this->title = 'Update Unit Charge: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Unit Charges', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="unit-charge-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
