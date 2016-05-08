<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReportBalanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jurnal Children';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurnal-child-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Jurnal Child', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_jur',
            'id_coa',
            'date',
            'amount',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',
            // 'dc',
            // 'description',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
