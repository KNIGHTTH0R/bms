<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UnitCharge */

$this->title = 'Create Unit Charge';
$this->params['breadcrumbs'][] = ['label' => 'Unit Charges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
	<h3 class="box-title" style="margin-left:10px;"><?= Html::encode($this->title) ?></h3>
	
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>


