<?
include "../include/com.php";
require_once dirname(__FILE__) . '/../include/pkshop_auth_lib.php';

$pkshop_login_from_buy = (isset($_GET['from']) && $_GET['from'] === 'buy');
$b = pkshop_auth_branding('member');
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?=pkshop_auth_h($b['form_title'])?> — <?=pkshop_auth_h(pkshop_site_setting('site_title', 'Pentakleva'))?></title>
<?php pkshop_auth_css_link(); ?>
<script language="JavaScript">
function login022() {
	if (!document.relogin22.id.value) {
		alert('<?=pkshop_auth_h($b['label_id'])?>을(를) 입력하세요!');
		document.relogin22.id.focus();
		return;
	}
	if (!document.relogin22.passwd.value) {
		alert('<?=pkshop_auth_h($b['label_password'])?>을(를) 입력하세요!');
		document.relogin22.passwd.focus();
		return;
	}
	if (document.relogin22.idcheck.checked) {
		saveLogin(document.relogin22.id.value);
	} else {
		saveLogin("");
	}
	document.relogin22.submit();
}
function EnterCheck011(i) {
	if (event.keyCode === 13 && i === 1) {
		document.relogin22.passwd.focus();
	}
	if (event.keyCode === 13 && i === 2) {
		login022();
	}
}
function setsave(name, value, expiredays) {
	var today = new Date();
	today.setDate(today.getDate() + expiredays);
	document.cookie = name + "=" + escape(value) + "; path=/; expires=" + today.toGMTString() + ";";
}
function confirmSave(checkbox) {
	if (checkbox.checked) {
		var isRemember = confirm("이 PC에 로그인 정보를 저장하시겠습니까? 공용 PC에서는 주의하세요.");
		if (!isRemember) {
			checkbox.checked = false;
		}
	}
}
function saveLogin(id) {
	if (id !== "") {
		setsave("userid", id, 7);
	} else {
		setsave("userid", id, -1);
	}
}
function getLogin() {
	var cook = document.cookie + "";
	var key = "userid";
	var idx = cook.indexOf(key, 0);
	var val = "";
	if (idx !== -1) {
		cook = cook.substring(idx, cook.length);
		var begin = cook.indexOf("=", 0) + 1;
		var end = cook.indexOf(";", begin);
		val = unescape(cook.substring(begin, end));
	}
	if (val !== "") {
		document.relogin22.id.value = val;
		document.relogin22.idcheck.checked = true;
	}
}
</script>
</head>
<body onload="getLogin();">
<?php pkshop_auth_chrome_open('member'); ?>
<h2 class="pk-auth-title"><?=pkshop_auth_h($b['form_title'])?></h2>

<?php if (!empty($pkshop_login_from_buy)) { ?>
<div class="pk-auth-alert pk-auth-alert--warn">
	<strong>회원만 구매할 수 있습니다.</strong><br>로그인 후 계속 진행해 주세요.
</div>
<?php } ?>

<form name="relogin22" action="./logok.php" method="post" autocomplete="off">
	<div class="pk-auth-field">
		<label for="member_id"><?=pkshop_auth_h($b['label_id'])?></label>
		<input type="text" name="id" id="member_id" class="pk-auth-input" onkeydown="EnterCheck011(1);" />
	</div>
	<div class="pk-auth-field">
		<label for="member_passwd"><?=pkshop_auth_h($b['label_password'])?></label>
		<input type="password" name="passwd" id="member_passwd" onkeydown="EnterCheck011(2);" />
	</div>
	<button type="button" class="pk-auth-btn" onclick="login022();"><?=pkshop_auth_h($b['btn_submit'])?></button>
	<div class="pk-auth-extra">
		<label><input type="checkbox" name="idcheck" onclick="confirmSave(this)"> ID 저장</label>
	</div>
</form>

<div class="pk-auth-links">
	회원이 아니신가요? <a href="agree.php">회원가입</a>
</div>

<?php pkshop_auth_chrome_close($b['footer_text']); ?>
</body>
</html>
