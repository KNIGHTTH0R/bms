<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Coa */

$this->title = 'Update COA: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Coas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="coa-update">

    <?= $this->render('_form_update', [
        'model' => $model,
    ]) ?>

</div>
