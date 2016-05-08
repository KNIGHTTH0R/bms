<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Person */

$this->title = 'Create Person';
$this->params['breadcrumbs'][] = ['label' => 'People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-create">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsAdd' => $modelsAdd,
    ]) ?>

</div>
