<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use fedemotta\datatables\DataTables;
use backend\models\Coa;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CoaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Deposit Account';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i> Add New Bank', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
                    </p>
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
                            'bank_acc_number',
                            'bank_acc_name',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'update' => function($url, $model){
                                        return Html::a('<i class="fa fa-edit"></i> edit', $url, ['class' => 'btn btn-xs btn-success', 'title'=>'Update', 'aria-label'=>'Update', 'data-pjax'=>'0']);
                                    },
                                    'delete' => function($url, $model){
                                        return Html::a('<i class="fa fa-times"></i> del', $url, ['class' => 'btn btn-xs btn-danger', 'title'=>'Delete', 'aria-label'=>'Delete', 'data-confirm'=>'Are you sure you want to delete this item?', 'data-method'=>'post', 'data-pjax'=>'0']);
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>