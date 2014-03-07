<?php
$data = json_decode(file_get_contents('php://input'), true);
if(count($data) > 0) {
	$keys = array_keys($data[0]);
	$url = "csv/" . rand() . ".csv";
	$fp = fopen($url, 'w');
	fputcsv($fp, $keys);
	foreach($data as $obj) {
		$vals = array();
		foreach($keys as $key) {
			array_push($vals, $obj[$key]);
		}
		fputcsv($fp, $vals);
	}
	fclose($fp);
	echo $url;
	exit();
}
echo "error";
?>