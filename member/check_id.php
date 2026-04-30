<?php
	
	include  $_SERVER["DOCUMENT_ROOT"]."/include/com.php";
	
	$id 	= trim($_GET['uid']);    
	$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&userid=".$id;		
	
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $api_check_id);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec ($ch);
	curl_close ($ch);
	
	$json_o = json_decode($result, true);
	echo $json_o['result']; 
?>
