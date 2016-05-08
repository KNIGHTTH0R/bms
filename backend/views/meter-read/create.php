<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MeterRead */

$this->title = 'Create Meter Read';
$this->params['breadcrumbs'][] = ['label' => 'Meter Reads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meter-read-create">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'options' => $options
    ]) ?>

</div>
