<?php
if (!function_exists('adm_ui_h')) {
    require_once dirname(__FILE__) . '/../../inc/adm_ui_lib.php';
}

function pkshop_render_favicon_upload_card($setting_key, $upload_only, $form_id, $card_title, $notice_html, $submit_label) {
    global $s;
    $current = isset($s[$setting_key]) ? (string)$s[$setting_key] : '';
    $preview = $current;
    if ($current !== '' && function_exists('pkshop_site_asset_url')) {
        $preview = pkshop_site_asset_url($current);
    }

    $input_name = 'upload_' . $setting_key;
    $display_id = $input_name . '_display';
    $file_id = $input_name;
    $btn_id = $form_id . '_btn';
    $preview_id = $form_id . '_pending_preview';
    $current_preview_id = $form_id . '_current_preview';
    ?>
<form method="post" action="pro_site_settings_ok.php" enctype="multipart/form-data" class="pg-favicon-upload-form" id="<?=adm_ui_h($form_id)?>" onsubmit="return pkshopValidateFaviconUpload('<?=adm_ui_h($form_id)?>');">
<input type="hidden" name="section" value="brand">
<input type="hidden" name="upload_only" value="<?=adm_ui_h($upload_only)?>">
<?php adm_ui_card_open($card_title); ?>
<?php adm_ui_notice($notice_html, 'info'); ?>
<?php adm_ui_settings_col_open(); ?>
<?php
    $html = '현재: <span class="pg-field-hint-inline">' . adm_ui_h($current !== '' ? $current : '(미설정)') . '</span>';
    if ($current !== '' && $preview !== '') {
        $html .= '<br><img src="' . adm_ui_h($preview) . '" alt="" class="pg-settings-preview" id="' . adm_ui_h($current_preview_id) . '">';
    }
    $html .= '<br><div class="pg-file-attach-toolbar">';
    $html .= '<div class="pg-file-attach-picker">';
    $html .= '<input type="text" id="' . adm_ui_h($display_id) . '" class="pg-input pg-file-attach-name" readonly placeholder="선택된 파일 없음" value="">';
    $html .= '<label for="' . adm_ui_h($file_id) . '" class="pg-btn pg-btn-outline pg-btn-file-browse">파일 선택</label>';
    $html .= '<input type="file" name="' . adm_ui_h($input_name) . '" id="' . adm_ui_h($file_id) . '" class="pg-file-attach-hidden" data-pkshop-attach-ui="1" accept=".png,.ico,.jpg,.jpeg,.gif,.webp,image/png,image/x-icon" onchange="pkshopOnFaviconFileChange(this, \'' . adm_ui_h($display_id) . '\', \'' . adm_ui_h($btn_id) . '\', \'' . adm_ui_h($preview_id) . '\');">';
    $html .= '</div>';
    $html .= '<button type="submit" class="pg-btn pg-btn-primary pg-file-attach-submit" id="' . adm_ui_h($btn_id) . '" disabled>' . adm_ui_h($submit_label) . '</button>';
    $html .= '</div>';
    $html .= '<p class="pg-file-attach-hint">PNG 또는 ICO 권장 (32×32px, 최대 2MB). 큰 이미지는 자동으로 64px 이하로 줄여 저장합니다.</p>';
    $html .= '<img src="" alt="" class="pg-settings-preview pg-favicon-pending-preview" id="' . adm_ui_h($preview_id) . '" style="display:none;">';
    adm_ui_field_row('파비콘 파일', $html, false, true);
?>
<?php adm_ui_settings_col_close(); ?>
<?php adm_ui_card_close(); ?>
</form>
<?php
}

pkshop_render_favicon_upload_card(
    'favicon',
    'favicon',
    'favicon_upload_form',
    '쇼핑몰 파비콘',
    '쇼핑몰(회원 사이트) 브라우저 탭·북마크 아이콘입니다. 파일 선택 후 <strong>쇼핑몰 파비콘 업로드</strong>를 눌러 주세요.',
    '쇼핑몰 파비콘 업로드'
);

pkshop_render_favicon_upload_card(
    'admin_favicon',
    'admin_favicon',
    'admin_favicon_upload_form',
    '관리자 파비콘',
    '관리자(Adm) 사이트 브라우저 탭·북마크 아이콘입니다. 쇼핑몰과 별도로 설정합니다. 파일 선택 후 <strong>관리자 파비콘 업로드</strong>를 눌러 주세요.',
    '관리자 파비콘 업로드'
);
