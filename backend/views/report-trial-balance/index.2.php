<?php

// use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\helpers\Html;
use backend\models\Coa;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReportTrialBalanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Trial Balances';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-trial-balance-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?php //Html::a('Create Report Trial Balance', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

     <?php   //echo GridView::widget([
    //     'dataProvider' => $dataProvider,
    //     'filterModel' => $searchModel,
    //     'hover' => true,
    //     'columns' => [
    //         [
    //             'attribute'=>'coa.type',
    //             'label' => 'Type',
    //             'value' => 'coaType.name',
    //             'width'=>'150px',
    //             // 'format'=>['decimal', 0],
    //             'group' => true,
    //             'groupHeader' => function($model, $key, $index, $widget) {
    //                 return [
    //                     'mergeColumns' => [[0,4]],
    //                     'content' => [
    //                         0 => 'Summary (' . $model->coaType->name . ')',
    //                         5 => GridView::F_SUM,
    //                         6 => GridView::F_SUM,
    //                     ],
    //                     'contentFormats'=>[      // content reformatting for each summary cell
    //                         5=>['format'=>'number', 'decimals'=>0, 'decPoint'=>',', 'thousandSep'=>'.'],
    //                         6=>['format'=>'number', 'decimals'=>0, 'decPoint'=>',', 'thousandSep'=>'.'],
    //                     ],
    //                     'contentOptions'=>[      // content html attributes for each summary cell
    //                         1=>['style'=>'font-variant:small-caps'],
    //                         5=>['style'=>'text-align:right'],
    //                         6=>['style'=>'text-align:right'],
    //                     ],
    //                     // html attributes for group summary row
    //                     'options'=>['class'=>'danger','style'=>'font-weight:bold;']
    //                 ];
    //             },
                
    //         ],
    //         [
    //             'attribute'=>'coaParent.code',
    //             'label' => 'Acc. No.',
    //             'value' => 'coaParent.code',
    //             'width'=>'100px',
    //             'group' => true,
    //         ],
    //         [
    //             'attribute'=>'coaParent.name',
    //             'label' => 'Parent',
    //             'value' => 'coaParent.name',
    //             'width'=>'250px',
    //             // 'format'=>['decimal', 0],
    //             'group' => true,
    //             'subGroupOf'=>0,
    //             'groupFooter' => function($model, $key, $index, $widget) {
    //                 return [
    //                     'mergeColumns' => [[1,4]],
    //                     'content' => [
    //                         2 => 'Summary (' . $model->coaParent->name . ' / ' . $model->coaParent->code . ')',
    //                         5 => GridView::F_SUM,
    //                         6 => GridView::F_SUM,
    //                     ],
    //                     'contentFormats'=>[      // content reformatting for each summary cell
    //                         5=>['format'=>'number', 'decimals'=>0, 'decPoint'=>',', 'thousandSep'=>'.'],
    //                         6=>['format'=>'number', 'decimals'=>0, 'decPoint'=>',', 'thousandSep'=>'.'],
    //                     ],
    //                     'contentOptions'=>[      // content html attributes for each summary cell
    //                         5=>['style'=>'text-align:right'],
    //                         6=>['style'=>'text-align:right'],
    //                     ],
    //                     // html attributes for group summary row
    //                     'options'=>['class'=>'success','style'=>'font-weight:bold;']
    //                 ];
    //             },
    //         ],
    //         [
    //             'attribute'=>'id_coa',
    //             'label' => 'Acc. No',
    //             'value' => 'coa.code',
    //             'width'=>'100px',
    //         ],
    //         [
    //             'attribute'=>'id_coa',
    //             'label' => 'Name',
    //             'value' => 'coa.name',

    //         ],
    //         [
    //             'attribute'=>'debitAmount',
    //             'label' => 'Debit',
    //             'value' => 'debitAmount',
    //             // 'value' => function($data) {
    //             //     return number_format($data->debitAmount, 2, '.', ',');
    //             // },
    //             'hAlign'=>'right',
    //             'format' => ['currency'],
    //             // 'format'=>['decimal', 0],
    //             // 'format' => ['integer']
    //         ],
    //         [
    //             'attribute'=>'creditAmount',
    //             'label' => 'Credit',
    //             'value' => 'creditAmount',
    //             // 'value' => function($data) {
    //             //     return number_format($data->creditAmount, 2, '.', ',');
    //             // },
    //             'hAlign'=>'right',
    //             'format' => ['currency'],
    //             // 'format'=>['decimal', 0],
    //             // 'format' => ['integer']
    //         ],
    //     ],
    // ]); 
    ?>

    <?php 
        // echo GridView::widget([
        //     'dataProvider' => $dataProvider,
        //     'summary'=>'',
        //     'showHeader' => false,
        //     'tableOptions' =>['class' => 'table table-striped table-bordered table-condensed'],
        //     'columns' => [
        //         [
        //             'attribute' => 'coaType.name',
        //             'label' => 'Type',
        //             'value' => function($data){
        //                 return $data->coaType->name;
        //             },
        //             // 'width'=>'150px',
        //             'options' => ['width' => '150']
        //             // 'group' => true,
        //         ],
        //         [
        //             'attribute'=>'coaParent.code',
        //             'label' => 'Acc. No.',
        //             'value' => 'coaParent.code',
        //             'options' => ['width' => '100']
        //             // 'width'=>'100px',
        //             // 'group' => true,
        //         ],
        //         [
        //             'attribute'=>'coaParent.name',
        //             'label' => 'Parent',
        //             'value' => 'coaParent.name',
        //             'options' => ['width' => '250']
        //             // 'width'=>'250px',
        //             // 'group' => true,
        //         ],
        //         [
        //             'attribute'=>'id_coa',
        //             'label' => 'Acc. No',
        //             'value' => 'coa.code',
        //             'options' => ['width' => '100']
        //             // 'width'=>'100px',
        //             // 'group' => true,
        //         ],
        //         [
        //             'attribute'=>'id_coa',
        //             'label' => 'Name',
        //             'value' => 'coa.name',
        //             // 'group' => true,
        //         ],
        //         [
        //             'attribute'=>'debitAmount',
        //             'label' => 'Debit',
        //             'value' => 'debitAmount',
        //             'format' => ['decimal', 0],
        //             'hAlign'=>'right',
        //             // 'group' => true,
        //         ],
        //         [
        //             'attribute'=>'creditAmount',
        //             'label' => 'Credit',
        //             'value' => 'creditAmount',
        //             'format' => ['decimal', 0],
        //             'hAlign'=>'right',
        //             // 'group' => true,
        //         ],
        //     ],
        // ]); 

        // $datas = $data->all();

        // var_dump($datas[1]['coaParent']);

    // foreach ($dataProvider->models as $model) {
    //     echo "addMarker({$model->lat_field}, {$model->lon_field});";
    // }

        // foreach ($dataProvider->models as $model) {
        //     echo $model->creditAmount.'<br/>';
        // }
        // var_dump($dataProvider->models);die();
    ?>
    <?php
        // foreach ($dataProvider->models as $model) {
        //     $debit[] = $model->debitAmount(25);
        //     $credit[] = $model->creditAmount(25);
        // }

        // $amount = [
        //     'debit' => $debit,
        //     'credit' => $credit
        // ];

        // var_dump($amount); die();
    ?>
    <table class="table table-striped table-bordered table-condensed">
    <tr>
        <th>Code</th>
        <th>Debit</th>
        <th>Credit</th>
    </tr>
    <?php foreach($types as $type) { ?>
        <tr>
            <td colspan="3"><?= $type->name ?></td>
        </tr>
        <?php foreach(Coa::find()->where(['coa.type' => $type->id, 'coa.parent_id' => null])->all() as $parentcoa) {?>
            <tr>
                <td style="padding-left: 30px;">(<?= $parentcoa->code ?>) <?= $parentcoa->name ?></td>
                <td></td>
                <td></td>
            </tr>
            <?php foreach(Coa::find()->where(['coa.type' => $type->id, 'coa.parent_id' => $parentcoa->id])->all() as $coa) {?>
                <tr>
                    <td style="padding-left: 45px;">(<?= $coa->code ?>) <?= $coa->name ?></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php if(!empty(Coa::find()->where(['coa.type' => $type->id, 'coa.parent_id' => $coa->id])->all())) { ?>
                <?php foreach(Coa::find()->where(['coa.type' => $type->id, 'coa.parent_id' => $coa->id])->all() as $coachild) {?>
                <tr>
                    <td style="padding-left: 60px;">(<?= $coachild->code ?>) <?= $coachild->name ?></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    <?php }?>
   </table>
</div>
