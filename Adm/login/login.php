<?
include "../common/dbconn.php";
require_once dirname(__FILE__) . '/../../include/pkshop_auth_lib.php';
require_once dirname(__FILE__) . '/../../include/site_settings_lib.php';

if (isset($_SESSION["idok"]) && $_SESSION["idok"] === "yes") {
	header('Location: ../main/main.php');
	exit;
}

$b = pkshop_auth_branding('admin');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex, nofollow" />
<title><?=pkshop_auth_h($b['form_title'])?> — Admin</title>
<?=pkshop_admin_favicon_head_html()?>
<?php pkshop_auth_css_link(); ?>
<script language="JavaScript">
function loginP(j) {
	if (j === "i") {
		if (!document.form.id.value) {
			alert('아이디를 입력하세요!');
			document.form.id.focus();
			return;
		}
		if (!document.form.password.value) {
			alert('패스워드를 입력하세요!');
			document.form.password.focus();
			return;
		}
		document.form.action = "login_do.php";
	} else {
		document.form.action = "logout.php";
	}
	document.form.submit();
}
function EnterCheck(i) {
	if (event.keyCode === 13 && i === 1) {
		document.form.password.focus();
	}
	if (event.keyCode === 13 && i === 2) {
		loginP('i');
	}
}
</script>
</head>
<body>
<?php pkshop_auth_chrome_open('admin'); ?>
<h2 class="pk-auth-title"><?=pkshop_auth_h($b['form_title'])?></h2>
<form name="form" method="post" action="login_do.php" autocomplete="off">
	<div class="pk-auth-field">
		<label for="admin_id"><?=pkshop_auth_h($b['label_id'])?></label>
		<input type="text" name="id" id="admin_id" maxlength="50" tabindex="1" onkeydown="EnterCheck(1);" />
	</div>
	<div class="pk-auth-field">
		<label for="admin_password"><?=pkshop_auth_h($b['label_password'])?></label>
		<input type="password" name="password" id="admin_password" maxlength="50" tabindex="2" onkeydown="EnterCheck(2);" />
	</div>
	<button type="button" class="pk-auth-btn" onclick="loginP('i');"><?=pkshop_auth_h($b['btn_submit'])?></button>
</form>
<?php pkshop_auth_chrome_close($b['footer_text']); ?>
</body>
</html>
