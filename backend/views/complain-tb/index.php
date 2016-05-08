<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ComplainTbSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Complain';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complain-tb-index">
   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
    <h3 class="box-title" style="margin-top:0px; margin-bottom:20px"><?= Html::encode($this->title) ?></h3>
    <p>
        <?= Html::a('Create Complain Tb', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_complain',
            // 'id_unit',
            [
                'label'=>'Unit',
                'attribute'=>'code_unit'
            ],
            'date_complain_char',
            'complain:ntext',
            'solution:ntext',
            [
                'attribute'=>'user',    
                'label' => 'Staff',
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'format' => 'raw',
                'value' => function($data){
                    return $data->fullName->fullname;
                }
            ],
            'status_complain',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
</div>
</div>