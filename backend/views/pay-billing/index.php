<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PayBillingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pay Billings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-billing-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pay Billing', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'unit_code:ntext',
            'unit_charge_value_id',
            'total_charge',
            [
                                'label'=>'Use Period',
                                'format'=>'raw',
                                'value'=>function($data){
                                    $kalender = CAL_GREGORIAN;

                                    if($data->tariffPeriod=='MONTH'){
                                        
                                        $jumbul = $data->unitChargeValue->charge_month;
                                        $jumtah = $data->unitChargeValue->charge_year;
                                        $hari = cal_days_in_month($kalender, $jumbul, $jumtah);
                                        
                                    }
                                    elseif($data->tariffPeriod=='3MONTH'){
                                        $jumbul1 = $data->unitChargeValue->charge_month;
                                        $jumbul2 = $data->unitChargeValue->charge_month-1;
                                        $jumbul3 = $data->unitChargeValue->charge_month-2;

                                        $jumtah = date('Y');
                                        $hari1 = cal_days_in_month($kalender, $jumbul1, $jumtah);
                                        $hari2 = cal_days_in_month($kalender, $jumbul2, $jumtah);
                                        $hari3 = cal_days_in_month($kalender, $jumbul3, $jumtah);
                                        $hari = $hari1+$hari2+$hari3;    
                                    }
                                    elseif($data->tariffPeriod=='6MONTH'){
                                        $jumbul1 = $data->unitChargeValue->charge_month;
                                        $jumbul2 = $data->unitChargeValue->charge_month-1;
                                        $jumbul3 = $data->unitChargeValue->charge_month-2;
                                        $jumbul4 = $data->unitChargeValue->charge_month-3;
                                        $jumbul5 = $data->unitChargeValue->charge_month-4;
                                        $jumbul6 = $data->unitChargeValue->charge_month-5;

                                        $jumtah = date('Y');
                                        $hari1 = cal_days_in_month($kalender, $jumbul1, $jumtah);
                                        $hari2 = cal_days_in_month($kalender, $jumbul2, $jumtah);
                                        $hari3 = cal_days_in_month($kalender, $jumbul3, $jumtah);
                                        $hari4 = cal_days_in_month($kalender, $jumbul4, $jumtah);
                                        $hari5 = cal_days_in_month($kalender, $jumbul5, $jumtah);
                                        $hari6 = cal_days_in_month($kalender, $jumbul6, $jumtah);

                                        $hari = $hari1+$hari2+$hari3+$hari4+$hari5+$hari6;    
                                    }else if($data->tariffPeriod=='YEAR'){

                                        $jumbul1 = $data->unitChargeValue->charge_month;
                                        $jumbul2 = $data->unitChargeValue->charge_month-1;
                                        $jumbul3 = $data->unitChargeValue->charge_month-2;
                                        $jumbul4 = $data->unitChargeValue->charge_month-3;
                                        $jumbul5 = $data->unitChargeValue->charge_month-4;
                                        $jumbul6 = $data->unitChargeValue->charge_month-5;
                                        $jumbul7 = $data->unitChargeValue->charge_month-6;
                                        $jumbul8 = $data->unitChargeValue->charge_month-7;
                                        $jumbul9 = $data->unitChargeValue->charge_month-8;
                                        $jumbul10 = $data->unitChargeValue->charge_month-9;
                                        $jumbul11 = $data->unitChargeValue->charge_month-10;
                                        $jumbul12 = $data->unitChargeValue->charge_month-11;

                                        $jumtah = date('Y');
                                        $hari1 = cal_days_in_month($kalender, $jumbul1, $jumtah);
                                        $hari2 = cal_days_in_month($kalender, $jumbul2, $jumtah);
                                        $hari3 = cal_days_in_month($kalender, $jumbul3, $jumtah);
                                        $hari4 = cal_days_in_month($kalender, $jumbul4, $jumtah);
                                        $hari5 = cal_days_in_month($kalender, $jumbul5, $jumtah);
                                        $hari6 = cal_days_in_month($kalender, $jumbul6, $jumtah);
                                        $hari7 = cal_days_in_month($kalender, $jumbul7, $jumtah);
                                        $hari8 = cal_days_in_month($kalender, $jumbul8, $jumtah);
                                        $hari9 = cal_days_in_month($kalender, $jumbul9, $jumtah);
                                        $hari10 = cal_days_in_month($kalender, $jumbul10, $jumtah);
                                        $hari11 = cal_days_in_month($kalender, $jumbul11, $jumtah);
                                        $hari12 = cal_days_in_month($kalender, $jumbul12, $jumtah);

                                        $hari = $hari1+$hari2+$hari3+$hari4+$hari5+$hari6+$hari7+$hari8+$hari9+$hari10+$hari11+$hari12;   
                                    }

                                    $newdate = strtotime('-'.$hari.' day',$data->unitChargeValue->charge_date);
                                    return Html::label(date('d M', $newdate).' - '.date('d M Y', $data->unitChargeValue->charge_date-1));

                                    
                                }
                            ],
            // 'balance_value',
            // 'status_pay',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
