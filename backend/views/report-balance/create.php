<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\JurnalChild */

$this->title = 'Create Jurnal Child';
$this->params['breadcrumbs'][] = ['label' => 'Jurnal Children', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurnal-child-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
