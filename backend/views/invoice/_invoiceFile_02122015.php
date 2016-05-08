<?php
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $content string */
?>
<?php $this->beginPage() ?>

<html>
<head>
	<meta charset="UTF-8"/>
    
    <title></title>
    
</head>
<body>
	<div style='float:left; margin-left:400px; text-align:left; padding:0px 5px 0px 5px; width:400px; border:solid 1px #000'><?= $model->namePerson; ?></div>
	<div style='float:left; margin-left:400px; margin-top:1px; text-align:left; padding:0px 5px 0px 5px; width:400px; border:solid 1px #000'><?= $model->unitCode; ?></div>
	<div style='float:left; margin-left:400px; font-size:10px; margin-top:1px; text-align:left; padding:0px 5px 0px 5px; width:400px; border:solid 1px #000'><?= $model->address->building.",".$model->address->street.". ".$model->address->city." ".$model->address->province; ?></div>
	<div style='float:left; margin-left:400px; margin-top:5px; text-align:left; padding:0px 5px 0px 5px; width:120px; border:solid 1px #000'>No Invoice</div>
	<div style='float:left; margin-left:1px; text-align:left; padding:0px 5px 0px 5px; width:135px; border:solid 1px #000'><?= $model->inv_number; ?></div>
	<div style='float:left; margin-left:400px; margin-top:1px; text-align:left; padding:0px 5px 0px 5px; width:120px; border:solid 1px #000'>Tgl Invoice</div>
	<div style='float:left; margin-left:1px; text-align:left; padding:0px 5px 0px 5px; width:135px; border:solid 1px #000'><?= date('d-F-Y', $model->charge_date); ?></div>
	<div style='float:left; margin-left:400px; margin-top:1px; text-align:left; padding:0px 5px 0px 5px; width:120px; border:solid 1px #000'>Tgl Jatuh Tempo</div>
	<div style='float:left; margin-left:1px; text-align:left; padding:0px 5px 0px 5px; width:135px; border:solid 1px #000'><?= date('d-F-Y', $model->due_date); ?></div>
	<div>
		<table style='margin-top:20px;' cellpadding="5px" cellspacing="0px" width="100%">
			<tr>
				<td style='border:solid 1px #000; width:70%; text-align:center; font-weight:bold'>Keterangan</td>
				<td style='border:solid 1px #000; border-left:none; text-align:center; font-weight:bold'>Jumlah</td>
			
			</tr>
			<tr>
				<td valign="top" style="border:solid 1px #000; width:70%; border-top:none; line-height:30px;">

					<table cellpadding="5">
						<tr>
							<?php if(substr($model->inv_number, 5,1)=='U'){
								echo '<td style="font-size:10px; font-weight:bold;" colspan="7">Perhitungan Pemakaian Utilitas (Listrik dan Air )</td>';
							}
							else if(substr($model->inv_number, 5,1)=='M'){
								echo '<td style="font-size:10px; font-weight:bold;" colspan="7">Perhitungan Iuaran Pengelolaan Lingkungan (IPL)</td>';	
							}
							else if(substr($model->inv_number, 5,1)=='S'){
								echo '<td style="font-size:10px; font-weight:bold;" colspan="7">Perhitungan Iuaran Singking Fund (SF)</td>';	
							}else{
								echo '<td></td>';
							}
							$totalbiaya=null;
							$subtotal=null;
							$subtotal2=null;
						?>
						</tr>
						<tr>
							<td style="font-size:10px; font-weight:bold;" colspan="7">Periode Pemakaian</td>
						</tr>
						<?php
						$no=0;
						foreach ($modelDetail as $modelDetail) {
						$no++;
						echo '
							<tr>
								<td colspan="7" style="font-size:10px; font-weight:bold; padding-top:20px">'.$no.'. '.$modelDetail->type.'</td>
							</tr>';
							
							if($modelDetail->type=='ELECTRICITY'){
							echo '
							<tr>
								<td>Daya Terpasang</td>
								<td>:</td>
								<td>'.($modelDetail->unitData/1000).'</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								
							  </tr>
							  <tr>
								<td>Meter Awal</td>
								<td>:</td>
								<td>'.($modelDetail->usage->prev_value).'Kwh</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								
							  </tr>
							  <tr>
								<td>Meter Akhir</td>
								<td>:</td>
								<td style="border-bottom:solid 1px #000;">'.($modelDetail->usage->cur_value).' Kwh</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								
							  </tr>
							  <tr>
								<td>Pemakaian</td>
								<td>:</td>
								<td>'.($modelDetail->usage->delta).' Kwh</td>
								<td>x</td>';
								if(substr($model->unitCode, 0,2)=='OF'){
									echo '<td>1732</td>
									<td>=</td>
									<td style="border-bottom:solid 1px #000;">Rp. '.($modelDetail->usage->delta*1732).'</td>';
								}else {
									echo '
								<td>Rp. '.($modelDetail->tariffFormula).'</td>
								<td>=</td>
								<td style="border-bottom:solid 1px #000;">Rp. '.($modelDetail->usage->delta)*($modelDetail->tariffFormula).'</td>';

								}
								echo '
								
								
							  </tr>
							  <tr>
								<td>PJU</td>
								<td>:</td>
								<td>'.($modelDetail->pju).' %</td>
								<td>x</td>
								<td>Rp. '.($modelDetail->usage->delta)*($modelDetail->tariffFormula).'</td>
								<td>=</td>';
								if(substr($model->unitCode, 0,2)=='OF'){
									echo '
									<td>Rp. '.(($modelDetail->usage->delta*1732)*3/100).'</td>';

								}else{
									echo '
									<td>Rp. '.(($modelDetail->usage->delta)*($modelDetail->tariffFormula)*$modelDetail->pju/100).'</td>';
								}
								echo '
								
							  </tr>
							  <tr>
								<td>Biaya Pemeliharaan</td>
								<td>:</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>Rp. 0</td>
								
							  </tr>
							  <tr>
								<td>Administrasi</td>
								<td>:</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>';
								if(substr($model->unitCode, 0,2)=='OF'){
									echo '
								<td style="border-bottom:solid 1px #000">Rp. '.(($modelDetail->usage->delta*1732)*10/100).'</td>';
								}else{
									echo '
								<td style="border-bottom:solid 1px #000">Rp. '.$modelDetail->tariffAdmin.'</td>';
								}
								echo '
								
							  </tr>
							  <tr>';
							  			if(substr($model->unitCode, 0,2)=='OF'){
							  				echo '<td colspan="7" style="font-weight:bold">Pemakaian x 1732 + PJU (3%) + Admin (10%)</td>';
							  				echo '.';

							  			}else{
							  				echo '
												<td colspan="7" style="font-weight:bold">Subtotal Biaya - 40 Jam x 1153 x Daya ('.($modelDetail->unitData).' KVA) </td>
											  ';
							  			}
							  echo '</tr>';				

							} else if($modelDetail->type=='WATER')

							{
								echo '
							 <tr>
								<td>Meter Awal</td>
								<td>:</td>
								<td>'.($modelDetail->usage->prev_value).'Kwh</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								
							  </tr>
							  <tr>
								<td>Meter Akhir</td>
								<td>:</td>
								<td style="border-bottom:solid 1px #000;">'.($modelDetail->usage->cur_value).' Kwh</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								
							  </tr>
							  <tr>
								<td>Pemakaian</td>
								<td>:</td>
								<td>'.($modelDetail->usage->delta).' Kwh</td>
								<td>x</td>
								<td>Rp. '.($modelDetail->tariffFormula).'</td>
								<td>=</td>
								<td style="border-bottom:solid 1px #000;">Rp. '.($modelDetail->usage->delta)*($modelDetail->tariffFormula).'</td>
								
							  </tr>
							 
							  <tr>
								<td>Biaya Pemeliharaan</td>
								<td>:</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>Rp. 0</td>
								
							  </tr>
							  <tr>
								<td>Administrasi</td>
								<td>:</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td style="border-bottom:solid 1px #000">Rp. '.$modelDetail->tariffAdmin.'</td>
								
							  </tr>
							  <tr>
								<td colspan="7" style="font-weight:bold">Subtotal Biaya Pemakaian Air</td>
							  </tr>';	
							}
						}
					?>					
					</table>
					
				</td>
				
				<td valign="top" style='border:solid 1px #000; border-left:none; text-align:center; font-weight:bold; border-top:none'>
					<table cellpadding="5">
						<tr>
							<td style="color:#fff">-</td>
						</tr>
						<tr>
							<td style="color:#fff">-</td>
						</tr>
						<?php
						$no=0;
						foreach ($modelDetail2 as $modelDetail2) {
						$no++;
						
						echo '
							<tr>
								<td colspan="7" style="font-size:10px; font-weight:bold; padding-top:20px; color:#fff">-</td>
							</tr>';
							if($modelDetail2->type=='ELECTRICITY'){
							// $subtotal = (($modelDetail2->usageDelta)*($modelDetail2->tariffFormula)*$modelDetail2->pju/100)+($modelDetail2->usageDelta)*($modelDetail2->tariffFormula)+$modelDetail2->tariffAdmin;
								if(substr($model->unitCode, 0,2)=='OF'){
									$subtotal = ($modelDetail2->usage->delta*1732) + (($modelDetail2->usage->delta*1732)*3/100) + (($modelDetail2->usage->delta*1732)*10/100);
								}else{
									$subtotal = ((40*1153)*$modelDetail2->unitData);

								}
							echo '
							<tr>
								<td style="color:#fff">-</td>
								
							  </tr>
							  <tr>
								<td style="color:#fff">-</td>
								
								
							  </tr>
							  <tr>
								<td style="color:#fff">-</td>
								
							  </tr>
							  <tr>
								<td style="color:#fff">-</td>
								
							  </tr>
							  <tr>
								<td style="color:#fff">-</td>
								
							  </tr>
							  <tr>
								<td style="color:#fff">-</td>
								
							  </tr>
							  <tr>
								<td colspan="7" style="font-weight:bold; padding-top:25px">Rp. '.$subtotal.'</td>
							  </tr>';
							} else if($modelDetail2->type=='WATER')
							{
								$subtotal2 = ($modelDetail2->usageDelta)*($modelDetail2->tariffFormula)+$modelDetail2->tariffAdmin;
								echo '
								<tr>
								<td style="color:#fff">-</td>
								
							  </tr>
							  <tr>
								<td style="color:#fff">-</td>
								
								
							  </tr>
							  <tr>
								<td style="color:#fff">-</td>
								
							  </tr>
							  <tr>
								<td style="color:#fff">-</td>
								
							  </tr>
							  <tr>
								<td style="color:#fff">-</td>
								
							  </tr>
							  <tr>
								<td colspan="7" style="font-weight:bold; padding-top:10px">Rp. '.$subtotal2.'</td>
							  </tr>';	
							}
							
						}
					?>					
					</table>
				

				</td>
			
			</tr>      
			<?php $total=$subtotal+$subtotal2; ?>
			<tr>
				<td style='border:solid 1px #000; border-top:none; text-align:center; font-weight:bold'>Total Tagihan Utilitas Bulan Ini (Biaya Pemakaian Listri dan Air)</td>
				<td style='border:solid 1px #000; border-top:none; border-left:none; text-align:center; font-weight:bold'><?php echo 'Rp. '.$total; ?></td>
			</tr>
		</table>
	</div>
</body>
</html>
