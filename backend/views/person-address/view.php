<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PersonAddress */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Person Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-address-view">

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
            'id',
            'person_id',
            'postal_code:ntext',
            'phone:ntext',
            'fax:ntext',
            'name:ntext',
            'for_billing:boolean',
            'for_letternotif:boolean',
            'building:ntext',
            'street:ntext',
            'city:ntext',
            'province:ntext',
            'country:ntext',
        ],
    ]) ?>

</div>
