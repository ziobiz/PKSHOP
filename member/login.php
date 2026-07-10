<?
include "../include/get_balance.php";
require_once dirname(__FILE__) . '/../include/site_settings_lib.php';

$pkshop_login_from_buy = (isset($_GET['from']) && $_GET['from'] === 'buy');
$member_title = pkshop_site_setting('login_member_title', 'Login');
$member_subtitle = 'Meet a variety of services and benefits at ' . pkshop_site_setting('site_title', 'Pentakleva') . '.';
$member_box_title = pkshop_site_setting('login_member_title', 'Member log-in.');
$label_id = pkshop_site_setting('login_member_label_id', 'ID');
$label_password = pkshop_site_setting('login_member_label_password', 'Password');
$btn_login = pkshop_site_setting('login_member_btn', 'Login');
$page_title = htmlspecialchars($member_title, ENT_QUOTES, 'UTF-8') . ' — ' . htmlspecialchars(pkshop_site_setting('site_title', 'Pentakleva'), ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=$page_title?></title>
<link rel="stylesheet" href="../include/reset.css">
<link rel="stylesheet" type="text/css" href="../include/style.css?v=20260710memberlogin" media="screen and (min-width:1024px)"/>
<link rel="stylesheet" type="text/css" href="../include/responsive.css?v=20260710memberlogin" media="screen and (max-width:1023px)"/>
<script language="JavaScript">
function login022() {
	if (!document.relogin22.id.value) {
		alert('<?=htmlspecialchars($label_id, ENT_QUOTES, 'UTF-8')?>을(를) 입력하세요!');
		document.relogin22.id.focus();
		return;
	}
	if (!document.relogin22.passwd.value) {
		alert('<?=htmlspecialchars($label_password, ENT_QUOTES, 'UTF-8')?>을(를) 입력하세요!');
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
		var isRemember = confirm("Do you want to save your login information on this PC? Please be careful as personal information may be leaked from public places such as PC rooms.");
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
<div id="wrap">
<? include "../include/top.php"; ?>
<div id="content">
<div class="content_inner">
<div class="sp90"></div>
<div class="member_title"><?=htmlspecialchars($member_title, ENT_QUOTES, 'UTF-8')?></div>
<div class="sp10"></div>
<div class="member_title01"><?=htmlspecialchars($member_subtitle, ENT_QUOTES, 'UTF-8')?></div>
<div class="sp35"></div>
<hr class="hr_gray"/>
<div class="sp35"></div>

<?php if (!empty($pkshop_login_from_buy)) { ?>
<div style="max-width:720px;margin:0 auto 20px;padding:12px 16px;background:#fff8e6;border:1px solid #f0d78c;border-radius:6px;color:#7a5b00;">
	<strong>회원만 구매할 수 있습니다.</strong><br>로그인 후 계속 진행해 주세요.
</div>
<?php } ?>

<div class="login_inner">
<div class="sp50"></div>
<form name="relogin22" action="./logok.php" method="post" autocomplete="off">
<div class="login_box">
<div class="login_box_title"><?=htmlspecialchars($member_box_title, ENT_QUOTES, 'UTF-8')?></div>
<div class="login_title_s">If you log in and use it, you can enjoy more diverse services.</div>
<div class="sp20"></div>
<table class="login_table">
<tr>
<td width="80%">
<table class="login_table_in">
<tr>
<th width="30%"><?=htmlspecialchars($label_id, ENT_QUOTES, 'UTF-8')?></th>
<td width="68%"><input type="text" name="id" class="input_login" onkeydown="EnterCheck011(1);"></td>
</tr>
<tr><td colspan="2" height="10px"></td></tr>
<tr>
<th width="30%"><?=htmlspecialchars($label_password, ENT_QUOTES, 'UTF-8')?></th>
<td width="68%"><input type="password" name="passwd" class="input_login" onkeydown="EnterCheck011(2);"></td>
</tr>
</table>
</td>
<td width="20%"><input type="button" value="<?=htmlspecialchars($btn_login, ENT_QUOTES, 'UTF-8')?>" class="btn_login" onclick="login022();"></td>
</tr>
</table>
<div style="margin-left:150px;margin-top:10px;margin-bottom:10px;"><br>
<input type="checkbox" name="idcheck" onclick="confirmSave(this)"> <span style="font-family:'Nanum Gothic',sans-serif; font-size:14px; color:#c3070b">ID SAVED</span>
</div>
</div>
</form>
<div class="sp50"></div>
</div>

<div class="sp30"></div>
<hr class="hr_gray"/>
<div class="sp30"></div>
<div class="login_btn_box">
<div class="login_left">
<table class="find_id_table"><tr><td></td></tr></table>
</div>
<div class="sp5"></div>
<div class="login_left">
<table class="find_id_table">
<tr>
<td width="60%">Aren't you a member? <br>You can get various benefits by <br>signing up as a member.</td>
<td width="40%"><a href="agree.php" style="background:#c3070b; color: #fff;padding: 8% 12%;border-radius: 15px;">Sign up</a></td>
</tr>
</table>
</div>
</div>

</div>
</div>

<div class="sp50"></div>
<? include "../include/bottom.php"; ?>
</div>
</body>
</html>
