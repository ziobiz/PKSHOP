<?php

if (session_status() === PHP_SESSION_NONE) {

	session_start();

}

include_once dirname(__FILE__) . '/shop_public_config.php';

include_once dirname(__FILE__) . '/com.php';



if (!isset($_SESSION['member_id']) || $_SESSION['member_id'] === '') {

	$valid_user = '';

	$json_balance = array(

		'shop_bonus' => 0,

		'total_SP' => 0,

		'shop_country' => '1',

	);

	$session_cart = isset($_SESSION['session_cart']) ? $_SESSION['session_cart'] : '';

	$shop_country = '1';

} else {

	$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&user_id=" . $_SESSION['member_id'];



	$valid_user = $_SESSION['member_id'];



	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $api_balance);

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);

	curl_setopt($ch, CURLOPT_POST, 1);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

	curl_setopt($ch, CURLOPT_TIMEOUT, 30);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$result = curl_exec($ch);

	curl_close($ch);



	$json_balance = json_decode($result, true);

	if (!is_array($json_balance)) {

		$json_balance = array();

	}

	$session_cart = isset($_SESSION['session_cart']) ? $_SESSION['session_cart'] : '';

	$shop_country = isset($json_balance['shop_country']) ? $json_balance['shop_country'] : '';

	if ($shop_country == '') {

		$shop_country = '1';

	}

}

