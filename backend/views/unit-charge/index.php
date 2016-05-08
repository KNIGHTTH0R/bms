<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnitChargeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unit Charges';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-charge-index">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i> Add New', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
                    </p>

                    <?= GridView::widget([
                        
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        // 'clientOptions' => [
                        //     "lengthMenu"=> [[10,-1], [10,Yii::t('app',"All")]],
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

                            [
                                'attribute'=>'unit',
                                'value'=>'unit.code',
                                'label'=>'Unit Code',

                            ],
                            [
                                'attribute'=>'type',
                                'value'=>'type',
                                'label'=>'Type Charge',

                            ],
                            [
                                'attribute'=>'tariff_id',
                                'value'=>'tariff.tariff_name',
                                'label'=>'Tariff',

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
