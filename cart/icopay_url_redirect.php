<?php
/**
 * ICOPAY URL 결제 — prepare 후 payUrl 로 HTTP 리다이렉트 (전체 페이지 이동).
 */
include dirname(__FILE__) . '/../include/get_balance.php';
include dirname(__FILE__) . '/../include/login_check.php';
include dirname(__FILE__) . '/../lib/icopay_merchant.php';

if (!icopay_url_checkout_active()) {
	http_response_code(400);
	exit('ICOPAY URL checkout is not enabled.');
}

$api = icopay_merchant_api();
if ($api === null) {
	http_response_code(500);
	exit('ICOPAY is not configured.');
}

$merchantOrderId = isset($_REQUEST['merchantOrderId']) ? trim((string)$_REQUEST['merchantOrderId']) : '';
$pend = isset($_SESSION['icopay_pending_checkout']) && is_array($_SESSION['icopay_pending_checkout'])
	? $_SESSION['icopay_pending_checkout'] : null;

if ($merchantOrderId === '' && $pend) {
	$merchantOrderId = isset($pend['ediDate']) ? trim((string)$pend['ediDate']) : '';
}
if (!$pend || $merchantOrderId === '' || $pend['ediDate'] !== $merchantOrderId) {
	http_response_code(400);
	exit('Invalid or expired checkout session.');
}

$amount = isset($pend['amount']) ? str_replace(',', '', (string)$pend['amount']) : '0';
$amount = is_numeric($amount) ? (float)$amount : $amount;
$currency = defined('ICOPAY_PAY_CURRENCY') ? ICOPAY_PAY_CURRENCY : 'JPY';
$productName = isset($pend['description']) ? mb_substr((string)$pend['description'], 0, 200) : 'Order';
$buyer = icopay_resolve_buyer($_POST);
$buyerErr = icopay_validate_buyer($buyer);
if ($buyerErr !== null) {
	http_response_code(400);
	exit($buyerErr);
}

$prep = $api->prepareUnifiedCheckout(
	$merchantOrderId,
	$amount,
	$buyer,
	$currency,
	$productName,
	icopay_resolve_checkout_lang_api()
);

if (empty($prep['success'])) {
	http_response_code(502);
	header('Content-Type: text/plain; charset=utf-8');
	exit(icopay_format_prepare_error($prep));
}

$data = is_array($prep['data'] ?? null) ? $prep['data'] : array();
$payUrl = !empty($data['payUrl']) ? (string)$data['payUrl'] : '';
$payUrl = icopay_append_lang_to_pay_url($payUrl, icopay_resolve_checkout_lang_api());
$payUrl = icopay_pay_url_for_redirect($payUrl);

if ($payUrl === '') {
	http_response_code(502);
	exit('payUrl missing from prepare response.');
}

header('Location: ' . $payUrl, true, 302);
exit;
