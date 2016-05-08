<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CoaTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Coa Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coa-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Coa Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'type',
            'name',
            [
		'class' => 'yii\grid\ActionColumn',
		'template' => '{update} {view}',
	    ],
        ],
    ]); ?>

</div>
