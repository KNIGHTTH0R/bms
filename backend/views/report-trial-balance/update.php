<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ReportTrialBalance */

$this->title = 'Update Report Trial Balance: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Report Trial Balances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="report-trial-balance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
