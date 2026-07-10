<?php
if (!function_exists('adm_ui_h')) {
    require_once dirname(__FILE__) . '/../../inc/adm_ui_lib.php';
}

function pkshop_payment_field_hint($text) {
    return '<p class="pg-field-hint">' . $text . '</p>';
}

$secret_masked = '<span style="color:#dc3545;">미설정</span>';
if ($icopay_secret_status['configured']) {
    $secret_masked = '<span style="font-family:monospace;">' . adm_ui_h($icopay_secret_status['masked']) . '</span>';
}
$secret_field = '<div class="pg-field-stack">';
$secret_field .= '<div class="pg-field-hint">현재: ' . $secret_masked . '</div>';
$secret_field .= '<input type="password" name="icopay_broker_secret" class="pg-input pg-input--w-title" placeholder="ic_... (변경 시에만 입력)" autocomplete="off">';
$secret_field .= pkshop_payment_field_hint('비워두면 기존 시크릿을 유지합니다.');
$secret_field .= '</div>';

$mode_select = '<select name="icopay_integration_mode" class="pg-input pg-input--w-md">';
foreach ($icopay_mode_opts as $mode_key => $mode_label) {
    $mode_select .= '<option value="' . adm_ui_h($mode_key) . '"' . ($s['icopay_integration_mode'] === $mode_key ? ' selected' : '') . '>' . adm_ui_h($mode_label) . '</option>';
}
$mode_select .= '</select>';

$pay_curr = '<select name="icopay_payment_currency" class="pg-input pg-input--w-md">';
foreach ($currency_opts as $code => $info) {
    $pay_curr .= '<option value="' . adm_ui_h($code) . '"' . ($s['icopay_payment_currency'] === $code ? ' selected' : '') . '>' . adm_ui_h($info['label']) . '</option>';
}
$pay_curr .= '</select>';
$pay_curr .= pkshop_payment_field_hint('ICOPAY prepare API currency (예: JPY)');

$lang_select = '<select name="icopay_checkout_lang" class="pg-input pg-input--w-md">';
foreach ($icopay_lang_opts as $lang_key => $lang_label) {
    $lang_select .= '<option value="' . adm_ui_h($lang_key) . '"' . ($s['icopay_checkout_lang'] === $lang_key ? ' selected' : '') . '>' . adm_ui_h($lang_label) . '</option>';
}
$lang_select .= '</select>';

if ($icopay_secret_status['configured'] && $s['icopay_comp_id'] !== '') {
    $status_html = '<span style="color:#198754;"><strong>연동 준비됨</strong></span>';
    $status_html .= pkshop_payment_field_hint('compId ' . adm_ui_h($s['icopay_comp_id']) . ' · ' . adm_ui_h($s['icopay_integration_mode']));
} else {
    $status_html = '<span style="color:#dc3545;"><strong>업체코드·브로커 시크릿을 입력 후 저장하세요.</strong></span>';
}

adm_ui_card_open('ICOPAY 기본 설정');
adm_ui_settings_col_open();
adm_ui_field_row('결제 사용', '<label class="pg-check-item"><input type="checkbox" name="payment_pg_enabled" value="1"' . ($s['payment_pg_enabled'] !== '0' ? ' checked' : '') . '> ICOPAY 카드결제 활성화</label>', false, true);
adm_ui_field_row('결제대행사', '<select name="payment_pg_provider" class="pg-input pg-input--w-md"><option value="ICOPAY"' . ($s['payment_pg_provider'] === 'ICOPAY' ? ' selected' : '') . '>ICOPAY</option></select>', false, true);
adm_ui_field_row('가맹점 명칭', '<input type="text" name="icopay_merchant_name" value="' . adm_ui_h($s['icopay_merchant_name']) . '" class="pg-input pg-input--w-title" placeholder="예: TESTING LIVE">' . pkshop_payment_field_hint('관리용 표시명'), false, true);
adm_ui_field_row('업체코드 (compId)', '<input type="text" name="icopay_comp_id" value="' . adm_ui_h($s['icopay_comp_id']) . '" class="pg-input pg-input--w-md" placeholder="6000000017">', false, true);
adm_ui_field_row('브로커 시크릿', $secret_field, false, true);
adm_ui_field_row('API Base URL', '<input type="text" name="icopay_api_base_url" value="' . adm_ui_h($s['icopay_api_base_url']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('연동 방식', $mode_select, false, true);
adm_ui_field_row('결제 통화', $pay_curr, false, true);
adm_ui_field_row('체크아웃 언어', $lang_select, false, true);
adm_ui_settings_col_close();
adm_ui_card_close();

adm_ui_card_open('JPAY / 레거시 (참고)');
adm_ui_settings_col_open();
adm_ui_field_row('JPAY MID', '<input type="text" name="icopay_jpay_mid" value="' . adm_ui_h($s['icopay_jpay_mid']) . '" class="pg-input pg-input--w-md" placeholder="10546">' . pkshop_payment_field_hint('관리 참고용'), false, true);
adm_ui_field_row('ChillPay MID', '<input type="text" name="icopay_ccd_merchant_code" value="' . adm_ui_h($s['icopay_ccd_merchant_code']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('ChillPay API Key', '<input type="text" name="icopay_ccd_api_key" value="' . adm_ui_h($s['icopay_ccd_api_key']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('ChillPay CCD 언어', '<input type="text" name="icopay_ccd_lang" value="' . adm_ui_h($s['icopay_ccd_lang']) . '" class="pg-input pg-input--w-sm" placeholder="en">', false, true);
adm_ui_settings_col_close();
adm_ui_card_close();

adm_ui_card_open('Webhook');
adm_ui_settings_col_open();
adm_ui_field_row('Webhook URL', '<input type="text" value="' . adm_ui_h($icopay_webhook_url) . '" class="pg-input pg-input--w-title" readonly onclick="this.select();">' . pkshop_payment_field_hint('ICOPAY 업체관리 merchantNotifyUrls 에 등록'), false, true);
adm_ui_field_row('연동 상태', $status_html, false, true);
adm_ui_settings_col_close();
adm_ui_form_actions('<input type="submit" value="결제연동 설정 저장" class="pg-btn pg-btn-primary">');
adm_ui_card_close();
