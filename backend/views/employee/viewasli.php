<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Employee */

$this->title = $model->idemployee;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idemployee], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idemployee], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <h1><?= Html::img('@web/'.$model->photo, ['alt'=>'some', 'class' => 'img-circle', 'style'=>'width:150px']) ?></h1>

    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idemployee',
            'nip',
            'name_employee',
            'address_employee:ntext',
            'phone_employee',
            'email_employee:email',
            'gender',
            'religion',
            'pob',
            'dob',
            'section',
            'position',
            'marital_status',
            'work_status',
            'start_work',
            // 'photo',
            'idgroup',
        ],
    ]) ?>

</div>
