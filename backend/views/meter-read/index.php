<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;
use kartik\export\ExportMenu;
use backend\models\MeterRead;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MeterReadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Meter Reads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meter-read-index">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">

                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i> Add New', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                        <?= Html::a('<i class="fa fa-cloud-upload"></i> Upload Excel', ['upload'], ['class' => 'btn btn-warning btn-sm']) ?>
                        <?= Html::a('<i class="fa fa-download"></i> Download Prev Electric', ['download-electric'], ['class' => 'btn btn-primary btn-sm']) ?>
                        <?= Html::a('<i class="fa fa-download"></i> Download Prev Water', ['download-water'], ['class' => 'btn btn-info btn-sm']) ?>
                    </p>

                    <?= GridView::widget([
                        
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pager' => [
                            'firstPageLabel'=>'First',
                            'lastPageLabel'=>'Last',
                            'nextPageLabel'=>'Next',
                            'prevPageLabel'=>'Prev'
                        ],

                        'columns' => [
                            
                            ['class' => 'yii\grid\SerialColumn'],

                            // [   'attribute'=>'id',
                            //     'value'=>'id',
                            //     'contentOptions' =>['style'=>'width:100px;'],
                            // ],
                            'type',
                            [
                            'value' => 'date_read',
                            'format' =>  ['date', 'php:d-m-Y'],
                            'label'=>'Date Read',
                            'attribute' => 'date_read',
                            ],
                            
                            [
                                'attribute'=>'prev_value',
                                'value'=>'prev_value',
                                'contentOptions' =>['style'=>'width:80px;']
                            ],
                            [
                                'attribute'=>'cur_value',
                                'value'=>'cur_value',
                                'contentOptions' =>['style'=>'width:80px;']
                            ],
                            [
                                'value'=>'delta', 
                                'attribute' => 'delta',
                                'label' => 'Usage',
                                'contentOptions' =>['style'=>'width:80px;']
                            ],

                            'status',
                            // 'created_by',
                            // 'created_at',
                            // 'updated_by',
                            // 'updated_at',
                            // 'unit_meter_id',
                            [
                                'label'=>'Unit',
                                'content'=>function($d){
                                    return $d->unitCode;
                                },
                                'attribute'=>'unitCode',

                            ],
                            [

                            'class' => 'yii\grid\ActionColumn',
                            'contentOptions' =>['style'=>'width:80px;']
                            ],

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
