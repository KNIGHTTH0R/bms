<?php

//use yii\helpers\Html;
//use yii\grid\GridView;

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReportLedgerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ledger';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurnal-child-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
        //echo $this->render('_search', ['model' => $searchModel]); 
        // $gridColumns = [
        //     'code',
        //     'name',
        //     [
        //         'attribute'=>'debit',
        //         'label'=>'Debit',
        //         'format' => ['decimal', 0],
        //         'hAlign'=>'right',
        //         // 'format' => ['currency'],
        //         'pageSummary' => true,
        //         'value' => function($data){
        //             if($data->debit!=0)
        //                 return $data->debit;
        //             else
        //                 return 0;
        //         },
        //     ],
        //     [
        //         'attribute'=>'credit',
        //         'label'=>'Credit',
        //         'format' => ['decimal', 0],
        //         'hAlign'=>'right',
        //         // 'format' => ['currency'],
        //         'pageSummary' => true,
        //         'value' => function($data){
        //             if($data->debit!=0)
        //                 return $data->debit;
        //             else
        //                 return 0;
        //         }
        //     ],
        // ];

        // $fullExportMenu = ExportMenu::widget([
        //     'dataProvider' => $dataProvider,
        //     'columns' => $gridColumns,
        //     'target' => ExportMenu::TARGET_BLANK,
        //     'fontAwesome' => true,
        //     'asDropdown' => false, // this is important for this case so we just need to get a HTML list    
        //     'dropdownOptions' => [
        //         'label' => '<i class="glyphicon glyphicon-export"></i> Full'
        //     ],
        // ]);
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
               <div class="box-body">
                    <?php // echo GridView::widget([
                        // 'dataProvider' => $dataProvider,
                        // 'columns' => $gridColumns,
                        // 'pjax' => true,
                        // // 'toolbar' => [
                        // //     '{export}',
                        // // ],
                        // // 'export' => [
                        // //     'fontAwesome' => true,
                        // //     'itemsAfter'=> [
                        // //         '<li role="presentation" class="divider"></li>',
                        // //         '<li class="dropdown-header">Export All Data</li>',
                        // //         $fullExportMenu
                        // //     ]
                        // // ],
                        // 'showPageSummary'=>true,
                        // // 'panel' => [
                        //     'type' => GridView::TYPE_PRIMARY,
                        // ],
                        // 'exportConfig' => [
                        //     GridView::CSV => ['label' => 'CSV'],
                        //     GridView::HTML => ['label' => 'HTML'],
                        //     GridView::PDF => ['label' => 'PDF'],
                        //     GridView::EXCEL => ['label' => 'Excel'],
                        // ]
                    // ]); ?>
                    <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>COA</th>
                            <th>Name</th>
                            <th>Debit</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($dataProvider->models as $model) {?>
                        <tr>
                            <td><?= $model->code ?></td>
                            <td><?= $model->name ?></td>
                            <td class="text-right"><?= Yii::$app->formatter->format($model->debit ? $model->debit : 0, ['decimal', 0]) ?></td>
                            <td class="text-right"><?= Yii::$app->formatter->format($model->credit ? $model->credit : 0, ['decimal', 0]) ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr style="text-align: right; font-weight: bold;">
                            <td colspan="2">Total</td>
                            <td>
                                <?php
                                    $sumc = 0; 
                                    foreach ($dataProvider->models as $key) {
                                        $sumc += $key->debit;
                                    }
                                    echo Yii::$app->formatter->format($sumc, ['decimal', 0]);
                                ?>
                            </td>
                            <td>
                                <?php
                                    $sumc = 0; 
                                    foreach ($dataProvider->models as $key) {
                                        $sumc += $key->credit;
                                    }
                                    echo Yii::$app->formatter->format($sumc, ['decimal', 0]);
                                ?>
                            </td>
                        </tr>
                    </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
