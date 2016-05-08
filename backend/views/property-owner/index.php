<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Json;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PropertyOwnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Property Owners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-owner-index">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
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

                            'code:ntext',
                            'name:ntext',
                            'tax_reg:ntext',
                            [
                            'label' => 'Address',
                            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                            'value' => function ($data) {
                                $add = json_decode($data->address);
                                return $add->building_name.', '.$add->street.'. '.$add->Province; // $data['name'] for array data, e.g. using SqlDataProvider.
                                //return $data->address;
                            },
                            
                            ],
                            [
                            'label' => 'Phone',
                            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                            'value' => function ($data) {
                                $add = json_decode($data->address);
                                return $add->phone;
                                //return $data->address;
                            },
                            
                            ],
                            [
                            'label' => 'Fax',
                            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                            'value' => function ($data) {
                                $add = json_decode($data->address);
                                return $add->fax;
                                //return $data->address;
                            },
                            
                            ],
                            //'created_at',
                            // 'created_by',
                            // 'updated_at',
                            // 'updated_by',
                            // 'id',

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
