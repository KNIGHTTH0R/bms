<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Unit;
/* @var $this yii\web\View */
/* @var $model backend\models\Person */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-view">

    <h3><?= Html::encode($this->title) ?></h3>

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
            [                      
                    'label' => 'Name',
                    [$add = json_decode($model->detail_person)],
                    'value' => $add->salutation ? $add->salutation .'. '.$model->name : $model->name,
            ],
            'is_company:boolean',
            'tax_reg:ntext',
            [                      
                    'label' => 'ID',
                    [$add = json_decode($model->detail_person)],
                    'value' => $add->id_type.' : '.$add->id_number,
            ],

            [                      
                    'label' => 'Religion',
                    [$add = json_decode($model->detail_person)],
                    'value' => $add->religion,
            ],

            [                      
                    'label' => 'Date Of Birthday',
                    [$add = json_decode($model->detail_person)],
                    'value' => Yii::$app->formatter->asDate($add->dob),
            ],     
            [                      
                    'label' => 'Nationality',
                    [$add = json_decode($model->detail_person)],
                    'value' => $add->nationality,
                    
            ],
            [                      
                    'label' => 'Contact Name',
                    [$add = json_decode($model->detail_person)],
                    'value' => $add->contact_name,

            ],     
            [                      
                    'label' => 'Position',
                    [$add = json_decode($model->detail_person)],
                    'value' => $add->position,
                                        
            ],     
            [                      
                    'label' => 'Contact Phone Number',
                    [$add = json_decode($model->detail_person)],
                    'value' => $add->phone,
                                        
            ],     
            [                      
                    'label' => 'Contact Fax Number',
                    [$add = json_decode($model->detail_person)],
                    'value' => $add->fax,
                                        
            ],     

            //'id',

        ],
    ]) ?>

</div>
