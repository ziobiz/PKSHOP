<?php
/**
 * ChillPay / 브로커 리턴 URL. 성공 시 기존 orderUpdate(ediDate, tid) 호출.
 */
include dirname(__FILE__) . '/../include/get_balance.php';
include dirname(__FILE__) . '/../include/login_check.php';

$ediDate = isset($_REQUEST['ediDate']) ? trim((string)$_REQUEST['ediDate']) : '';
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

if ($ok && $ediDate !== '' && $tid !== '' && $_SESSION['member_id'] !== '') {
	curl_d($api_category, '&Type=orderUpdate&ediDate=' . rawurlencode($ediDate) . '&tid=' . rawurlencode($tid));
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
