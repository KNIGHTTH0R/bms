<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeTransaction */

$this->title = 'Update Employee Transaction: ' . ' ' . $model->id_transaction;
$this->params['breadcrumbs'][] = ['label' => 'Employee Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_transaction, 'url' => ['view', 'id' => $model->id_transaction]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employee-transaction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
