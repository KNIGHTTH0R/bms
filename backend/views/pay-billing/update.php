<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PayBilling */

$this->title = 'Update Pay Billing: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pay Billings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pay-billing-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
