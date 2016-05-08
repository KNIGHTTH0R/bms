<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmployeeTransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-transaction-index">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
    <p>
        <?= Html::a('Create Employee Transaction', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_transaction',
            'idemployee',
            ['attribute'=>'atten_day'],
            'overtime_day:datetime',
            'debt_value',
            'emp_trans_month',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
</div>
</div>
</div>