<?php
/**
 * ICOPAY → merchant payment webhook (register in HQ merchantNotifyUrls).
 * Example: https://pentakleva.shop/cart/icopay_webhook.php
 */
header('Content-Type: text/plain; charset=UTF-8');

include dirname(__FILE__) . '/../lib/icopay_pg_config.php';
include dirname(__FILE__) . '/lib_icopay_unified.php';
include_once dirname(__FILE__) . '/../include/com.php';

$raw = file_get_contents('php://input') ?: '';
@file_put_contents(
	dirname(__FILE__) . '/icopay_webhook.log',
	date('c') . ' len=' . strlen($raw) . ' body=' . $raw . PHP_EOL,
	FILE_APPEND | LOCK_EX
);

if (!ICOPAY_UNIFIED_ENABLED || $raw === '') {
	http_response_code(200);
	echo 'OK';
	exit;
}

$payload = json_decode($raw, true);
if (!is_array($payload)) {
	http_response_code(200);
	echo 'OK';
	exit;
}

$orderNo = '';
foreach (array('orderNo', 'merchantOrderId', 'order_no') as $k) {
	if (!empty($payload[$k])) {
		$orderNo = trim((string)$payload[$k]);
		break;
	}
}
if ($orderNo === '' && isset($payload['data']) && is_array($payload['data'])) {
	foreach (array('orderNo', 'merchantOrderId') as $k) {
		if (!empty($payload['data'][$k])) {
			$orderNo = trim((string)$payload['data'][$k]);
			break;
		}
	}
}

$payStatus = '';
foreach (array('status', 'paymentStatus', 'result') as $k) {
	if (!empty($payload[$k])) {
		$payStatus = (string)$payload[$k];
		break;
	}
}
if ($payStatus === '' && isset($payload['data']) && is_array($payload['data'])) {
	foreach (array('status', 'paymentStatus') as $k) {
		if (!empty($payload['data'][$k])) {
			$payStatus = (string)$payload['data'][$k];
			break;
		}
	}
}

if ($orderNo === '' || !icopay_unified_is_paid_status($payStatus)) {
	http_response_code(200);
	echo 'OK';
	exit;
}

$tid = $orderNo;
foreach (array('transactionId', 'tid', 'pgTransactionId', 'approvalNo') as $k) {
	if (!empty($payload[$k])) {
		$tid = trim((string)$payload[$k]);
		break;
	}
}
if ($tid === $orderNo && isset($payload['data']) && is_array($payload['data'])) {
	foreach (array('transactionId', 'tid', 'pgTransactionId', 'approvalNo') as $k) {
		if (!empty($payload['data'][$k])) {
			$tid = trim((string)$payload['data'][$k]);
			break;
		}
	}
}

global $DB, $shop_order, $api_category;
if (isset($DB) && isset($shop_order)) {
	$DB->get("SELECT ediDate, id FROM $shop_order WHERE ordernum='" . addslashes($orderNo) . "' AND status='주문접수' ORDER BY signdate DESC LIMIT 1", $rows, $rn);
	if ($rn > 0) {
		icopay_unified_finalize_order((string)$rows[0]['ediDate'], $tid, (string)$rows[0]['id'], $api_category);
	}
}

http_response_code(200);
echo 'OK';
exit;
