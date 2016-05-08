<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DepositTb */

$this->title = 'Update Deposit Tb: ' . ' ' . $model->id_deposit;
$this->params['breadcrumbs'][] = ['label' => 'Deposit Tbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_deposit, 'url' => ['view', 'id' => $model->id_deposit]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="deposit-tb-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
