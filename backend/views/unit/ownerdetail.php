<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Unit */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$detail_owner = json_decode($person->detail_person); //Company

?>

<div class="unit-view">

  <h3 class="box-title"><?= Html::encode($this->title) ?></h3>

  <div class="row">
    <div class="col-md-4">
      <!-- Widget: user widget style 1 -->
      <div class="box box-widget widget-user-2">
       <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-yellow">
          <div class="widget-user-image">
            <img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">
          </div><!-- /.widget-user-image -->
          <h3 class="widget-user-username"><?= $detail_owner->salutation ? $detail_owner->salutation :''?> <?= $person->name ?></h3>
          <h5 class="widget-user-desc">OWNER</h5>
          <h5 class="widget-user-desc">TAX ID: <?= $person->tax_reg ?></h5>
        </div>
        <div class="box-footer no-padding">
          <ul class="nav nav-stacked">
            <li><a href="#">UNIT <span class="pull-right"><?= $model->code ?></span></a></li>
            <li><a href="#">ID TYPE <span class="pull-right"><?= $detail_owner->id_type ? $detail_owner->id_type : '-' ?></span></a></li>
            <li><a href="#">ID NUMBER <span class="pull-right"><?= $detail_owner->id_number ? $detail_owner->id_number :'-' ?></span></a></li>
            <li><a href="#">DATE OF BIRTH <span class="pull-right"><?= $detail_owner->dob ? date('d F Y', strtotime($detail_owner->dob)) : '-' ?></span></a></li>
            <li><a href="#">SEX <span class="pull-right"><?= $detail_owner->sex ? $detail_owner->sex : '-' ?></span></a></li>
            <li><a href="#">RELIGION <span class="pull-right"><?= $detail_owner->religion ? $detail_owner->religion : '-' ?></span></a></li>
            <li><a href="#">MARITAL STATUS <span class="pull-right"><?= $detail_owner->marital_status ? $detail_owner->marital_status : '-' ?></span></a></li>
          </ul>
        </div>
      </div><!-- /.widget-user -->
    </div><!-- /.col -->
    <?php
    if ($model->tenant_id) {
      $detail_tenant = json_decode($tenant->detail_person);
    ?>
    <div class="col-md-4">
      <!-- Widget: user widget style 1 -->
      <div class="box box-widget widget-user-2">
       <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-blue">
          <div class="widget-user-image">
            <img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">
          </div><!-- /.widget-user-image -->
          <h3 class="widget-user-username"><?= $detail_tenant->salutation ? $detail_tenant->salutation :''?> <?= $model->tenantName ?></h3>
          <h5 class="widget-user-desc">TENANT</h5>
          <h5 class="widget-user-desc">TAX ID: <?= $person->tax_reg ?></h5>
        </div>
        <div class="box-footer no-padding">
          <ul class="nav nav-stacked">
            <li><a href="#">UNIT <span class="pull-right"><?= $model->code ?></span></a></li>
            <li><a href="#">ID TYPE <span class="pull-right"><?= $detail_tenant->id_type ? $detail_tenant->id_type : '-' ?></span></a></li>
            <li><a href="#">ID NUMBER <span class="pull-right"><?= $detail_tenant->id_number ? $detail_tenant->id_number :'-' ?></span></a></li>
            <li><a href="#">DATE OF BIRTH <span class="pull-right"><?= $detail_tenant->dob ? Yii::$app->formatter->asDate($detail_tenant->dob) : '-' ?></span></a></li>
            <li><a href="#">SEX <span class="pull-right"><?= $detail_tenant->sex ? $detail_tenant->sex : '-' ?></span></a></li>
            <li><a href="#">RELIGION <span class="pull-right"><?= $detail_tenant->religion ? $detail_tenant->religion : '-' ?></span></a></li>
            <li><a href="#">MARITAL STATUS <span class="pull-right"><?= $detail_tenant->marital_status ? $detail_tenant->marital_status : '-' ?></span></a></li>
          </ul>
        </div>
      </div><!-- /.widget-user -->
    </div><!-- /.col -->
    <?php
    # code...
    }
    ?>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-warning direct-chat direct-chat-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Address Detail</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="content">
            <?php foreach ($detailAddress as $detailAddress) {?>
              <div class="panel panel-default">
                <div class="panel-heading"><?= $detailAddress->name ?></div>
                <div class="panel-body">
                  <p>Building: <?= $detailAddress->building ? $detailAddress->building: '' ?></p>
                  <p>Street: <?= $detailAddress->street ? $detailAddress->street: '' ?></p>
                  <p>City: <?= $detailAddress->city ? $detailAddress->city: '' ?></p>
                  <p>Province: <?= $detailAddress->province ? $detailAddress->province: '' ?></p>
                  <p>Country: <?= $detailAddress->country ? $detailAddress->country: '' ?></p>
                  <p>Postal Code: <?= $detailAddress->postal_code ? $detailAddress->postal_code: '' ?></p>
                  <p><i class="glyphicon glyphicon-earphone"></i> <?= $detailAddress->phone ? $detailAddress->phone: '' ?></p>
                  <p>Fax: <?= $detailAddress->fax ? $detailAddress->fax: '' ?></p>
                  <p><i class="glyphicon glyphicon-envelope"></i> <?= $detailAddress->email ? $detailAddress->email: '' ?></p>
                </div>
              </div>
            <?php } ?>
          </div>
        </div><!-- /.box-body -->
      </div>
    </div>
  </div>
</div>