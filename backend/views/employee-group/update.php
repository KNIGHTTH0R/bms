<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeGroup */

$this->title = 'Update Employee Group: ' . ' ' . $model->idgroup;
$this->params['breadcrumbs'][] = ['label' => 'Employee Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idgroup, 'url' => ['view', 'id' => $model->idgroup]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employee-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
