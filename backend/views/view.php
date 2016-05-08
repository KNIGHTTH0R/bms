<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Tariff */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tariffs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tariff-view">

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
                            'property_id',
                            'type',
                            'recurring:boolean',
                            'recur_period',
                            'recur_date',
                            'recur_month',
                            'progressive:boolean',
                            'meter_unit',
                            'formula',
                            'progressive_formula',
                            'tax:boolean',
                            'tax_formula',
                            'admin_charge:boolean',
                            'admin_formula',
                            'created_by',
                            'created_at',
                            'updated_by',
                            'updated_at',
                            'penalty:boolean',
                            'penalty_formula',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
