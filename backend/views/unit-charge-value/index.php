<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnitChargeValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unit Charge Values';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-charge-value-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">

                    <p>
                        <?php /* Html::a('Create Unit Charge Value', ['create'], ['class' => 'btn btn-success']) */?>
                    </p>
                    
                    <?= GridView::widget([
                        
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'showOnEmpty'=>true,
                        'columns' => [
                            
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute'=>'inv_number',
                                'value'=>'inv_number',
                            ],
                            'type',
                            [
                                'attribute'=>'unit_charge_id',
                                'label'=>'Unit',
                                'format'=>'raw',
                                'value'=>function($data){
                                    
                                    return Html::label($data->unitCode);
                                    
                                }
                            ],
                            [
                                'label'=>'Usage',
                                'format'=>['decimal',0],
                                'value'=>function($data){
                                    if($data->type <> 'ELECTRICITY' AND $data->type <> 'WATER'){
                                         return $data=null;
                                    }else{
                                         return $data->usageDelta;
                                    }    
                                    
                                }
                            ],
                            [
                                'label'=>'Tariiff',
                                'format'=>['currency', 'Rp.'],
                                'value'=>function($data){
                                    return $data->tariffFormula;
                                }
                            ],
                            [
                                'label'=>'PJU',
                                'format'=>'raw',
                                'value'=>function($data){
                                    return ($data->tariffFormula*$data->usageDelta)*($data->pju/100).' ('.$data->pju.'%)';
                                }
                            ],
                            
                            [
                                'label'=>'Value Charge',
                                'format'=>['currency', 'Rp.'],
                                'value'=>function($data){
                                 
                                    return $data->value_charge;
                                    
                                    
                                }
                            ],
                            'value_tax',
                            [
                                'label'=>'Value Admin',
                                'format'=>['currency', 'Rp.'],
                                'value'=>function($data){
                                    return $data->value_admin;
                                    
                                    
                                }
                            ],
                            // 'value_penalty',
                            // 'detail:ntext',
                            // 'charge_date',
                            // 'overdue:boolean',
                            // 'due_date',
                            // 'created_by',
                            // 'created_at',
                            // 'updated_by',
                            // 'updated_at',
                            [
                                'attribute'=>'charge_month',
                                'format'=>'raw',
                                'value'=>function($data){
                                    if($data->charge_month == 10){
                                        return 'October';
                                    }else if($data->charge_month == 11){
                                        return 'November';
                                    }
                                    else if($data->charge_month == 12){
                                        return 'December';
                                    }
                                    else if($data->charge_month == 1 ||  $data->charge_month == 01){
                                        return 'January';
                                    }
                                    else if($data->charge_month == 2 ||  $data->charge_month == 02){
                                        return 'February';
                                    }
                                    else if($data->charge_month == 3 ||  $data->charge_month == 03){
                                        return 'March';
                                    }
                                    else if($data->charge_month == 4 ||  $data->charge_month == 04){
                                        return 'April';
                                    }
                                    else if($data->charge_month == 5 ||  $data->charge_month == 05){
                                        return 'May';
                                    }
                                    else if($data->charge_month == 6 ||  $data->charge_month == 06){
                                        return 'June';
                                    }
                                    else if($data->charge_month == 7 ||  $data->charge_month == 07){
                                        return 'July';
                                    }
                                    else if($data->charge_month == 8 ||  $data->charge_month == 08){
                                        return 'August';
                                    }
                                    else if($data->charge_month == 9 ||  $data->charge_month == 09){
                                        return 'September';
                                    }
                                    
                                }
                            ],
                            [
                                'attribute'=>'charge_year',
                                'label'=>'Charge Year',
                                'format'=>'raw',
                                'value'=>'charge_year',
                            ],
                            [
                                'label'=>'Total Charge',
                                'format'=>['currency','Rp.'],
                                'value'=>function($data){
                                    
                                    return $data->value_charge+$data->value_admin;
                                    
                                }
                            ],
                            [

                            'class' => 'yii\grid\ActionColumn',
                            
                            ],

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
