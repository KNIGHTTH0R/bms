<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Jurnal */

$this->title = 'Update Jurnal: ' . ' ' . $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Jurnals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->description, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jurnal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelJurnalChild' => $modelJurnalChild,
    ]) ?>

</div>
