<?php

use kartik\grid\GridView;
use kartik\helpers\Html;
use backend\models\CoaSearch;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReportTrialBalanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Trial Balances';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-trial-balance-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'showPageSummary'=>true,
        'columns' => [
            [
                'attribute'=>'coaTypeName',
                'value'=>function($model, $key, $index, $widget){
                    return $model->coaTypeName;
                },
                'group'=>true,
            ],
            [
                'attribute'=>'coaCode',
                'value'=>function($model, $key, $index, $widget){
                    return $model->coaCode;
                },
                'group'=>true,
            ],
            [
                'attribute'=>'coaName',
                'value'=>function($model, $key, $index, $widget){
                    return $model->coaName;
                },
                'group'=>true,
            ],
            [
                'attribute'=>'debit',
                'value'=>function($model, $key, $index, $widget){
                    return $model->amountDebit;
                },
                'group'=>true,
            ],
            [
                'attribute'=>'credit',
                'value'=>function($model, $key, $index, $widget){
                    return $model->amountCredit;
                },
                'group'=>true,
            ]
            // [
            //     'attribute'=>'amount',
            //     'value'=>function($model, $key, $index, $widget){
            //         return $model->amount;
            //     },
            //     'pageSummary'=>true,
            // ],
        ],
    ]); ?>

</div>
