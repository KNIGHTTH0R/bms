<?php


/*
Koneksi Lokal
$dbconn = pg_connect("host=localhost port=5432 dbname=bmsfix user=postgres password=tps912014");
*/



$dbconn = pg_connect("host=202.149.74.162 port=5432 dbname=bmsys user=userbms password=bms212");


$pilihSc="SELECT * FROM unit_charge where type='SERVICECHARGE'";
$eksSc = pg_query($pilihSc);
while($sc=pg_fetch_assoc($eksSc)){
		$scid=$sc['id'];
		$updateSc = "UPDATE unit_charge SET type='IURAN PEMELIHARAAN LINGKUNGAN' where id='$scid'";
		$eksUpSC = pg_query($updateSc);
}


?>