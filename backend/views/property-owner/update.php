<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PropertyOwner */

$this->title = 'Update Property Owner: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Property Owners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="property-owner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
