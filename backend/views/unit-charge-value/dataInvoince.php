<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnitChargeValueSearch */
/* @var $datasProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice Data';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-charge-value-index">

    <h3 style="margin-top:-5px; font-weight:bold; margin-bottom:20px"><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box-body">
    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Invoice Number</th>
                                <th>Unit Code</th>
                                <th>Bill To</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Pay</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php
                            foreach ($data as $datas) {
                                echo '<tr>
                                        <td>'.$datas->inv_number.'</td>
                                        <td>'.$datas->unit_code.'</td>
                                        <td>'.$datas->NamePerson.'</td>
                                        <td>';
                    if($datas->charge_month == 10){
                        echo 'October';
                    }else if($datas->charge_month == 11){
                        echo 'November';
                    }
                    else if($datas->charge_month == 12){
                        echo 'December';
                    }
                    else if($datas->charge_month == 1 ||  $datas->charge_month == 01){
                        echo 'January';
                    }
                    else if($datas->charge_month == 2 ||  $datas->charge_month == 02){
                        echo 'February';
                    }
                    else if($datas->charge_month == 3 ||  $datas->charge_month == 03){
                        echo 'March';
                    }
                    else if($datas->charge_month == 4 ||  $datas->charge_month == 04){
                        echo 'April';
                    }
                    else if($datas->charge_month == 5 ||  $datas->charge_month == 05){
                        echo 'May';
                    }
                    else if($datas->charge_month == 6 ||  $datas->charge_month == 06){
                        echo 'June';
                    }
                    else if($datas->charge_month == 7 ||  $datas->charge_month == 07){
                        echo 'July';
                    }
                    else if($datas->charge_month == 8 ||  $datas->charge_month == 08){
                        echo 'August';
                    }
                    else if($datas->charge_month == 9 ||  $datas->charge_month == 09){
                        echo 'September';
                    } echo '</td>
                                        <td>'.$datas->charge_year.'</td>';
                                        $url = 'index.php?r=bill-inv/create&id='.$datas->inv_number;
                                        echo '
                                        <td>'.Html::a(Html::img('@web/images/edite.png'), $url, ['title' => 'Detail', 'img']).'</td>
                                      </tr>  
                                ';
                            }
                        ?>
                            
                        </tbody>
    </table>                    
    </div>
</div>
<?php 
    $this->registerJs('');

?>