<?
include "../common/dbconn.php";
include "../common/user_function.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";

$chk_order = $_GET["chk_order"];
$sel_cate = $_REQUEST["sel_cate"];
if ($_REQUEST["sel_code1"] != "" || $_REQUEST["sel_code2"] != "" || $_REQUEST["sel_code3"] != "" || $_REQUEST["sel_code4"] != "") {
	$sel_code1 = $_REQUEST["sel_code1"];
	$sel_code2 = $_REQUEST["sel_code2"];
	$sel_code3 = $_REQUEST["sel_code3"];
	$sel_code4 = $_REQUEST["sel_code4"];
} else {
	$sel_code1 = $_GET["sel_code1"];
	$sel_code2 = $_GET["sel_code2"];
	$sel_code3 = $_GET["sel_code3"];
	$sel_code4 = $_GET["sel_code4"];
}
$soldout = $_GET["soldout"];
$mode = $_GET["mode"];
if ($_REQUEST["keyfield"] != "" || $_REQUEST['key'] != "" || $_REQUEST["page"] != "") {
	$keyfield = $_REQUEST['keyfield'];
	$key = $_REQUEST['key'];
} else {
	$keyfield = $_GET['keyfield'];
	$key = $_GET['key'];
	$page_num = $_GET["page"];
}

$per_page_info = adm_ui_resolve_per_page();
$p_num = $per_page_info['is_all'] ? 0 : $per_page_info['p_num'];

$page = 1;
if (isset($_REQUEST['page']) && $_REQUEST['page'] !== '') {
	$page = intval($_REQUEST['page']);
}
if ($page < 1) {
	$page = 1;
}

if ($sel_cate == "") {
	$sel_code1 = "";
	$sel_code2 = "";
	$sel_code3 = "";
	$sel_code4 = "";
} else if ($sel_cate == "1") {
	$sel_code2 = "";
	$sel_code3 = "";
	$sel_code4 = "";
} else if ($sel_cate == "2") {
	$sel_code3 = "";
	$sel_code4 = "";
} else if ($sel_cate == "3") {
	$sel_code4 = "";
}

$encoded_key = '';
if ($soldout == "Y") {
	$tmp_where = "where soldout='Y'";
} else {
	$tmp_where = "where soldout<>''";
}
if ($P_id != "") {
	$tmp_where .= " P_id='$P_id'";
}
$tmp_order = "ORDER BY signdate DESC";
if ($chk_order == "Y") {
	if ($sel_code1 != "") {
		$tmp_where .= " and code1='$sel_code1'";
		$tmp_order = "ORDER BY order1";
		if ($sel_code2 != "") {
			$tmp_where .= " and code2='$sel_code2'";
			$tmp_order = "ORDER BY order2";
			if ($sel_code3 != "") {
				$tmp_where .= " and code3='$sel_code3'";
				$tmp_order = "ORDER BY order3";
				if ($sel_code4 != "") {
					$tmp_where .= " and code4='$sel_code4'";
					$tmp_order = "ORDER BY order4";
				}
			}
		}
	}
	$query = "SELECT No,code,code1,code2,code3,title,currnum,pricec,theme,order1,order2,order3,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,theme_s,code4,order4,prices,priced,c_pv,c_dis,country,home FROM $shop_goods $tmp_where $tmp_order";
} else if ($key == "") {
	$query = "SELECT No,code,code1,code2,code3,title,currnum,pricec,theme,order1,order2,order3,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,theme_s,code4,order4,prices,priced,c_pv,c_dis,country,home FROM $shop_goods $tmp_where ORDER BY signdate DESC";
} else {
	$encoded_key = urlencode($key);
	$query = "SELECT No,code,code1,code2,code3,title,currnum,pricec,theme,order1,order2,order3,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,theme_s,code4,order4,prices,priced,c_pv,c_dis,country,home FROM $shop_goods $tmp_where and $keyfield LIKE '%$key%' ORDER BY signdate DESC";
}

$DB->get($query, $rs, $rn);
$total_record = $rn;
$page_per_block = 10;

$pg = adm_ui_paginate_slice($total_record, $page, $per_page_info);
$num_per_page = $pg['num_per_page'];
$first = $pg['first'];
$last = $pg['last'];
$IsNext = $pg['is_next'];
$total_page = $pg['total_page'];
$article_num = $pg['article_num'];

	if (!$total_record) {
	$first = 0;
	$last = -1;
	$IsNext = 0;
}

$list_mode = "keyfield=$keyfield&key=$encoded_key&sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&sel_code4=$sel_code4&chk_order=$chk_order&sel_cate=$sel_cate&soldout=$soldout&p_num=" . adm_ui_per_page_query_value($per_page_info);

$order_index_map = array();
if ($chk_order == "Y" && $sel_code1 != "") {
	for ($oi = 0; $oi < $total_record; $oi++) {
		$order_index_map[$rs[$oi][0]] = $oi;
	}
}
$chk_num = ($last >= $first) ? ($last - $first + 1) : 0;
$page_title = ($soldout == "Y") ? "대기상품관리" : "전체상품관리";
?>
<script language="javascript">
var productsEditMode = false;

function go_out() { document.form.action = "products_out.php"; document.form.submit(); }
function go_sort(str) { document.form.action = "products_sort.php?init=" + (str || ""); document.form.submit(); }
function go_select(i) {
	if (eval("document.form.sel_code" + i + ".value!=''")) {
		document.form.sel_cate.value = i;
	}
	document.form.action = "products.php?chk_order=Y<?=($soldout=='Y')?'&soldout=Y':''?>";
	document.form.submit();
}
function go_search() {
	document.form.action = "products.php<?=($soldout=='Y')?'?soldout=Y':''?>";
	document.form.submit();
}
function confirmTwice(message) {
	if (!confirm(message)) return false;
	if (!confirm(message)) return false;
	return true;
}
function go_save() {
	if (!confirmTwice('저장하시겠습니까?\n변경 내용이 반영됩니다.')) return;
	document.querySelectorAll('.theme-chk, .prio-sel').forEach(function(el) { el.disabled = false; });
	document.form.action = 'products_save.php';
	document.form.submit();
}
function updateEditSaveButton() {
	var btn = document.getElementById('btn_edit_save');
	if (!btn) return;
	if (productsEditMode) {
		btn.textContent = '저장';
		btn.className = 'pg-btn pg-btn-pastel-blue';
	} else {
		btn.textContent = '수정';
		btn.className = 'pg-btn pg-btn-pastel-blue';
	}
}
function toggleProductsEditSave() {
	if (!productsEditMode) {
		startProductsEditMode();
		return;
	}
	go_save();
}
function selectAllRows(checked) {
	document.querySelectorAll('.row-sel-chk').forEach(function(el) {
		el.checked = checked;
	});
	var allChk = document.getElementById('check_all_rows');
	if (allChk) allChk.checked = checked;
}
function getCheckedRowNos() {
	var nos = [];
	document.querySelectorAll('.row-sel-chk:checked').forEach(function(el) {
		nos.push(parseInt(el.value, 10));
	});
	return nos;
}
function startProductsEditMode() {
	if (productsEditMode) return;
	productsEditMode = true;
	document.querySelectorAll('.pg-product-row').forEach(function(row) {
		row.classList.add('is-editing');
		row.querySelectorAll('.theme-chk').forEach(function(el) { el.disabled = false; });
		var prio = row.querySelector('.prio-sel');
		if (prio) prio.disabled = false;
	});
	updateEditSaveButton();
}
function deleteSelectedRows() {
	var nos = getCheckedRowNos();
	if (nos.length === 0) {
		alert('삭제할 상품을 선택해 주세요.');
		return;
	}
	var deleteMsg = '선택한 ' + nos.length + '개 상품을 삭제하시겠습니까?\n복원이 불가합니다.';
	if (!confirmTwice(deleteMsg)) return;
	var params = new URLSearchParams();
	params.append('action', 'delete_rows');
	nos.forEach(function(no) { params.append('nos[]', no); });
	fetch('products_row_ajax.php', { method: 'POST', body: params })
		.then(function(res) { return res.json(); })
		.then(function(data) {
			if (data.ok) {
				alert(data.message || '삭제되었습니다.');
				location.reload();
			} else {
				alert(data.message || '삭제에 실패했습니다.');
			}
		})
		.catch(function() { alert('삭제 요청 중 오류가 발생했습니다.'); });
}
function productOrderMove(no, dir) {
	var params = new URLSearchParams();
	params.append('action', 'move');
	params.append('No', no);
	params.append('dir', dir);
	params.append('soldout', document.form.soldout.value);
	params.append('sel_code1', document.form.sel_code1.value);
	params.append('sel_code2', document.form.sel_code2.value);
	params.append('sel_code3', document.form.sel_code3.value);
	params.append('sel_code4', document.form.sel_code4.value);
	fetch('products_order_ajax.php', { method: 'POST', body: params })
		.then(function(res) { return res.json(); })
		.then(function(data) {
			if (data.ok) location.reload();
			else alert(data.message || '순서 변경에 실패했습니다.');
		})
		.catch(function() { alert('순서 변경 요청 중 오류가 발생했습니다.'); });
}
</script>

<?php adm_ui_page_open('pg-products-screen'); ?>

<form name="form" method="post" action="products.php<?=($soldout=='Y')?'?soldout=Y':''?>">
<input type="hidden" name="soldout" value="<?=$soldout?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="chk_order" value="<?=$chk_order?>">
<input type="hidden" name="sel_cate" value="<?=$sel_cate?>">
<input type="hidden" name="num_per_page" value="<?=$num_per_page?>">
<input type="hidden" name="p_num" value="<?=$num_per_page?>">

<?php adm_ui_card_open('검색 조건'); ?>
<div class="pg-screen-search-form pg-products-search-form">
	<div class="pg-search-form-row pg-search-form-row--keyword">
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">검색구분</span>
			<div class="pg-search-cell-input">
				<select name="keyfield" class="pg-select">
					<option value="code" <?=$keyfield == "code" ? "selected" : ""?>>상품코드</option>
					<option value="title" <?=$keyfield == "title" ? "selected" : ""?>>상품명</option>
				</select>
			</div>
		</div>
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">검색어</span>
			<div class="pg-search-cell-input">
				<input type="text" name="key" value="<?=htmlspecialchars($key, ENT_QUOTES, 'UTF-8')?>" maxlength="50" class="pg-input">
			</div>
		</div>
	</div>
	<div class="pg-search-form-row pg-search-form-row--cate">
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">1차 카테고리</span>
			<div class="pg-search-cell-input">
				<select name="sel_code1" class="pg-select" onchange="go_select('1');">
					<option value="">전체</option>
<?
$query = "SELECT cate1,code1 FROM $shop_cate WHERE code2='00' and code3='00' and code4='00' ORDER BY order_rank";
$DB->get($query, $rs_c1, $rn_c1);
for ($i = 0; $i < $rn_c1; $i++) {
	$cate = htmlspecialchars(stripslashes($rs_c1[$i][0]), ENT_QUOTES, 'UTF-8');
	$g_code = $rs_c1[$i][1];
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
$query = "SELECT cate2,code2 FROM $shop_cate WHERE code1='$sel_code1' and code2!='00' and code3='00' and code4='00' ORDER BY order_rank";
$DB->get($query, $rs_c2, $rn_c2);
for ($i = 0; $i < $rn_c2; $i++) {
	$cate = htmlspecialchars(stripslashes($rs_c2[$i][0]), ENT_QUOTES, 'UTF-8');
	$g_code = $rs_c2[$i][1];
	$oselect = ($sel_code2 == $g_code) ? 'selected' : '';
?>
					<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<? } ?>
				</select>
			</div>
		</div>
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">3차 카테고리</span>
			<div class="pg-search-cell-input">
				<select name="sel_code3" class="pg-select" onchange="go_select('3');">
					<option value="">전체</option>
<?
$query = "SELECT cate3,code3 FROM $shop_cate WHERE code1='$sel_code1' and code2='$sel_code2' and code3!='00' and code4='00' ORDER BY order_rank";
$DB->get($query, $rs_c3, $rn_c3);
for ($i = 0; $i < $rn_c3; $i++) {
	$cate = htmlspecialchars(stripslashes($rs_c3[$i][0]), ENT_QUOTES, 'UTF-8');
	$g_code = $rs_c3[$i][1];
	$oselect = ($sel_code3 == $g_code) ? 'selected' : '';
?>
					<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<? } ?>
				</select>
			</div>
		</div>
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">4차 카테고리</span>
			<div class="pg-search-cell-input">
				<select name="sel_code4" class="pg-select" onchange="go_select('4');">
					<option value="">전체</option>
<?
$query = "SELECT cate4,code4 FROM $shop_cate WHERE code1='$sel_code1' and code2='$sel_code2' and code3='$sel_code3' and code4!='00' ORDER BY order_rank";
$DB->get($query, $rs_c4, $rn_c4);
for ($i = 0; $i < $rn_c4; $i++) {
	$cate = htmlspecialchars(stripslashes($rs_c4[$i][0]), ENT_QUOTES, 'UTF-8');
	$g_code = $rs_c4[$i][1];
	$oselect = ($sel_code4 == $g_code) ? 'selected' : '';
?>
					<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<? } ?>
				</select>
			</div>
		</div>
		<div class="pg-search-actions">
			<button type="button" class="pg-btn pg-btn-search" onclick="go_search()">검색</button>
		</div>
	</div>
</div>
<?php adm_ui_card_close(); ?>

<?php adm_ui_card_open($page_title . ' 목록'); ?>
<div class="pg-summary-total-bar" style="margin-bottom:12px;">
	<?php adm_ui_per_page_bar('products.php', $list_mode, $per_page_info, $total_record); ?>
	<span style="margin-left:auto;display:flex;gap:8px;flex-wrap:wrap;">
<? if ($sel_code1 == "") { ?>
		<button type="button" class="pg-btn pg-btn-outline" onclick="go_sort('init')">우선순위초기화<?=($sel_cate)?'('.$sel_cate.'차)':''?></button>
<? } ?>
		<button type="button" class="pg-btn pg-btn-pastel-blue" id="btn_edit_save" onclick="toggleProductsEditSave()">수정</button>
		<button type="button" class="pg-btn pg-btn-pastel-red" onclick="deleteSelectedRows()">삭제</button>
<? if ($soldout == "Y") { ?>
		<button type="button" class="pg-btn pg-btn-outline" onclick="go_out()">등록변경</button>
<? } ?>
	</span>
</div>

<div class="pg-table-responsive">
<table class="pg-data-grid adm-table">
<thead>
<tr>
	<th class="pg-col-check"><input type="checkbox" id="check_all_rows" onclick="selectAllRows(this.checked);" title="전체 선택"></th>
	<th class="pg-col-num">번호</th>
	<th class="pg-col-code">상품코드</th>
	<th class="pg-col-cate">최종카테고리</th>
	<th class="pg-col-country">국가</th>
	<th class="pg-col-title">상품명</th>
	<th class="pg-col-price">판매가격</th>
	<th class="pg-col-pct">RV%</th>
	<th class="pg-col-label">MNSS</th>
	<th class="pg-col-theme-chk">추천</th>
	<th class="pg-col-theme-chk">베스트</th>
	<th class="pg-col-theme-chk">HOT</th>
	<th class="pg-col-rank">우선순위</th>
</tr>
</thead>
<tbody>
<?
if ($total_record > 0) {
$ii = 0;
for ($i = $first; $i <= $last; $i++) {
	$No = $rs[$i][0];
	$code = $rs[$i][1];
	$code1 = $rs[$i][2];
	$code2 = $rs[$i][3];
	$code3 = $rs[$i][4];
	$title = stripslashes($rs[$i][5]);
	$pricec = $rs[$i][7];
	$theme_g = $rs[$i][12];
	$theme_n_raw = $rs[$i][13];
	$theme_r_raw = $rs[$i][14];
	$theme_f_raw = $rs[$i][15];
	$theme_x = $rs[$i][16];
	$theme_y = $rs[$i][17];
	$theme_z = $rs[$i][18];
	$theme_s = $rs[$i][19];
	$code4 = $rs[$i][20];
	$order1 = $rs[$i][9];
	$order2 = $rs[$i][10];
	$order3 = $rs[$i][11];
	$order4 = $rs[$i][21];
	$c_pv = $rs[$i][24];
	$c_dis = $rs[$i][25];
	$country = isset($rs[$i][26]) ? $rs[$i][26] : '';
	$home = isset($rs[$i][27]) ? $rs[$i][27] : '';
	$country_label = adm_ui_country_label($country, $home);

	$theme_str = '';
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

	if ($code2 == "00") {
		$query2 = "SELECT cate1 FROM $shop_cate WHERE code1='$code1' and code2='00' and code3='00' and code4='00'";
	} else if ($code3 == "00") {
		$query2 = "SELECT cate2 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='00' and code4='00'";
	} else if ($code4 == "00") {
		$query2 = "SELECT cate3 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='00'";
	} else {
		$query2 = "SELECT cate4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='$code4'";
	}
	$DB->get($query2, $rs2, $rn2);
	$cate_name = stripslashes($rs2[0][0]);

	$g_order = $order1;
	if ($sel_code1 != "") {
		$g_order = $order1;
		if ($sel_code2 != "") {
			$g_order = $order2;
			if ($sel_code3 != "") {
				$g_order = $order3;
				if ($sel_code4 != "") $g_order = $order4;
			}
		}
	}
?>
<tr id="prod-row-<?=$No?>" class="pg-product-row">
	<td class="pg-col-check text-center">
		<input type="hidden" name="no[<?=$No?>]" value="<?=$No?>">
		<input type="checkbox" class="row-sel-chk" name="check<?=$ii?>" id="row-chk-<?=$No?>" value="<?=$No?>">
	</td>
	<td class="pg-col-num"><?=$article_num?></td>
	<td class="pg-col-code"><?=htmlspecialchars($code, ENT_QUOTES, 'UTF-8')?></td>
	<td class="pg-col-cate"><?=htmlspecialchars($cate_name, ENT_QUOTES, 'UTF-8')?></td>
	<td class="pg-col-country"><?=htmlspecialchars($country_label, ENT_QUOTES, 'UTF-8')?></td>
	<td class="pg-col-title pg-product-name"><a href="pro_info.php?<?=$list_mode?>&page=<?=$page?>&code=<?=urlencode($code)?>&No=<?=$No?>"><?=htmlspecialchars($title, ENT_QUOTES, 'UTF-8')?></a></td>
	<td class="pg-col-price"><?=htmlspecialchars($pricec, ENT_QUOTES, 'UTF-8')?></td>
	<td class="pg-col-pct"><?=htmlspecialchars($c_pv, ENT_QUOTES, 'UTF-8')?>%</td>
	<td class="pg-col-label"><?=$theme_str?></td>
	<td class="pg-col-theme-chk"><input type="checkbox" class="theme-chk" name="theme_n[<?=$No?>]" value="n" <?=$theme_n_raw=="n"?"checked":""?> disabled></td>
	<td class="pg-col-theme-chk"><input type="checkbox" class="theme-chk" name="theme_r[<?=$No?>]" value="r" <?=$theme_r_raw=="r"?"checked":""?> disabled></td>
	<td class="pg-col-theme-chk"><input type="checkbox" class="theme-chk" name="theme_f[<?=$No?>]" value="f" <?=$theme_f_raw=="f"?"checked":""?> disabled></td>
	<td class="pg-col-rank">
<? if ($sel_code1 == "") {
	if ($soldout == "Y") $soldout_tmp = "where soldout='Y'";
	else if ($soldout == "N") $soldout_tmp = "where soldout='K'";
	else $soldout_tmp = "where soldout='N'";
	if ($sel_cate == 1) { $order = "order1"; $order_tmp = $soldout_tmp; }
	else if ($sel_cate == 2) { $order = "order2"; $order_tmp = $soldout_tmp . " and code2!='00'"; }
	else if ($sel_cate == 3) { $order = "order3"; $order_tmp = $soldout_tmp . " and code3!='00'"; }
	else if ($sel_cate == 4) { $order = "order4"; $order_tmp = $soldout_tmp . " and code4!='00'"; }
	else { $order = "order1"; $order_tmp = $soldout_tmp; }
	$DB->get("select count($order) as total_order from $shop_goods $order_tmp", $rss, $rnn);
	$total_order = $rss[0]["total_order"];
?>
		<select name="sel[<?=$No?>]" class="pg-select prio-sel" style="min-width:72px;" disabled>
			<option value="99999" selected><?=($sel_cate)?$sel_cate.'차':''?>변경</option>
<? for ($j = 0; $j < $total_order; $j++) {
	$oselect = ($$order == $j + 1) ? 'selected' : '';
?>
			<option value="<?=$j+1?>" <?=$oselect?>><?=$j+1?></option>
<? } ?>
		</select>
<? } else {
	$order_idx = isset($order_index_map[$No]) ? $order_index_map[$No] : -1;
	$can_up = ($order_idx > 0);
	$can_down = ($order_idx >= 0 && $order_idx < $total_record - 1);
?>
		<button type="button" class="pg-btn" onclick="productOrderMove(<?=$No?>,'up')" <?=$can_up?'':'disabled'?>>▲</button>
		<button type="button" class="pg-btn" onclick="productOrderMove(<?=$No?>,'down')" <?=$can_down?'':'disabled'?>>▼</button>
		<span><?=$g_order?></span>
<? } ?>
	</td>
</tr>
<?
	$article_num--;
	$ii++;
}
$chk_num = $ii;
} else {
?>
<tr><td colspan="13">등록된 상품이 없습니다.</td></tr>
<? } ?>
</tbody>
</table>
</div>

<?php
adm_ui_notice('* 상단 [수정] → [저장] 시 테마·우선순위 변경 내용이 이중 확인 후 반영됩니다.<br>* 상품 선택 후 상단 [삭제] 시 「삭제하시겠습니까? 복원이 불가합니다.」 알림이 두 번 표시된 뒤 삭제됩니다.<br>* 1차 카테고리 선택 시 ▲▼ 화살표로 우선순위를 조정할 수 있습니다.', 'info');
adm_ui_pagination($list_mode, $page, $total_page, $page_per_block, $IsNext);
?>
<?php adm_ui_card_close(); ?>

<input type="hidden" name="chk_num" value="<?=(int)$chk_num?>">
</form>

<?php adm_ui_page_close(); ?>
<? include "../inc/down_menu.php"; ?>
