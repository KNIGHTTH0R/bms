<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Coa;

/* @var $this yii\web\View */
/* @var $model backend\models\Jurnal */

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Jurnals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurnal-view">

    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $model->description ?></h3>
                    <div class="box-tools pull-right">
                        <?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-box-tool']) ?>
                        <?= Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-box-tool',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Code</th>
                                <th>Date</th>
                                <th>Ref#</th>
                                <th>Debit</th>
                                <th>Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php 
                                        if($model->status == 20) echo '<span class="danger">DRAFT</span>';
                                        if($model->status == 10) echo '<span class="text-aqua">POSTED</span>';
                                        if($model->status == 30) echo '<span class="text-red">VOID</span>';
                                    ?>
                                </td>
                                <td><?=$model->code ?></td>
                                <td><?= Yii::$app->formatter->asDate($model->date) ?></td>
                                <td><?=$model->ref ?></td>
                                <td><?= number_format($model->debit, 2, ',', '.') ?></td>
                                <td><?= number_format($model->credit, 2, ',', '.') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <th class="col-md-4">COA</th>
                            <th class="col-md-4">Description</th>
                            <th class="col-md-2">Debit</th>
                            <th class="col-md-2">Credit</th>
                        </tr>
                        <?php 
                            $sc = 0;
                            $sd = 0;
                            foreach ($modelJurnalChild as $modelJurnalChild) { 
                        ?>
                        <tr>
                            <td><?= Coa::findOne($modelJurnalChild->id_coa)->name ?></td>
                            <td><?= $modelJurnalChild->description ?></td>
                            <td><?= $modelJurnalChild->dc == 'D' ? number_format($modelJurnalChild->amount, 2, ',', '.') : 0 ?></td>
                            <td><?= $modelJurnalChild->dc == 'C' ? number_format($modelJurnalChild->amount, 2, ',', '.') : 0 ?></td>
                        </tr>
                        <?php 
                                if($modelJurnalChild->dc == 'C') {
                                   $sc = $sc + $modelJurnalChild->amount; 
                                } else {
                                    $sd = $sd + $modelJurnalChild->amount;
                                }
                            } 
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2"><p class="text-right">Total:</p></th>
                            <th><?= number_format($sd, 2, ',', '.') ?></th>
                            <th><?= number_format($sc, 2, ',', '.') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>