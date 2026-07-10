<?
include "../common/dbconn.php";
include "../common/user_function.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";
require_once dirname(__FILE__) . '/../../include/site_settings_lib.php';

function pkshop_admin_main_all_label($DB, $shop_cate, $entry) {
	$label = '전체 상품';
	$code1 = $entry['code1'];
	if ($code1 === '') {
		return $label;
	}
	$q = "SELECT cate1 FROM $shop_cate WHERE code1='$code1' and code2='00' and code3='00' and code4='00' LIMIT 1";
	$DB->get($q, $rs, $rn);
	if ($rn > 0) {
		$label = stripslashes($rs[0][0]);
	}
	if ($entry['code2'] !== '' && $entry['code2'] !== '00') {
		$q = "SELECT cate2 FROM $shop_cate WHERE code1='$code1' and code2='" . $entry['code2'] . "' and code3='00' and code4='00' LIMIT 1";
		$DB->get($q, $rs, $rn);
		if ($rn > 0) {
			$label .= ' > ' . stripslashes($rs[0][0]);
		}
	}
	if ($entry['code3'] !== '' && $entry['code3'] !== '00') {
		$q = "SELECT cate3 FROM $shop_cate WHERE code1='$code1' and code2='" . $entry['code2'] . "' and code3='" . $entry['code3'] . "' and code4='00' LIMIT 1";
		$DB->get($q, $rs, $rn);
		if ($rn > 0) {
			$label .= ' > ' . stripslashes($rs[0][0]);
		}
	}
	if ($entry['code4'] !== '' && $entry['code4'] !== '00') {
		$q = "SELECT cate4 FROM $shop_cate WHERE code1='$code1' and code2='" . $entry['code2'] . "' and code3='" . $entry['code3'] . "' and code4='" . $entry['code4'] . "' LIMIT 1";
		$DB->get($q, $rs, $rn);
		if ($rn > 0) {
			$label .= ' > ' . stripslashes($rs[0][0]);
		}
	}
	return $label;
}

$sel_cate = isset($_REQUEST['sel_cate']) ? trim($_REQUEST['sel_cate']) : '';
$sel_code1 = isset($_REQUEST['sel_code1']) ? trim($_REQUEST['sel_code1']) : '';
$sel_code2 = isset($_REQUEST['sel_code2']) ? trim($_REQUEST['sel_code2']) : '';
$sel_code3 = isset($_REQUEST['sel_code3']) ? trim($_REQUEST['sel_code3']) : '';
$sel_code4 = isset($_REQUEST['sel_code4']) ? trim($_REQUEST['sel_code4']) : '';
$saved_categories = pkshop_main_all_categories_list();

if ($sel_cate === '1') {
	$sel_code2 = '';
	$sel_code3 = '';
	$sel_code4 = '';
} else if ($sel_cate === '2') {
	$sel_code3 = '';
	$sel_code4 = '';
} else if ($sel_cate === '3') {
	$sel_code4 = '';
}
?>
<script language="javascript">
function go_select(i) {
	var el = document.form_add['sel_code' + i];
	if (el && el.value !== '') {
		document.form_add.sel_cate.value = i;
	} else if (i > 1) {
		document.form_add.sel_cate.value = String(i - 1);
	} else {
		document.form_add.sel_cate.value = '';
	}
	document.form_add.action = "pro_all.php";
	document.form_add.submit();
}
function go_add() {
	if (document.form_add.sel_code1.value === '') {
		alert('1차 카테고리를 선택하세요.');
		return;
	}
	document.form_add.action = "pro_all_ok.php";
	document.form_add.submit();
}
function go_clear() {
	if (!confirm('등록된 카테고리를 모두 삭제하고, 메인 All PRODUCTS 영역에 전체 상품을 노출하도록 초기화할까요?')) {
		return;
	}
	document.form_clear.submit();
}
function go_remove(index) {
	if (!confirm('선택한 카테고리를 목록에서 삭제할까요?')) {
		return;
	}
	document.form_remove.index.value = index;
	document.form_remove.submit();
}
</script>

<?php adm_ui_page_open('pg-products-screen'); ?>

<?php adm_ui_card_open('카테고리 추가'); ?>
<form name="form_add" method="post">
<input type="hidden" name="action" value="add">
<input type="hidden" name="sel_cate" value="<?=htmlspecialchars($sel_cate, ENT_QUOTES, 'UTF-8')?>">
<div class="pg-screen-search-form pg-products-search-form">
	<div class="pg-search-form-row pg-search-form-row--cate">
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">1차 카테고리</span>
			<div class="pg-search-cell-input">
				<select name="sel_code1" class="pg-select" onchange="go_select('1');">
					<option value="">전체</option>
<?
$query = "SELECT cate1,code1 FROM $shop_cate WHERE code2='00' and code3='00' and code4='00' ORDER BY order_rank";
$DB->get($query, $rs, $rn);
for ($i = 0; $i < $rn; $i++) {
	$cate = htmlspecialchars(stripslashes($rs[$i][0]), ENT_QUOTES, 'UTF-8');
	$g_code = $rs[$i][1];
	$oselect = ($sel_code1 == $g_code) ? 'selected' : '';
?>
					<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<? } ?>
				</select>
			</div>
		</div>
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">2차 카테고리</span>
			<div class="pg-search-cell-input">
				<select name="sel_code2" class="pg-select" onchange="go_select('2');">
					<option value="">전체</option>
<?
if ($sel_code1 != '') {
	$query = "SELECT cate2,code2 FROM $shop_cate WHERE code1='$sel_code1' and code2!='00' and code3='00' and code4='00' ORDER BY order_rank";
	$DB->get($query, $rs, $rn);
	for ($i = 0; $i < $rn; $i++) {
		$cate = htmlspecialchars(stripslashes($rs[$i][0]), ENT_QUOTES, 'UTF-8');
		$g_code = $rs[$i][1];
		$oselect = ($sel_code2 == $g_code) ? 'selected' : '';
?>
					<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?	}
} ?>
				</select>
			</div>
		</div>
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">3차 카테고리</span>
			<div class="pg-search-cell-input">
				<select name="sel_code3" class="pg-select" onchange="go_select('3');">
					<option value="">전체</option>
<?
if ($sel_code1 != '' && $sel_code2 != '') {
	$query = "SELECT cate3,code3 FROM $shop_cate WHERE code1='$sel_code1' and code2='$sel_code2' and code3!='00' and code4='00' ORDER BY order_rank";
	$DB->get($query, $rs, $rn);
	for ($i = 0; $i < $rn; $i++) {
		$cate = htmlspecialchars(stripslashes($rs[$i][0]), ENT_QUOTES, 'UTF-8');
		$g_code = $rs[$i][1];
		$oselect = ($sel_code3 == $g_code) ? 'selected' : '';
?>
					<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?	}
} ?>
				</select>
			</div>
		</div>
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">4차 카테고리</span>
			<div class="pg-search-cell-input">
				<select name="sel_code4" class="pg-select" onchange="go_select('4');">
					<option value="">전체</option>
<?
if ($sel_code1 != '' && $sel_code2 != '' && $sel_code3 != '') {
	$query = "SELECT cate4,code4 FROM $shop_cate WHERE code1='$sel_code1' and code2='$sel_code2' and code3='$sel_code3' and code4!='00' ORDER BY order_rank";
	$DB->get($query, $rs, $rn);
	for ($i = 0; $i < $rn; $i++) {
		$cate = htmlspecialchars(stripslashes($rs[$i][0]), ENT_QUOTES, 'UTF-8');
		$g_code = $rs[$i][1];
		$oselect = ($sel_code4 == $g_code) ? 'selected' : '';
?>
					<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?	}
} ?>
				</select>
			</div>
		</div>
		<div class="pg-search-actions">
			<button type="button" class="pg-btn pg-btn-primary" onclick="go_add()">카테고리 추가</button>
		</div>
	</div>
</div>
</form>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('이용 안내'); ?>
<?php adm_ui_notice(
	'메인 페이지 <strong>All PRODUCTS</strong> 영역에 노출할 카테고리를 <strong>여러 개</strong> 등록할 수 있습니다.<br>'
	. '등록된 카테고리는 <strong>각 4개씩</strong> 순서대로 노출됩니다. (1번 카테고리 4개 → 2번 카테고리 4개 → …)<br>'
	. '카테고리를 등록하지 않으면 판매중인 전체 상품이 노출됩니다.',
	'info'
); ?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('등록된 노출 카테고리'); ?>
<div class="pg-summary-total-bar" style="margin-bottom:12px;">
	<span>총 <strong><?=number_format(count($saved_categories))?></strong>건</span>
	<span style="margin-left:auto;">
		<button type="button" class="pg-btn pg-btn-outline" onclick="go_clear()">전체 초기화 (전체 상품 노출)</button>
	</span>
</div>
<div class="pg-table-responsive">
<table class="pg-data-grid pg-theme-list-grid">
	<thead>
		<tr>
			<th class="pg-col-num">순서</th>
			<th class="pg-col-title">노출 카테고리</th>
			<th class="pg-col-actions">관리</th>
		</tr>
	</thead>
	<tbody>
<? if (empty($saved_categories)) { ?>
		<tr><td colspan="3" class="pg-table-empty">등록된 카테고리가 없습니다. 위에서 카테고리를 추가하세요.</td></tr>
<? } else {
	$order = 1;
	foreach ($saved_categories as $idx => $entry) {
		$label = pkshop_admin_main_all_label($DB, $shop_cate, $entry);
?>
		<tr>
			<td class="pg-col-num text-center"><?=$order?></td>
			<td class="pg-col-title"><?=htmlspecialchars($label, ENT_QUOTES, 'UTF-8')?> <span style="color:#6b7280;">(메인 4개)</span></td>
			<td class="pg-col-actions text-center">
				<button type="button" class="pg-btn pg-btn-sm pg-btn-danger" onclick="go_remove(<?=(int)$idx?>)">삭제</button>
			</td>
		</tr>
<?		$order++;
	}
} ?>
	</tbody>
</table>
</div>
<form name="form_remove" method="post" action="pro_all_ok.php" style="display:none;">
	<input type="hidden" name="action" value="remove">
	<input type="hidden" name="index" value="">
</form>
<form name="form_clear" method="post" action="pro_all_ok.php" style="display:none;">
	<input type="hidden" name="action" value="clear">
</form>
<?php adm_ui_card_close(); ?>

<?php adm_ui_page_close(); ?>
<? include "../inc/down_menu.php"; ?>
