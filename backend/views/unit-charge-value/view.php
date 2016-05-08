<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\UnitChargeValue;

/* @var $this yii\web\View */
/* @var $model app\models\UnitChargeValue */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Unit Charge Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-charge-value-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
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
                            'type',
                            'unit_charge_id',
                            'value_charge',
                            'value_tax',
                            'value_admin',
                            'value_penalty',
                            'detail:ntext',
                            'charge_date',
                            'overdue:boolean',
                            'due_date',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at',
                            'charge_month',
                            'charge_year',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
