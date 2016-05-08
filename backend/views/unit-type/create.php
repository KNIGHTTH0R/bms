<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UnitType */

$this->title = 'Create Unit Type';
$this->params['breadcrumbs'][] = ['label' => 'Unit Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-type-create">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
