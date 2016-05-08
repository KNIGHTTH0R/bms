<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Unit */

$this->title ='Detail Unit : '. $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-view">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

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
            ['label'=>'Building', 'value'=>$model->building->name],
            //'updated_at',
            //'updated_by',
            //['label'=>'Owner', 'value'=>$personName->name],
            [
                'attribute'=>'owner_id',
                'value'=>$model->ownerName,
            ],
            [
                'attribute'=>'tenant_id',
                'value'=>$model->tenantName,
            ],
            ['label'=>'Unit Type', 'value'=>$model->unitType->name],
            'code:ntext',
            [
                'attribute' => 'power',
                'value' => $model->getPowerLabel($model->power),
            ],
            'va',
            'unit_floor:ntext',
            'unit_num:ntext',
            'space_size',
            'space_unit:ntext',
            //'created_at',
            //'created_by',
        ],
    ]) ?>

</div>
<?php //var_dump($model->powerName); die(); ?>