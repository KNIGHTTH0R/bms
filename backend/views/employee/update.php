<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Employee */

$this->title = 'Update Employee: ' . ' ' . $model->idemployee;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idemployee, 'url' => ['view', 'id' => $model->idemployee]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employee-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
