<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PayBilling */

$this->title = 'Payment Receipt Invoice : '.$model2->inv_number;
$this->params['breadcrumbs'][] = ['label' => 'Payment Receipt', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-billing-view">

    
        <section class="invoice" style="padding: 30px 50px">
          <!-- title row -->
           <div class="row">
            <div class="col-xs-12">
              
              <table class="table table-bordered" width="100%">
                  <tr>                    
                    <td rowspan="3" style="width:20%; padding:20px 10px;"><img src="../web/dist/img/wplogo.png"></td>
                    <td rowspan="3" style="width:50%; padding:20px 80px 10px 80px; line-height: 35px; text-transform: uppercase; font-size:40px; text-align: center">WoodLand Park Residence</td>
                    <td style="width:30%">No Dokumen : F : FAC-04</td>
                  </tr>
                  <tr>                    
                    <td style="width:20%">Departemen : Finance & Acc</td>
                  </tr>
                  <tr>                    
                    <td style="width:20%">Berlaku Efektif : </td>
                  </tr>
                  <tr>                    
                    <td colspan="2" rowspan="2" style="width:20% padding:10px 80px 0px 80px; line-height: 35px; text-transform: uppercase; font-size:35px; text-align: center"><p style="margin-top: 10px">Bukti Deposit</p></td>                  
                    <td style="width:20%">Revisi : </td>
                  </tr>
                  <tr>              
                    <td style="width:20%">Halaman : 1 dari 1</td>
                  </tr>
              </table>
            </div><!-- /.col -->
          </div>
          
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              <p>Sudah terima dari : <strong><?= $model2->personBill; ?></strong></p>
              <p style="margin-top: -5px;">Lantai/Blok/No.   : <strong><?= $model2->unit_code; ?></strong></p>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
             
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col" style="text-align: right;">
              <p>NO KWITANSI : P.1022020202</p>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div class="row">
            <div class="col-xs-12">
              <table width="100%">
                <tr>
                  <td style="width:70%">
                  
                    <table class="table table-striped">
                    <thead>
                      <tr>
                        
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Admin</th>
                        <th>Tax</th>
                        <th>Total</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no=0;
                    $subtotal=0;
                    foreach ($model as $model) {
                      $no++;
                      
                      echo '
                      <tr>
                        
                        <td>'; 
                          if ($model->type=='ELECTRICITY') {
                            echo 'Pembayaran Tagihan Listrik Periode ';
                          }else if($model->type=='WATER'){
                            echo 'Pembayaran Tagihan Air Periode ';
                          }else if($model->type=='SINKINGFUND'){
                            echo 'Pembayaran Tagihan SINKINGFUND Periode ';
                          }else if($model->type=='IURAN PEMELIHARAAN LINGKUNGAN'){
                            echo 'Pembayaran Iuran Pengelolaan Lingkungan Periode ';
                          }
                        echo'</td>
                        <td>Rp.'.number_format($model->unitChargeValue->value_charge,0,',','.').'</td>
                        <td>Rp.'.number_format($model->unitChargeValue->value_admin,0,',','.').'</td>
                        <td>Rp.'.number_format($model->unitChargeValue->value_tax,0,',','.').'</td>
                        <td>Rp.'.number_format($model->total_charge,0,',','.').'</td>
                        
                      </tr>';
                      $subtotal+=$model->total_charge;
                    }
                      
                    echo '  
                    </tbody>
                    <tfooter>
                      <tr>
                        <td colspan="4" style="text-align: center; font-weight: bold;">TOTAL TAGIHAN</td>
                        <td><strong>Rp.'.number_format($subtotal,0,',','.').'</strong></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align: center; font-weight: bold; color:red;">TOTAL Deposit</td>
                        <td style="color:red;"><strong>Rp.'.number_format($modelDeposit,0,',','.').'</strong></td>
                      </tr>
                    </tfooter>';

                    ?>
                  </table>
                  
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td>Ini adalah bukti pembayaran tagihan sebagian, status pembayaran terhadap tagihan adalah <strong style="color:red">belum terbayar</strong>. Dana yg tertera pada total deposit sebesar <strong><?= 'Rp.'.number_format($modelDeposit,0,',','.').'</strong> akan dimasukan sebagai deposit anda'; ?></td>
                                                
                      </tr>
                    </tbody>
                  </table>

                  </td>
                  <td style="width:30%; padding:10px 20px" valign="top">
                      <p><strong>Pembayaran Dengan : </strong></p>
                      <p>Cash</p>
                      <p style="margin-top: 10px">Jakarta, <span style="margin-left: 80px"><?php echo date('d/m/Y'); ?></span></p> 
                      <p style="margin-top: 100px">(.......................................................)</p>
                      <p style="margin-top: -10px; margin-left: 70px">Bendahara</p>
                  </td>
                </tr>

              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-2"><?php
              echo '
              <a class="btn btn-block btn-default" href="index.php?r=pay-billing/print&invnumber='.$model2->inv_number.'" target="_blank"><i class="fa fa-print"></i> Print</a>';
              ?>
            </div>
          </div>
        </section><!-- /.content -->

</div>
