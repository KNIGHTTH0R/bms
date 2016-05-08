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
				<td style="border:solid 1px #000; width:70%; border-top:none; line-height:30px;">
				   
					<div style="float:left">
						<?php if(substr($model->inv_number, 5,1)=='U'){
								echo '<p style="font-size:10px; text-align:left; margin-bottom:30px">Perhitungan Pemakaian Utilitas (Listrik dan Air )</p>';
							}
							else if(substr($model->inv_number, 5,1)=='M'){
								echo '<p style="font-size:10px; text-align:left; margin-bottom:30px">Perhitungan Iuaran Pengelolaan Lingkungan (IPL)</p>';	
							}
							else if(substr($model->inv_number, 5,1)=='S'){
								echo '<p style="font-size:10px; text-align:left; margin-bottom:30px">Perhitungan Iuaran Singking Fund (SF)</p>';	
							}	
						?>
					</div>
					
					<div style='margin-top:20px; float:left'>Periode Pemakaian : 21-01-2015 s/d : 20-02-2015</div>
					
					<ul style="list-style-type:circle; line-height:10px;">
					<?php
					foreach ($modelDetail as $modelDetail) {
						echo '<li>'.$modelDetail->type.'
									<ul>';
									
									if($modelDetail->type=='ELECTRICITY'){
										echo '<li> Daya Terpasang : '.($modelDetail->unitData/1000).' KVA</li>';
										echo '<li> Meter Awal : '.($model->usageAllDetail->prev_value).' Kwh</li>';
										echo '<li> Meter Akhir : '.($model->usageAllDetail->cur_value).' Kwh</li>';
										echo '<li>-----------------------------------------------------------</li>';
										echo '<li style=margin-top:-20px> Pemakaian : '.($model->usageAllDetail->delta).' Kwh</li>';
										echo '<li style=margin-top:-20px> Subtotal Biaya - 40 Jam x 1153 x Daya ('.($modelDetail->unitData/1000).' KVA) : Rp. '.(40*1153*$modelDetail->unitData/1000).' </li>';
										
									}else if($modelDetail->type=='WATER'){
										echo '<li> Meter Awal</li>';	
									}
									
									echo '
									</ul>
							  </li>';
					}
					
					echo '</ul>';
					?>

				</td>
				<td valign="top" style='border:solid 1px #000; border-left:none; text-align:center; font-weight:bold; border-top:none'>
					
				<div style="margin-top:100px; float:left"><?php echo 'Rp. '.(40*1153*$modelDetail->unitData/1000); ?></div>

				</td>
			
			</tr>      
			
		</table>
	</div>
</body>
</html>
