<?php
if (!function_exists('adm_ui_h')) {
    require_once dirname(__FILE__) . '/../../inc/adm_ui_lib.php';
}

function pkshop_settings_file_row($label, $current, $input_name, $hint = '', $delete_name = '', $accept = '') {
    $preview_url = $current;
    if ($current !== '' && function_exists('pkshop_site_asset_url')) {
        $preview_url = pkshop_site_asset_url($current);
    }
    $html = '현재: <span class="pg-field-hint-inline">' . adm_ui_h($current) . '</span>';
    if ($current !== '' && $preview_url !== '') {
        $html .= '<br><img src="' . adm_ui_h($preview_url) . '" alt="" class="pg-settings-preview">';
    }
    $accept_attr = ($accept !== '') ? ' accept="' . adm_ui_h($accept) . '"' : '';
    $html .= '<br><input type="file" name="' . adm_ui_h($input_name) . '" class="pg-input"' . $accept_attr . '>';
    if ($hint !== '') {
        $html .= ' <span class="pg-field-hint-inline">' . $hint . '</span>';
    }
    if ($delete_name !== '') {
        $html .= '<br><label class="pg-check-item"><input type="checkbox" name="' . adm_ui_h($delete_name) . '" value="1"> 삭제</label>';
    }
    adm_ui_field_row($label, $html, false, true);
}

function pkshop_settings_size_pair($w_name, $h_name, $w_val, $h_val, $hint = '') {
    $html = '<div class="pg-settings-size-stack">';
    $html .= '<label class="pg-settings-size-row">가로 <input type="text" name="' . adm_ui_h($w_name) . '" value="' . adm_ui_h($w_val) . '" class="pg-input pg-input--w-xs"> px</label>';
    $html .= '<label class="pg-settings-size-row">세로 <input type="text" name="' . adm_ui_h($h_name) . '" value="' . adm_ui_h($h_val) . '" class="pg-input pg-input--w-xs"> px</label>';
    if ($hint !== '') {
        $html .= '<p class="pg-field-hint">' . $hint . '</p>';
    }
    $html .= '</div>';
    return $html;
}

function pkshop_settings_logo_current_html($path) {
    $html = '<div class="pg-field-stack"><span class="pg-field-hint-inline">현재: ' . adm_ui_h($path !== '' ? $path : '(미설정)') . '</span>';
    if ($path !== '' && function_exists('pkshop_site_asset_url')) {
        $url = pkshop_site_asset_url($path);
        if ($url !== '') {
            $html .= '<img src="' . adm_ui_h($url) . '" alt="" class="pg-settings-preview">';
        }
    }
    $html .= '</div>';
    return $html;
}

function pkshop_settings_size_input($name, $val) {
    return '<div class="pg-input-unit pg-input-unit--px-right"><input type="text" name="' . adm_ui_h($name) . '" value="' . adm_ui_h($val) . '" class="pg-input"><span>px</span></div>';
}

function pkshop_settings_logo_file_input($input_name) {
    $file_id = $input_name;
    $display_id = $input_name . '_display';
    $html = '<div class="pg-file-attach-picker">';
    $html .= '<input type="text" id="' . adm_ui_h($display_id) . '" class="pg-input pg-file-attach-name" readonly placeholder="선택된 파일 없음" value="">';
    $html .= '<label for="' . adm_ui_h($file_id) . '" class="pg-btn pg-btn-outline pg-btn-file-browse">파일 선택</label>';
    $html .= '<input type="file" name="' . adm_ui_h($input_name) . '" id="' . adm_ui_h($file_id) . '" class="pg-file-attach-hidden" data-pkshop-attach-ui="1" accept="image/*" onchange="pkshopOnFaviconFileChange(this, \'' . adm_ui_h($display_id) . '\', \'\', \'\');">';
    $html .= '</div>';
    return $html;
}

function pkshop_settings_logo_guide_line($text) {
    echo '<div class="pg-form-field pg-form-field--stacked pg-logo-guide-field">';
    echo '<div class="pg-form-control"><p class="pg-logo-guide-line">안내 : ' . adm_ui_h($text) . '</p></div>';
    echo "</div>\n";
}

adm_ui_card_open('기본 / 브라우저');
adm_ui_settings_row_open();
adm_ui_field_row('브라우저 타이틀', '<input type="text" name="browser_title" value="' . adm_ui_h($s['browser_title']) . '" class="pg-input">', false, true);
adm_ui_field_row('페이지 타이틀', '<input type="text" name="site_title" value="' . adm_ui_h($s['site_title']) . '" class="pg-input">', false, true);
adm_ui_settings_row_close();
adm_ui_settings_row_open();
adm_ui_field_row('OG 타이틀', '<input type="text" name="og_title" value="' . adm_ui_h($s['og_title']) . '" class="pg-input">', false, true);
adm_ui_field_row('OG 설명', '<input type="text" name="og_description" value="' . adm_ui_h($s['og_description']) . '" class="pg-input">', false, true);
adm_ui_settings_row_close();
adm_ui_settings_col_open();
$favicon_note = '현재: <span class="pg-field-hint-inline">' . adm_ui_h($s['favicon']) . '</span>';
if ($s['favicon'] !== '' && function_exists('pkshop_site_asset_url')) {
    $favicon_note .= '<br><img src="' . adm_ui_h(pkshop_site_asset_url($s['favicon'])) . '" alt="" class="pg-settings-preview">';
}
$favicon_note .= '<br><span class="pg-field-hint-inline">변경은 상단 <strong>쇼핑몰 파비콘</strong> 카드에서 업로드하세요.</span>';
adm_ui_field_row('쇼핑몰 파비콘', $favicon_note, false, true);
$admin_favicon_note = '현재: <span class="pg-field-hint-inline">' . adm_ui_h($s['admin_favicon'] !== '' ? $s['admin_favicon'] : '(미설정)') . '</span>';
if ($s['admin_favicon'] !== '' && function_exists('pkshop_site_asset_url')) {
    $admin_favicon_note .= '<br><img src="' . adm_ui_h(pkshop_site_asset_url($s['admin_favicon'])) . '" alt="" class="pg-settings-preview">';
}
$admin_favicon_note .= '<br><span class="pg-field-hint-inline">변경은 상단 <strong>관리자 파비콘</strong> 카드에서 업로드하세요.</span>';
adm_ui_field_row('관리자 파비콘', $admin_favicon_note, false, true);
adm_ui_settings_col_close();
adm_ui_card_close();

adm_ui_card_open('상단 로고');
echo '<div class="pg-settings-logo-grid">' . "\n";
adm_ui_settings_row_open();
adm_ui_field_row('PC 로고', pkshop_settings_logo_current_html($s['logo_pc']), false, true);
adm_ui_field_row('모바일 로고', pkshop_settings_logo_current_html($s['logo_mobile']), false, true);
adm_ui_settings_row_close();
adm_ui_settings_row_open();
adm_ui_field_row('가로', pkshop_settings_size_input('logo_pc_width', $s['logo_pc_width']), false, true);
adm_ui_field_row('가로', pkshop_settings_size_input('logo_mobile_width', $s['logo_mobile_width']), false, true);
adm_ui_settings_row_close();
adm_ui_settings_row_open();
adm_ui_field_row('세로', pkshop_settings_size_input('logo_pc_height', $s['logo_pc_height']), false, true);
adm_ui_field_row('세로', pkshop_settings_size_input('logo_mobile_height', $s['logo_mobile_height']), false, true);
adm_ui_settings_row_close();
adm_ui_settings_row_open();
adm_ui_field_row('파일 업로드', pkshop_settings_logo_file_input('upload_logo_pc'), false, true);
adm_ui_field_row('파일 업로드', pkshop_settings_logo_file_input('upload_logo_mobile'), false, true);
adm_ui_settings_row_close();
adm_ui_settings_row_open();
pkshop_settings_logo_guide_line('PC 상단 헤더 로고');
pkshop_settings_logo_guide_line('모바일 상단 헤더 로고');
adm_ui_settings_row_close();
echo "</div><!-- pg-settings-logo-grid -->\n";
adm_ui_card_close();

adm_ui_card_open('메인 배너 (슬라이드 3장)');
adm_ui_settings_col_open();
adm_ui_field_row('배너 권장 사이즈', pkshop_settings_size_pair('banner_width', 'banner_height', $s['banner_width'], $s['banner_height'], 'px'), false, true);
for ($bi = 1; $bi <= 3; $bi++) {
    $bk = 'banner' . $bi;
    pkshop_settings_file_row('배너 ' . $bi, $s[$bk], 'upload_' . $bk);
}
adm_ui_field_row('BEST 문구', '<input type="text" name="main_welcome_best" value="' . adm_ui_h($s['main_welcome_best']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('REC 문구', '<input type="text" name="main_welcome_recommended" value="' . adm_ui_h($s['main_welcome_recommended']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('ALL 문구', '<input type="text" name="main_welcome_all" value="' . adm_ui_h($s['main_welcome_all']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_settings_col_close();
adm_ui_card_close();

adm_ui_card_open('푸터 위 환영 배너');
adm_ui_settings_col_open();
pkshop_settings_file_row('환영 배너 1', $s['footer_story_banner1'], 'upload_footer_story_banner1', '푸터 顧客センター 블록 바로 위', 'delete_footer_story_banner1');
pkshop_settings_file_row('환영 배너 2', $s['footer_story_banner2'], 'upload_footer_story_banner2', '슬라이드 2번째 (선택)', 'delete_footer_story_banner2');
adm_ui_field_row('배너 고정 사이즈', pkshop_settings_size_pair('footer_story_banner_width', 'footer_story_banner_height', $s['footer_story_banner_width'], $s['footer_story_banner_height'], '기본 1200 × 420'), false, true);
adm_ui_settings_col_close();
adm_ui_card_close();

adm_ui_card_open('하단 정보 블록');
adm_ui_settings_col_open();
adm_ui_field_row('顧客センター 제목', '<input type="text" name="footer_cs_title" value="' . adm_ui_h($s['footer_cs_title']) . '" class="pg-input pg-input--w-md">', false, true);
adm_ui_field_row('顧客センター 1행', '<input type="text" name="footer_cs_line1" value="' . adm_ui_h($s['footer_cs_line1']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('顧客センター 2행', '<input type="text" name="footer_cs_line2" value="' . adm_ui_h($s['footer_cs_line2']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('銀行口座情報 제목', '<input type="text" name="footer_bank_title" value="' . adm_ui_h($s['footer_bank_title']) . '" class="pg-input pg-input--w-md"><p class="pg-field-hint"><a href="/Adm/admin_pass/bank_change.php">계좌변경</a>과 연동</p>', false, true);
adm_ui_field_row('銀行口座情報 1행', '<input type="text" name="footer_bank_line1" value="' . adm_ui_h($s['footer_bank_line1']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('銀行口座情報 2행', '<input type="text" name="footer_bank_line2" value="' . adm_ui_h($s['footer_bank_line2']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('購入履歴情報 제목', '<input type="text" name="footer_history_title" value="' . adm_ui_h($s['footer_history_title']) . '" class="pg-input pg-input--w-md">', false, true);
adm_ui_field_row('配送情報 제목', '<input type="text" name="footer_delivery_title" value="' . adm_ui_h($s['footer_delivery_title']) . '" class="pg-input pg-input--w-md">', false, true);
adm_ui_field_row('配送情報 내용', '<input type="text" name="footer_delivery_line1" value="' . adm_ui_h($s['footer_delivery_line1']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('HOME 링크', '<input type="text" name="footer_link_home" value="' . adm_ui_h($s['footer_link_home']) . '" class="pg-input pg-input--w-md" placeholder="HOME">', false, true);
adm_ui_field_row('Terms 링크', '<input type="text" name="footer_link_terms" value="' . adm_ui_h($s['footer_link_terms']) . '" class="pg-input pg-input--w-md" placeholder="Terms">', false, true);
adm_ui_field_row('Policy 링크', '<input type="text" name="footer_link_policy" value="' . adm_ui_h($s['footer_link_policy']) . '" class="pg-input pg-input--w-md" placeholder="Policy">', false, true);
adm_ui_settings_col_close();
adm_ui_card_close();

adm_ui_card_open('About company');
adm_ui_settings_col_open();
adm_ui_field_row('섹션 제목', '<input type="text" name="footer_about_title" value="' . adm_ui_h($s['footer_about_title']) . '" class="pg-input pg-input--w-md">', false, true);
adm_ui_field_row('회사명', '<input type="text" name="footer_company_name" value="' . adm_ui_h($s['footer_company_name']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('대표', '<input type="text" name="footer_ceo" value="' . adm_ui_h($s['footer_ceo']) . '" class="pg-input pg-input--w-md">', false, true);
adm_ui_field_row('주소', '<input type="text" name="footer_address" value="' . adm_ui_h($s['footer_address']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('Tel', '<input type="text" name="footer_tel" value="' . adm_ui_h($s['footer_tel']) . '" class="pg-input pg-input--w-md">', false, true);
adm_ui_field_row('Fax', '<input type="text" name="footer_fax" value="' . adm_ui_h($s['footer_fax']) . '" class="pg-input pg-input--w-md">', false, true);
adm_ui_field_row('사업자번호', '<input type="text" name="footer_biz_no" value="' . adm_ui_h($s['footer_biz_no']) . '" class="pg-input pg-input--w-md">', false, true);
adm_ui_field_row('Copyright', '<input type="text" name="footer_copyright" value="' . adm_ui_h($s['footer_copyright']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('약관 회사명', '<input type="text" name="agree_company_name" value="' . adm_ui_h($s['agree_company_name']) . '" class="pg-input pg-input--w-title"><p class="pg-field-hint">약관/정책 본문의 회사명 치환에 사용</p>', false, true);
adm_ui_field_row('약관 회사 주소', '<input type="text" name="agree_company_address" value="' . adm_ui_h($s['agree_company_address']) . '" class="pg-input pg-input--w-title">', false, true);
pkshop_settings_file_row('MY INFO 아이콘', $s['footer_icon_myinfo'], 'upload_footer_icon_myinfo');
pkshop_settings_file_row('CART 아이콘', $s['footer_icon_cart'], 'upload_footer_icon_cart');
pkshop_settings_file_row('하단 이미지', $s['footer_bottom_image'], 'upload_footer_bottom_image', '', 'delete_footer_bottom_image');
adm_ui_field_row('하단 이미지 사이즈', pkshop_settings_size_pair('footer_bottom_image_width', 'footer_bottom_image_height', $s['footer_bottom_image_width'], $s['footer_bottom_image_height'], '가로 기본 1200px (0=자동높이)'), false, true);
adm_ui_settings_col_close();
adm_ui_card_close();

$agree_terms_edit = function_exists('pkshop_agree_terms_text') ? pkshop_agree_terms_text(true) : (isset($s['agree_terms_text']) ? $s['agree_terms_text'] : '');
$agree_privacy_edit = function_exists('pkshop_agree_privacy_text') ? pkshop_agree_privacy_text(true) : (isset($s['agree_privacy_text']) ? $s['agree_privacy_text'] : '');
adm_ui_card_open('이용 약관 / 개인정보 정책');
adm_ui_notice('아래에서 수정·저장하면 <a href="/member/agree.php" target="_blank" rel="noopener">회원 약관 페이지</a>에 바로 반영됩니다. 회사명·주소는 위 「약관 회사명/주소」 값으로도 치환됩니다.', 'info');
adm_ui_settings_col_open();
adm_ui_field_row(
    '이용 약관/환불 정책',
    '<textarea name="agree_terms_text" rows="18" class="pg-input pg-input--w-memo" style="min-height:280px;font-family:Consolas,monospace;font-size:12px;line-height:1.45;">'
    . adm_ui_h($agree_terms_edit)
    . '</textarea><p class="pg-field-hint">member/agree.php 첫 번째 약관 영역</p>',
    false,
    true
);
adm_ui_field_row(
    '개인 정보 보호 정책',
    '<textarea name="agree_privacy_text" rows="14" class="pg-input pg-input--w-memo" style="min-height:220px;font-family:Consolas,monospace;font-size:12px;line-height:1.45;">'
    . adm_ui_h($agree_privacy_edit)
    . '</textarea><p class="pg-field-hint">member/agree.php 두 번째 프라이버시 영역</p>',
    false,
    true
);
adm_ui_settings_col_close();
adm_ui_card_close();

adm_ui_card_open('현금결제 은행정보');
adm_ui_notice('1·2행은 하단 銀行口座情報과 <a href="/Adm/admin_pass/bank_change.php">계좌변경</a>과 자동 연동됩니다.', 'info');
adm_ui_settings_col_open();
adm_ui_field_row('은행 표시 1행', '<input type="text" name="payment_bank_line1" value="' . adm_ui_h($s['payment_bank_line1']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('은행 표시 2행', '<input type="text" name="payment_bank_line2" value="' . adm_ui_h($s['payment_bank_line2']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_field_row('은행 표시 3행', '<input type="text" name="payment_bank_line3" value="' . adm_ui_h($s['payment_bank_line3']) . '" class="pg-input pg-input--w-title">', false, true);
adm_ui_settings_col_close();
adm_ui_form_actions('<input type="submit" value="브랜드설정 저장" class="pg-btn pg-btn-primary">');
adm_ui_card_close();
