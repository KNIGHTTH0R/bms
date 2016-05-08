<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PersonAddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Person Addresses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-address-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Person Address', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'person_id',
            'postal_code:ntext',
            'phone:ntext',
            'fax:ntext',
            // 'name:ntext',
            // 'for_billing:boolean',
            // 'for_letternotif:boolean',
            // 'building:ntext',
            // 'street:ntext',
            // 'city:ntext',
            // 'province:ntext',
            // 'country:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
