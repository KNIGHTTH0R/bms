<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UnitHistory */

$this->title = 'Create Unit History';
$this->params['breadcrumbs'][] = ['label' => 'Unit Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
