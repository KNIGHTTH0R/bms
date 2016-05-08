<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\EmployeeGroup */

$this->title = 'Create Employee Group';
$this->params['breadcrumbs'][] = ['label' => 'Employee Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
