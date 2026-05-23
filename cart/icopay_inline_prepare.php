<?php
/**
 * Icopay 인라인 결제 prepare — 브로커 시크릿은 서버에서만 사용.
 */
while (ob_get_level() > 0) {
	ob_end_clean();
}
ob_start();

include dirname(__FILE__) . '/../include/get_balance.php';
include dirname(__FILE__) . '/../include/login_check.php';
include dirname(__FILE__) . '/../lib/icopay_merchant.php';

if (!icopay_inline_checkout_active()) {
	icopay_json_response(array('success' => false, 'message' => 'Inline checkout is not enabled.'));
}

$api = icopay_merchant_api();
if ($api === null) {
	icopay_json_response(array('success' => false, 'message' => 'Icopay is not configured (compId / broker secret).'));
}

$raw = file_get_contents('php://input');
$in = json_decode($raw, true);
if (!is_array($in)) {
	$in = $_POST;
}
if (!is_array($in)) {
	$in = array();
}

$merchantOrderId = isset($in['merchantOrderId']) ? trim((string)$in['merchantOrderId']) : '';
$pend = isset($_SESSION['icopay_pending_checkout']) && is_array($_SESSION['icopay_pending_checkout'])
	? $_SESSION['icopay_pending_checkout'] : null;

if ($merchantOrderId === '' && $pend) {
	$merchantOrderId = isset($pend['ediDate']) ? trim((string)$pend['ediDate']) : '';
}
if (!$pend || $merchantOrderId === '' || $pend['ediDate'] !== $merchantOrderId) {
	icopay_json_response(array('success' => false, 'message' => 'Invalid or expired checkout session.'));
}
if (isset($pend['ts']) && (time() - (int)$pend['ts']) > 3600) {
	unset($_SESSION['icopay_pending_checkout']);
	icopay_json_response(array('success' => false, 'message' => 'Checkout session expired.'));
}

$vendor = isset($in['vendor']) ? trim((string)$in['vendor']) : icopay_merchant_config_array()['default_vendor'];
$amount = isset($pend['amount']) ? $pend['amount'] : '0';
if (is_string($amount)) {
	$amount = str_replace(',', '', $amount);
}
$amount = is_numeric($amount) ? (float)$amount : $amount;
$currency = defined('ICOPAY_CHILL_PAY_CURRENCY') ? ICOPAY_CHILL_PAY_CURRENCY : 'THB';
$productName = isset($pend['description']) ? mb_substr((string)$pend['description'], 0, 200) : 'Order';
if (!empty($in['productName'])) {
	$productName = mb_substr((string)$in['productName'], 0, 200);
}

$checkoutLang = icopay_resolve_checkout_lang();
if (!empty($in['lang'])) {
	$checkoutLang = strtolower(trim((string)$in['lang']));
}

$prep = $api->prepareInlineCheckout($vendor, $merchantOrderId, $amount, $currency, $productName, $checkoutLang);
if (empty($prep['success']) || empty($prep['data']['sessionToken'])) {
	$msg = isset($prep['message']) ? (string)$prep['message'] : 'prepare failed';
	icopay_json_response(array(
		'success' => false,
		'message' => $msg,
		'errorCode' => isset($prep['errorCode']) ? $prep['errorCode'] : null,
	));
}

$data = $prep['data'];
$sessionToken = (string)$data['sessionToken'];
$targetId = $api->getEmbedTargetId($vendor);
$embedScriptUrl = !empty($data['embedScriptUrl'])
	? (string)$data['embedScriptUrl']
	: $api->getEmbedScriptUrl($vendor);
$payUrl = !empty($data['payUrl']) ? (string)$data['payUrl'] : '';
$payUrl = icopay_append_lang_to_pay_url($payUrl, $checkoutLang);

icopay_json_response(array(
	'success' => true,
	'sessionToken' => $sessionToken,
	'embedScriptUrl' => $embedScriptUrl,
	'payUrl' => $payUrl,
	'checkoutLang' => $checkoutLang,
	'targetId' => $targetId,
	'orderNo' => $merchantOrderId,
	'apiOrigin' => defined('ICOPAY_PUBLIC_BASE') ? ICOPAY_PUBLIC_BASE : 'https://api.icopay.co.kr',
	'checkoutJsUrl' => (defined('ICOPAY_PUBLIC_BASE') ? ICOPAY_PUBLIC_BASE : 'https://api.icopay.co.kr')
		. '/merchant-api-samples/common/icopay-checkout.js',
));
