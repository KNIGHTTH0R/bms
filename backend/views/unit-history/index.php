<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnitHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unit Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Unit History', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'unit_id',
            'person_id',
            'data:ntext',
            'as_owner:boolean',
            // 'date_start',
            // 'date_end',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
