<?php
/**
 * Browser return page after ICOPAY unified inline checkout.
 */
include dirname(__FILE__) . '/../include/get_balance.php';
include dirname(__FILE__) . '/../include/login_check.php';

$orderNo = isset($_REQUEST['orderNo']) ? trim((string)$_REQUEST['orderNo']) : '';
$ok = isset($_REQUEST['success']) ? ((string)$_REQUEST['success'] !== '0') : true;
$tid = isset($_REQUEST['tid']) ? trim((string)$_REQUEST['tid']) : $orderNo;

$img = $ok
	? '<img src="images/confirm_icon01.png" alt=""/><br/>'
	: '<img src="images/cart_delet.png" alt=""/><br/>';
$text = $ok
	? ('Payment completed.<br>Thank you.<br><span style="font-weight:bold;">Reference: ' . htmlspecialchars($tid, ENT_QUOTES, 'UTF-8') . '</span>')
	: 'Payment was not completed. Please try again or use another method.';
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
		<?php echo $text; ?>
		<div class="sp40"></div>
		<div class="cart_btn_order" style="cursor:pointer;display:inline-block;padding:10px 24px;background:#1fa0e8;color:#fff;border-radius:4px;" onclick="location.href='../main/main.html'">Back to main</div>
	</div>
</div>
<?php include dirname(__FILE__) . '/../include/bottom.html'; ?>
</div>
</body>
</html>
