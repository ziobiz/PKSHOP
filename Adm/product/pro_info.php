<?
include "../common/dbconn.php";
include "../common/user_function.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";
include "pro_product_form_lib.php";

$No = isset($_REQUEST['No']) ? intval($_REQUEST['No']) : 0;
if ($No <= 0) {
	echo '<script>alert("잘못된 상품 번호입니다."); history.back();</script>';
	exit;
}

$product = pro_form_load_product_by_no($DB, $shop_goods, $No);
if ($product === false) {
	echo '<script>alert("상품 정보를 찾을 수 없습니다."); history.back();</script>';
	exit;
}

foreach ($product as $key => $val) {
	$$key = $val;
}

$return_url = isset($_REQUEST['return_url']) ? $_REQUEST['return_url'] : '';
if ($return_url === '' && $p_id === 'admin_ai') {
	$return_url = 'pro_ai_products.php';
} elseif ($return_url === '') {
	$return_url = 'products.php';
}

if (isset($_POST['code1']) && $_POST['code1'] !== '') {
	$code1 = $_POST['code1'];
	$code2 = isset($_POST['code2']) ? $_POST['code2'] : '00';
	$code3 = isset($_POST['code3']) ? $_POST['code3'] : '00';
	$code4 = isset($_POST['code4']) ? $_POST['code4'] : '00';
	$sel_cate = isset($_POST['sel_cate']) ? $_POST['sel_cate'] : pro_form_infer_sel_cate($code2, $code3, $code4);
} else {
	$sel_cate = pro_form_infer_sel_cate($code2, $code3, $code4);
}

if ($sel_cate == "1") {
	$code2 = "00";
	$code3 = "00";
	$code4 = "00";
} else if ($sel_cate == "2") {
	$code3 = "00";
	$code4 = "00";
} else if ($sel_cate == "3") {
	$code4 = "00";
}

if ($country === '' || $country === null) {
	$country = '1';
}
if ($pr_kind === '') {
	$pr_kind = 'main';
}

$shop_img = "../../upload/";
$page_title = '상품 수정';
?>
<script type="text/javascript" src="se2/js/HuskyEZCreator.js" charset="utf-8"></script>
<script language="javascript">
function go_select(i) {
	document.form.sel_cate.value = i;
	document.form.action = "pro_info.php?No=<?=(int)$No?>";
	document.form.submit();
}
function go_modify() {
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
	document.form.action = "pro_info_ok.php";
	document.form.submit();
}
function go_list() {
	location.href = <?=json_encode($return_url)?>;
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

<form name="form" method="post" action="pro_info_ok.php" enctype="multipart/form-data">
<input type="hidden" name="No" value="<?=(int)$No?>">
<input type="hidden" name="sel_cate" value="<?=adm_ui_h($sel_cate)?>">
<input type="hidden" name="p_id" value="<?=adm_ui_h($p_id)?>">
<input type="hidden" name="pr_kind" value="<?=adm_ui_h($pr_kind)?>">
<input type="hidden" name="old_code" value="<?=adm_ui_h($code)?>">
<input type="hidden" name="return_url" value="<?=adm_ui_h($return_url)?>">
<input type="hidden" name="old_imgl" value="<?=adm_ui_h($imgl)?>">
<input type="hidden" name="old_imgm" value="<?=adm_ui_h($imgm)?>">
<input type="hidden" name="old_imgb1" value="<?=adm_ui_h($imgb1)?>">
<input type="hidden" name="old_imgb2" value="<?=adm_ui_h($imgb2)?>">
<input type="hidden" name="old_imgb3" value="<?=adm_ui_h($imgb3)?>">

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
adm_ui_field_row('상품코드', '<input type="text" name="code" value="' . adm_ui_h($code) . '" class="pg-input pg-input-readonly pg-input--w-md" readonly>', false, true);
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
adm_ui_field_row('할인가격', '<div class="pg-input-unit"><input type="text" name="prices" value="' . adm_ui_h($prices) . '" class="pg-input pg-input--w-price"><span>원</span></div>', false, true);
adm_ui_field_row('RV 퍼센트', '<div class="pg-input-unit pg-input-unit--inline-hint"><input type="number" name="c_pv" value="' . adm_ui_h($c_pv) . '" class="pg-input pg-input--w-sm"><span>%</span><span class="pg-field-hint-inline">(숫자만 입력)</span></div>', false, true);
?>
</div>
<?php
adm_ui_field_row('포인트 전용 구매', '<label class="pg-check-item pg-check-item--inline"><input type="checkbox" name="onlypoint" value="1"' . ($onlypoint == '1' ? ' checked' : '') . '> 포인트로만 구매 가능 (체크 시 일반 결제 불가)</label>', false, true);
?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('추가 옵션'); ?>
<?php adm_ui_notice('옵션사항과 증/차감금액은 <strong>엔터(줄바꿈)</strong>으로 구분합니다. 예) 250mm → 0원, 260mm(+5000원) → 5000', 'info'); ?>
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
	<textarea name="detail" id="detail" rows="12" class="pg-input--editor-full" style="width:100%;"><?=str_replace('</textarea>', '&lt;/textarea&gt;', $detail)?></textarea>
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
<?php adm_ui_form_actions(
	'<button type="button" class="pg-btn pg-btn-primary" onclick="go_modify();">저장하기</button>'
	. '<button type="button" class="pg-btn pg-btn-outline" onclick="go_list();">목록</button>'
); ?>
<?php adm_ui_card_close(); ?>

</form>

<?php adm_ui_page_close(); ?>
<? include "../inc/down_menu.php"; ?>
