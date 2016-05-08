<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UnitChargeValue */

$this->title = 'Pay Billing Invoice ';
$this->params['breadcrumbs'][] = ['label' => 'Unit Charge Values', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bill-inv-create">

    <h4 style="margin-top:0px; margin-bottom:25px"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
    ]) ?>

</div>
