<?
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";
require_once dirname(__FILE__) . '/../../include/site_settings_lib.php';
require_once dirname(__FILE__) . '/../../include/icopay_settings_lib.php';
require_once dirname(__FILE__) . '/../../include/pkshop_promo_lib.php';
include "gemini_client.php";

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'ai';
if (!in_array($tab, array('ai', 'brand', 'currency', 'payment', 'promo'), true)) {
	$tab = 'ai';
}
$s = pkshop_site_settings();
if ($tab === 'payment') {
	$s = pkshop_icopay_admin_form_values();
}
$currency_opts = pkshop_currency_options();
$api_key_status = gemini_api_key_status();
$enabled_codes = pkshop_currency_enabled_codes();
$icopay_secret_status = pkshop_icopay_broker_secret_status();
$icopay_mode_opts = pkshop_icopay_integration_mode_options();
$icopay_lang_opts = pkshop_icopay_checkout_lang_options();
$icopay_webhook_url = pkshop_icopay_webhook_url();
$interval_opts = pkshop_promo_rotate_interval_options();
$promo_best_sec = pkshop_promo_rotate_seconds('best');
$promo_recommended_sec = pkshop_promo_rotate_seconds('recommended');
$promo_all_sec = pkshop_promo_rotate_seconds('all');
?>
<script>
function postRun(data) {
	var body = (data instanceof URLSearchParams) ? data.toString() : new URLSearchParams(data).toString();
	return fetch('pro_ai_generate_run.php', {
		method: 'POST',
		credentials: 'same-origin',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: body
	}).then(function(r) { return r.json(); });
}
async function saveApiKey() {
	var key = document.getElementById('api_key_input').value.trim();
	if (!key) { alert('API 키를 입력하세요.'); return; }
	var res = await postRun({ action: 'save_api_key', api_key: key });
	if (res.error) { alert(res.error); return; }
	document.getElementById('api_key_masked').textContent = res.masked;
	document.getElementById('api_key_input').value = '';
	alert(res.message || 'API 키가 저장되었습니다.');
}
function syncPaymentCurrency() {
	var enabled = [];
	if (document.getElementById('currency_primary_enabled').checked) {
		enabled.push(document.getElementById('currency_primary_code').value);
	}
	if (document.getElementById('currency_secondary_enabled').checked) {
		var sec = document.getElementById('currency_secondary_code').value;
		if (enabled.indexOf(sec) < 0) enabled.push(sec);
	}
	var sel = document.getElementById('currency_payment_code');
	var current = sel.value;
	sel.innerHTML = '';
	for (var i = 0; i < enabled.length; i++) {
		var opt = document.createElement('option');
		opt.value = enabled[i];
		opt.textContent = enabled[i];
		if (enabled[i] === current) opt.selected = true;
		sel.appendChild(opt);
	}
	if (sel.options.length === 0) {
		var opt = document.createElement('option');
		opt.value = 'USD';
		opt.textContent = 'USD';
		sel.appendChild(opt);
	}
}
function pkshopValidateBrandUploads() {
	var maxBytes = {};
	var totalBytes = 0;
	var inputs = document.querySelectorAll('input[type="file"]');
	for (var i = 0; i < inputs.length; i++) {
		var input = inputs[i];
		if (!input.files || !input.files.length) continue;
		var file = input.files[0];
		totalBytes += file.size || 0;
		var limit = maxBytes[input.name] || (10 * 1024 * 1024);
		if (file.size > limit) {
			alert('[' + (input.name === 'upload_favicon' ? '파비콘' : input.name) + '] 파일 크기(' + Math.ceil(file.size / 1024) + 'KB)가 허용 한도(' + Math.ceil(limit / 1024) + 'KB)를 초과했습니다.');
			input.focus();
			return false;
		}
	}
	if (totalBytes > 80 * 1024 * 1024) {
		alert('선택한 파일 전체 용량이 너무 큽니다. 파비콘은 2MB 이하, 배너는 개별 10MB 이하로 줄여 주세요.');
		return false;
	}
	return true;
}
function pkshopValidateFaviconUpload(formId) {
	var form = document.getElementById(formId);
	if (!form) return false;
	var input = form.querySelector('input[type="file"]');
	if (!input || !input.files || !input.files.length) {
		alert('파비콘 파일을 선택하세요.');
		return false;
	}
	var file = input.files[0];
	if (file.size > 2 * 1024 * 1024) {
		alert('파비콘 파일 크기(' + Math.ceil(file.size / 1024) + 'KB)가 허용 한도(2048KB)를 초과했습니다.');
		return false;
	}
	return true;
}
function pkshopOnFaviconFileChange(input, displayId, btnId, previewId) {
	var display = document.getElementById(displayId);
	var btn = document.getElementById(btnId);
	var preview = document.getElementById(previewId);
	if (!input || !input.files || !input.files.length) {
		if (display) display.value = '';
		if (btn) btn.disabled = true;
		if (preview) preview.style.display = 'none';
		return;
	}
	var file = input.files[0];
	if (display) display.value = file.name;
	if (btn) btn.disabled = false;
	if (preview && file.type.indexOf('image/') === 0) {
		preview.src = URL.createObjectURL(file);
		preview.style.display = 'block';
	} else if (preview) {
		preview.style.display = 'none';
	}
}
</script>
<?php
$page_screen_class = 'pg-site-settings-screen';
adm_ui_page_open($page_screen_class); ?>

<? if ($tab === 'ai') {
	$api_status_html = '<span id="api_key_masked" style="font-family:monospace;color:#003366;">';
	if ($api_key_status['configured']) {
		$api_status_html .= adm_ui_h($api_key_status['masked']);
	} else {
		$api_status_html .= '<span style="color:#dc3545;">미설정</span>';
	}
	$api_status_html .= '</span>';
	$api_input_html = '<div class="pg-api-key-field">';
	$api_input_html .= '<div class="pg-field-hint" style="margin-bottom:8px;">현재: ' . $api_status_html . '</div>';
	$api_input_html .= '<div class="pg-input-unit pg-input-unit--inline-hint">';
	$api_input_html .= '<input type="password" id="api_key_input" class="pg-input pg-input--w-title" placeholder="Google AI Studio API 키 (AIzaSy...)" autocomplete="off">';
	$api_input_html .= '<button type="button" class="pg-btn pg-btn-primary" onclick="saveApiKey();">API 키 저장</button>';
	$api_input_html .= '</div>';
	$api_input_html .= '<p class="pg-field-hint">lib/gemini_secrets.local.php 에 저장됩니다.</p>';
	$api_input_html .= '</div>';
?>
<?php adm_ui_card_open('AI 설정'); ?>
<?php adm_ui_notice('AI 상품생성은 <a href="pro_ai_generate.php">AI 상품생성</a> 메뉴에서 진행합니다.', 'info'); ?>
<?php adm_ui_settings_col_open(); ?>
<?php adm_ui_field_row('API 키', $api_input_html, true, true); ?>
<?php adm_ui_settings_col_close(); ?>
<?php adm_ui_card_close(); ?>

<? } elseif ($tab === 'brand') { ?>
<?php require dirname(__FILE__) . '/inc/pro_site_settings_favicon_form.php'; ?>
								<form method="post" action="pro_site_settings_ok.php" enctype="multipart/form-data" onsubmit="return pkshopValidateBrandUploads();">
								<input type="hidden" name="section" value="brand">
<?php adm_ui_card_open('로그인 화면 (레이아웃)'); ?>
<?php adm_ui_notice('CRYPTO/TINPASS와 <strong>동일한 화면 구성(UI)</strong>만 적용합니다. <strong>① 로고 ② 공지 ③ 폼 문구 ④ 푸터</strong> 순서로 노출됩니다.<br>로그인 방식은 기존 PKSHOP과 동일합니다 — <strong>아이디 + 비밀번호</strong>만 사용하며, 이메일·OTP 인증은 포함하지 않습니다.', 'info'); ?>
<?php adm_ui_settings_col_open(); ?>
<?php
adm_ui_field_row('① 로그인 로고', '<div class="pg-field-stack"><div>현재: ' . adm_ui_h($s['login_auth_logo']) . '</div><input type="file" name="upload_login_auth_logo" class="pg-input"><p class="pg-field-hint">우측 패널 상단, 권장 PNG</p></div>', false, true);
adm_ui_field_row('배경 이미지', '<div class="pg-field-stack"><div>현재: ' . adm_ui_h($s['login_auth_background']) . '</div><input type="file" name="upload_login_auth_background" class="pg-input"><p class="pg-field-hint">좌측 전체 배경</p></div>', false, true);
adm_ui_field_row('배경 문구', '<textarea name="login_auth_main_text" rows="3" class="pg-input pg-input--w-memo">' . adm_ui_h($s['login_auth_main_text']) . '</textarea>', false, true);
adm_ui_field_row('② 공지 사용', '<label class="pg-check-item"><input type="checkbox" name="login_notice_enabled" value="1"' . ($s['login_notice_enabled'] !== '0' ? ' checked' : '') . '> 로그인 패널에 공지 표시</label>', false, true);
adm_ui_field_row('② 공지 제목', '<input type="text" name="login_notice_title" value="' . adm_ui_h($s['login_notice_title']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('② 공지 내용', '<textarea name="login_notice_body" rows="4" class="pg-input pg-input--w-memo">' . adm_ui_h($s['login_notice_body']) . '</textarea>', false, true);
adm_ui_field_row('④ 푸터 문구', '<input type="text" name="login_footer_text" value="' . adm_ui_h($s['login_footer_text']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_settings_col_close();
?>
<div class="pg-screen-notice pg-screen-notice--info" style="margin-top:8px;"><strong>③ 일반회원 로그인</strong> (member/login.php)</div>
<?php adm_ui_settings_row_open(); ?>
<?php
adm_ui_field_row('폼 제목', '<input type="text" name="login_member_title" value="' . adm_ui_h($s['login_member_title']) . '" class="pg-input">', false, true);
adm_ui_field_row('ID 라벨', '<input type="text" name="login_member_label_id" value="' . adm_ui_h($s['login_member_label_id']) . '" class="pg-input">', false, true);
?>
<?php adm_ui_settings_row_close(); ?>
<?php adm_ui_settings_row_open(); ?>
<?php
adm_ui_field_row('비밀번호 라벨', '<input type="text" name="login_member_label_password" value="' . adm_ui_h($s['login_member_label_password']) . '" class="pg-input">', false, true);
adm_ui_field_row('버튼 문구', '<input type="text" name="login_member_btn" value="' . adm_ui_h($s['login_member_btn']) . '" class="pg-input">', false, true);
?>
<?php adm_ui_settings_row_close(); ?>
<div class="pg-screen-notice pg-screen-notice--info"><strong>③ 관리자 로그인</strong> (Adm/login/login.php)</div>
<?php adm_ui_settings_row_open(); ?>
<?php
adm_ui_field_row('폼 제목', '<input type="text" name="login_admin_title" value="' . adm_ui_h($s['login_admin_title']) . '" class="pg-input">', false, true);
adm_ui_field_row('ID 라벨', '<input type="text" name="login_admin_label_id" value="' . adm_ui_h($s['login_admin_label_id']) . '" class="pg-input">', false, true);
?>
<?php adm_ui_settings_row_close(); ?>
<?php adm_ui_settings_row_open(); ?>
<?php
adm_ui_field_row('비밀번호 라벨', '<input type="text" name="login_admin_label_password" value="' . adm_ui_h($s['login_admin_label_password']) . '" class="pg-input">', false, true);
adm_ui_field_row('버튼 문구', '<input type="text" name="login_admin_btn" value="' . adm_ui_h($s['login_admin_btn']) . '" class="pg-input">', false, true);
?>
<?php adm_ui_settings_row_close(); ?>
<?php adm_ui_card_close(); ?>
<?php require dirname(__FILE__) . '/inc/pro_site_settings_brand_ui.php'; ?>
								</form>

<? } elseif ($tab === 'currency') { ?>
								<form method="post" action="pro_site_settings_ok.php" onsubmit="syncPaymentCurrency();">
								<input type="hidden" name="section" value="currency">
<?php adm_ui_card_open('통화 설정'); ?>
<?php adm_ui_notice('상품 DB 가격은 USD 기준입니다. Yahoo Finance 환율로 변환·표시합니다.', 'info'); ?>
<?php adm_ui_settings_col_open(); ?>
<?php
$primary_curr = '<label class="pg-check-item"><input type="checkbox" name="currency_primary_enabled" id="currency_primary_enabled" value="1"' . ($s['currency_primary_enabled'] !== '0' ? ' checked' : '') . ' onchange="syncPaymentCurrency();"></label> ';
$primary_curr .= '<select name="currency_primary_code" id="currency_primary_code" class="pg-input pg-input--w-md" onchange="syncPaymentCurrency();">';
foreach ($currency_opts as $code => $info) {
    $primary_curr .= '<option value="' . adm_ui_h($code) . '"' . ($s['currency_primary_code'] === $code ? ' selected' : '') . '>' . adm_ui_h($info['label']) . '</option>';
}
$primary_curr .= '</select>';
adm_ui_field_row('1차 통화', $primary_curr, false, true);

$secondary_curr = '<label class="pg-check-item"><input type="checkbox" name="currency_secondary_enabled" id="currency_secondary_enabled" value="1"' . ($s['currency_secondary_enabled'] !== '0' ? ' checked' : '') . ' onchange="syncPaymentCurrency();"></label> ';
$secondary_curr .= '<select name="currency_secondary_code" id="currency_secondary_code" class="pg-input pg-input--w-md" onchange="syncPaymentCurrency();">';
foreach ($currency_opts as $code => $info) {
    $secondary_curr .= '<option value="' . adm_ui_h($code) . '"' . ($s['currency_secondary_code'] === $code ? ' selected' : '') . '>' . adm_ui_h($info['label']) . '</option>';
}
$secondary_curr .= '</select><p class="pg-field-hint">미사용 시 1개 통화만 노출·결제</p>';
adm_ui_field_row('2차 통화', $secondary_curr, false, true);

$payment_curr = '<select name="currency_payment_code" id="currency_payment_code" class="pg-input pg-input--w-md">';
foreach ($enabled_codes as $code) {
    $payment_curr .= '<option value="' . adm_ui_h($code) . '"' . ($s['currency_payment_code'] === $code ? ' selected' : '') . '>' . adm_ui_h($code) . ' (ICOPAY·카드결제)</option>';
}
$payment_curr .= '</select><p class="pg-field-hint">노출 통화 중에서만 선택 가능</p>';
adm_ui_field_row('결제 기준 통화', $payment_curr, false, true);

$example_html = '<div class="pg-field-stack"><div>예시 (USD 430 기준): <strong>' . adm_ui_h(pkshop_format_display_price(430)) . '</strong></div>';
$example_html .= '<div>결제 금액 예시: <strong>' . adm_ui_h(pkshop_format_currency_amount(pkshop_payment_amount_from_usd(430), pkshop_get_payment_currency())) . '</strong></div></div>';
adm_ui_field_row('환율 예시', $example_html, false, true);
?>
<?php adm_ui_settings_col_close(); ?>
<?php adm_ui_form_actions('<input type="submit" value="통화 설정 저장" class="pg-btn pg-btn-primary">'); ?>
								</form>
								<script>syncPaymentCurrency();</script>
<?php adm_ui_card_close(); ?>

<? } elseif ($tab === 'payment') { ?>
								<form method="post" action="pro_site_settings_ok.php">
								<input type="hidden" name="section" value="payment">
<?php adm_ui_notice('ICOPAY 카드결제·통합 인라인 체크아웃 설정입니다. 브로커 시크릿은 <code>lib/icopay_pg_secrets.local.php</code> 에 저장됩니다.', 'info'); ?>
<?php require dirname(__FILE__) . '/inc/pro_site_settings_payment_ui.php'; ?>
								</form>

<? } elseif ($tab === 'promo') { ?>
								<form method="post" action="pro_site_settings_ok.php">
								<input type="hidden" name="section" value="promo">
<?php adm_ui_card_open('홍보설정'); ?>
<?php adm_ui_notice('메인 첫 화면의 <strong>BEST</strong>(4개), <strong>RECOMMENDED</strong>(8개), <strong>All PRODUCTS</strong> 영역이 등록된 상품·카테고리 풀에서 정해진 시간마다 순차적으로 교체됩니다.', 'info'); ?>
<?php adm_ui_settings_col_open(); ?>
<?php
$best_opts = '<select name="promo_rotate_best" class="pg-input pg-input--w-md">';
foreach ($interval_opts as $sec => $label) {
    $best_opts .= '<option value="' . adm_ui_h($sec) . '"' . ((string)$promo_best_sec === (string)$sec ? ' selected' : '') . '>' . adm_ui_h($label) . ' (화면 4개)</option>';
}
$best_opts .= '</select>';
adm_ui_field_row('BEST 순환 간격', $best_opts, false, true);

$rec_opts = '<select name="promo_rotate_recommended" class="pg-input pg-input--w-md">';
foreach ($interval_opts as $sec => $label) {
    $rec_opts .= '<option value="' . adm_ui_h($sec) . '"' . ((string)$promo_recommended_sec === (string)$sec ? ' selected' : '') . '>' . adm_ui_h($label) . ' (화면 8개)</option>';
}
$rec_opts .= '</select>';
adm_ui_field_row('RECOMMENDED 순환 간격', $rec_opts, false, true);

$all_opts = '<select name="promo_rotate_all" class="pg-input pg-input--w-md">';
foreach ($interval_opts as $sec => $label) {
    $all_opts .= '<option value="' . adm_ui_h($sec) . '"' . ((string)$promo_all_sec === (string)$sec ? ' selected' : '') . '>' . adm_ui_h($label) . ' (카테고리별 4개)</option>';
}
$all_opts .= '</select>';
adm_ui_field_row('All PRODUCTS 순환 간격', $all_opts, false, true);

adm_ui_field_row('안내', '<div class="pg-field-stack"><p class="pg-field-hint">※ BEST·RECOMMENDED는 테마 등록 상품이 지정 개수보다 많을 때 자동 순환합니다.</p><p class="pg-field-hint">※ All PRODUCTS는 <a href="pro_all.php">All 상품</a>에 등록한 카테고리별 4개씩 순환합니다.</p></div>', false, true);
?>
<?php adm_ui_settings_col_close(); ?>
adm_ui_form_actions('<input type="submit" value="홍보설정 저장" class="pg-btn pg-btn-primary">');
?>
								</form>
<?php adm_ui_card_close(); ?>

<? } ?>
<?php adm_ui_page_close(); ?>
<? include "../inc/down_menu.php"; ?>
