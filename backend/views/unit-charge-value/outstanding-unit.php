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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
                    <?= DataTables::widget([           
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'clientOptions' => [
                            "lengthMenu"=> [[8,-1], [8,Yii::t('app',"All")]],
                            "info"=>false,
                            "responsive"=>true, 
                            "dom"=> 'lfTrtip',
                            "tableTools"=>[
                                "aButtons"=> [  
                                    [
                                    "sExtends"=> "copy",
                                    "sButtonText"=> Yii::t('app',"Copy to clipboard")
                                    ],[
                                    "sExtends"=> "csv",
                                    "sButtonText"=> Yii::t('app',"Save to CSV")
                                    ],[
                                    "sExtends"=> "xls",
                                    "oSelectorOpts"=> ["page"=> 'current']
                                    ],[
                                    "sExtends"=> "pdf",
                                    "sButtonText"=> Yii::t('app',"Save to PDF")
                                    ],[
                                    "sExtends"=> "print",
                                    "sButtonText"=> Yii::t('app',"Print")
                                    ],
                                ]
                            ]
                        ],
                        'columns' => [
                            
                            ['class' => 'yii\grid\SerialColumn'],

                            'inv_number',
                            'unit_code',
                            [
                                'label'=>'Total Charge',
                                'format'=>'raw',
                                'value'=>function($data){
                                    $tcharge = 'Rp. '.number_format($data->total_charge,0,',','.').',-';
                                    return $tcharge;
                                    
                                }
                            ],
                            [
                                'label'=>'Total Pay',
                                'format'=>'raw',
                                'value'=>function($data){
                                    $tcharge = 'Rp. '.number_format($data->total_pay,0,',','.').',-';
                                    return $tcharge;
                                    
                                }
                            ],
                            [
                                'label'=>'Balance Value',
                                'format'=>'raw',
                                'value'=>function($data){
                                    $tcharge = 'Rp. '.number_format($data->balance_value,0,',','.').',-';
                                    return $tcharge;
                                    
                                }
                            ],
                            'status_pay',
                            [
                                'label'=>'Invoice',
                                'format'=>'raw',
                                'value'=>function($data){
                                    $url = 'index.php?r=invoice/view&id='.$data->inv_number;
                                    return Html::a(Html::img('@web/images/pdf.png'), $url, ['title' => 'Detail', 'img']);
                                    
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
                

