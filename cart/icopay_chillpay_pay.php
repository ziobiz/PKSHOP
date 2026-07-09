<?php
/**
 * ChillPay(CCD) PaymentCreditToken 으로 브로커 결제 요청 → PaymentUrl 반환.
 */
header('Content-Type: application/json; charset=utf-8');

include dirname(__FILE__) . '/../include/get_balance.php';
include dirname(__FILE__) . '/../include/login_check.php';
include dirname(__FILE__) . '/../lib/icopay_pg_config.php';
include dirname(__FILE__) . '/lib_icopay_chillpay.php';

if (!ICOPAY_CHILLPAY_ENABLED) {
	echo json_encode(array('success' => false, 'message' => 'Icopay ChillPay is not configured.'));
	exit;
}

$raw = file_get_contents('php://input');
$in = json_decode($raw, true);
if (!is_array($in)) {
	echo json_encode(array('success' => false, 'message' => 'Invalid JSON body.'));
	exit;
}

$pend = isset($_SESSION['icopay_pending_checkout']) && is_array($_SESSION['icopay_pending_checkout'])
	? $_SESSION['icopay_pending_checkout'] : null;
$merchantOrderId = isset($in['merchantOrderId']) ? trim((string)$in['merchantOrderId']) : '';
if (!$pend || $merchantOrderId === '' || $pend['ediDate'] !== $merchantOrderId) {
	echo json_encode(array('success' => false, 'message' => 'Invalid or expired checkout session.'));
	exit;
}

if (isset($pend['ts']) && (time() - (int)$pend['ts']) > 3600) {
	unset($_SESSION['icopay_pending_checkout']);
	echo json_encode(array('success' => false, 'message' => 'Checkout session expired.'));
	exit;
}

$token = isset($in['paymentCreditToken']) ? trim((string)$in['paymentCreditToken']) : '';
if ($token === '' && isset($in['directCreditToken'])) {
	$token = trim((string)$in['directCreditToken']);
}
if ($token === '') {
	echo json_encode(array('success' => false, 'message' => 'Missing paymentCreditToken.'));
	exit;
}

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$base = $scheme . '://' . $host;
$returnUrl = $base . dirname($_SERVER['SCRIPT_NAME']) . '/icopay_chillpay_return.php?ediDate=' . rawurlencode($pend['ediDate']);
$cancelUrl = $returnUrl . '&cancel=1';

$amountStr = isset($pend['amount']) ? (string)$pend['amount'] : '0';
$description = isset($in['description']) ? mb_substr((string)$in['description'], 0, 200) : (isset($pend['description']) ? (string)$pend['description'] : 'Order');

$payload = array(
	'compId' => ICOPAY_COMP_ID,
	'paymentCreditToken' => $token,
	'merchantOrderId' => $pend['ediDate'],
	'amount' => $amountStr,
	'currency' => isset($pend['currency']) && $pend['currency'] !== ''
		? (string)$pend['currency']
		: ((function_exists('pkshop_get_payment_currency') ? pkshop_get_payment_currency() : ICOPAY_CHILL_PAY_CURRENCY)),
	'returnUrl' => $returnUrl,
	'cancelUrl' => $cancelUrl,
	'description' => $description,
);
if (!empty($in['payerEmail'])) {
	$payload['payerEmail'] = (string)$in['payerEmail'];
}
if (!empty($in['payerPhone'])) {
	$payload['payerPhone'] = (string)$in['payerPhone'];
}
if (!empty($in['payerFirstName'])) {
	$payload['payerFirstName'] = (string)$in['payerFirstName'];
}
if (!empty($in['payerLastName'])) {
	$payload['payerLastName'] = (string)$in['payerLastName'];
}

$r = icopay_chillpay_http_json('POST', icopay_chillpay_request_url(), array(
	'X-Icopay-Merchant-Broker-Secret: ' . ICOPAY_BROKER_SECRET,
), $payload);

$j = $r['json'];
if (!is_array($j) || empty($j['success'])) {
	$msg = is_array($j) && isset($j['message']) ? $j['message'] : 'Broker request failed.';
	if ($r['curlError'] !== '') {
		$msg .= ' (curl: ' . $r['curlError'] . ')';
	}
	if ($r['httpCode'] > 0) {
		$msg .= ' [HTTP ' . $r['httpCode'] . ']';
	}
	echo json_encode(array('success' => false, 'message' => $msg, 'errorCode' => is_array($j) ? (isset($j['errorCode']) ? $j['errorCode'] : null) : null));
	exit;
}

$data = isset($j['data']) && is_array($j['data']) ? $j['data'] : array();
$paymentUrl = '';
if (isset($data['paymentUrl'])) {
	$paymentUrl = (string)$data['paymentUrl'];
} elseif (isset($data['PaymentUrl'])) {
	$paymentUrl = (string)$data['PaymentUrl'];
}
if ($paymentUrl === '') {
	echo json_encode(array('success' => false, 'message' => 'No paymentUrl in broker response.', 'data' => $data));
	exit;
}

unset($_SESSION['icopay_pending_checkout']);
echo json_encode(array('success' => true, 'paymentUrl' => $paymentUrl));
exit;
