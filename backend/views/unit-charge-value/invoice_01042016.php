<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnitChargeValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice Data';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-charge-value-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <?= GridView::widget([
                        
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            
                            ['class' => 'yii\grid\SerialColumn'],

                            'inv_number',
                            [
                                'attribute'=>'unit_code',
                                'value'=>'unit_code',
                                'headerOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'attribute'=>'personId',
                                'label'=>'Bill To',
                                'format'=>'raw',
                                'headerOptions' => ['class' => 'text-center'],
                                'value'=>function($data){
                                    
                                    return Html::label($data->personId->name);
                                    
                                }
                            ],
                            [
                                'attribute'=>'inv_month',
                                'label'=>'Charge Month',
                                'headerOptions' => ['class' => 'text-center'],
                                'format'=>'raw',
                                'value'=>function($data){
                                    
                                    if($data->inv_month == 10){
                                        return 'October';
                                    }else if($data->inv_month == 11){
                                        return 'November';
                                    }
                                    else if($data->inv_month == 12){
                                        return 'December';
                                    }
                                    else if($data->inv_month == 1 ||  $data->inv_month == 01){
                                        return 'January';
                                    }
                                    else if($data->inv_month == 2 ||  $data->inv_month == 02){
                                        return 'February';
                                    }
                                    else if($data->inv_month == 3 ||  $data->inv_month == 03){
                                        return 'March';
                                    }
                                    else if($data->inv_month == 4 ||  $data->inv_month == 04){
                                        return 'April';
                                    }
                                    else if($data->inv_month == 5 ||  $data->inv_month == 05){
                                        return 'May';
                                    }
                                    else if($data->inv_month == 6 ||  $data->inv_month == 06){
                                        return 'June';
                                    }
                                    else if($data->inv_month == 7 ||  $data->inv_month == 07){
                                        return 'July';
                                    }
                                    else if($data->inv_month == 8 ||  $data->inv_month == 08){
                                        return 'August';
                                    }
                                    else if($data->inv_month == 9 ||  $data->inv_month == 09){
                                        return 'September';
                                    }
                                    
                                }
                            ],
                            
                            [
                                'attribute'=>'charge_year',
                                'label'=>'Charge Year',
                                'format'=>'raw',
                                'value'=>'charge_year',
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label'=>'Print Invoice',
                                'format'=>'raw',
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['class' => 'text-center'],
                                'value'=>function($data){
                                    $url = 'index.php?r=unit-charge-value/print-inv&id='.$data->inv_number;
                                    return Html::a(Html::img('@web/images/print.png'), $url, ['title' => 'Print', 'img', 'target'=>'_blank']);
                                    
                                }
                            ],
                            // [
                            //     'label'=>'Invoice',
                            //     'format'=>'raw',
                            //     'value'=>function($data){
                            //         $url = 'index.php?r=invoice/view&id='.$data->inv_number;
                            //         return Html::a(Html::img('@web/images/pdf.png'), $url, ['title' => 'Detail', 'img', 'target'=>'_blank']);
                                    
                            //     }
                            // ],
                            [
                                'label'=>'Pay',
                                'format'=>'raw',
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['class' => 'text-center'],
                                'value'=>function($data){
                                    $url = 'index.php?r=pay-billing/create&invnumber='.$data->inv_number;
                                    return Html::a(Html::img('@web/images/edite.png'), $url, ['title' => 'Detail', 'img']);
                                    
                                }
                            ],
                            

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
