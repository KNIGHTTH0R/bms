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
                                        return null;
                                    }
                                }
                            ],
                            [
                                'attribute'=>'building_id',    
                                'value'=>'building.name',
                            ],
                            [
                                'attribute'=>'owner_id',
                                'value'=>'ownerName',
                            ],
                            [
                                'attribute'=>'tenant_id',
                                'value'=>'tenant.name',
                            ],
                            // 'unit_type_id',
                            'unit_floor:ntext',
                            'unit_num:ntext',
                            'space_size',
                            'space_unit:ntext',
                            // 'created_at',
                            // 'created_by',
                            [

                            'class' => 'yii\grid\ActionColumn',
                            // 'template' => '{update} {view}',
                            
                            ],

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
