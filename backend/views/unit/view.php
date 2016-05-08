<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Unit */

$this->title ='Detail Unit : '. $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-view" style="margin-left:15px;">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

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

        </div>
    </div>
    <div class="row">

        <div class="col-sm-3" style="font-size:16px;">
        
            <dl style="margin-top:20px">
                    <dt>Building</dt>
                    <dd><?php echo $model->building->name; ?></dd>

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Owner</dt>
                    <dd><?php echo $model->ownerName; ?></dd>
                    
                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Tenant</dt>
                    <dd><?php if($model->tenantName==NULL){
                            echo '-';
                        }else{
                            echo $model->tenantName;
                        } ?></dd>
                    
                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Virtual Account</dt>
                    <dd><?php echo $model->va; ?></dd>
                    
                    
            </dl>
                  
        </div>
        <div class="col-sm-3" style="font-size:16px;">
        
            <dl style="margin-top:20px">

                    <dt>Unit Type</dt>
                    <dd><?php if($model->unitTypeName==NULL){
                            echo '-';
                        }else{
                            echo $model->unitTypeName;
                        } ?></dd>
                    
                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Unit Floor</dt>
                    <dd><?php echo $model->unit_floor; ?></dd>
                    
                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Unit Number</dt>
                    <dd><?php echo $model->unit_num; ?></dd>

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Space Size</dt>
                    <dd><?php echo $model->space_size.' '.$model->space_unit; ?></dd>

                    

            </dl>
        </div>

        <div class="col-sm-4" style="font-size:16px;">
        
            <dl style="margin-top:20px">
                    
                    <dt>Electric</dt>
                    <dd><?php echo $model->getPowerLabel($model->power); ?></dd>

                    <dt style="margin-top:12px; border-top:solid 1px #d1d5d9; padding-top:5px;">Power Electric</dt>
                    <dd><?php echo $model->power.' KVA';?></dd>

            </dl>

        </div>

    </div>
</div>
<?php //var_dump($model->powerName); die(); ?>