<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PropertyManagement */

$this->title = 'Form Edit : ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Property Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="property-management-update">

    <h4 class="box-title"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
