<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CoaType */

$this->title = 'Create Coa Type';
$this->params['breadcrumbs'][] = ['label' => 'Coa Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coa-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
