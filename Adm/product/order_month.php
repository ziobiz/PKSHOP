<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../common/user_function.php";

########## 데이터베이스에 연결한다. #################################


include "../inc/top_menu.php";
include "../inc/left_menu_sell.php";
if($tyear == "") {	$year_e = date("Y"); }

#####################################################################
?>
<script language="javascript">
<!--
function go() {
	location.href="./order_day.php";
}
function pgo() {
	location.href="./order_profit.php";
}
function move() {
	document.dform.submit();
}
//-->
</script>

				<table width="800" border="0" cellspacing="0" cellpadding="0" class="left_margin30">
					<tr><td height=30></td></tr>
					<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>월별 매출 조회</b></td>
								</tr>
							</table>
					</td></tr>	
					<tr> 
						<td align=left> 						
							
							<form name=dform action="./order_month.php" method=post>
							<table width="800" border='0' cellspacing='0' cellpadding='3'>
								<tr>
									<td align=center colspan=3>*월별매출현황&nbsp;&nbsp;
										<select name=tyear onchange="move()">
										<?
											for($a=2002;$a<2101;$a++) {
										?>
											<option value="<?=$a?>" <?if($year_e == $a || $tyear == $a) echo "selected"?>><?echo $a?></option>
										<?
											}
										?>
											</select>년&nbsp;
									</td>
								</tr>
								<tr><td colspan=6 height=3 bgcolor='#88B7DA'></td></tr>
								<tr align="center" bgcolor='#EBF0F4'>
									<td class="ttext01" align=center width=50><b>월</td>
									<td class="ttext01" align=center width=500><b>그래프(주문수)</td>
									<!-- <td class="ttext01" align=center width=100><b>무통장</td> -->
									<td class="ttext01" align=center width=100><b>카드</td>
									<td class="ttext01" align=center width=100><b>계좌이체</td>
									<!-- <td class="ttext01" align=center width=100><b>포인트</td> -->
								</tr>
								<tr><td colspan=6 height=3 bgcolor='#88B7DA'></td></tr>
<?
#####################################################################

		for($i=1;$i<13;$i++) {
		if($i < 10) {
			$ii = "0".$i;
		}else {
			$ii = $i;
		}
	
		if($tyear == "") {
		$year_e = date("Y");
		$month_e = $ii;
		$day_e= 1;
		$mkt = mktime(0,0,0,$month_e,$day_e,$year_e);
		$nmkt = mktime(0,0,0,$month_e+1,$day_e,$year_e);
		}else {
		$mkt = mktime(0,0,0,$ii,1,$tyear);
		$nmkt = mktime(0,0,0,$ii+1,1,$tyear);
	}
		
		$cond = "ss.ordernum=so.ordernum and ss.signdate>".$mkt." and ss.signdate <".$nmkt." and (so.status like '%배송%' or so.status like '%구매확정%')";	
		$query = "SELECT ss.ordernum,ss.code,ss.title,ss.money,ss.count,so.kind,so.usepoint FROM $shop_sell as ss,$shop_order as so where $cond order by ss.ordernum desc";

		$DB->get($query,$rs,$rn);
		
		$total_record = $rn;

		$cnt = $total_record;  //주문건수 초기화
		$mcnt = $total_record; //월별 주문수
		$tcnt = $tcnt + $cnt;  //토탈 주문수
		$bordnum = "";         //이전 주문번호 초기화
		$vtmmoney = 0; //월매출
		$tpoint=0; //월 포인트합
		$ytpoint=0; //년 포인트합
		$bmoney=0; //무통장
		$cmoney=0; //카드
		$kmoney=0; //계좌이체

		for($j = 0; $j < $total_record; $j++) {
			$ordernum = $rs[$j][0];
			$code = $rs[$j][1];
			$title = $rs[$j][2];
			$money = $rs[$j][3];
			$count = $rs[$j][4];
			$kind = $rs[$j][5];
			$pointout = $rs[$j][6];
			
			//echo $ordernum."=".$nordernum."<p>";

			$tmoney = $money * $count;		//주문별 매출
			$tmmoney = $tmmoney + $tmoney;	//월총매출
			if($kind=="2"){
				$bmoney=$bmoney+$tmoney;				
			}else if($kind=="3"){
				$cmoney=$bmoney+$tmoney;
			}else{
				$kmoney=$bmoney+$tmoney;
			}
			$tpoint=$tpoint+$pointout; //포인트총합

			$vtmmoney = number_format($tmmoney);

			//현재주문번호와 이전주문번호를 비교하여 같으면 같은 주문으로 간주
			$cordnum = $ordernum;
			if($cordnum == $bordnum) {
				$tcnt = $tcnt - 1;
				$mcnt = $mcnt - 1;
			}
			$bordnum = $cordnum;
			
		}

		$ytmoney = $ytmoney + $tmmoney; //년총매출 누적

		$ytpoint = $ytpoint + $tpoint;

		// 그래프 계산
		$gtotal = 10000000;	//100%가 천만원
		$graph = ($tmmoney * 600)/$gtotal;
		$graph = $graph / 100;

#####################################################################
?>
								<tr bgcolor='#EBF0F4'>
									<td align=center height=30><?=$ii?></td>
									<td height=30>
										<img src="../image/graph1.gif" width=<?=$graph?> height=10>&nbsp;(<?=$mcnt?>)</td>
									<!-- <td align=center height=30><font color="#3399FF"><b>\<?=number_format($bmoney)?></font></td> -->
									<td align=center height=30><font color="#3399FF"><b>$ <?=number_format($kmoney)?></font></td>
									<td align=center height=30><font color="#3399FF"><b>$ <?=number_format($bmoney)?></font></td>
									<!-- <td align=center height=30><font color="#3399FF"><b>\<?=number_format($tpoint)?></font></td> -->
								</tr>
								<tr><td colspan="8" height="1" bgcolor="#D2DEE8"></td></tr>
<?
		$tmmoney = 0; //월매출 초기화
		$vtmmoney = 0;
		$mcnt = 0;	//월주문수 초기화
		$tpoint=0;
		$bmoney=0; //무통장
		$cmoney=0; //카드
		$kmoney=0; //계좌이체
	}

	$vytmoney = number_format($ytmoney);
?>
								<tr>
									<td colspan=6 align=center bgcolor='#EBF0F4' height=30><b><font color="#3399FF">
<?
	if($tyear=="") {
		echo $year_e;
	}
	else {
		echo $tyear;
	}
?>
										</font>년 &nbsp;총주문수 : <font color=#FF6600><?=$tcnt;?></font>건 &nbsp; 총매출 : 
										<font color=#FF6600>\<?=$vytmoney?>(<?=number_format($ytpoint)?>)</font>
									</td>
								</tr>
							</table>
							<p><center>
							<input type=button value=" 매출조회 " onclick="go()">&nbsp;
							
							</center>
							</form>
							<br><br>
							</td>
					</tr>
				</table>
<? include "../inc/down_menu.php"; ?>