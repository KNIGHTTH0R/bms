<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ComplainTb */

$this->title = 'Report Complain Form';
$this->params['breadcrumbs'][] = ['label' => 'Complain', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complain-tb-create">

    

    <?= $this->render('_form', [
        'model' => $model,
        'modelUnit' => $modelUnit,
    ]) ?>

</div>
