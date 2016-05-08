<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use kartik\grid\GridView;
use kartik\date\DatePicker;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\JurnalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Journals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurnal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
               <div class="box-body">
                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i> Add New', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
                    </p>
                    <?php Pjax::begin(); ?>
                    <?php 
                        $gridColumns = [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute'=>'status',
                                'label'=>'Status',
                                'content'=>function($data){
                                    if($data->status == 20) return '<span class="danger">DRAFT</span>';
                                    if($data->status == 10) return '<span class="text-aqua">POSTED</span>';
                                    if($data->status == 30) return '<span class="text-red">VOID</span>';
                                }
                            ],
                            'code',
                            [
                                'attribute'=>'date',
                                'label'=>'Date',
                                'format'=>['date', 'php:d-m-Y']
                            ],
                            'description',
                            'ref',
                            [
                                'attribute'=>'debit',
                                'label'=>'Debit',
                                'content'=>function($data){
                                    return number_format($data->debit, 2, ',', '.');
                                }
                            ],
                            [
                                'attribute'=>'credit',
                                'label'=>'Credit',
                                'content'=>function($data){
                                    return number_format($data->credit, 2, ',', '.');
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'headerOptions'=>['width'=>'100'],
                                //'template'=>'{view} {update} {delete}',
				'template'=>'{view} {update}',
                                'buttons'=>[
                                    'update'=>function($url, $model){
                                        return Html::a('<i class="fa fa-edit"></i>', $url, ['class' => 'btn btn-xs btn-success', 'title'=>'Update', 'aria-label'=>'Update', 'data-pjax'=>'0']);
                                    },
                                    'view'=>function($url, $model){
                                        return Html::a('<i class="fa fa-eye"></i>', $url, ['class' => 'btn btn-xs btn-info', 'title'=>'View', 'aria-label'=>'View', 'data-pjax'=>'0']);
                                    },
                                    //'delete'=>function($url, $model){
                                    //    return Html::a('<i class="fa fa-times"></i>', $url, ['class' => 'btn btn-xs btn-danger', 'title'=>'Delete', 'aria-label'=>'Delete', 'data-confirm'=>'Are you sure you want to delete this item?', 'data-method'=>'post', 'data-pjax'=>'0']);
                                    //}
                                ],
                            ],
                        ];
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'rowOptions' => function($model){
                            if($model->status == 10) return ['class'=>'info'];
                            if($model->status == 20) return ['class'=>'warning'];
                            if($model->status == 30) return ['class'=>'danger'];
                        },
                        'columns' => $gridColumns,
                        'tableOptions'=>['class'=>'table table-striped table-bordered'],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
