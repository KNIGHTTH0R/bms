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
    
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
               <div class="box-body">
                    <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr class="bg-primary">
                            <th>ACCOUNT</th>
                            <th class="text-center">DEBIT</th>
                            <th class="text-center">CREDIT</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $xb = '';
                        foreach($dataProvider->models as $model) { 
                        
                            $xa =  $model->coaType->name;
                            if($xa != $xb) { 
                        ?>
                        
                        <tr class="success">
                            <td colspan="3">
                                <strong> <?= $xa; $xb = $xa; ?> </strong>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="3" style="padding-left: 20px;"><strong>(<?= $model->coaParent->code ?>) <?= $model->coaParent->name ?></strong></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 35px;">(<?= $model->coa->code ?>) <?= $model->coa->name ?></td>
                            <td class="text-right"><?= Yii::$app->formatter->format($model->debitAmount, ['decimal', 0]) ?></td>
                            <td class="text-right"><?= Yii::$app->formatter->format($model->creditAmount, ['decimal', 0]) ?></td>
                        </tr>
                    <?php }?>
                    </tbody>
                    <tfoot>
                        <tr style="text-align: right; font-weight: bold;">
                            <td>Total</td>
                            <td>
                                <?php
                                    $sumc = 0; 
                                    foreach ($dataProvider->models as $key) {
                                        $sumc += $key->debitAmount;
                                    }
                                    echo Yii::$app->formatter->format($sumc, ['decimal', 0]);
                                ?>
                            </td>
                            <td>
                                <?php
                                    $sumd = 0; 
                                    foreach ($dataProvider->models as $key) {
                                        $sumd += $key->creditAmount;
                                    }
                                    echo Yii::$app->formatter->format($sumd, ['decimal', 0]); 
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
