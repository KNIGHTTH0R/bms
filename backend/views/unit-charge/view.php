<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UnitCharge */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Unit Charges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-charge-view">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'unit.code',
            'unitMeter.type',
            'tariff.tariff_name',
            'created_by',
            'created_at:datetime',
            'updated_by',
            'updated_at:datetime',
            'bill_to',
        ],
    ]) ?>

</div>
