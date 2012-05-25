<?php
include('../include.php');

$array	  = array_ajax('investor_country,host_country');

//get values from db
$investor = db_grab('SELECT pdi, idv, mas, uai, ltowvs, ivr FROM user_countries WHERE id = ' . $array['investor_country']);
$host	  = db_grab('SELECT pdi, idv, mas, uai, ltowvs, ivr FROM user_countries WHERE id = ' . $array['host_country']);

//calculate and echo cultural distance
$distance = abs($investor['pdi'] - $host['pdi']) + 
			abs($investor['idv'] - $host['idv']) + 
			abs($investor['mas'] - $host['mas']) + 
			abs($investor['uai'] - $host['uai']) + 
			abs($investor['ltowvs'] - $host['ltowvs']) + 
			abs($investor['ivr'] - $host['ivr']);
			
echo $distance;