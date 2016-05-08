<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PropertyManagement */

$this->title = 'Create Property Management';
$this->params['breadcrumbs'][] = ['label' => 'Property Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-management-create">

    <div class="box-header with-border">
    	<h3 class="box-title" style="margin-left:10px;"><?= Html::encode($this->title) ?></h3>
    <div class="box-header with-border">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
