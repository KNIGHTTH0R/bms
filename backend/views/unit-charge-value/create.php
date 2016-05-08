<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UnitChargeValue */

$this->title = 'Create Unit Charge Value';
$this->params['breadcrumbs'][] = ['label' => 'Unit Charge Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-charge-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
