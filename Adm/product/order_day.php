<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_sell.php";

include "../common/user_function.php";

########## 데이터베이스에 연결한다. #################################
$tmonth = $_REQUEST["tmonth"];
$tday = $_REQUEST["tday"];
$tyear = $_REQUEST["tyear"];
$emonth = $_REQUEST["emonth"];
$eday = $_REQUEST["eday"];
$eyear = $_REQUEST["eyear"];

adm_ui_apply_pg_date_range_request(adm_ui_sales_day_date_field_map());
$tyear = isset($_REQUEST['tyear']) ? $_REQUEST['tyear'] : '';
$tmonth = isset($_REQUEST['tmonth']) ? $_REQUEST['tmonth'] : '';
$tday = isset($_REQUEST['tday']) ? $_REQUEST['tday'] : '';
$eyear = isset($_REQUEST['eyear']) ? $_REQUEST['eyear'] : '';
$emonth = isset($_REQUEST['emonth']) ? $_REQUEST['emonth'] : '';
$eday = isset($_REQUEST['eday']) ? $_REQUEST['eday'] : '';

if($kkid!=""){
	$kk_query=" and so.id='$kkid'";
}

if($kkid1!=""){
	$kk_query1=" and ss.title='$kkid1'";
}
if($tday == "") {
	$year_e = date("Y");
	$month_e = date("m");
	$day_e= date("d");

	$mkt = mktime(0,0,0,$month_e,$day_e,$year_e); //현재날짜를 저장형태로 받기
	$nmkt = mktime(0,0,0,$month_e,$day_e+1,$year_e); //현재날짜다음날

	//처음 페이지가 로딩 되었을 때 현재 날짜로 당일매출 리스트 쿼리
	$cond = "ss.ordernum=so.ordernum and ss.signdate>".$mkt." and ss.signdate <".$nmkt." and (so.status like '%배송%' or so.status like '%구매확정%')";
}else {
	$tdate = mktime(0,0,0,$tmonth,$tday,$tyear); //선택된 날짜 이날부터
	$ydate = mktime(0,0,0,$emonth,$eday+1,$eyear); //선택된 날짜 이날까지 다음날

	//날짜를 선택했을 때 선택된 날짜로 당일매출 리스트 쿼리
	$cond = "ss.ordernum=so.ordernum and ss.signdate>".$tdate." and ss.signdate <".$ydate." and (so.status like '%배송%' or so.status like '%구매확정%')";
}

$query = "SELECT ss.code,ss.title,ss.count,ss.opt1,ss.money,so.id,so.pay_name,so.ordernum,ss.signdate,so.status,so.kind FROM $shop_sell as ss,$shop_order as so where $cond $kk_query $kk_query1 order by ss.ordernum desc";
//echo $query;
//exit;
$DB->get($query,$rs,$rn);


$total_record = $rn;

$order_day_disp_from = array('y' => $tyear, 'm' => $tmonth, 'd' => $tday);
$order_day_disp_to = array('y' => $eyear, 'm' => $emonth, 'd' => $eday);
if ($tday === '' || $tday === null) {
	$order_day_disp_from = array('y' => date('Y'), 'm' => date('m'), 'd' => date('d'));
	$order_day_disp_to = $order_day_disp_from;
}

#####################################################################
?>
<script language="javascript">
<!--
function go() {
	location.href="./order_month.php";
}
function pgo() {
	location.href="./order_profit.php";
}
function move() {
	document.dform.submit();
}
//-->
</script>

				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr><td height=30></td></tr>
					<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>

								<tr>
									<? 
	$file_name=date("Y-m-d");
?>
									<td class='td14'><b>일별 매출 조회&nbsp;&nbsp;<a href="order_day_excel.php?kkid=<?=$kkid?>&tmonth=<?=$tmonth?>&tday=<?=$tday?>&tyear=<?=$tyear?>&emonth=<?=$emonth?>&eday=<?=$eday?>&eyear=<?=$eyear?>&file_name=<?=$file_name?>">[엑셀파일다운로드]</a></b></td>
								</tr>
							</table>
					</td></tr>		
					<tr> 
						<td align=left> 							
							<b><font size="3">  </font></b></p>
							<form name=dform action="./order_day.php" method=post>
							<table width="850" border='0' cellspacing='0' cellpadding='0'>
								<tr>
									<td align=center colspan=11 class="pg-order-day-search">
										<span class="pg-order-day-search-label">조회기간</span>
										<?php
										echo adm_ui_pg_date_range_html(
											$order_day_disp_from,
											$order_day_disp_to,
											adm_ui_sales_day_date_field_map()
										);
										?>
										<input type="text" name="kkid1" value="<?=adm_ui_h($kkid1)?>" class="pg-input" placeholder="상품명 검색">
										<input type="button" value=" 조 회 " class="pg-btn" onclick="move()">
									</td>
								</tr>
								<tr><td colspan=12 height=3 bgcolor='#88B7DA'></td></tr>
								<tr bgcolor='#EBF0F4'>
									<td class="ttext01" align=center height="30">번호</td>
									<td class="ttext01" align=center>주문날짜</td>
									<td class="ttext01" align=center>주문번호</td>
									<td class="ttext01" align=center>주문ID</td>
									<td class="ttext01" align=center>주문자</td>
									<td class="ttext01" align=center>상품명</td>
									<td class="ttext01" align=center>제조사</td>
									<td class="ttext01" align=center>수량</td>
									<td class="ttext01" align=center>사이즈</td>
									<td class="ttext01" align=center>판매가격</td>
									<td class="ttext01" align=center>합계금액</td>
									<td class="ttext01" align=center>지불수단</td>
								</tr>
								<tr><td colspan=12 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr><td colspan=12 height=3></td></tr>
<?
#####################################################################

$cnt = $total_record;  //주문건수 초기화
$bordnum = "";         //이전 주문번호 초기화
for($i = 0; $i < $total_record; $i++) {
	$code =$rs[$i][0];
  	$title =$rs[$i][1];
	$count =$rs[$i][2];
	$size =$rs[$i][3];
	$money =$rs[$i][4];
	$id =$rs[$i][5];
	$name =$rs[$i][6];
	$ordernum =$rs[$i][7];
	$signdate =$rs[$i][8];
	$status =$rs[$i][9];
	$kind =$rs[$i][10];


	$signdate = date("Y-m-d",$signdate);

	$vmoney = number_format($money);
	$tmoney = $money * $count;
	$vtmoney = number_format($tmoney);

	if($i == 0) {
		$ii = $total_record;
	}

	//제조사 쿼리
	$cquery = "SELECT company FROM $shop_goods WHERE code='$code'";
	$DB->get($cquery,$crs,$crn);

	$company = $crs[0][0];

#####################################################################
?>
								<tr>
									<td align=center height=30  class="text02"><?=$ii?></td>
									<td align=center height=30  class="text02"><?=$signdate?></td>
									<td align=center height=30  class="text02"><?=$ordernum?></td>
									<td align=center height=30  class="text02"><?=$id?></td>
									<td align=center height=30  class="text02"><?=$name?>(<?=$status?>)</td>
									<td align=center height=30  class="text02"><?=$title?></td>
									<td align=center height=30  class="text02"><?=$company?></td>
									<td align=center height=30  class="text02"><?=$count?></td>
									<td align=center height=30  class="text02"><?if($size != "") echo $size; else echo "없음";?></td>
									<td align=center height=30  class="text02">\<?=$vmoney?></td>
									<td align=center height=30  class="text02"><font color="#3399FF"><b>\<?=$vtmoney?></font></td>
									<td align=center height=30  class="text02">
										<?if($kind=="2"){?>
										무통장
										<?}else if($kind=="3"){?>
										계좌이체
										<?}else{?>
										카드
										<?}?>
									</td>
								</tr>
								<tr><td colspan=12 height=1 bgcolor='#D2DEE8'></td></tr>
<?
	$ii = --$ii;
	$total_day = $total_day + $tmoney;

	//현재주문번호와 이전주문번호를 비교하여 같으면 같은 주문으로 간주
	$cordnum = $ordernum;
	if($cordnum == $bordnum) {
		$cnt = $cnt - 1;
	}
	$bordnum = $cordnum;
}
	$vtotal_day = number_format($total_day);

#####################################################################
?>
								<tr>
									<td align=center colspan=12  class="text02" height=30>
										<b>주문수 <font color=#FF6600>[<?=$cnt?>]</font>건 &nbsp;&nbsp; 매출 <font color=#FF6600>[<?=$vtotal_day?>]</font>
									</td>
								</tr>
							</table>
							<p><center>
							<input type=button value=" 월별매출 " onclick="go()">&nbsp;
							
							<center>
							</form>
							<br><br>
							</td>
					</tr>

				</table>
<? include "../inc/down_menu.php"; ?>
