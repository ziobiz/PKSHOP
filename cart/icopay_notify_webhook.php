<?php
/**
 * ICOPAY → 가맹점 웹훅. 본사 merchantNotifyUrls 로 POST 시 주문 상태 갱신(멱등).
 * PG/ChillPay 콘솔 BACKGROUND URL 예: https://{도메인}/cart/icopay_notify_webhook.php
 */
declare(strict_types=1);

include dirname(__FILE__) . '/../include/com.php';
include dirname(__FILE__) . '/../lib/icopay_merchant.php';

$raw = file_get_contents('php://input') ?: '';
$logDir = dirname(__FILE__) . '/../logs';
if (!is_dir($logDir)) {
	@mkdir($logDir, 0755, true);
}
@file_put_contents(
	$logDir . '/icopay_notify.log',
	date('c') . ' len=' . strlen($raw) . ' body=' . $raw . PHP_EOL,
	FILE_APPEND | LOCK_EX
);

$payload = array();
if ($raw !== '') {
	$decoded = json_decode($raw, true);
	if (is_array($decoded)) {
		$payload = $decoded;
	} else {
		parse_str($raw, $parsed);
		if (is_array($parsed)) {
			$payload = $parsed;
		}
	}
}
if (empty($payload) && !empty($_POST)) {
	$payload = $_POST;
}

$orderNo = icopay_notify_extract_order_no($payload);
$paid = icopay_notify_payload_is_paid($payload);

if ($orderNo !== '' && $paid) {
	$tid = icopay_notify_extract_transaction_id($payload, $orderNo);
	icopay_apply_order_paid($orderNo, $tid);
}

http_response_code(200);
header('Content-Type: text/plain; charset=UTF-8');
echo 'OK';
