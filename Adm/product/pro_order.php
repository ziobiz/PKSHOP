<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_order.php";

include "../common/user_function.php";
include "../inc/set_com.php";
########## 데이터베이스에 연결한다. #################################
//임시 작업
//$sql="CREATE table coin_wallet (";
//$sql=$sql."No int not null primary key auto_increment"; //넘버값
//$sql=$sql.",ordernum int(10)";//주문번호
//$sql=$sql.",id varchar(20)";//주문자 id
//$sql=$sql.",info varchar(100)"; //지갑주소
//$sql=$sql.")";
//
//$result = mysql_query($sql,$DBconn);
//if(!$result){
//	echo("sucess!!");
//}else{
//	echo("fail!");
//}

?>
<script language="javascript">
<!--
function go_del() {
	document.form.action="order_delete.php";
	document.form.submit();
}
function go_search() {
	document.form.action="pro_order.php";
	document.form.submit();
}

function go_modify() {
	document.form.action="order_modify.php";
	document.form.submit();
}

function go_excel() {
	document.form.action="pro_order_excel.php";
	document.form.submit();
}

function all_chk() {
 	var chk = document.forms.form; 
 	for (var i=0; i<chk.length; i++) {
 		if (chk[i].type == "checkbox" && chk[i].checked == false) {
 			chk[i].checked = true;
 		} else {
 			chk[i].checked = false;
 		}
 	}
}

function select_all(){ 
	for(var i=0; i<document.form.chk_num.value; i++){ 
		
		if(document.form.elements[ "check2" + i ].checked==true){
			document.form.elements[ "check2" + i ].checked=false;
		}else{
			document.form.elements[ "check2" + i ].checked=true;
		}
	} 
}
function go_reset() {
	location.href = 'pro_order.php?sel_status=<?=urlencode($sel_status)?>';
}

function set_quick_date(range) {
	var now = new Date();
	var y1 = now.getFullYear(), m1 = now.getMonth() + 1, d1 = now.getDate();
	var y2 = y1, m2 = m1, d2 = d1;
	if (range === 'day') {
		// today
	} else if (range === 'month') {
		m1 = m2 = m1;
		d1 = 1;
	} else if (range === 'prevDay') {
		var p = new Date(now.getTime() - 86400000);
		y1 = y2 = p.getFullYear();
		m1 = m2 = p.getMonth() + 1;
		d1 = d2 = p.getDate();
	} else if (range === 'week') {
		var w = new Date(now.getTime() - 6 * 86400000);
		y1 = w.getFullYear(); m1 = w.getMonth() + 1; d1 = w.getDate();
	} else if (range === 'week2') {
		var w2 = new Date(now.getTime() - 13 * 86400000);
		y1 = w2.getFullYear(); m1 = w2.getMonth() + 1; d1 = w2.getDate();
	} else if (range === 'prevMonth') {
		var pm = new Date(y1, m1 - 2, 1);
		y1 = y2 = pm.getFullYear();
		m1 = m2 = pm.getMonth() + 1;
		d1 = 1;
		d2 = new Date(y2, m2, 0).getDate();
	}
	if (window.pkshopSetIsoDateRange) {
		pkshopSetIsoDateRange(pkshopIsoFromYmd(y1, m1, d1), pkshopIsoFromYmd(y2, m2, d2));
	}
	document.querySelectorAll('.pg-quick-date').forEach(function(btn) {
		btn.classList.toggle('is-active', btn.getAttribute('data-range') === range);
	});
}
//-->
</script>

<?php
adm_ui_apply_pg_date_range_request(adm_ui_order_date_field_map());
$ydate1 = isset($_REQUEST['ydate1']) ? $_REQUEST['ydate1'] : (isset($ydate1) ? $ydate1 : '');
$mdate1 = isset($_REQUEST['mdate1']) ? $_REQUEST['mdate1'] : (isset($mdate1) ? $mdate1 : '');
$ddate1 = isset($_REQUEST['ddate1']) ? $_REQUEST['ddate1'] : (isset($ddate1) ? $ddate1 : '');
$ydate2 = isset($_REQUEST['ydate2']) ? $_REQUEST['ydate2'] : (isset($ydate2) ? $ydate2 : '');
$mdate2 = isset($_REQUEST['mdate2']) ? $_REQUEST['mdate2'] : (isset($mdate2) ? $mdate2 : '');
$ddate2 = isset($_REQUEST['ddate2']) ? $_REQUEST['ddate2'] : (isset($ddate2) ? $ddate2 : '');

$adm_status_label = ($sel_status !== '') ? $sel_status : '전체';

if ($ydate1 == '') $ydate1 = date('Y');
if ($mdate1 == '') $mdate1 = date('m') - 1;
if ($ddate1 == '') $ddate1 = date('d');
if ($ydate2 == '') $ydate2 = date('Y');
if ($mdate2 == '') $mdate2 = date('m');
if ($ddate2 == '') $ddate2 = date('d');

$wdate1 = mktime(0, 0, 0, $mdate1, $ddate1, $ydate1);
$wdate2 = mktime(23, 59, 59, $mdate2, $ddate2, $ydate2);
$where_date1 = ($wdate1 != '') ? " and signdate > '$wdate1'" : '';
$where_date2 = ($mdate2 != '' || $ddate2 != '' || $ydate2 != '') ? " and signdate < '$wdate2'" : '';

$year_e = date('Y');
$month_e = date('m');
$day_e = date('d');
$timestamp_s = mktime(0, 0, 0, $month_e, $day_e, $year_e);
$timestamp_e = mktime(23, 59, 59, $month_e, $day_e, $year_e);
$query = "SELECT count(ordernum) FROM $shop_order WHERE signdate>$timestamp_s and signdate<$timestamp_e and status!='주문대기'";
$DB->get($query, $rs, $rn);
$cnt1 = $rs[0][0];

$timestamp_s = mktime(0, 0, 0, $month_e, 1, $year_e);
$timestamp_e = mktime(0, 0, 0, $month_e + 1, 1, $year_e);
$query = "SELECT count(ordernum) FROM $shop_order WHERE signdate>$timestamp_s and signdate<$timestamp_e and status!='주문대기'";
$DB->get($query, $rs, $rn);
$cnt2 = $rs[0][0];

$query = "SELECT count(ordernum) FROM $shop_order WHERE status='주문취소'";
$DB->get($query, $rs, $rn);
$cnt3 = $rs[0][0];

$where_sql = '';
if ($sel_kind != '') $where_sql = "and kind='$sel_kind'";
if ($sel_status != '') $where_sql .= " and status='$sel_status'";

if ($key == '') {
	$query = "SELECT * FROM $shop_order WHERE ordernum!='' $where_sql $where_date1 $where_date2 ORDER BY signdate DESC";
	$encoded_key = '';
} else {
	$encoded_key = urlencode($key);
	$query = "SELECT * FROM $shop_order WHERE ordernum!='' and $keyfield LIKE '%$key%' $where_sql $where_date1 $where_date2 $theme_sql ORDER BY signdate DESC";
}
$DB->get($query, $rs, $rn);
$total_record = $rn;

if ($page == '') $page = 1;
$per_page_info = adm_ui_resolve_per_page();
$page_per_block = 10;
$pg = adm_ui_paginate_slice($total_record, $page, $per_page_info);
$num_per_page = $pg['num_per_page'];
$first = $pg['first'];
$last = $pg['last'];
$IsNext = $pg['is_next'];
$total_page = $pg['total_page'];
$article_num = $pg['article_num'];
$file_name = mktime(date('H'), date('i'), date('s'), date('Y'), date('m'), date('d'));

$adm_status_counts = array();
$adm_status_defs = array(
	array('label' => '오늘 주문', 'tone' => 'other', 'count' => $cnt1),
	array('label' => '이달 주문', 'tone' => 'month', 'count' => $cnt2),
	array('label' => '주문취소', 'tone' => 'cancel', 'count' => $cnt3),
	array('label' => '주문접수', 'tone' => 'other', 'status' => '주문접수'),
	array('label' => '결제완료', 'tone' => 'success', 'status' => '결제완료'),
	array('label' => '배송중', 'tone' => 'progress', 'status' => '배송중'),
	array('label' => '배송완료', 'tone' => 'success', 'status' => '배송완료'),
	array('label' => '구매확정', 'tone' => 'success', 'status' => '구매확정'),
	array('label' => '반품', 'tone' => 'refund', 'status' => '반품'),
);
foreach ($adm_status_defs as $def) {
	if (isset($def['count'])) {
		$adm_status_counts[] = $def;
		continue;
	}
	$st = $def['status'];
	$query = "SELECT count(ordernum) FROM $shop_order WHERE status='$st'";
	$DB->get($query, $rs_st, $rn_st);
	$def['count'] = (int) $rs_st[0][0];
	$adm_status_counts[] = $def;
}
?>
<div class="adm-content-panel-inner">

<form name="form" method="post" action="pro_order.php">
<input type="hidden" name="level_l" value="<?=$level_l?>">
<input type="hidden" name="file_name" value="<?=$file_name?>">

<div class="pg-screen-search-form pay-mng-search-form">
	<div class="pg-search-form-row">
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">주문일자</span>
			<div class="pg-search-cell-input pg-search-cell-input--daterange">
				<?php
				echo adm_ui_pg_date_range_html(
					array('y' => $ydate1, 'm' => $mdate1, 'd' => $ddate1),
					array('y' => $ydate2, 'm' => $mdate2, 'd' => $ddate2),
					adm_ui_order_date_field_map()
				);
				?>
			</div>
		</div>
		<div class="pg-search-cell">
			<div class="pg-search-cell-input">
				<button type="button" class="pg-quick-date" data-range="day" onclick="set_quick_date('day')">당일</button>
				<button type="button" class="pg-quick-date" data-range="month" onclick="set_quick_date('month')">당월</button>
				<button type="button" class="pg-quick-date" data-range="prevDay" onclick="set_quick_date('prevDay')">전일</button>
				<button type="button" class="pg-quick-date" data-range="week" onclick="set_quick_date('week')">1주</button>
				<button type="button" class="pg-quick-date" data-range="week2" onclick="set_quick_date('week2')">2주</button>
				<button type="button" class="pg-quick-date" data-range="prevMonth" onclick="set_quick_date('prevMonth')">전월</button>
			</div>
		</div>
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">결제방법</span>
			<div class="pg-search-cell-input">
				<select name="sel_kind" class="pg-select pg-select--wide">
					<option value="" <?if ($sel_kind == '') echo('selected')?>>전체</option>
					<option value="2" <?if ($sel_kind == '2') echo('selected')?>>무통장</option>
					<option value="1" <?if ($sel_kind == '1') echo('selected')?>>신용카드</option>
					<option value="5" <?if ($sel_kind == '5') echo('selected')?>>포인트</option>
				</select>
			</div>
		</div>
	</div>
	<div class="pg-search-form-row">
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">검색구분</span>
			<div class="pg-search-cell-input">
				<select name="keyfield" class="pg-select">
					<option value="id" <?if ($keyfield == 'id') echo('selected')?>>아이디</option>
					<option value="pay_name" <?if ($keyfield == 'pay_name') echo('selected')?>>주문자</option>
					<option value="pay_mobile" <?if ($keyfield == 'pay_mobile') echo('selected')?>>휴대폰번호</option>
					<option value="receive_name" <?if ($keyfield == 'receive_name') echo('selected')?>>수취인</option>
				</select>
			</div>
		</div>
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">검색어</span>
			<div class="pg-search-cell-input">
				<input type="text" name="key" value="<?=htmlspecialchars($key, ENT_QUOTES, 'UTF-8')?>" maxlength="64" class="pg-input">
			</div>
		</div>
		<div class="pg-search-cell pg-search-cell--with-label">
			<span class="pg-search-cell-label">상태구분</span>
			<div class="pg-search-cell-input pg-search-cell-input--with-actions">
				<select name="sel_status" class="pg-select pg-select--wide">
					<option value="">전체</option>
					<option value="주문접수" <?if ($sel_status == '주문접수') echo('selected')?>>주문접수</option>
					<option value="결제완료" <?if ($sel_status == '결제완료') echo('selected')?>>결제완료</option>
					<option value="준비중" <?if ($sel_status == '준비중') echo('selected')?>>준비중</option>
					<option value="주문취소" <?if ($sel_status == '주문취소') echo('selected')?>>주문취소</option>
					<option value="주문자취소" <?if ($sel_status == '주문자취소') echo('selected')?>>주문자취소</option>
					<option value="배송중" <?if ($sel_status == '배송중') echo('selected')?>>배송중</option>
					<option value="배송완료" <?if ($sel_status == '배송완료') echo('selected')?>>배송완료</option>
					<option value="구매확정" <?if ($sel_status == '구매확정') echo('selected')?>>구매확정</option>
					<option value="반송" <?if ($sel_status == '반송') echo('selected')?>>반송</option>
					<option value="반품" <?if ($sel_status == '반품') echo('selected')?>>반품</option>
				</select>
				<div class="pg-search-actions pg-search-actions--inline">
					<button type="button" class="pg-btn pg-btn-search" onclick="go_search()">검색</button>
					<button type="button" class="pg-btn pg-btn-outline" onclick="go_reset()">검색 초기화</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="pg-screen-summary-action-row">
	<div class="pg-summary-total-bar">
		<?php
		$order_list_mode = "keyfield=$keyfield&key=$encoded_key&sel_kind=$sel_kind&sel_status=$sel_status&ydate1=$ydate1&mdate1=$mdate1&ddate1=$ddate1&ydate2=$ydate2&mdate2=$mdate2&ddate2=$ddate2&p_num=" . rawurlencode(adm_ui_per_page_query_value($per_page_info));
		adm_ui_per_page_bar('pro_order.php', $order_list_mode, $per_page_info, $total_record);
		?>
	</div>
	<div class="pg-screen-action-buttons">
		<button type="button" class="pg-btn pg-btn-outline" onclick="location.reload()">새로고침</button>
		<button type="button" class="pg-btn pg-btn-info" onclick="go_excel()"><?=htmlspecialchars($level_l, ENT_QUOTES, 'UTF-8')?> 엑셀다운로드</button>
		<button type="button" class="pg-btn pg-btn-primary" onclick="go_modify()">상태 변경</button>
<?if ($sel_status == '주문취소' || $sel_status == '취소' || $sel_status == '주문자취소') {?>
		<button type="button" class="pg-btn pg-btn-outline" onclick="all_chk()">전체선택</button>
		<button type="button" class="pg-btn pg-btn-secondary" onclick="go_del()">삭제</button>
<?}?>
	</div>
</div>

<div class="pg-aggregate-stack">
	<div class="pg-status-bar__inner--grid">
<?
$metric_chunks = array_chunk($adm_status_counts, 3);
foreach ($metric_chunks as $chunk) {
?>
		<div class="pg-status-bar__row">
<?foreach ($chunk as $metric) {?>
			<div class="pg-status-bar__pill pg-status-bar__pill--<?=$metric['tone']?>">
				<span class="pg-status-bar__lbl"><?=htmlspecialchars($metric['label'], ENT_QUOTES, 'UTF-8')?></span>
				<span class="pg-status-bar__cnt">[<?=number_format($metric['count'])?>건]</span>
			</div>
<?}?>
		</div>
<?}?>
	</div>
</div>

<div class="pg-table-responsive">
<table class="pg-data-grid adm-table" cellspacing="0" cellpadding="0">
<thead>
<tr>
	<th width="40"><input type="checkbox" name="checkbox" onclick="select_all()"></th>
	<th>주문번호</th>
	<th>주문일시</th>
	<th>주문ID</th>
	<th>주문자</th>
	<th>연락처</th>
	<th>결제방법</th>
	<th>입금자명</th>
	<th>포인트사용</th>
	<th>상품명</th>
	<th>수량</th>
	<th>입금일</th>
	<th>색상/옵션</th>
	<th>금액</th>
	<th>상태</th>
<?if ($sel_status == '주문취소' || $sel_status == '취소' || $sel_status == '주문자취소') {?>
	<th width="56">삭제</th>
<?}?>
</tr>
</thead>
<tbody>
<?
$ii = 0;
if (!$total_record) {
	$colspan = ($sel_status == '주문취소' || $sel_status == '취소' || $sel_status == '주문자취소') ? 16 : 15;
?>
<tr><td colspan="<?=$colspan?>" class="pg-empty-cell">조회된 데이터가 없습니다.</td></tr>
<?
} else {
for ($i = $first; $i <= $last; $i++) {
	$ordernum = $rs[$i]['ordernum'];
	$id =$rs[$i][1];
	$pay_name =$rs[$i]["pay_name"];
	$kind =$rs[$i]["kind"];
	$status =$rs[$i]["status"];
	$signdate =$rs[$i]["signdate"];
	$pay_tel =$rs[$i]["pay_tel"];
	$pay_addr =$rs[$i]["pay_addr"];
	$in_name =$rs[$i]["in_name"];
	$in_day =$rs[$i]["in_day"];
	$qty =$rs[$i]["qty"];
	$usepoint =$rs[$i]["usepoint"];
	
	
	for($j=1;$j<=$settle_count;$j++) {
		if($kind==$j) $kind=$settles[--$j];
	}
	
	if ($kind=="1") $kind="신용카드";
//	else $kind="무통장입금";
	else if($kind=="2")$kind="무통장입금";
	else if($kind=="5")$kind="포인트";
	else if($kind=="9")$kind="포인트결제";

	$signdate = date('Y-m-d H:i', $signdate);
	$status1 = $status;
	$status_pill = adm_order_status_pill($status1);
#####################################################################
// 마이페이지 매출 내역 가져오기 
//
//	    $ALL_ID			= $id;
//		$ALL_ORDERNUM	= $ordernum;
//
//        $URL = 'http://coalcobalt.com/api/Request_sell_api.php';
//
//        $ch = curl_init();
//        curl_setopt ($ch, CURLOPT_URL, $URL);
//        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
//        curl_setopt ($ch, CURLOPT_POST, 1);
//        curl_setopt ($ch, CURLOPT_POSTFIELDS, 'ALL_ID='.$ALL_ID.'&ALL_ORDERNUM='.$ALL_ORDERNUM);
//        curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
//        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
//		$Result_data = curl_exec($ch);		
//        curl_close ($ch);
//		
//		
//		$json_data = json_decode($Result_data,true);



// 코인 입금확인
//	$query_select_wallet = "SELECT info FROM coin_wallet where id='$id' and ordernum = '$ordernum' ";
//	$result_select_wallet = mysql_query($query_select_wallet,$DBconn);
//	$value_select_wallet = mysql_fetch_row($result_select_wallet);
//	$addr =  $value_select_wallet[0];
//	echo($addr);
// 코인 입금확인 end

$query_cc = "SELECT code,title,money,point,count,opt1,opt2,new_opt1,new_opt2,new_opt3,new_opt4,new_opt5 FROM $shop_sell WHERE ordernum='$ordernum'";
$DB->get($query_cc,$rs_cc,$rn_cc);
$total_record_cc = $rn_cc;
$total_money_cc = 0;
$total_money_num = 0;

if ($total_record_cc < 1) {
	$total_record_cc = 1;
	$rs_cc = array(array());
}

for ($i_cc = 0; $i_cc < $total_record_cc; $i_cc++) {
	$code_cc = isset($rs_cc[$i_cc][0]) ? $rs_cc[$i_cc][0] : '';
	$title_cc = isset($rs_cc[$i_cc][1]) ? stripslashes($rs_cc[$i_cc][1]) : '-';
	$money_cc = isset($rs_cc[$i_cc][2]) ? $rs_cc[$i_cc][2] : 0;
	$point2_cc = isset($rs_cc[$i_cc][3]) ? $rs_cc[$i_cc][3] : 0;
	$count_cc = isset($rs_cc[$i_cc][4]) ? $rs_cc[$i_cc][4] : 0;
	$opt1_cc = isset($rs_cc[$i_cc][5]) ? $rs_cc[$i_cc][5] : '';
	$opt2_cc = isset($rs_cc[$i_cc][6]) ? $rs_cc[$i_cc][6] : '';
	$new_opt1_cc = isset($rs_cc[$i_cc][7]) ? $rs_cc[$i_cc][7] : '';
	$new_opt2_cc = isset($rs_cc[$i_cc][8]) ? $rs_cc[$i_cc][8] : '';
	$new_opt3_cc = isset($rs_cc[$i_cc][9]) ? $rs_cc[$i_cc][9] : '';
	$new_opt4_cc = isset($rs_cc[$i_cc][10]) ? $rs_cc[$i_cc][10] : '';
	$new_opt5_cc = isset($rs_cc[$i_cc][11]) ? $rs_cc[$i_cc][11] : '';

	$sum_money_cc = $money_cc * $count_cc;
	$point2_cc = $point2_cc * $count_cc;
	$total_money_cc += $sum_money_cc;
	$total_money_num = $total_money_cc;
	$sum_money_cc_fmt = number_format($sum_money_cc);
	$total_point = $total_point + $point2_cc;

	$option_t1 = $option_t2 = $option_t3 = $option_t4 = $option_t5 = '';
	if ($code_cc !== '') {
		$query_o = "SELECT option_t1,option_t2,option_t3,option_t4,option_t5 from $shop_goods WHERE code='$code_cc'";
		$DB->get($query_o,$rs_o,$rn_o);
		if ($rn_o > 0) {
			$option_t1 = $rs_o[0]["option_t1"];
			$option_t2 = $rs_o[0]["option_t2"];
			$option_t3 = $rs_o[0]["option_t3"];
			$option_t4 = $rs_o[0]["option_t4"];
			$option_t5 = $rs_o[0]["option_t5"];
		}
	}

	$opt_lines = array();
	if ($new_opt1_cc != "") $opt_lines[] = '<b>'.htmlspecialchars($option_t1, ENT_QUOTES, 'UTF-8').'</b> : '.htmlspecialchars($new_opt1_cc, ENT_QUOTES, 'UTF-8');
	if ($new_opt2_cc != "") $opt_lines[] = '<b>'.htmlspecialchars($option_t2, ENT_QUOTES, 'UTF-8').'</b> : '.htmlspecialchars($new_opt2_cc, ENT_QUOTES, 'UTF-8');
	if ($new_opt3_cc != "") $opt_lines[] = '<b>'.htmlspecialchars($option_t3, ENT_QUOTES, 'UTF-8').'</b> : '.htmlspecialchars($new_opt3_cc, ENT_QUOTES, 'UTF-8');
	if ($new_opt4_cc != "") $opt_lines[] = '<b>'.htmlspecialchars($option_t4, ENT_QUOTES, 'UTF-8').'</b> : '.htmlspecialchars($new_opt4_cc, ENT_QUOTES, 'UTF-8');
	if ($new_opt5_cc != "") $opt_lines[] = '<b>'.htmlspecialchars($option_t5, ENT_QUOTES, 'UTF-8').'</b> : '.htmlspecialchars($new_opt5_cc, ENT_QUOTES, 'UTF-8');
	$opt_html = '';
	if (!empty($opt_lines)) {
		$opt_html = '<div class="pg-opt-line">'.implode('<br>', $opt_lines).'</div>';
	}
?>
								<tr class="<?=$i_cc === 0 ? 'adm-order-group-start' : ''?>">
									<td><?if ($i_cc === 0) {?><input type="checkbox" name="check2<?=$ii?>" value="<?=$ordernum?>"><?}?></td>
									<td class="adm-nowrap"><?=htmlspecialchars($ordernum, ENT_QUOTES, 'UTF-8')?></td>
									<td class="adm-nowrap"><?=htmlspecialchars($signdate, ENT_QUOTES, 'UTF-8')?></td>
									<td class="adm-nowrap"><a href="buyer_info.php?cmenu=order&ordernum=<?=$ordernum?>"><?=htmlspecialchars($id, ENT_QUOTES, 'UTF-8')?></a></td>
									<td class="adm-nowrap"><a href="buyer_info.php?cmenu=order&ordernum=<?=$ordernum?>"><?=htmlspecialchars($pay_name, ENT_QUOTES, 'UTF-8')?></a></td>
									<td class="adm-nowrap"><?=htmlspecialchars($pay_tel, ENT_QUOTES, 'UTF-8')?></td>
									<td class="adm-nowrap"><?=htmlspecialchars($kind, ENT_QUOTES, 'UTF-8')?></td>
									<td class="adm-nowrap"><?=htmlspecialchars($in_name, ENT_QUOTES, 'UTF-8')?></td>
									<td class="adm-nowrap"><?=number_format($usepoint)?></td>
									<td class="adm-product-name"><?=htmlspecialchars($title_cc, ENT_QUOTES, 'UTF-8')?><?=$opt_html?></td>
									<td><?=$count_cc > 0 ? number_format($count_cc).' EA' : '-'?></td>
									<td><?=htmlspecialchars($in_day, ENT_QUOTES, 'UTF-8')?></td>
									<td><?=htmlspecialchars($opt2_cc, ENT_QUOTES, 'UTF-8')?></td>
									<td><?=$sum_money_cc_fmt?></td>
									<td><?=$i_cc === 0 ? $status_pill : ''?></td>
<?if($sel_status=="주문취소" || $sel_status=="취소" || $sel_status=="주문자취소"){?>
									<td><?if ($i_cc === 0) {?><input type="checkbox" name="check<?=$ii?>" value="<?=$ordernum?>"><?}?></td>
<?}?>
								</tr>
<?
}
?>
<input type="hidden" name="check3<?=$ii?>" value="<?=$id?>">
<input type="hidden" name="check4<?=$ii?>" value="<?=$status1?>">
<input type="hidden" name="check5<?=$ii?>" value="<?=$signdate?>">
<input type="hidden" name="check6<?=$ii?>" value="<?=$total_money_num?>">
<?

   $article_num--;
   $ii++;
}
}
$chk_num = ($total_record > 0) ? ($last - $first + 1) : 0;
?>
</tbody>
</table>
</div>

<div class="pg-pagination">
<?
 $total_block = ceil($total_page/$page_per_block);
 $block = ceil($page/$page_per_block);
 $first_page = ($block-1)*$page_per_block;
 $last_page = $block*$page_per_block;
 if($total_block <= $block) {
 	$last_page = $total_page;
 }
 
 $mode=$order_list_mode;

 
  if ($page > 1) {
 	$page_num = $page - 1;
?>
	<a href="pro_order.php?<?=$mode?>&page=<?=$page_num?>">◀</a>
<?
 }
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
?>
	<span class="is-active"><?=$direct_page?></span>
<?	
	} else {
?>
	<a href="pro_order.php?<?=$mode?>&page=<?=$direct_page?>"><?=$direct_page?></a>
 <?	
	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
?>
	<a href="pro_order.php?<?=$mode?>&page=<?=$page_num?>">▶</a>
<?
 }
 ?>
</div>

<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="chk_num" value="<?=$chk_num?>">
</form>
</div><!-- adm-content-panel-inner -->

<? include "../inc/down_menu.php"; ?>
