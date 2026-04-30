<?php 
/*
	$acount_api 	= "http://1.255.226.238/Mobile/Wallet/accountInfo"; 
	$send_api		= "http://1.255.226.238/Mobile/Wallet/sendFrom";
	$move_api 		= "http://1.255.226.238/Mobile/Wallet/move";
	$list_api		= "http://1.255.226.238/Mobile/Wallet/lists";
	$api_btc_key	= "afahfdg";

$secret_key = "dodobird";
$secret_iv = "#@$%^&*()_+=-";
$api_key			="bFZFbXZoWTlLOE00d1JqUDA1TEdjQT09";
function Decrypt($str, $secret_key='secret key', $secret_iv='secret iv')
{
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 32);

    return openssl_decrypt(
            base64_decode($str), "AES-256-CBC", $key, 0, $iv
    );
}

//마스터 지갑 생성

$mater_wallet = "cereimall_master_wallet";	// 기존
//$mater_wallet = "diot_master_wallet";				// 새 이름
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $acount_api);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, 'deId='.Decrypt($api_key,$secret_key,$secret_iv).'&bitAccount='.$mater_wallet);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	$json_o = json_decode($result, true);
	$arr = $json_o['bitcoin'];
	$master_mostaddress = $arr["bitaddress"];
	$mater_bitbalance = $arr["bitbalance"];
	*/


?>