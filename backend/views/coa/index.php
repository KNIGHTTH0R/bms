<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use fedemotta\datatables\DataTables;
use backend\models\Coa;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CoaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'COA\'s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <p>
                        <?= Html::button('<i class="fa fa-plus"></i> Add New', ['value'=>Url::to('index.php?r=coa/create'), 'class' => 'btn btn-success btn-xs', 'id'=>'modalButton']) ?>
                        <?= Html::a('<i class="fa fa-cloud-upload"></i> Upload Excel File', ['excell'], ['class' => 'btn btn-warning btn-xs']) ?>
                    </p>
                    <?php
                        Modal::begin([
                            'header'=>'<h4>New COA</h4>',
                            'id'=>'modal',
                            'size'=>'modal-md',
                        ]);

                        echo '<div id="modalContent"></div>';
                        Modal::end();
                    ?>
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'code',
                            'name',
                            [
                                'attribute' => 'parent_id',
                                'label' => 'Parent Code',
                                'filter' => Coa::getParentList(),
                                'content' => function($d){
                                    return $d->getParentCode() ? $d->getParentCode() : '-';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
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
<?php
$script = <<< JS
    $(function(){
        $('#modalButton').click(function(){
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        });
    });
JS;
$this->registerJs($script);
?>