<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Person */

$detail_person=json_decode($model->detail_person);
$this->title = $detail_person->salutation.'. '. $model->name;
$this->params['breadcrumbs'][] = ['label' => 'People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="person-view" style="margin-left:15px">

    <h3><?= Html::encode($this->title) ?></h3>

    
    <div class="row">

        <div class="col-sm-3" style="font-size:16px;">
        
            <dl style="margin-top:20px">
                    <dt>Client Type</dt>
                    <dd><?php 
                    


                    if($model->is_company==FALSE){
                        echo 'Personal';
                    }else{
                        echo 'Company';
                    }
                    
                    ?></dd>
                

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Tax Reg</dt>
                    <dd><?php if($model->tax_reg==NULL){
                            echo '-';
                        }else{
                            echo $model->tax_reg;
                        } ?>
                    </dd>
                    
                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Sex</dt>
                    <dd><?php if($detail_person->sex==NULL){
                            echo '-';
                        }else{
                            echo $detail_person->sex;
                        } ?>
                    </dd>
                    
                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">DOB</dt>
                    <dd><?php if($detail_person->dob==NULL){
                            echo '-';
                        }else{
                            echo $detail_person->dob;
                        } ?>
                    </dd>
                    
                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Nationality</dt>
                    <dd><?php if($detail_person->nationality==NULL){
                            echo '-';
                        }else{
                            echo $detail_person->nationality;
                        } ?>
                    </dd>
                    
                    
            </dl>
                  
        </div>


        <div class="col-sm-3" style="font-size:16px;">
        
            <dl style="margin-top:20px">
                    
                    <dt>ID Type</dt>
                    <dd><?php if($detail_person->id_type==NULL){
                            echo '-';
                        }else{
                            echo $detail_person->id_type;
                        } ?>
                    </dd>
                    
                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">ID Number</dt>
                    <dd><?php if($detail_person->id_number==NULL){
                            echo '-';
                        }else{
                            echo $detail_person->id_number;
                        } ?>
                    </dd>
                    
                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Position</dt>
                    <dd><?php if($detail_person->position==NULL){
                            echo '-';
                        }else{
                            echo $detail_person->position;
                        } ?>
                    </dd>

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Phone</dt>
                    <dd><?php if($detail_person->phone==NULL){
                            echo '-';
                        }else{
                            echo $detail_person->phone;
                        } ?>
                    </dd>

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Fax</dt>
                    <dd><?php if($detail_person->fax==NULL){
                            echo '-';
                        }else{
                            echo $detail_person->fax;
                        } ?>
                    </dd>
                    
            </dl>
                  
        </div>
        

        <div class="col-sm-4" style="font-size:16px;">
        
            <dl style="margin-top:20px">
                    
                    <?php
                        
                        foreach ($detailAddress as $detailAddress) {
                        
                            echo '
                            <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Address '.$detailAddress->name.'</dt>
                            <dd>'.$detailAddress->building.', '.$detailAddress->street.' '.$detailAddress->city.'-'.$detailAddress->province.'</dd>
                            ';

                        }

                    ?>
                    
                    
                    
                    
            </dl>
                  
        </div>


        </div>
    
    <p>
        
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    </div>


