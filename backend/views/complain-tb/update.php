<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ComplainTb */

$this->title = 'Update Complain Tb: ' . ' ' . $model->id_complain;
$this->params['breadcrumbs'][] = ['label' => 'Complain Tbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_complain, 'url' => ['view', 'id' => $model->id_complain]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="complain-tb-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUnit' => $modelUnit,
    ]) ?>

</div>
