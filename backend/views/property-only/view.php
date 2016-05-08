<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Property */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <p>
                        <?= Html::a('Index', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
                            'id',
                            'code:ntext',
                            'name:ntext',
                            [                      // the owner name of the model
                            'label' => 'Address',
                            [$add = json_decode($model->address)],
                            'value' => $add->building_name.'. '.$add->street.'- '.$add->city.', '.$add->Province.'. '.$add->contry,
                            ],
                            [                      // the owner name of the model
                            'label' => 'Phone Number',
                            [$add = json_decode($model->address)],
                            'value' => $add->phone,
                            ],
                            [                      // the owner name of the model
                            'label' => 'Fax Number',
                            [$add = json_decode($model->address)],
                            'value' => $add->fax,
                            ],
                            //'created_at',
                            //'created_by',
                            //'updated_at',
                            //'updated_by',
                            ['label'=>'Property Owner', 'value' => $model->propertyOwner->name],
                            ['label'=>'Property Management', 'value' => $model->propertyManagement->name],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
