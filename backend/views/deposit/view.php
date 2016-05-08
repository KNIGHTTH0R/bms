<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Coa */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Deposit', 'url' => ['index']];
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
            'name',
            'bank_acc_number',
            'bank_acc_name',
        ],
    ]) ?>

</div>
