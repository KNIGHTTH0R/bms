<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Coa */

$this->title = 'Add Bank Account';
$this->params['breadcrumbs'][] = ['label' => 'Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
