<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PersonAddress */

$this->title = 'Create Person Address';
$this->params['breadcrumbs'][] = ['label' => 'Person Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-address-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
