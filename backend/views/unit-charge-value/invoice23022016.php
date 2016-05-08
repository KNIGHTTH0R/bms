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
                        // 'clientOptions' => [
                        //     "lengthMenu"=> [[8,-1], [8,Yii::t('app',"All")]],
                        //     "info"=>false,
                        //     "responsive"=>true, 
                        //     "dom"=> 'lfTrtip',
                        //     "tableTools"=>[
                        //         "aButtons"=> [  
                        //             [
                        //             "sExtends"=> "copy",
                        //             "sButtonText"=> Yii::t('app',"Copy to clipboard")
                        //             ],[
                        //             "sExtends"=> "csv",
                        //             "sButtonText"=> Yii::t('app',"Save to CSV")
                        //             ],[
                        //             "sExtends"=> "xls",
                        //             "oSelectorOpts"=> ["page"=> 'current']
                        //             ],[
                        //             "sExtends"=> "pdf",
                        //             "sButtonText"=> Yii::t('app',"Save to PDF")
                        //             ],[
                        //             "sExtends"=> "print",
                        //             "sButtonText"=> Yii::t('app',"Print")
                        //             ],
                        //         ]
                        //     ]
                        // ],
                        'columns' => [
                            
                            ['class' => 'yii\grid\SerialColumn'],

                            'inv_number',
                            [
                                'attribute'=>'unit_code',
                                'value'=>'unit_code',
                            ],
                            [
                                'attribute'=>'personId',
                                'label'=>'Bill To',
                                'format'=>'raw',
                                'value'=>function($data){
                                    
                                    return Html::label($data->personId->name);
                                    
                                }
                            ],
                            
                            [
                                'attribute'=>'charge_month',
                                'label'=>'Charge Month',
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
                                'label'=>'Invoice',
                                'format'=>'raw',
                                'value'=>function($data){
                                    $url = 'index.php?r=invoice/view&id='.$data->inv_number;
                                    return Html::a(Html::img('@web/images/pdf.png'), $url, ['title' => 'Detail', 'img', 'target'=>'_blank']);
                                    
                                }
                            ],
                            [
                                'label'=>'Pay',
                                'format'=>'raw',
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
