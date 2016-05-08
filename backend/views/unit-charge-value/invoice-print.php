<?php
use backend\assets\PrintAsset;
use yii\helpers\Html;
use backend\models\UnitChargeValue;
use backend\models\UnitChargeValueSearch;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
// use yii\widgets\Breadcrumbs;
// use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

PrintAsset::register($this);
?>
<?php $this->beginPage() ?>
<?php $this->title = 'Print Invoice'; ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="/js/html5shiv.min.js"></script>
        <script src="/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini" onload="window.print();">
    <?php $this->beginBody() ?>
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <i class="fa fa-building"></i> Woodland Park Management.
              <small class="pull-right">Date: <?= date('d M Y', $model->charge_date); ?></small>
            </h2>
          </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            From
            <address>
              <strong>Admin, Inc.</strong><br>
              795 Folsom Ave, Suite 600<br>
              San Francisco, CA 94107<br>
              Phone: (804) 123-5432<br/>
              Email: info@almasaeedstudio.com
            </address>
          </div><!-- /.col -->
          <div class="col-sm-6 invoice-col">
            To
            <address>
              <strong><?= $model->namePerson; ?></strong><br>
              <?= $model->personAdd->building; ?><br>
              <?= $model->personAdd->street.', '.$model->personAdd->city.', '.$model->personAdd->province.'. '.$model->personAdd->country; ?><br>
              Phone : <?= $model->personAdd->phone; ?><br/>
              Email : <?= $model->personAdd->email; ?>
            </address>
          </div><!-- /.col -->
          <div class="col-sm-2 invoice-col">
            <b>Invoice : <?= $model->inv_number; ?></b><br/>
            <br/>
            <b>Charge Date:</b> <?= date('d M Y', $model->charge_date); ?><br/>
            <b>Payment Due:</b> <?= date('d M Y', $model->due_date); ?><br/>
            <b>Account:</b> 968-34567
          </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row">
          <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
            <?php if($model->type=='ELECTRICITY' OR $model->type=='WATER'){
                echo '
                <thead>
                <tr>
                  <th>No</th>
                  <th>Type Of Charge</th>
                  <th>Installed Power</th>
                  <th>Initial Meter</th>
                  <th>Meter Final</th>
                  <th>Usage</th>
                  <th>Tariff/Meter</th>
                  <th>Formula</th>
                  <th>tax</th>
                  <th>Admistration</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>';
              
              $no=0;
              $subtotal=0;
              $totalTax=0;
              $totalAdmin=0;
              foreach ($modelDetail as $modelDetail) {
                  $no++;
                  $formula=json_decode($modelDetail->tariffPdf->formula);
                  $tax=json_decode($modelDetail->tariffPdf->tax_formula);
                  $admin=json_decode($modelDetail->tariffPdf->admin_formula);

                  if($modelDetail->type=='ELECTRICITY'){
                    if(substr($model->unitCode, 0,2)=='OF'){

                                    $usageValue = $modelDetail->usageDelta*$modelDetail->tariffFormula;
                                    $usageValueTotal=($modelDetail->usageDelta*$modelDetail->tariffFormula)+(($modelDetail->usageDelta*$modelDetail->tariffFormula)*$modelDetail->pju/100)+(($modelDetail->usageDelta*$modelDetail->tariffFormula)*$modelDetail->tariffAdmin/100);
                    }
                      else{
                            $usageValue=(40*$modelDetail->tariffFormula)*$modelDetail->unitData;
                            $usageValueTotal=(40*$modelDetail->tariffFormula)*$modelDetail->unitData;
                            
                    }

                  }else{
                    $usageValue = $modelDetail->usageDelta*$modelDetail->tariffFormula;
                    $adminValue=$usageValue*($modelDetail->tariffAdmin/100);
                    $usageValueTotal =($modelDetail->usageDelta)*($modelDetail->tariffFormula)+$adminValue;

                  }
                $subtotal+=$usageValueTotal;
                $totalTax+=$tax->formula;
                $totalAdmin+=$admin->value;
                echo '
                <tr>
                  <td>'.$no.'</td>
                  <td>'.$modelDetail->type.'</td>
                  <td>'; if($modelDetail->type=='ELECTRICITY'){echo $modelDetail->unitData.' Kwh'; }else{echo '-';} echo '</td>
                  <td>'.($modelDetail->usage->prev_value); if($modelDetail->type=='ELECTRICITY'){echo ' Kwh'; }else if($modelDetail->type=='WATER'){echo ' M3';} echo '</td>
                  <td>'.($modelDetail->usage->cur_value); if($modelDetail->type=='ELECTRICITY'){echo ' Kwh'; }else if($modelDetail->type=='WATER'){echo ' M3';} echo '</td>
                  <td>'.($modelDetail->usageDelta); if($modelDetail->type=='ELECTRICITY'){echo ' Kwh'; }else if($modelDetail->type=='WATER'){echo ' M3';} echo '</td>
                  <td>Rp. '.number_format($formula->tdl,0,',','.').'</td>
                  <td>'.$formula->formula.'</td>
                  <td>'.$tax->formula.' %</td>
                  <td>'.$admin->value.' %</td>
                  <td>Rp. '.number_format($usageValueTotal,0,',','.').',-</td>
                </tr>';

              }
            }else{
                echo '
                <thead>
                <tr>
                  <th>No</th>
                  <th>Type Of Charge</th>
                  <th>Space Size</th>
                  <th>Tariff</th>
                  <th>Formula</th>
                  <th>tax</th>
                  <th>Admistration</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>';
              
              $no=0;
              $subtotal=0;
              $totalTax=0;
              $totalAdmin=0;
              
              foreach ($modelDetail as $modelDetail) {
                $no++;
                $formula=json_decode($modelDetail->tariffPdf->formula);
                $tax=json_decode($modelDetail->tariffPdf->tax_formula);
                $admin=json_decode($modelDetail->tariffPdf->admin_formula);

                if($modelDetail->tariffRecur=='3MONTH'){
                    $usageValueTotal=($modelDetail->unitSpace*$formula->tdl)*3;
                    $formulaPrint='Space size x Tariff x 3 Month';
                }else if($modelDetail->tariffRecur=='6MONTH'){
                    $usageValueTotal=($modelDetail->unitSpace*$formula->tdl)*6;
                    $formulaPrint='Space size x Tariff x 6 Month';
                }else if($modelDetail->tariffRecur=='YEAR'){
                    $usageValueTotal=($modelDetail->unitSpace*$formula->tdl)*12;
                    $formulaPrint='Space size x Tariff x 12 Month';
                }

                $subtotal+=$usageValueTotal;
                $totalTax+=$tax->formula;
                $totalAdmin+=$admin->value;

                echo '
                <tr>
                  <td>'.$no.'</td>
                  <td>'.$modelDetail->type.'</td>
                  <td>'.$modelDetail->unitSpace.' '.$modelDetail->unitSatuan.'</td>
                  <td>Rp. '.number_format($formula->tdl,0,',','.').'</td>
                  <td>'.$formulaPrint.'</td>
                  <td>'.$tax->formula.' %</td>
                  <td>'.$admin->value.' %</td>
                  <td>Rp. '.number_format($usageValueTotal,0,',','.').',-</td>
                </tr>';

              }
            }
              
              ?>
                
                
              </tbody>
            </table>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row">
          <!-- accepted payments column -->
          <div class="col-xs-6">
            <p class="lead">Notes:</p>
            <div style="background: #F9F9F9; padding: 15px 10px 5px 0px; border-radius: 6px;">
             <ul>
                  <li>Payment due date 10th each month</li>

                  <li>Payment after date 25th will be allocated on your next month Billing Statement</li>

                  <li>Payment after due date will have 5% fine from total billing amount</li>

                  <li>Payment can be made by crossed cheque (GIRO) or transfer with state your name, unit no, and invoice no.</li>

                  <li>Please fax your giro or transfer slip/copy to our office at fax no : 021-021-93903718 or confirm to email : 18collection@gmail.com after payment</li>

              </ul>

              <ul>
                <li><b>Pembayaran ditujukan ke : / Payment to : PPRS Woodland Park Residence BCA - Cab. --------------------- </b></li>
                <li><b>No. Rek / Acc. No. : 4509-181818 </b></li>
                <li><b>Mohon cantumkan : No. UNIT & No. INVOICE Please state your UNIT No. & INVOICE No</b></li>
              </ul>

                

            </div>

            
            
          </div><!-- /.col -->
          <div class="col-xs-6">
            <p class="lead">Amount Due <?= date('d/m/Y', $model->charge_date); ?></p>
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th style="width:50%">Subtotal:</th>
                  <td><?= 'Rp. '.number_format($subtotal,0,',','.').',-' ?></td>
                </tr>
                <tr>
                  <th>Total Tax</th>
                  <td><?= 'Rp. '.number_format($totalTax,0,',','.').',-' ?></td>
                </tr>
                <tr>
                  <th>Total Admin</th>
                  <td><?= 'Rp. '.number_format($totalAdmin,0,',','.').',-' ?></td>
                </tr>
                <tr>
                  <th>Total:</th>
                  <td><?= 'Rp. '.number_format($subtotal+$totalAdmin+$totalTax,0,',','.').',-' ?></td>
                </tr>
              </table>
            </div>
            <p class="lead" style="margin-top: 120px; text-decoration: underline;">Building Management</p>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->
    </div><!-- ./wrapper -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
