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
	<div style='float:left; margin-left:400px; text-align:left; padding:0px 5px 0px 5px; width:400px; border:solid 1px #000; font-size:11px;'><?= $model->namePerson; ?></div>
	<div style='float:left; margin-left:400px; margin-top:1px; text-align:left; padding:0px 5px 0px 5px; width:400px; border:solid 1px #000; font-size:11px;'><?= $model->unitCode; ?></div>
	<div style='float:left; margin-left:400px; font-size:10px; margin-top:1px; text-align:left; padding:0px 5px 0px 5px; width:400px; border:solid 1px #000; font-size:11px;'><?= $model->address->building.",".$model->address->street.". ".$model->address->city." ".$model->address->province; ?></div>
	<div style='float:left; margin-left:400px; margin-top:5px; text-align:left; padding:0px 5px 0px 5px; width:120px; border:solid 1px #000; font-size:11px;'>No Invoice</div>
	<div style='float:left; margin-left:1px; text-align:left; padding:0px 5px 0px 5px; width:135px; border:solid 1px #000; font-size:11px;'><?= $model->inv_number; ?></div>
	<div style='float:left; margin-left:400px; margin-top:1px; text-align:left; padding:0px 5px 0px 5px; width:120px; border:solid 1px #000; font-size:11px;'>Tgl Invoice</div>
	<div style='float:left; margin-left:1px; text-align:left; padding:0px 5px 0px 5px; width:135px; border:solid 1px #000; font-size:11px;'><?= date('d-F-Y', $model->charge_date); ?></div>
	<div style='float:left; margin-left:400px; margin-top:1px; text-align:left; padding:0px 5px 0px 5px; width:120px; border:solid 1px #000; font-size:11px;'>Tgl Jatuh Tempo</div>
	<div style='float:left; margin-left:1px; text-align:left; padding:0px 5px 0px 5px; width:135px; border:solid 1px #000; font-size:11px;'><?= date('d-F-Y', $model->due_date); ?></div>
	<div>
		<table style='margin-top:10px;' cellpadding="5px" cellspacing="0px" width="100%">
			<tr>
				<td style='border:solid 1px #000; width:70%; text-align:center; font-weight:bold; font-size:11px;'>Keterangan</td>
				<td style='border:solid 1px #000; border-left:none; text-align:center; font-weight:bold; font-size:11px'>Jumlah</td>
			
			</tr>
			<tr>
				<td valign="top" style="border:solid 1px #000; width:80%; border-top:none; line-height:30px;">

					<table cellpadding="3" style="font-size:11px">
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
							$usageValueTotal=null;
							$usageValueTotal2=null;

						?>
						</tr>
						<tr>
							<td style="font-size:10px; font-weight:bold;" colspan="7">Periode Pemakaian</td>
						</tr>
						<?php
						$no=0;
						foreach ($modelDetail as $modelDetail) {
						$no++;
						if(substr($modelDetail->unitCode, 0,2)=='OF'){
							
							if($modelDetail->type<>'WATER'){
								echo '
							<tr>
								<td colspan="7" style="font-size:10px; font-weight:bold; padding-top:20px">'.$no.'. '.$modelDetail->type.'</td>
							</tr>';
							}else{

							}
							
						}else if(substr($model->inv_number, 5,1)=='M'){
							echo '
							<tr>
								<td colspan="7" style="font-size:10px; font-weight:bold; padding-top:20px">'.$no.'. Perhitungan Iuaran Pengelolaan Lingkungan (IPL)</td>
							</tr>';
						}
						else{
							echo '
							<tr>
								<td colspan="7" style="font-size:10px; font-weight:bold; padding-top:20px">'.$no.'. '.$modelDetail->type.'</td>
							</tr>';
						}
						
						if($modelDetail->type=='ELECTRICITY'){
							echo '
							<tr>
								<td>Daya Terpasang</td>
								<td>:</td>
								<td>'.($modelDetail->unitData).'</td>
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
							  <tr>';

								if(substr($model->unitCode, 0,2)=='OF'){

									$usageValue = $modelDetail->usageDelta*$modelDetail->tariffFormula;
									$usageValueTotal=($modelDetail->usageDelta*$modelDetail->tariffFormula)+(($modelDetail->usageDelta*$modelDetail->tariffFormula)*$modelDetail->pju/100)+(($modelDetail->usageDelta*$modelDetail->tariffFormula)*$modelDetail->tariffAdmin/100);
									echo '
											<td>Pemakaian</td>
											<td>:</td>
											<td>'.$modelDetail->usageDelta.' (Delta)</td>
											<td>x</td>
											<td>'.($modelDetail->tariffFormula).' (Tariff)</td>
											<td>=</td>
										 ';
									

								}else{

									$usageValueTotal=(40*$modelDetail->tariffFormula)*$modelDetail->unitData;
									$usageValue=(40*$modelDetail->tariffFormula)*$modelDetail->unitData;
									echo '
											<td>Pemakaian</td>
											<td>:</td>
											<td>40 x '.($modelDetail->tariffFormula).'</td>
											<td>x</td>
											<td>'.($modelDetail->unitData).' Kwh</td>
											<td>=</td>

										 ';
								}

								
								echo '
								<td style="border-bottom:solid 1px #000;">Rp. '.$usageValue.'</td>
								
							  </tr>
							  
							  <tr>
								<td>PJU</td>
								<td>:</td>
								<td>'.($modelDetail->pju).' %</td>
								<td>x</td>
								<td>Rp. '.$usageValue.'</td>
								<td>=</td>
								<td>Rp. '.$usageValue*($modelDetail->pju/100).'</td>
								
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
								<td>'.$modelDetail->tariffAdmin.'%</td>
								<td>x</td>
								<td>Rp. '.$usageValue.'</td>
								<td>=</td>
								<td style="border-bottom:solid 1px #000">Rp. '.$usageValue*($modelDetail->tariffAdmin/100).'</td>
								
							  </tr>
							  <tr>
								<td colspan="7" style="font-weight:bold">Subtotal Biaya Pemakaian Listrik</td>
							  </tr>';
							} else if($modelDetail->type=='WATER')

							{

							if(substr($model->unitCode, 0,2)<>'OF'){
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
						}
					?>					
					</table>
					
				</td>
				
				<!-- isi kolam Jumlah Mulai dari sini -->

				<td valign="top" style='border:solid 1px #000; border-left:none; text-align:center; font-weight:bold; border-top:none; font-size:10px; line-height:30px'>
					<table cellpadding="3">
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
								<td style="font-size:10px; font-weight:bold; padding-top:20px; color:#fff">-</td>
							</tr>';
							if($modelDetail2->type=='ELECTRICITY'){

							// $subtotal = ((40*$modelDetail2->tariffFormula)*$modelDetail2->unitData)+((40*$modelDetail2->tariffFormula)*($modelDetail2->unitData)*$modelDetail2->pju/100)+((40*$modelDetail2->tariffFormula)*($modelDetail2->unitData)*$modelDetail2->tariffAdmin/100);
							// $subtotal = (($modelDetail2->usageDelta)*($modelDetail2->tariffFormula)*$modelDetail2->pju/100)+($modelDetail2->usageDelta)*($modelDetail2->tariffFormula)+$modelDetail2->tariffAdmin;
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
								<td style="font-weight:bold">Rp. '.$usageValueTotal.'</td>
							  </tr>';
							} else if($modelDetail2->type=='WATER')

							{	// $subtotal2 = ($modelDetail2->usageDelta)*($modelDetail2->tariffFormula)+$modelDetail2->tariffAdmin;
								$usageValueTotal2 = ($modelDetail2->usageDelta)*($modelDetail2->tariffFormula)+$modelDetail2->tariffAdmin;
								if(substr($model->unitCode, 0,2)<>'OF'){
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
										<td style="font-weight:bold; padding-top:0px;">Rp. '.$usageValueTotal2.'</td>
									  </tr>';	
								}else{

								}
								
							}

							else if($modelDetail2->type=='SERVICECHARGE'){
							// $subtotal = ((40*$modelDetail2->tariffFormula)*$modelDetail2->unitData)+((40*$modelDetail2->tariffFormula)*($modelDetail2->unitData)*$modelDetail2->pju/100)+((40*$modelDetail2->tariffFormula)*($modelDetail2->unitData)*$modelDetail2->tariffAdmin/100);
							// $subtotal = (($modelDetail2->usageDelta)*($modelDetail2->tariffFormula)*$modelDetail2->pju/100)+($modelDetail2->usageDelta)*($modelDetail2->tariffFormula)+$modelDetail2->tariffAdmin;
							if(substr($model->unitCode, 0,2)=='OF'){
								$usageValueTotal=($modelDetail2->tariffFormula*12)*$modelDetail2->unitSpace;		
							}else{
								$usageValueTotal=($modelDetail2->tariffFormula*12)*$modelDetail2->unitSpace;		
							}
							echo '
							<tr>
								<td style="font-weight:bold">Rp. '.$usageValueTotal.'</td>
							  </tr>';
							}

							else if($modelDetail2->type=='SINKINGFUND'){
							// $subtotal = ((40*$modelDetail2->tariffFormula)*$modelDetail2->unitData)+((40*$modelDetail2->tariffFormula)*($modelDetail2->unitData)*$modelDetail2->pju/100)+((40*$modelDetail2->tariffFormula)*($modelDetail2->unitData)*$modelDetail2->tariffAdmin/100);
							// $subtotal = (($modelDetail2->usageDelta)*($modelDetail2->tariffFormula)*$modelDetail2->pju/100)+($modelDetail2->usageDelta)*($modelDetail2->tariffFormula)+$modelDetail2->tariffAdmin;
							if(substr($model->unitCode, 0,2)=='OF'){
								$usageValueTotal=($modelDetail2->tariffFormula*6)*$modelDetail2->unitSpace;		
							}else{
								$usageValueTotal=($modelDetail2->tariffFormula*6)*$modelDetail2->unitSpace;		
							}
							echo '
							<tr>
								<td style="font-weight:bold">Rp. '.$usageValueTotal.'</td>
							  </tr>';
							}
							
						}
						if(substr($model->unitCode, 0,2)<>'OF'){
							$total = $usageValueTotal+$usageValueTotal2;	
						}else{
							$total = $usageValueTotal;
						}
						
					?>					
					</table>
				

				</td>
			
			</tr>      
			<tr><?php 
				if(substr($model->unitCode, 0,2)<>'OF' AND $model->type <> 'SERVICECHARGE' AND $model->type <> 'SINKINGFUND' ){
					echo "<td style='border:solid 1px #000; border-top:none; text-align:center; font-weight:bold; font-size:10px'>Total Tagihan Utilitas Bulan Ini (Biaya Pemakaian Listrik dan Air)</td>";
				}
				else if(substr($model->unitCode, 0,2)<>'OF' AND $model->type == 'SERVICECHARGE'){
					echo "<td style='border:solid 1px #000; border-top:none; text-align:center; font-weight:bold; font-size:10px;'>Total Tagihan  Iuaran Pengelolaan Lingkungan (IPL) </td>";		
				}
				else if(substr($model->unitCode, 0,2)=='OF' AND $model->type == 'SERVICECHARGE'){
					echo "<td style='border:solid 1px #000; border-top:none; text-align:center; font-weight:bold; font-size:10px;'>Total Tagihan  Iuaran Pengelolaan Lingkungan (IPL) </td>";		
				}
				else if(substr($model->unitCode, 0,2)<>'OF' AND $model->type == 'SINKINGFUND'){
					echo "<td style='border:solid 1px #000; border-top:none; text-align:center; font-weight:bold; font-size:10px;'>Total Tagihan  Iuaran SINGKINGFUND </td>";		
				}
				else if(substr($model->unitCode, 0,2)=='OF' AND $model->type == 'SINKINGFUND'){
					echo "<td style='border:solid 1px #000; border-top:none; text-align:center; font-weight:bold; font-size:10px;'>Total Tagihan  Iuaran SINGKINGFUND </td>";		
				}
				else{
					echo "<td style='border:solid 1px #000; border-top:none; text-align:center; font-weight:bold; font-size:10px'>Total Tagihan Utilitas Bulan Ini (Biaya Pemakaian Listrik)</td>";
				}
				?>
				<td style='border:solid 1px #000; border-top:none; border-left:none; text-align:center; font-weight:bold'><?php echo 'Rp. '.$total; ?></td>
			</tr>
		</table>
		<p style="margin-top:15px; font-size:11px">Catatan / Notes</p>
		<table cellpadding="5px" cellspacing="0px" width="100%">
			
			<tr>
				
				<td colspan="2" style="border:solid 1px #000; line-height:20px; list-style-type: circle;">
					<ul style="font-size:11px;">

						<li>Tanggal jatuh tempo adalah tanggal 10 setiap bulannya</li>
						<li>Pembayaran di atas tanggal 25 akan dialokasikan pada Billing Statement bulan berikutnya</li>
						<li>Pembayaran di atas tanggal jatuh tempo, akan dikenakan sanksi denda 5% dari jumlah total tagihan</li>
						<li>Mulai tanggal 10 Mei 2014 denda keterlambatan akan kembali diberlakukan</li>
						
					</ul>

				</td>	
				<td style="border:none"></td>	
			</tr>
			<tr>
				
				<td colspan="2" style="border:solid 1px #000; border-top:none; line-height:20px; list-style-type: circle;">
					<ul style="font-size:11px;">
						<li>Payment due date 10th each month</li>
						<li>Payment after date 25th will be allocated on your next month Billing Statement</li>
						<li>Payment after due date will have 5% fine from total billing amount</li>
					</ul>
				<td style="border:none"></td>
			</tr>
			<tr>
				
				<td style="border:solid 1px #000; border-top:none; line-height:20px; list-style-type: circle; width:57%;">
					<ul style="font-size:11px;">
						<li>Pembayaran dapat dibuat dengan check/giro atau transfer	dengan mencantumkan nama, nomor unit dan nomor invoice</li>
						<li>Mohon salinan bukti giro/transfer Anda di-fax-kan ke kantor	kami pada nomor fax : 021-93903718 atau</li>
					</ul>	
				</td>	
				<td valign="top" rowspan="2" style="border:solid 1px #000; border-top:none; border-left:none; line-height:20px; list-style-type: circle; width:25%; font-size:11px">
					
					Pembayaran ditujukan ke : / Payment to :
					PPRS Woodland Park Residence
					BCA - Cab. ---------------------
					No. Rek / Acc. No. : 4509-181818
					Mohon cantumkan : No. UNIT & No. INVOICE
					Please state your UNIT No. & INVOICE No.

				</td>
				<td style="border:none; width:23%;"></td>
			</tr>
			<tr>
				<td style="border:solid 1px #000; border-top:none; line-height:20px; list-style-type: circle;">
					<ul style="font-size:11px;">
						<li>Payment can be made by crossed cheque (GIRO) or transfer with state your name, unit no, and invoice no.</li>
						<li>Please fax your giro or transfer slip/copy to our office at fax no : 021-021-93903718 or confirm to email : 18collection@gmail.com after payment</li>
					</ul>
				</td>	
				<td style="border:none;" valign="bottom" align="center"><p style="border-bottom:solid 1px #000">Building Manager</p></td>

			</tr>
			

		</table>
	</div>
</body>
</html>
