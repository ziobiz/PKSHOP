<?
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";

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

$query = "SELECT No,code,code1,code2,code3,code4,title,pricec,prices,priced,currnum,signdate,imgl,soldout FROM $shop_goods $tmp_where ORDER BY signdate DESC";
$DB->get($query, $rs, $rn);

$total_record = $rn;
$num_per_page = 15;
$page_per_block = 10;

if (!$total_record) {
	$first = 0;
	$last = -1;
} else {
	$first = $num_per_page * ($page - 1);
	$last = $num_per_page * $page - 1;
	if ($last >= $total_record) {
		$last = $total_record - 1;
	}
}
$total_page = $total_record > 0 ? ceil($total_record / $num_per_page) : 1;
$article_num = $total_record - $num_per_page * ($page - 1);
$mode = "view=$view&keyfield=$keyfield&key=" . urlencode($key);
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
	submit_action('hide', '선택한 AI 상품의 쇼핑몰 노출을 중지하시겠습니까?');
}
function go_show() {
	submit_action('show', '선택한 AI 상품의 쇼핑몰 노출을 재개하시겠습니까?');
}
</script>
					<table width=900 border=0 cellpadding=0 cellspacing=0>
						<tr><td height=30></td></tr>
						<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>AI 상품관리</b></td>
								</tr>
							</table>
						</td></tr>
						<tr><td height=10></td></tr>
						<tr>
							<td valign=top style="padding:10px;">
								<font color="#003366">AI로 자동 등록된 상품 목록입니다. (p_id=admin_ai)</font>
								<br><br>
								<form name="search_form" method="get" action="pro_ai_products.php">
								<input type="hidden" name="view" value="<?=$view?>">
								<select name="keyfield" class="adminbttn">
									<option value="title" <?=$keyfield==='title'?'selected':''?>>상품명</option>
									<option value="code" <?=$keyfield==='code'?'selected':''?>>상품코드</option>
								</select>
								<input type="text" name="key" value="<?=htmlspecialchars($key)?>" class="adminbttn" size="30">
								<input type="button" value="검색" class="adminbttn" onclick="go_search();">
								&nbsp;
								<input type="button" value="AI 상품 생성" class="adminbttn" onclick="location.href='pro_ai_generate.php';">
								&nbsp;
								<input type="button" value="노출 상품" class="adminbttn" onclick="location.href='pro_ai_products.php?view=active';"<?=$view==='active'?' disabled':''?>>
								<input type="button" value="노출 중지 상품" class="adminbttn" onclick="location.href='pro_ai_products.php?view=hidden';"<?=$view==='hidden'?' disabled':''?>>
								</form>
								<br>
								<form name="list_form" method="post" action="pro_ai_products_action.php">
								<input type="hidden" name="bulk_action" value="">
								<input type="hidden" name="view" value="<?=$view?>">
								<input type="hidden" name="keyfield" value="<?=htmlspecialchars($keyfield)?>">
								<input type="hidden" name="key" value="<?=htmlspecialchars($key)?>">
								<input type="hidden" name="page" value="<?=$page?>">
								<table width="900" border='0' cellspacing='0' cellpadding='0'>
									<tr>
										<td>
											<?if($view==='hidden'){?>
											<input type="button" value="선택 노출 재개" class="adminbttn" onclick="go_show();">
											<?}else{?>
											<input type="button" value="선택 노출 중지" class="adminbttn" onclick="go_hide();">
											<?}?>
											<input type="button" value="선택 삭제" class="adminbttn" onclick="go_delete();" style="border:1px #c9c9c9 solid;background-color:#ffecec;">
										</td>
									</tr>
									<tr><td height="8"></td></tr>
								</table>
								<table width="900" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=10 height=2 bgcolor='#88B7DA'></td></tr>
									<tr align="center" style="font-weight:bold;background:#f5f5f5;">
										<td height="30" width="40"><input type="checkbox" name="check_all" onclick="select_all_items(this.checked);"></td>
										<td width="50">No</td>
										<td width="60">이미지</td>
										<td width="110">상품코드</td>
										<td>상품명</td>
										<td width="80">가격</td>
										<td width="50">재고</td>
										<td width="90">상태</td>
										<td width="90">등록일</td>
										<td width="110">관리</td>
									</tr>
									<tr><td colspan=10 height=1 bgcolor='#D2DEE8'></td></tr>
<?
$ii = 0;
if ($total_record < 1) {
?>
									<tr><td colspan=10 height=60 align="center"><?=$view==='hidden'?'노출 중지된 AI 상품이 없습니다.':'등록된 AI 상품이 없습니다.'?></td></tr>
<?
} else {
	for ($i = $first; $i <= $last; $i++) {
		$No = $rs[$i]['No'];
		$code = $rs[$i]['code'];
		$title = htmlspecialchars(stripslashes($rs[$i]['title']));
		$pricec = $rs[$i]['pricec'];
		$currnum = $rs[$i]['currnum'];
		$imgl = $rs[$i]['imgl'];
		$soldout = $rs[$i]['soldout'];
		$signdate = date('Y-m-d', $rs[$i]['signdate']);
		$img_tag = ($imgl != '') ? '<img src="//pentakleva.shop/upload/'.$imgl.'" width="50" height="50" style="object-fit:cover;">' : '-';
		$status_label = ($soldout === 'Y') ? '<font color="#cc0000">노출중지</font>' : '<font color="#006600">노출중</font>';
?>
									<tr align="center">
										<td height="45"><input type="checkbox" name="check<?=$ii?>" value="<?=$No?>"></td>
										<td><?=$article_num?></td>
										<td><?=$img_tag?></td>
										<td><?=$code?></td>
										<td align="left" style="padding-left:8px;"><?=$title?></td>
										<td><?=number_format($pricec)?></td>
										<td><?=$currnum?></td>
										<td><?=$status_label?></td>
										<td><?=$signdate?></td>
										<td>
											<input type="button" value="수정" class="adminbttn" onclick="location.href='pro_info.php?code=<?=$code?>&No=<?=$No?>';">
											<input type="button" value="보기" class="adminbttn" onclick="window.open('../../sub04/view.php?left_code=<?=$code?>');">
										</td>
									</tr>
									<tr><td colspan=10 height=1 bgcolor='#D2DEE8'></td></tr>
<?
		$article_num--;
		$ii++;
	}
}
$chk_num = $ii;
?>
								</table>
								<input type="hidden" name="chk_num" value="<?=$chk_num?>">
								</form>
								<br>
								<div align="center">
<?
for ($direct_page = 1; $direct_page <= $total_page; $direct_page++) {
	if ($direct_page == $page) {
		echo "<b>[$direct_page]</b>&nbsp;";
	} else {
		echo "<a href='pro_ai_products.php?$mode&page=$direct_page'>[$direct_page]</a>&nbsp;";
	}
}
?>
								</div>
							</td>
						</tr>
						<tr><td height=40></td></tr>
					</table>
<? include "../inc/down_menu.php"; ?>
