<?php
/**
 * ICOPAY 브라우저 복귀(NOTI Result). 서버 확정은 webhook/status API 권장.
 */
include dirname(__FILE__) . '/../include/get_balance.php';
include dirname(__FILE__) . '/../include/login_check.php';
include dirname(__FILE__) . '/../lib/icopay_merchant.php';

$ediDate = isset($_REQUEST['ediDate']) ? trim((string)$_REQUEST['ediDate']) : '';
if ($ediDate === '' && !empty($_REQUEST['orderNo'])) {
	$ediDate = trim((string)$_REQUEST['orderNo']);
}
$cancel = isset($_REQUEST['cancel']) ? (string)$_REQUEST['cancel'] : '';

$tid = '';
foreach (array('TransactionId', 'transactionId', 'tid', 'TxnId', 'transaction_id') as $k) {
	if (!empty($_REQUEST[$k])) {
		$tid = trim((string)$_REQUEST[$k]);
		break;
	}
}
if ($tid === '') {
	foreach (array('OrderNo', 'orderNo', 'merchantOrderId') as $k) {
		if (!empty($_REQUEST[$k])) {
			$tid = trim((string)$_REQUEST[$k]);
			break;
		}
	}
}

$ok = ($cancel === '' || $cancel === '0');
if ($ok) {
	foreach (array('status', 'Status', 'paymentStatus', 'result') as $k) {
		if (isset($_REQUEST[$k])) {
			$v = strtoupper(trim((string)$_REQUEST[$k]));
			if ($v === 'FAIL' || $v === 'FAILED' || $v === 'CANCEL' || $v === 'CANCELLED') {
				$ok = false;
				break;
			}
		}
	}
}

$paidConfirmed = false;
if ($ok && $ediDate !== '' && icopay_integration_mode() === IcopayMerchantApi::INTEGRATION_UNIFIED) {
	$api = icopay_merchant_api();
	if ($api !== null) {
		$st = icopay_checkout_ui_mode() === 'url'
			? $api->getUnifiedRedirectPaymentStatus($ediDate)
			: $api->getUnifiedPaymentStatus($ediDate);
		if (!empty($st['success']) && isset($st['data']) && is_array($st['data'])) {
			$data = $st['data'];
			$ps = strtoupper(trim((string)($data['paymentStatus'] ?? $data['status'] ?? '')));
			if (in_array($ps, array('PAID', 'SUCCESS', 'SUCCEEDED', 'COMPLETED', 'APPROVED', 'CAPTURED'), true)) {
				$paidConfirmed = true;
				if (!empty($data['approvalNo'])) {
					$tid = trim((string)$data['approvalNo']);
				} elseif (!empty($data['transactionId'])) {
					$tid = trim((string)$data['transactionId']);
				}
			} elseif (in_array($ps, array('FAIL', 'FAILED', 'CANCEL', 'CANCELLED', 'NOT_FOUND'), true)) {
				$ok = false;
			}
		}
	}
}

if ($ok && $ediDate !== '' && $_SESSION['member_id'] !== '') {
	if ($paidConfirmed || $tid !== '') {
		if ($tid === '') {
			$tid = $ediDate;
		}
		icopay_apply_order_paid($ediDate, $tid);
	}
}

$img = $ok
	? '<img src="images/confirm_icon01.png" alt=""/><br/>'
	: '<img src="images/cart_delet.png" alt=""/><br/>';
$text = $ok
	? ('Payment completed.<br>Thank you.<br><span style="font-weight:bold;">Reference: ' . htmlspecialchars($tid, ENT_QUOTES, 'UTF-8') . '</span>')
	: 'Payment was not completed. Please try again or use another method.';
if ($cancel === '1') {
	$text = 'Payment was cancelled.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<link rel="shortcut icon" href="../images/webicon2.png">
<title>Payment result</title>
</head>
<body>
<div id="wrap">
<?php include dirname(__FILE__) . '/../include/top.php'; ?>
<div id="content">
	<div class="content_inner" align="center" style="padding:40px 16px;">
		<?php echo $img; ?>
		<?php echo nl2br($text); ?>
		<div class="sp40"></div>
		<div class="cart_btn_order" style="cursor:pointer;display:inline-block;padding:10px 24px;background:#1fa0e8;color:#fff;border-radius:4px;" onclick="location.href='../main/main.html'">Back to main</div>
	</div>
</div>
<?php include dirname(__FILE__) . '/../include/bottom.html'; ?>
</div>
</body>
</html>
