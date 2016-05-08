<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UnitMeter */

$this->title = $model->unit->code;
$this->params['breadcrumbs'][] = ['label' => 'Unit Meters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-meter-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <p>
                        <?= Html::a('Index', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
                            'unitCode',
                            'type',
                            'meter_number',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
