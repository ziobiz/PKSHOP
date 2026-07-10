<?
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_ai.php";

$keyfield = isset($_REQUEST['keyfield']) ? $_REQUEST['keyfield'] : 'title';
$key = isset($_REQUEST['key']) ? trim($_REQUEST['key']) : '';
$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'active';
if ($page < 1) $page = 1;
if ($view !== 'hidden') {
	$view = 'active';
}

$tmp_where = "where p_id='admin_ai'";
if ($view === 'hidden') {
	$tmp_where .= " and soldout='Y'";
} else {
	$tmp_where .= " and soldout<>'Y'";
}
if ($key !== '') {
	$key_safe = addslashes($key);
	$field_safe = ($keyfield === 'code') ? 'code' : 'title';
	$tmp_where .= " and $field_safe LIKE '%$key_safe%'";
}

$query = "SELECT No,code,code1,code2,code3,code4,title,pricec,prices,priced,currnum,signdate,imgl,soldout,country,home,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,theme_s,c_dis FROM $shop_goods $tmp_where ORDER BY signdate DESC";
$DB->get($query, $rs, $rn);

$total_record = $rn;
$per_page_info = adm_ui_resolve_per_page();
$page_per_block = 10;
$pg = adm_ui_paginate_slice($total_record, $page, $per_page_info);
$num_per_page = $pg['num_per_page'];
$first = $pg['first'];
$last = $pg['last'];
$total_page = $pg['total_page'];
$article_num = $pg['article_num'];
$IsNext = $pg['is_next'];
$mode = "view=$view&keyfield=$keyfield&key=" . urlencode($key) . '&p_num=' . rawurlencode(adm_ui_per_page_query_value($per_page_info));
?>
<script language="javascript">
function go_search() {
	document.search_form.submit();
}
function select_all_items(checked) {
	var total = parseInt(document.list_form.chk_num.value, 10);
	for (var i = 0; i < total; i++) {
		var el = document.list_form.elements['check' + i];
		if (el) {
			el.checked = checked;
		}
	}
	document.list_form.check_all.checked = checked;
}
function has_checked_items() {
	var total = parseInt(document.list_form.chk_num.value, 10);
	for (var i = 0; i < total; i++) {
		var el = document.list_form.elements['check' + i];
		if (el && el.checked) {
			return true;
		}
	}
	return false;
}
function submit_action(bulk_action, confirm_msg) {
	if (!has_checked_items()) {
		alert('처리할 상품을 선택해 주세요.');
		return;
	}
	if (!confirm(confirm_msg)) {
		return;
	}
	document.list_form.bulk_action.value = bulk_action;
	document.list_form.submit();
}
function go_delete() {
	submit_action('delete', '선택한 AI 상품을 삭제하시겠습니까?\n삭제 후에는 복구할 수 없습니다.');
}
function go_hide() {
	submit_action('hide', '선택한 AI 상품을 비공개 처리하시겠습니까?');
}
function go_show() {
	submit_action('show', '선택한 AI 상품을 공개 처리하시겠습니까?');
}
</script>

<?php adm_ui_page_open('pg-products-screen'); ?>

<?php adm_ui_card_open('검색 조건'); ?>
<form name="search_form" method="get" action="pro_ai_products.php">
<div class="pg-screen-search-form pg-products-search-form pg-ai-products-search-form">
	<div class="pg-search-form-row pg-search-form-row--keyword pg-search-form-row--ai-filter">
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">검색구분</span>
			<div class="pg-search-cell-input">
				<select name="keyfield" class="pg-select">
					<option value="title" <?=$keyfield === 'title' ? 'selected' : ''?>>상품명</option>
					<option value="code" <?=$keyfield === 'code' ? 'selected' : ''?>>상품코드</option>
				</select>
			</div>
		</div>
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">검색어</span>
			<div class="pg-search-cell-input">
				<input type="text" name="key" value="<?=htmlspecialchars($key, ENT_QUOTES, 'UTF-8')?>" maxlength="50" class="pg-input">
			</div>
		</div>
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">상태조건</span>
			<div class="pg-search-cell-input">
				<select name="view" class="pg-select pg-select--status">
					<option value="active" <?=$view === 'active' ? 'selected' : ''?>>공개</option>
					<option value="hidden" <?=$view === 'hidden' ? 'selected' : ''?>>비공개</option>
				</select>
				<button type="button" class="pg-btn pg-btn-search" onclick="go_search()">검색</button>
			</div>
		</div>
	</div>
</div>
</form>
<?php adm_ui_notice('AI로 자동 등록된 상품 목록입니다. (p_id=admin_ai)', 'info'); ?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open('AI 상품 목록'); ?>
<form name="list_form" method="post" action="pro_ai_products_action.php">
<input type="hidden" name="bulk_action" value="">
<input type="hidden" name="view" value="<?=htmlspecialchars($view, ENT_QUOTES, 'UTF-8')?>">
<input type="hidden" name="keyfield" value="<?=htmlspecialchars($keyfield, ENT_QUOTES, 'UTF-8')?>">
<input type="hidden" name="key" value="<?=htmlspecialchars($key, ENT_QUOTES, 'UTF-8')?>">
<input type="hidden" name="page" value="<?=(int)$page?>">

<div class="pg-summary-total-bar" style="margin-bottom:12px;">
	<?php adm_ui_per_page_bar('pro_ai_products.php', $mode, $per_page_info, $total_record); ?>
	<span style="margin-left:auto;display:flex;gap:8px;flex-wrap:wrap;">
<? if ($view === 'hidden') { ?>
		<button type="button" class="pg-btn pg-btn-pastel-blue" onclick="go_show()">공개</button>
<? } else { ?>
		<button type="button" class="pg-btn pg-btn-pastel-gray" onclick="go_hide()">비공개</button>
<? } ?>
		<button type="button" class="pg-btn pg-btn-pastel-red" onclick="go_delete()">삭제</button>
	</span>
</div>

<div class="pg-table-responsive">
<table class="pg-data-grid">
	<thead>
		<tr>
			<th class="pg-col-check"><input type="checkbox" name="check_all" onclick="select_all_items(this.checked);" title="전체 선택"></th>
			<th class="pg-col-num">No</th>
			<th class="pg-col-img">상품이미지</th>
			<th class="pg-col-code">상품코드</th>
			<th class="pg-col-cate">카테고리</th>
			<th class="pg-col-country">국가</th>
			<th class="pg-col-title">상품명</th>
			<th class="pg-col-price">가격</th>
			<th class="pg-col-label">MNSS</th>
			<th class="pg-col-theme-chk">추천</th>
			<th class="pg-col-theme-chk">베스트</th>
			<th class="pg-col-theme-chk">HOT</th>
			<th class="pg-col-qty">재고</th>
			<th class="pg-col-status">상태</th>
			<th class="pg-col-date">등록일</th>
			<th class="pg-col-actions">관리</th>
		</tr>
	</thead>
	<tbody>
<?
$ii = 0;
if ($total_record < 1) {
?>
		<tr><td colspan="16" class="pg-table-empty"><?=$view === 'hidden' ? '비공개 AI 상품이 없습니다.' : '등록된 AI 상품이 없습니다.'?></td></tr>
<?
} else {
	for ($i = $first; $i <= $last; $i++) {
		$No = $rs[$i][0];
		$code = $rs[$i][1];
		$code1 = $rs[$i][2];
		$code2 = $rs[$i][3];
		$code3 = $rs[$i][4];
		$code4 = $rs[$i][5];
		$title = htmlspecialchars(stripslashes($rs[$i][6]), ENT_QUOTES, 'UTF-8');
		$pricec = $rs[$i][7];
		$currnum = $rs[$i][10];
		$imgl = $rs[$i][12];
		$soldout = $rs[$i][13];
		$country = isset($rs[$i][14]) ? $rs[$i][14] : '';
		$home = isset($rs[$i][15]) ? $rs[$i][15] : '';
		$theme_g = isset($rs[$i][16]) ? $rs[$i][16] : '';
		$theme_n_raw = isset($rs[$i][17]) ? $rs[$i][17] : '';
		$theme_r_raw = isset($rs[$i][18]) ? $rs[$i][18] : '';
		$theme_f_raw = isset($rs[$i][19]) ? $rs[$i][19] : '';
		$theme_x = isset($rs[$i][20]) ? $rs[$i][20] : '';
		$theme_y = isset($rs[$i][21]) ? $rs[$i][21] : '';
		$theme_z = isset($rs[$i][22]) ? $rs[$i][22] : '';
		$theme_s = isset($rs[$i][23]) ? $rs[$i][23] : '';
		$c_dis = isset($rs[$i][24]) ? $rs[$i][24] : '';
		$cate_name = adm_ui_product_cate_name($DB, $shop_cate, $code1, $code2, $code3, $code4);
		$country_label = adm_ui_country_label($country, $home);
		$signdate = date('Y-m-d', $rs[$i][11]);
		$img_tag = ($imgl != '') ? '<img src="//pentakleva.shop/upload/' . htmlspecialchars($imgl, ENT_QUOTES, 'UTF-8') . '" width="50" height="50" style="object-fit:cover;border-radius:4px;">' : '-';
		$status_label = ($soldout === 'Y') ? '<span style="color:#b91c1c;">비공개</span>' : '<span style="color:#047857;">공개</span>';

		$labels = array();
		if ($c_dis == 1) $labels[] = '재구매상품';
		elseif ($theme_g == 'g' || $theme_g == '') $labels[] = '일반상품';
		if ($theme_n_raw == 'n') $labels[] = '추천상품';
		if ($theme_r_raw == 'r') $labels[] = '베스트상품';
		if ($theme_f_raw == 'f') $labels[] = 'HOT상품';
		if ($theme_x == 'x') $labels[] = '추천상품';
		if ($theme_y == 'y') $labels[] = '특가상품';
		if ($theme_z == 'z') $labels[] = '테마';
		if ($theme_s == 's') $labels[] = '세일상품';
		$theme_str = implode('<br>', $labels);
?>
		<tr class="pg-product-row">
			<td class="pg-col-check text-center"><input type="checkbox" name="check<?=$ii?>" value="<?=(int)$No?>"></td>
			<td class="pg-col-num text-center"><?=$article_num?></td>
			<td class="pg-col-img text-center"><?=$img_tag?></td>
			<td class="pg-col-code text-center"><?=htmlspecialchars($code, ENT_QUOTES, 'UTF-8')?></td>
			<td class="pg-col-cate text-center"><?=htmlspecialchars($cate_name, ENT_QUOTES, 'UTF-8')?></td>
			<td class="pg-col-country text-center"><?=htmlspecialchars($country_label, ENT_QUOTES, 'UTF-8')?></td>
			<td class="pg-col-title"><?=$title?></td>
			<td class="pg-col-price text-center"><?=number_format((int)$pricec)?></td>
			<td class="pg-col-label"><?=$theme_str?></td>
			<td class="pg-col-theme-chk text-center"><input type="checkbox" class="theme-chk" disabled<?=$theme_n_raw=="n"?" checked":""?>></td>
			<td class="pg-col-theme-chk text-center"><input type="checkbox" class="theme-chk" disabled<?=$theme_r_raw=="r"?" checked":""?>></td>
			<td class="pg-col-theme-chk text-center"><input type="checkbox" class="theme-chk" disabled<?=$theme_f_raw=="f"?" checked":""?>></td>
			<td class="pg-col-qty text-center"><?=htmlspecialchars($currnum, ENT_QUOTES, 'UTF-8')?></td>
			<td class="pg-col-status text-center"><?=$status_label?></td>
			<td class="pg-col-date text-center"><?=$signdate?></td>
			<td class="pg-col-actions text-center pg-row-actions">
				<button type="button" class="pg-btn pg-btn-sm" onclick="location.href='pro_info.php?No=<?=(int)$No?>&return_url=pro_ai_products.php';">수정</button>
				<button type="button" class="pg-btn pg-btn-sm pg-btn-outline" onclick="window.open('../../sub04/view.php?left_code=<?=urlencode($code)?>');">보기</button>
			</td>
		</tr>
<?
		$article_num--;
		$ii++;
	}
}
$chk_num = $ii;
?>
	</tbody>
</table>
</div>
<input type="hidden" name="chk_num" value="<?=(int)$chk_num?>">
</form>

<?php if ($total_page > 1) { adm_ui_pagination($mode, $page, $total_page, $page_per_block, $IsNext); } ?>
<?php adm_ui_card_close(); ?>

<?php adm_ui_page_close(); ?>
<? include "../inc/down_menu.php"; ?>
