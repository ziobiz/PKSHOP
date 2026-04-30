<? 	include "../include/com.php";
	
	$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&user_id=".$_SESSION['member_id'];

	$valid_user = $_SESSION['member_id'];

	
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $api_balance);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec ($ch);
		curl_close ($ch);
	
	
	$json_balance = json_decode($result,true);
	$session_cart = $_SESSION["session_cart"];
	$shop_country = $json_balance["shop_country"];
	if($shop_country == ""){
		$shop_country="1";
	}
	
	
	
?>