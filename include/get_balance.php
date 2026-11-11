<? 	include "../include/com.php";
	include_once dirname(__FILE__) . '/shop_public_config.php';
	
	$mid = isset($_SESSION['member_id']) ? $_SESSION['member_id'] : '';
	$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&user_id=".$mid;

	$valid_user = $mid;

	
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
	if (!is_array($json_balance)) {
		$json_balance = array();
	}
	if (defined('SHOP_BANK_NAME') && SHOP_BANK_NAME !== '') {
		$json_balance['su_bank'] = SHOP_BANK_NAME;
	}
	if (defined('SHOP_BANK_ACCOUNT') && SHOP_BANK_ACCOUNT !== '') {
		$json_balance['su_banknum'] = SHOP_BANK_ACCOUNT;
	}
	if (defined('SHOP_BANK_HOLDER') && SHOP_BANK_HOLDER !== '') {
		$json_balance['su_bankname'] = SHOP_BANK_HOLDER;
	}
	require_once dirname(__FILE__) . '/../lib/shop_currency.php';
	$session_cart = isset($_SESSION["session_cart"]) ? $_SESSION["session_cart"] : null;
	$shop_country = isset($json_balance["shop_country"]) ? $json_balance["shop_country"] : "";
	if($shop_country == ""){
		$shop_country="1";
	}
	
	
	
?>