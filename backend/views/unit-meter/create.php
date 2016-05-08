<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UnitMeter */

$this->title = 'Create Unit Meter';
$this->params['breadcrumbs'][] = ['label' => 'Unit Meters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-meter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
