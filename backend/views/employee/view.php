<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Employee */

$this->title = $model->name_employee;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idemployee], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idemployee], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= Html::img('@web/'.$model->photo, ['alt'=>'some', 'class' => 'img-circle', 'style'=>'width:150px']) ?>

    <div class="row">

        <div class="col-sm-3" style="font-size:16px;">
        
            <dl style="margin-top:20px">
                    <dt >Full Name</dt>
                    <dd><?php echo $model->name_employee; ?></dd>
                    
                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Phone Number</dt>
                    <dd><?php echo $model->phone_employee; ?></dd>

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Section</dt>
                    <dd><?php echo $model->section; ?></dd>
                    
                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Position</dt>
                    <dd><?php echo $model->position; ?></dd>
                    
                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Work Status</dt>
                    <dd><?php echo $model->work_status; ?></dd>
                    
                    
            </dl>
                  
        </div>
        <div class="col-sm-3" style="font-size:16px;">
        
            <dl style="margin-top:20px">

                    <dt>Address</dt>
                    <dd><?php echo $model->address_employee; ?></dd>

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Religion</dt>
                    <dd><?php echo $model->religion; ?></dd>

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Place Of Birth</dt>
                    <dd><?php echo $model->pob; ?></dd>

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Date Of Birth</dt>
                    <dd><?php echo $model->dob;?></dd>


            </dl>
        </div>

        <div class="col-sm-4" style="font-size:16px;">
        
            <dl style="margin-top:20px">
            
                    <dt>Basic Salary</dt>
                    <dd><?php echo $model->idgroup0->basic_salary; ?></dd>        

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Overtime / Hour</dt>
                    <dd><?php echo $model->idgroup0->overtime_value; ?></dd>        

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Transport Allowance</dt>
                    <dd><?php echo $model->idgroup0->transport_value; ?></dd>        

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Meal Allowance</dt>
                    <dd><?php echo $model->idgroup0->meal_allow; ?></dd>        
                                
            </dl>

        </div>

    </div>
</div>
