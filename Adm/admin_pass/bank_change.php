<?php
include "../common/dbconn.php";
include "../inc/top_menu.php";
require_once dirname(__FILE__) . '/../../include/site_settings_lib.php';
require_once dirname(__FILE__) . '/../inc/adm_ui_lib.php';

$s = pkshop_site_settings();
?>
<?php adm_ui_page_open('pg-site-settings-screen pg-bank-change-screen'); ?>
<?php adm_ui_card_open('계좌변경'); ?>
<?php adm_ui_notice('브랜드설정의 <strong>하단 정보 블록 · 銀行口座情報</strong> 및 <strong>현금결제 은행정보</strong>와 동일한 데이터입니다. 여기서 저장하면 브랜드설정에도 바로 반영됩니다.', 'info'); ?>
<form name="form" method="post" action="bank_change_do.php">
<div class="pg-bank-change-row">
<?php
adm_ui_field_row('銀行口座情報 제목', '<input type="text" name="footer_bank_title" value="' . adm_ui_h($s['footer_bank_title']) . '" class="pg-input">', false, true);
adm_ui_field_row('은행 표시 1행', '<input type="text" name="footer_bank_line1" value="' . adm_ui_h($s['footer_bank_line1']) . '" class="pg-input"><p class="pg-field-hint">푸터·결제 화면 1행</p>', false, true);
adm_ui_field_row('은행 표시 2행', '<input type="text" name="footer_bank_line2" value="' . adm_ui_h($s['footer_bank_line2']) . '" class="pg-input"><p class="pg-field-hint">푸터·결제 화면 2행</p>', false, true);
adm_ui_field_row('은행 표시 3행', '<input type="text" name="payment_bank_line3" value="' . adm_ui_h($s['payment_bank_line3']) . '" class="pg-input"><p class="pg-field-hint">결제 화면 추가 행 (선택)</p>', false, true);
?>
</div>
<?php adm_ui_form_actions('<input type="submit" value="계좌 저장" class="pg-btn pg-btn-primary">'); ?>
</form>
<?php adm_ui_card_close(); ?>
<?php adm_ui_page_close(); ?>
<?php include "../inc/down_menu.php"; ?>
