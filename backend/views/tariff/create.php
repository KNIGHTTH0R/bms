<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Tariff */

$this->title = 'Create Tariff';
$this->params['breadcrumbs'][] = ['label' => 'Tariffs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tariff-create">

	<div class="box-header with-border">
    	<h3 class="box-title" style="margin-left:10px;"><?= Html::encode($this->title) ?></h3>
    <div class="box-header with-border">
    
    <?= $this->render('_form', [
        'model' => $model,
        'options' => $options
    ]) ?>

</div>
