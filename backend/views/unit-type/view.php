<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UnitType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Unit Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-type-view">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
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
                            'id',
                            'code:ntext',
                            'name:ntext',
                            
                            //'updated_by',
                            //'created_at',
                            //'created_by',
                            //'updated_at',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
