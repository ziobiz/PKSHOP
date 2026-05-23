<?php
/**
 * Icopay 카드 주문 저장 — JSON 만 반환 (order_ok2 의 디버그 출력·PingPong 우회).
 */
while (ob_get_level() > 0) {
	ob_end_clean();
}
ob_start();

include dirname(__FILE__) . '/../lib/icopay_pg_config.php';
include dirname(__FILE__) . '/../lib/icopay_merchant.php';

if (!defined('ICOPAY_CHILLPAY_ENABLED') || !ICOPAY_CHILLPAY_ENABLED) {
	icopay_json_response(array(
		'success' => false,
		'result' => '0',
		'message' => 'Icopay is not configured. Create lib/icopay_pg_secrets.local.php with ICOPAY_COMP_ID and ICOPAY_BROKER_SECRET.',
	));
}

define('ICOPAY_ORDER_SAVE_VIA_WRAPPER', true);
include dirname(__FILE__) . '/order_ok2.php';

$buf = ob_get_clean();
$trim = trim($buf);

if ($trim !== '' && ($trim[0] === '{' || $trim[0] === '[')) {
	header('Content-Type: application/json; charset=utf-8');
	echo $trim;
	exit;
}

if ($trim === 'asd' || stripos($trim, 'asd') === 0) {
	icopay_json_response(array(
		'success' => false,
		'result' => '0',
		'message' => 'Server order_ok2.php still outputs debug text "asd". Upload the latest cart/order_ok2.php and lib/icopay_*.php files.',
	));
}

icopay_json_response(array(
	'success' => false,
	'result' => '0',
	'message' => 'Order save did not return JSON.',
	'raw' => substr($trim, 0, 300),
));
