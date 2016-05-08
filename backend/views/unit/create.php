<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Unit */

$this->title = 'Create Unit';
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-create">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUc' => $modelUc,
        
    ]) ?>

</div>
