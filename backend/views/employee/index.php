<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees Data';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">

    <p>
        <?= Html::a('Create Employee', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nip',
            [
                'label'=>'Nama Karyawan',
                'attribute'=>'name_employee',
            ],
            // 'address_employee:ntext',
            [
                'label'=>'Tlp',
                'attribute'=>'phone_employee'
            ],
            // 'email_employee:email',
            // 'gender',
            // 'religion',
            // 'pob',
            // 'dob',
            [   
                'label'=>'Bagian',
                'attribute'=>'section',
            ],
            [
                'label'=>'Jabatan',
                'attribute'=>'position',
            ],
            
            // 'marital_status',
            // 'work_status',
            // 'start_work',
            [
                    'label'=>'Foto',
                    'format'=>'raw',
                    'value'=>function($data){
                        $url = '#';
                        return Html::img('@web/'.$data->photo, ['alt'=>'some', 'width'=>'70px']);
                                    
                                }
            ],
            // 'photo',
            // 'idgroup',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

            </div>
        </div>
    </div>
</div>
