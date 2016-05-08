<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use common\models\PermissionHelpers;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
//use kartik\datecontrol\DateControl;
//use kartik\datecontrol\Module;

/* @var $this yii\web\View */
/* @var $model backend\models\ProfileUser */

$this->title = $model->user->fullname . "'s Profile";
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-user-view">
    <div class="row">
        <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user">
                <div class="box-tools pull-right">
                    <?php 
                        echo Html::a('<i class="fa fa-key"></i> Change Password', ['staff/changepass', 'id' => $model->id], ['class' => 'btn btn-warning btn-xs btnSpecial']) ;
                        echo Html::a('<i class="fa fa-edit"></i> Update', ['update'], ['class' => 'btn btn-primary btn-xs btnSpecial']) ;
                    ?>
                </div>
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-aqua-active">
                <h3 class="widget-user-username"><?= Html::encode($this->title) ?></h3>
                <h5 class="widget-user-desc">Founder &amp; CEO</h5>
              </div>
              <div class="widget-user-image">
                <?php if($model->avatar) {?>
                    <?=Html::img($model->getImageUrl(), [
                                        'class' => 'img-circle',
                                        'alt' => $this->title . ' avatar',
                                        'title' => $this->title . ' avatar'
                                    ]) ?>
                <?php } else { ?>
                <?php if($model->gender->id == 1) {?>
                    <img class="img-circle" src="../dist/img/avatar5.png" alt="User Avatar">
                <?php } else {?>
                    <img class="img-circle" src="../dist/img/avatar3.png" alt="User Avatar">
                <?php }} ?>
              </div>
              <div class="box-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header"><?= Yii::$app->formatter->asDatetime($model->user->lastlogin) ?></h5>
                      <span class="description-text">LAST LOGIN</span>
                    </div><!-- /.description-block -->
                  </div><!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header"><?= $model->user->email ?></h5>
                      <span class="description-text">EMAIL</span>
                    </div><!-- /.description-block -->
                  </div><!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header"><?= Yii::$app->formatter->asDate($model->birthdate) ?></h5>
                      <span class="description-text">BIRTHDATE</span>
                    </div><!-- /.description-block -->
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div>
              <hr class="hr-primary"/>
              <div class="box-body with-border">
                <p>Log Activity</p>
              </div>
            </div><!-- /.widget-user -->
        </div><!-- /.col -->
    </div>
</div>
