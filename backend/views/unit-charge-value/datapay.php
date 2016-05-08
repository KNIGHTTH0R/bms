<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnitChargeValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Data '.date('F').' '.date('Y');

?>
<div class="unit-charge-value-index">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
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
                           
                            [
                                'attribute'=>'unit_code',
                                'value'=>'unit_code',
                                'headerOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'attribute'=>'inv_month',
                                'label'=>'Invoice Month',
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
                                'label'=>'Invoice Year',
                                'format'=>'raw',
                                'value'=>function($data){
                                    return $data->charge_year;
                                },
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['class' => 'text-center'],
                            ],                            
                            [
                                'label'=>'Charge Value',
                                'attribute'=>'total_charge',
                                'format'=>'raw',
                                'value'=>function($data){
                                    $tcharge = 'Rp. '.number_format($data->value_charge,0,',','.').',-';
                                    return $tcharge;
                                    
                                }
                            ],
                        ],
                        
                    ]); 
                    $total=0;
                    foreach ($modelPay as $modelPay) {
                        $total += $modelPay->value_charge;
                    }
                    echo '<table class="table table-striped" style="margin-top:-18px">
                    
                    <tr style="background-color:#d4edfb">
                      <td style="width:87%; text-align:left">Total</td>
                      <td><strong>Rp. '.number_format($total,0,',','.').',-</strong></td>
                      
                    </tr>
                    
                  </table>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
