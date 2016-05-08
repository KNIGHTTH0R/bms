<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Coa */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Coas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coa-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'code',
            'name',
            [
                'label'=>'Parent',
                'value'=>$model->parentCode ? $model->parentCode : ' - ',
            ],
            [
                'label'=>'Type',
                'value'=>$model->coatype['name'] ? $model->coatype['name'] : ' - ',
            ],
            [
                'label'=>'Debit/Credit',
                'value'=>$model->getDkLabel($model->debet_credit),
            ],
        ],
    ]) ?>

</div>
