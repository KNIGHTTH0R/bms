<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TypeChargeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Type Charges';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-charge-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Type Charge', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            ['value'=>'name_type', 'label'=>'Name Of Charge'],
            ['value'=>'code_type', 'label'=>'Code Of Charge'],
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
