<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TypeCharge */

$this->title = 'Create Type Charge';
$this->params['breadcrumbs'][] = ['label' => 'Type Charges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-charge-create">

    <h3 style="margin-top:0px"><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
