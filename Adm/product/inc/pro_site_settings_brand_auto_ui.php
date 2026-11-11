<?php
if (!function_exists('adm_ui_h')) {
    require_once dirname(__FILE__) . '/../../inc/adm_ui_lib.php';
}

$preset_store = pkshop_brand_presets(true);
$preset_type = isset($_GET['type']) ? strtoupper(trim((string)$_GET['type'])) : (isset($preset_store['active']) ? $preset_store['active'] : 'A');
if (!in_array($preset_type, pkshop_brand_preset_types(), true)) {
    $preset_type = 'A';
}
$current_preset = pkshop_brand_preset_get($preset_type, true);
$d = isset($current_preset['data']) && is_array($current_preset['data'])
    ? pkshop_brand_preset_sanitize_data($current_preset['data'])
    : pkshop_brand_preset_sanitize_data(array());
$preset_label = isset($current_preset['label']) ? (string)$current_preset['label'] : ($preset_type . '형');

function pkshop_brand_auto_input($name, $value, $class = 'pg-input pg-input--w-title') {
    return '<input type="text" name="' . adm_ui_h($name) . '" value="' . adm_ui_h($value) . '" class="' . adm_ui_h($class) . '">';
}
?>
<script>
function pkshopBrandAutoSwitch(type) {
	var url = 'pro_site_settings.php?tab=brand_auto&type=' + encodeURIComponent(type);
	location.href = url;
}
function pkshopBrandAutoConfirmApply() {
	var type = document.getElementById('brand_auto_type').value;
	return confirm(type + '형 내용으로 라이브 사이트(하단정보 / About company / 이용약관·개인정보)에 일괄적용할까요?\n\n현재 라이브 값이 덮어씌워집니다.');
}
</script>

<?php adm_ui_notice('A/B/C 타입에 회사·푸터·약관 정보를 저장해 두고, <strong>이 타입으로 라이브 일괄적용</strong>을 누르면 라이브 사이트에 바로 반영됩니다. 로고·배너·결제연동은 포함되지 않습니다.', 'info'); ?>

<form method="post" action="pro_site_settings_ok.php" id="brand_auto_form">
<input type="hidden" name="section" value="brand_auto">
<input type="hidden" name="brand_auto_type" id="brand_auto_type" value="<?php echo adm_ui_h($preset_type); ?>">

<?php adm_ui_card_open('타입 선택'); ?>
<?php adm_ui_settings_col_open(); ?>
<?php
$type_html = '<div class="pg-field-stack" style="gap:10px;">';
foreach (pkshop_brand_preset_types() as $t) {
    $p = isset($preset_store['presets'][$t]) ? $preset_store['presets'][$t] : pkshop_brand_preset_empty($t);
    $lbl = isset($p['label']) && trim((string)$p['label']) !== '' ? trim((string)$p['label']) : ($t . '형');
    $checked = ($preset_type === $t) ? ' checked' : '';
    $type_html .= '<label class="pg-check-item" style="display:flex;align-items:center;gap:8px;">';
    $type_html .= '<input type="radio" name="brand_auto_type_ui" value="' . adm_ui_h($t) . '"' . $checked . ' onchange="pkshopBrandAutoSwitch(this.value);">';
    $type_html .= '<strong>' . adm_ui_h($t) . '형</strong>';
    $type_html .= '<span class="pg-field-hint-inline">(' . adm_ui_h($lbl) . ')</span>';
    $type_html .= '</label>';
}
$type_html .= '</div>';
adm_ui_field_row('적용 타입', $type_html, false, true);
adm_ui_field_row('타입 표시명', pkshop_brand_auto_input('preset_label', $preset_label) . '<p class="pg-field-hint">보통 About company 회사명과 동일하게 둡니다.</p>', false, true);
?>
<?php adm_ui_settings_col_close(); ?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('About company / 연락처'); ?>
<?php adm_ui_settings_col_open(); ?>
<?php
adm_ui_field_row('회사명', pkshop_brand_auto_input('footer_company_name', $d['footer_company_name']), false, true);
adm_ui_field_row('대표', pkshop_brand_auto_input('footer_ceo', $d['footer_ceo'], 'pg-input pg-input--w-md'), false, true);
adm_ui_field_row('주소', pkshop_brand_auto_input('footer_address', $d['footer_address']), false, true);
adm_ui_field_row('Tel', pkshop_brand_auto_input('footer_tel', $d['footer_tel'], 'pg-input pg-input--w-md'), false, true);
adm_ui_field_row('Fax', pkshop_brand_auto_input('footer_fax', $d['footer_fax'], 'pg-input pg-input--w-md'), false, true);
adm_ui_field_row('사업자번호', pkshop_brand_auto_input('footer_biz_no', $d['footer_biz_no'], 'pg-input pg-input--w-md'), false, true);
adm_ui_field_row('Copyright', pkshop_brand_auto_input('footer_copyright', $d['footer_copyright']), false, true);
adm_ui_field_row('약관 회사명', pkshop_brand_auto_input('agree_company_name', $d['agree_company_name']), false, true);
adm_ui_field_row('약관 회사 주소', pkshop_brand_auto_input('agree_company_address', $d['agree_company_address']), false, true);
?>
<?php adm_ui_settings_col_close(); ?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('하단 정보 블록'); ?>
<?php adm_ui_settings_col_open(); ?>
<?php
adm_ui_field_row('顧客センター 제목', pkshop_brand_auto_input('footer_cs_title', $d['footer_cs_title'], 'pg-input pg-input--w-md'), false, true);
adm_ui_field_row('顧客センター 1행', pkshop_brand_auto_input('footer_cs_line1', $d['footer_cs_line1']), false, true);
adm_ui_field_row('顧客センター 2행', pkshop_brand_auto_input('footer_cs_line2', $d['footer_cs_line2']), false, true);
adm_ui_field_row('銀行口座情報 제목', pkshop_brand_auto_input('footer_bank_title', $d['footer_bank_title'], 'pg-input pg-input--w-md'), false, true);
adm_ui_field_row('銀行口座情報 1행', pkshop_brand_auto_input('footer_bank_line1', $d['footer_bank_line1']), false, true);
adm_ui_field_row('銀行口座情報 2행', pkshop_brand_auto_input('footer_bank_line2', $d['footer_bank_line2']), false, true);
adm_ui_field_row('購入履歴情報 제목', pkshop_brand_auto_input('footer_history_title', $d['footer_history_title'], 'pg-input pg-input--w-md'), false, true);
adm_ui_field_row('配送情報 제목', pkshop_brand_auto_input('footer_delivery_title', $d['footer_delivery_title'], 'pg-input pg-input--w-md'), false, true);
adm_ui_field_row('配送情報 내용', pkshop_brand_auto_input('footer_delivery_line1', $d['footer_delivery_line1']), false, true);
adm_ui_field_row('HOME 링크', pkshop_brand_auto_input('footer_link_home', $d['footer_link_home'], 'pg-input pg-input--w-md'), false, true);
adm_ui_field_row('Terms 링크', pkshop_brand_auto_input('footer_link_terms', $d['footer_link_terms'], 'pg-input pg-input--w-md'), false, true);
adm_ui_field_row('Policy 링크', pkshop_brand_auto_input('footer_link_policy', $d['footer_link_policy'], 'pg-input pg-input--w-md'), false, true);
adm_ui_field_row('현금결제 은행 1행', pkshop_brand_auto_input('payment_bank_line1', $d['payment_bank_line1']), false, true);
adm_ui_field_row('현금결제 은행 2행', pkshop_brand_auto_input('payment_bank_line2', $d['payment_bank_line2']), false, true);
adm_ui_field_row('현금결제 은행 3행', pkshop_brand_auto_input('payment_bank_line3', $d['payment_bank_line3']), false, true);
?>
<?php adm_ui_settings_col_close(); ?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('이용 약관 / 개인정보 정책'); ?>
<?php adm_ui_settings_col_open(); ?>
<?php
adm_ui_field_row(
    '이용 약관/환불 정책',
    '<textarea name="agree_terms_text" rows="16" class="pg-input pg-input--w-memo" style="min-height:260px;font-family:Consolas,monospace;font-size:12px;line-height:1.45;">'
    . adm_ui_h($d['agree_terms_text'])
    . '</textarea>',
    false,
    true
);
adm_ui_field_row(
    '개인 정보 보호 정책',
    '<textarea name="agree_privacy_text" rows="12" class="pg-input pg-input--w-memo" style="min-height:200px;font-family:Consolas,monospace;font-size:12px;line-height:1.45;">'
    . adm_ui_h($d['agree_privacy_text'])
    . '</textarea>',
    false,
    true
);
?>
<?php adm_ui_settings_col_close(); ?>
<?php
$actions = '';
$actions .= '<button type="submit" name="brand_auto_action" value="save" class="pg-btn pg-btn-pastel-blue">이 타입 저장</button> ';
$actions .= '<button type="submit" name="brand_auto_action" value="capture" class="pg-btn pg-btn-pastel-yellow">현재 사이트 설정을 이 타입에 저장</button> ';
$actions .= '<button type="submit" name="brand_auto_action" value="apply" class="pg-btn pg-btn-pastel-red" onclick="return pkshopBrandAutoConfirmApply();">이 타입으로 라이브 일괄적용</button>';
adm_ui_form_actions($actions);
?>
<?php adm_ui_card_close(); ?>
</form>
