<?php
/**
 * ICOPAY unified checkout — server-side payment confirmation after embed postMessage.
 */
header('Content-Type: application/json; charset=utf-8');

include dirname(__FILE__) . '/../include/get_balance.php';
include dirname(__FILE__) . '/../include/login_check.php';
include dirname(__FILE__) . '/../lib/icopay_pg_config.php';
include dirname(__FILE__) . '/lib_icopay_unified.php';

if (!ICOPAY_UNIFIED_ENABLED) {
	echo json_encode(array('success' => false, 'message' => 'ICOPAY unified checkout is not configured.'));
	exit;
}

$raw = file_get_contents('php://input');
$in = json_decode($raw, true);
if (!is_array($in)) {
	$in = $_POST;
}

$orderNo = isset($in['orderNo']) ? trim((string)$in['orderNo']) : '';
$ediDate = isset($in['ediDate']) ? trim((string)$in['ediDate']) : '';

$pend = isset($_SESSION['icopay_pending_checkout']) && is_array($_SESSION['icopay_pending_checkout'])
	? $_SESSION['icopay_pending_checkout'] : null;

if (!$pend) {
	echo json_encode(array('success' => false, 'message' => 'Checkout session expired.'));
	exit;
}

if ($orderNo === '') {
	$orderNo = isset($pend['orderNo']) ? (string)$pend['orderNo'] : '';
}
if ($ediDate === '') {
	$ediDate = isset($pend['ediDate']) ? (string)$pend['ediDate'] : '';
}

if ($orderNo === '' || $ediDate === '' || (string)$pend['orderNo'] !== $orderNo) {
	echo json_encode(array('success' => false, 'message' => 'Invalid checkout session.'));
	exit;
}

if (isset($pend['ts']) && (time() - (int)$pend['ts']) > 7200) {
	unset($_SESSION['icopay_pending_checkout']);
	echo json_encode(array('success' => false, 'message' => 'Checkout session expired.'));
	exit;
}

$api = icopay_unified_api_client();
$status = $api->getUnifiedPaymentStatus($orderNo);
if (empty($status['success'])) {
	echo json_encode(array(
		'success' => false,
		'message' => isset($status['message']) ? $status['message'] : 'Could not verify payment status.',
	));
	exit;
}

$data = isset($status['data']) && is_array($status['data']) ? $status['data'] : array();
$payStatus = '';
if (isset($data['status'])) {
	$payStatus = (string)$data['status'];
} elseif (isset($data['paymentStatus'])) {
	$payStatus = (string)$data['paymentStatus'];
}

$tid = '';
foreach (array('transactionId', 'tid', 'pgTransactionId', 'approvalNo') as $k) {
	if (!empty($data[$k])) {
		$tid = trim((string)$data[$k]);
		break;
	}
}
if ($tid === '') {
	$tid = $orderNo;
}

if (!icopay_unified_is_paid_status($payStatus)) {
	echo json_encode(array(
		'success' => false,
		'message' => 'Payment is not completed yet.',
		'status' => $payStatus,
	));
	exit;
}

icopay_unified_finalize_order($ediDate, $tid, $_SESSION['member_id'], $api_category);
unset($_SESSION['icopay_pending_checkout']);

echo json_encode(array(
	'success' => true,
	'orderNo' => $orderNo,
	'ediDate' => $ediDate,
	'tid' => $tid,
	'status' => $payStatus,
));
exit;
