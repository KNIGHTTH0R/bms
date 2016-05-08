<?php

// $json_data = 'www.infopangan.jakarta.go.id/api/price/series_by_commodity?public=1&cid=12&m=4&y=2016';
// $ch = curl_init($json_data);
// $options = array(
// 	CURLOPT_RETURNTRANSFER => TRUE,
// 	CURLOPT_HTTPHEADER => array('Content-type: application/json'),
// 	CURLOPT_POSTFIELDS => $json_data
// 	);
// curl_setopt_array($ch, $options);
// echo $result = curl_exec($ch);
// $decode = json_decode($result, true);
// print_r($decode);

// function bacaHtml($url){

		$data = curl_init();
	$url = 'http://www.infopangan.jakarta.go.id/api/price/series_by_commodity?public=1&cid=12&m=4&y=2016';
	curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($data, CURLOPT_URL, $url);

	$hasil = curl_exec($data);
	
	curl_close($data);
	$decode = json_decode($hasil, true);
	print_r($decode);

	echo "<p style=color:red>".$decode['data']['0']['series'][1]."</p>";
	$num=0;
	foreach ($decode['data'] as $data) {
		$num++;
		$num2=0;
		foreach ($data['series'] as $data2) {
			$num2++;
			echo $decode[$num]['name']."-".$data2[$num2]."<br />";
		}
		// echo $num."<br />";
	}













	// $hasil = json_decode($hasil);

	// return $hasil;
// }

// echo bacaHtml("http://www.infopangan.jakarta.go.id/api/price/series_by_commodity?public=1&cid=12&m=4&y=2016");


// {"status":"ok","message":"","data":
//  [
//  	{"name":"Pasar Induk Kramat Jati","id":"1","low":"34000","high":"36000","average":"35250","series":{"1":"34000","2":"35000","3":"36000","4":"36000"}},
//  	{"name":"Pasar Senen Blok III - VI","id":"3","low":"40000","high":"40000","average":"40000","series":{"1":"40000","2":"40000","3":"40000","4":"40000"}},
//  	{"name":"Pasar Jembatan Merah","id":"4","low":"45000","high":"45000","average":"45000","series":{"1":"45000","2":"45000","3":"45000","4":"45000"}},
//  	{"name":"Pasar Sunter Podomoro","id":"5","low":"42000","high":"44000","average":"43600","series":{"1":"44000","2":"44000","3":"44000","4":"44000"}},
//  	{"name":"Pasar Rawa Badak","id":"6","low":"45000","high":"50000","average":"48000","series":{"1":"50000","2":"50000","3":"50000","4":"45000"}},
//  	{"name":"Pasar Grogol","id":"7","low":"45000","high":"45000","average":"45000","series":{"1":"45000","2":"45000","3":"45000","4":"45000"}},
//  	{"name":"Pasar Glodok","id":"8","low":"45000","high":"50000","average":"47500","series":{"1":"45000","3":"50000"}},
//  	{"name":"Pasar Minggu","id":"9","low":"40000","high":"45000","average":"43750","series":{"1":"45000","2":"45000","3":"45000","4":"40000"}},
//  	{"name":"Pasar Mayestik","id":"10","low":"45000","high":"50000","average":"48600","series":{"1":"50000","2":"50000","3":"50000","4":"45000"}},
//  	{"name":"Pasar Pramuka","id":"11","low":"40000","high":"42000","average":"40800","series":{"1":"40000","2":"40000","3":"40000","4":"42000"}},
//  	{"name":"Pasar Kramat Jati","id":"12","low":"36000","high":"45000","average":"39400","series":{"1":"36000","2":"40000","3":"37000","4":"39000"}},
//  	{"name":"Pasar Jatinegara","id":"13","low":"43000","high":"45000","average":"44400","series":{"1":"45000","2":"45000","3":"45000","4":"44000"}}
//  ]
// }

?>