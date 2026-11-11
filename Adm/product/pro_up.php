<? 
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";
include "pro_product_form_lib.php";

if (!isset($country) || $country === '') {
	$country = '1';
}

$form_defaults = array(
	'sel_cate', 'code1', 'code2', 'code3', 'code4', 'code_copy', 'title', 'company', 'color', 'size', 'home',
	'pricec', 'priced', 'c_pv', 'onlypoint', 'currnum', 'warnnum', 'detail', 'soldout', 'dis',
	'theme_g', 'theme_n', 'theme_r', 'theme_f', 'imgl', 'imgm', 'imgb1', 'imgb2', 'imgb3',
	'option_t1', 'option_n1', 'option_p1', 'option_t2', 'option_n2', 'option_p2',
	'option_t3', 'option_n3', 'option_p3', 'option_t4', 'option_n4', 'option_p4',
	'option_t5', 'option_n5', 'option_p5',
);
foreach ($form_defaults as $fk) {
	if (!isset($$fk)) {
		$$fk = '';
	}
}

$shop_img = "../../shop_img";

if ($sel_cate == "1") {
	$code2 = "";
	$code3 = "";
	$code4 = "";
} else if ($sel_cate == "2") {
	$code3 = "";
	$code4 = "";
} else if ($sel_cate == "3") {
	$code4 = "";
}

$code = pro_form_compute_code($DB, $shop_goods, $sel_cate, $code1, $code2, $code3, $code4, $code_copy);
?>
					<script type="text/javascript" src="se2/js/HuskyEZCreator.js" charset="utf-8"></script>
<script language="javascript">
function go_select(i) {
	document.form.action = "pro_up.php?sel_cate=" + i;
	document.form.submit();
}
function regist() {
	if (document.form.code1.value == "00") {
		alert('1차 카테고리는 반드시 입력하십시요');
		return;
	}
	if (document.form.title.value == "") {
		alert('상품명은 반드시 입력하십시요');
		return;
	}
	if (document.form.country.value == "") {
		document.form.country.value = "1";
	}
	oEditors.getById["detail"].exec("UPDATE_CONTENTS_FIELD", []);
	document.form.action = "pro_up_ok.php";
	document.form.submit();
}
function onProductImageChange(input, displayId) {
	var display = document.getElementById(displayId);
	if (!display) return;
	if (input.files && input.files.length > 0) {
		display.value = input.files[0].name;
	} else {
		display.value = '';
	}
}
</script>

<?php adm_ui_page_open('pg-product-form-screen'); ?>

<form name="form" method="post" action="./pro_up_ok.php" enctype="multipart/form-data">
<input type="hidden" name="pr_kind" value="main">
<input type="hidden" name="p_id" value="admin">

<?php adm_ui_card_open('기본 정보'); ?>
<div class="pg-form-section pg-form-section--cate">
<div class="pg-form-grid pg-form-grid--cate">
<?php
adm_ui_field_row('1차 카테고리', pro_form_cate_select_html($DB, $shop_cate, 1, $code1, $code2, $code3, $code1), true);
adm_ui_field_row('2차 카테고리', pro_form_cate_select_html($DB, $shop_cate, 2, $code1, $code2, $code3, $code2));
adm_ui_field_row('3차 카테고리', pro_form_cate_select_html($DB, $shop_cate, 3, $code1, $code2, $code3, $code3));
adm_ui_field_row('4차 카테고리', pro_form_cate_select_html($DB, $shop_cate, 4, $code1, $code2, $code3, $code4));
?>
</div>
</div>
<?php
adm_ui_field_row('상품코드', '<input type="text" name="code" value="' . adm_ui_h($code) . '" class="pg-input pg-input-readonly pg-input--w-md" readonly placeholder="자동 생성되는 코드입니다.">', false, true);
adm_ui_field_row('상품명', '<input type="text" name="title" value="' . adm_ui_h($title) . '" class="pg-input pg-input--w-title" maxlength="100">', true, true);
adm_ui_field_row('상품구분', pro_form_dis_radios_html($dis), false, true);
adm_ui_field_row('제조사', '<input type="text" name="company" value="' . adm_ui_h($company) . '" class="pg-input pg-input--w-md" maxlength="30">', false, true);
adm_ui_field_row('국가', pro_form_country_select_html($country), true, true);
?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('옵션 정보'); ?>
<?php adm_ui_notice('색상·사이즈 옵션은 금액/포인트 계산에 영향을 주지 않는 표시용 옵션입니다. 가격이 변하는 옵션은 아래 <strong>추가 옵션</strong>을 이용하세요.', 'info'); ?>
<?php
adm_ui_field_row('색상/종류', '<div class="pg-input-unit pg-input-unit--inline-hint"><input type="text" name="color" value="' . adm_ui_h($color) . '" class="pg-input pg-input--w-md" placeholder="예: 하늘색,핑크색,블랙,화이트"><span class="pg-field-hint-inline">(콤마로 구분)</span></div>', false, true);
adm_ui_field_row('사이즈/규격', '<input type="text" name="size" value="' . adm_ui_h($size) . '" class="pg-input pg-input--w-md" placeholder="예: S,M,L,XL">', false, true);
adm_ui_field_row('원산지', '<input type="text" name="home" value="' . adm_ui_h($home) . '" class="pg-input pg-input--w-md" maxlength="30">', false, true);
?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('노출 설정'); ?>
<?php adm_ui_field_row('상품홍보', pro_form_theme_checkboxes_html($theme_g, $theme_n, $theme_r, $theme_f), false, true); ?>
<p class="pg-field-hint">체크한 항목은 쇼핑몰 메인·테마 영역에 노출됩니다.</p>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('가격 · RV'); ?>
<div class="pg-form-grid pg-form-grid--price-rv">
<?php
adm_ui_field_row('판매가격', '<div class="pg-input-unit"><input type="text" name="pricec" value="' . adm_ui_h($pricec) . '" class="pg-input pg-input--w-price"><span>원</span></div>', false, true);
adm_ui_field_row('실판매가격', '<div class="pg-input-unit"><input type="text" name="priced" value="' . adm_ui_h($priced) . '" class="pg-input pg-input--w-price"><span>원</span></div>', false, true);
adm_ui_field_row('할인가격', '<div class="pg-input-unit"><input type="text" name="prices" value="' . adm_ui_h($priced) . '" class="pg-input pg-input--w-price"><span>원</span></div>', false, true);
adm_ui_field_row('RV 퍼센트', '<div class="pg-input-unit pg-input-unit--inline-hint"><input type="number" name="c_pv" value="' . adm_ui_h($c_pv) . '" class="pg-input pg-input--w-sm"><span>%</span><span class="pg-field-hint-inline">(숫자만 입력)</span></div>', false, true);
?>
</div>
<?php
adm_ui_field_row('포인트 전용 구매', '<label class="pg-check-item pg-check-item--inline"><input type="checkbox" name="onlypoint" value="1"' . ($onlypoint == '1' ? ' checked' : '') . '> 포인트로만 구매 가능 (체크 시 일반 결제 불가)</label>', false, true);
?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('추가 옵션'); ?>
<?php adm_ui_notice('옵션사항과 증/차감금액은 <strong>엔터(줄바꿈)</strong>으로 구분합니다. 예) 250mm → 0원, 260mm(+5000원) → 5000', 'info'); ?>
<div class="pg-option-example">
	<div class="pg-option-block-title">입력 예시 — 신발사이즈</div>
	<div class="pg-option-pair-grid">
		<div class="pg-form-field pg-form-field--stacked">
			<label class="pg-form-label">옵션사항</label>
			<div class="pg-form-control"><textarea name="option_n1_s" rows="5" class="pg-input pg-input-demo" readonly onfocus="this.blur();">240mm
245mm
250mm(+3000원)
260mm(+5000원)</textarea></div>
		</div>
		<div class="pg-form-field pg-form-field--stacked">
			<label class="pg-form-label">증/차감가격</label>
			<div class="pg-form-control"><textarea name="option_p1_s" rows="5" class="pg-input pg-input-demo" readonly onfocus="this.blur();">0
0
3000
5000</textarea></div>
		</div>
	</div>
</div>
<?
for ($opt_i = 1; $opt_i <= 5; $opt_i++) {
	$t_var = 'option_t' . $opt_i;
	$n_var = 'option_n' . $opt_i;
	$p_var = 'option_p' . $opt_i;
	echo pro_form_option_block_html($opt_i, $$t_var, $$n_var, $$p_var);
}
?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('재고'); ?>
<?php
adm_ui_field_row('현재수량', '<div class="pg-input-unit"><input type="text" name="currnum" value="' . adm_ui_h($currnum) . '" class="pg-input pg-input--w-sm" maxlength="16"><span>개</span></div>');
adm_ui_field_row('재고경고수량', '<div class="pg-input-unit pg-input-unit--inline-hint"><input type="text" name="warnnum" value="' . adm_ui_h($warnnum) . '" class="pg-input pg-input--w-sm" maxlength="16"><span>개</span><span class="pg-field-hint-inline">(경고 시 관리자 확인)</span></div>');
?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('상품 이미지'); ?>
<div class="pg-product-image-grid">
<?php
echo pro_form_image_slot_html('imgl', '상품리스트', '175×175', $imgl, $shop_img, $imgl);
echo pro_form_image_slot_html('imgm', '상세설명 1', '275×275', $imgm, $shop_img, $imgm);
echo pro_form_image_slot_html('imgb1', '상세설명 2', '275×275', $imgb1, $shop_img, $imgb1);
echo pro_form_image_slot_html('imgb2', '상세설명 3', '275×275', $imgb2, $shop_img, $imgb2);
echo pro_form_image_slot_html('imgb3', '상세설명 4', '275×275', $imgb3, $shop_img, $imgb3);
?>
</div>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('상세 설명'); ?>
<div class="pg-editor-wrap">
	<textarea name="detail" id="detail" rows="12" class="pg-input--editor-full" style="width:100%;"><?=adm_ui_h($detail)?></textarea>
</div>
								<script type="text/javascript">
									var oEditors = [];
									nhn.husky.EZCreator.createInIFrame({
										oAppRef: oEditors,
										elPlaceHolder: "detail",
										sSkinURI: "se2/SmartEditor2Skin.html",
	fCreator: "createSEditor2",
	fOnAppLoad: function() {
		var wrap = document.querySelector('.pg-editor-wrap');
		if (!wrap || !oEditors.getById || !oEditors.getById['detail']) return;
		var w = wrap.clientWidth;
		if (w > 0) {
			oEditors.getById['detail'].exec('RESIZE_EDITING_AREA', [w + 'px', null]);
		}
	}
									});
								</script>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('판매 설정'); ?>
<?php adm_ui_field_row('판매대기', '<label class="pg-check-item pg-check-item--block"><input type="checkbox" name="soldout" value="Y"' . ($soldout == 'Y' ? ' checked' : '') . '> 판매대기 (체크 시 쇼핑몰에 노출되지 않음)</label>'); ?>
<?php adm_ui_form_actions('<button type="button" class="pg-btn pg-btn-primary" onclick="regist();">등록하기</button>'); ?>
<?php adm_ui_card_close(); ?>

									</form>  

<?php adm_ui_page_close(); ?>
<? include "../inc/down_menu.php"; ?>		
