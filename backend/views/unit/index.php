<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Units';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-index">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">

                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i> Add New', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
                        <?= Html::a('<i class="fa fa-cloud-upload"></i> Upload Excel File', ['upload-unit'], ['class' => 'btn btn-warning btn-xs']) ?>
                    </p>

                    <?= GridView::widget([
                        
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'showOnEmpty'=>true,
                        'columns' => [
                            
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                            'attribute' => 'code',
                            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                            //'value' => 'code',
                            'format' => 'raw',
                            'value'=>function($data){
                                    if(isset($data->owner->id)){
                                        $url = 'index.php?r=unit/detail-unit&id='.$data->id;
                                        return Html::a($data->code, $url, ['title' => $data->code]);
                                    } else {
                                        return $data->code;
                                    }
                                }
                            ],
                            [
                                'attribute'=>'building_id',    
                                'value'=>'building.name',
                                'headerOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'attribute'=>'owner_id',
                                'value'=>'ownerName',
                                'headerOptions' => ['style' => 'width:200px', 'class' => 'text-center'],
                            ],
                            [
                                'attribute'=>'tenant_id',
                                'value'=>'tenant.name',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            // 'unit_type_id',
                            [
                                'attribute'=>'unit_floor',
                                'headerOptions' => ['class' => 'text-center'],
                                'label'=>'Unit Floor',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'attribute'=>'unit_num',
                                'headerOptions' => ['class' => 'text-center'],
                                'label'=>'Unit Number',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'attribute'=>'space_size',
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['class' => 'text-center'],
                                'value'=>function($data){
                                    return $data->space_size.' '.$data->space_unit;
                                }
                            ],
                            [
                                'attribute'=>'isoccupied',
                                'label'=>'Occupancy Status',
                                'value'=>function($data){
                                    if($data->isoccupied==TRUE){
                                        return 'Occupied';
                                        
                                    }else{
                                        return 'Empty';                                      
                                    }
                                }
                            ],
                            [
                                'label'=>'Edit Owner',
                                'format'=>'raw',
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['class' => 'text-center'],
                                'value'=>function($data){
                                    $url = 'index.php?r=unit/editowner&id='.$data->id;
                                    return Html::a(Html::img('@web/images/edite.png'), $url, ['title' => 'Detail', 'img']);
                                    
                                }
                            ],
                            [
                                'label'=>'Edit Tenant',
                                'format'=>'raw',
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['class' => 'text-center'],
                                'value'=>function($data){
                                    $url = 'index.php?r=unit/edit-tenant&id='.$data->id;
                                    return Html::a(Html::img('@web/images/edite.png'), $url, ['title' => 'Detail', 'img']);
                                    
                                }
                            ],
                            
                            // 'created_at',
                            // 'created_by',
                            [

                            'class' => 'yii\grid\ActionColumn',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['style' => 'width:70px'],
                            // 'template' => '{update} {view}',
                            
                            ],

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
