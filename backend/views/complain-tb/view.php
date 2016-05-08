<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ComplainTb */

$this->title = 'Complain Unit '.$model->code_unit;
$this->params['breadcrumbs'][] = ['label' => 'Complain Tbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complain-tb-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Index', ['index', 'id' => $model->id_complain], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id_complain], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_complain], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_complain',
            'code_unit',
            [
                'label'=>'Complain Date',
                'value'=>date('d F Y', $model->date_complain)
            ],
            'complain:ntext',
            'solution:ntext',
            [
                'attribute'=>'user_id',
                'value'=>$model->user->username
            ],
            'status_complain'
        ],
    ]) ?>

</div>
