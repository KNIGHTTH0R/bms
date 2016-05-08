<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DepositTb */

$this->title = 'Create Deposit Tb';
$this->params['breadcrumbs'][] = ['label' => 'Deposit Tbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deposit-tb-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
