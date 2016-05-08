<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeGroup */

$this->title = $model->group_name;
$this->params['breadcrumbs'][] = ['label' => 'Employee Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-group-view">

    <h3 class="box-tittle" style="margin-top: -5px; margin-bottom:20px;"><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Index', ['index', 'id' => $model->idgroup], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->idgroup], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idgroup], [
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
            // 'idgroup',
            'group_name',
            [ 
                'label'=>'Basic Salary',
                'value'=>'Rp. '. number_format($model->basic_salary,0,',','.')
            ],
            [ 
                'label'=>'Overtime',
                'value'=>'Rp. '. number_format($model->overtime_value,0,',','.')
            ],
            [ 
                'label'=>'Transport Value',
                'value'=>'Rp. '. number_format($model->transport_value,0,',','.')
            ],
            [ 
                'label'=>'Meat Allowance',
                'value'=>'Rp. '. number_format($model->meal_allow,0,',','.')
            ],
            // 'allowance1',
            // 'allowance2',
            // 'allowance3',
        ],
    ]) ?>

</div>
