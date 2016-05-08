<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <p>
                        <?= Html::a('<i class="fa fa-plus"></i> Add New', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
                    </p>
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'username',
                            //'fullname',
                            [
                                'attribute'=>'fullname',
                                'format' => 'raw',
                                //'value' => 'profileLink'
                                /*'value' => function($d) {
                                    $url = "index.php?r=profile/view&id=".$d->id;
                                    return Html::a($d->fullname, $url, ['title' => 'Profile']);
                                }*/
                            ],
                            'email:email',
                            [
                                'attribute'=>'status',
                                'filter'=>array("10"=>"Active","20"=>"Inactive", "30"=>"Deleted"),
                                'headerOptions'=>['width'=>'100'],
                                'content'=>function($d){
                                    return $d->getStatusLabel($d->status);
                                }
                            ],
                            // 'created_at',
                            // 'updated_at',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'headerOptions'=>['width'=>'150'],
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'update' => function($url, $model){
                                        return Html::a('<i class="fa fa-edit"></i> edit', $url, ['class' => 'btn btn-xs btn-success', 'title'=>'Update', 'aria-label'=>'Update', 'data-pjax'=>'0']);
                                    },
                                    'delete' => function($url, $model){
                                        return Html::a('<i class="fa fa-times"></i> del', $url, ['class' => 'btn btn-xs btn-danger', 'title'=>'Delete', 'aria-label'=>'Delete', 'data-confirm'=>'Are you sure you want to delete this item?', 'data-method'=>'post', 'data-pjax'=>'0']);
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
