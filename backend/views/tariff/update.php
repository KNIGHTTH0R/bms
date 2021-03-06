<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tariff */

$this->title = 'Update Tariff: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tariffs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tariff-update">

    <h1><?= Html::encode($this->title) ?></h1>

     <?= $this->render('_formedit', [
        'model' => $model,
        'options' => $options,
        'json'=>json_decode($model->formula),
    ]) ?>

</div>
