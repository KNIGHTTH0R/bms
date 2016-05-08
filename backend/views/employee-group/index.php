<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmployeeGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Employee Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idgroup',
            'group_name',
            'basic_salary',
            'overtime_value',
            'transport_value',
            // 'meal_allow',
            // 'allowance1',
            // 'allowance2',
            // 'allowance3',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
</div>
</div>