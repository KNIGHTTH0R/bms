<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TariffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tariffs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tariff-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">

                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i> Add New', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
                    </p>

                    <?= DataTables::widget([
                        
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'clientOptions' => [
                            "lengthMenu"=> [[20,-1], [20,Yii::t('app',"All")]],
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

                            //'id',
                            ['value'=>'property.name', 'label'=>'Property Name'],
                            ['value'=>'type', 'label'=>'Charge Type'],
                            ['value'=>'tariff_name', 'label'=>'Name'],
                            'recurring:boolean',
                            'recur_period',
                            'recur_date',
                            // 'recur_month',
                            // 'progressive:boolean',
                            'meter_unit',
                            // 'formula',
                            // 'progressive_formula',
                            'tax:boolean',
                            // 'tax_formula',
                            'admin_charge:boolean',
                            // 'admin_formula',
                            // 'created_by',
                            // 'created_at',
                            // 'updated_by',
                            // 'updated_at',
                            // 'penalty:boolean',
                            // 'penalty_formula',

                            [

                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {view}',
                            
                            ],

                        ],
                    ]); ?>
            </div>
            </div>
        </div>
    </div>
</div>
