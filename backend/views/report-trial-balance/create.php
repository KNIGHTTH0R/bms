<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ReportTrialBalance */

$this->title = 'Create Report Trial Balance';
$this->params['breadcrumbs'][] = ['label' => 'Report Trial Balances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-trial-balance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
