<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include_once "../inc/admin_shell_lib.php";
include "../common/user_function.php";

########## 데이터베이스에 연결한다. #################################
if($tyear == "") {	$year_e = date("Y"); }

#####################################################################
?>
<?php pkshop_admin_auto_shell_begin(); ?>
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

				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0" class="left_margin30">
					<tr><td height=30></td></tr>
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
								<tr><td colspan=3 height=3 bgcolor='#88B7DA'></td></tr>
								<tr align="center" bgcolor='#EBF0F4'>
									<td class="ttext01" align=center width=50><b>월</td>
									<td class="ttext01" align=center width=600><b>그래프(주문수)</td>
									<td class="ttext01" align=center width=150><b>월매출</td>
								</tr>
								<tr><td colspan=3 height=3 bgcolor='#88B7DA'></td></tr>
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

		$cond = "ss.ordernum=so.ordernum and ss.signdate>".$mkt." and ss.signdate <".$nmkt." and (so.status like '배송%' or so.status like '입금%')";	
		$query = "SELECT ss.ordernum,ss.code,ss.title,ss.money,ss.count,so.kind FROM $shop_sell as ss,$shop_order as so where $cond order by ss.ordernum desc";

		$DB->get($query,$rs,$rn);
		if (!$result) {
			error("QUERY_ERROR");
			exit;
		}
		  
		$total_record = $rn;

		$cnt = $total_record;  //주문건수 초기화
		$mcnt = $total_record; //월별 주문수
		$tcnt = $tcnt + $cnt;  //토탈 주문수
		$bordnum = "";         //이전 주문번호 초기화
		$vtmmoney = 0;

		for($j = 0; $j < $total_record; $j++) {
			$ordernum = mysql_result($result,$j,0);
			$code = mysql_result($result,$j,1);
			$title = mysql_result($result,$j,2);
			$money = mysql_result($result,$j,3);
			$count = mysql_result($result,$j,4);
			$kind = mysql_result($result,$j,5);

			//echo $ordernum."=".$nordernum."<p>";

			$tmoney = $money * $count;		//주문별 매출
			$tmmoney = $tmmoney + $tmoney;	//월총매출

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

		// 그래프 계산
		$gtotal = 10000000;	//100%가 천만원
		$graph = ($tmmoney * 600)/$gtotal;

#####################################################################
?>
								<tr bgcolor='#EBF0F4'>
									<td align=center height=30><?=$ii?></td>
									<td height=30>
										<img src="../image/graph1.gif" width=<?=$graph?> height=10>&nbsp;(<?=$mcnt?>)</td>
									<td align=center height=30><font color="#3399FF"><b>\<?=$vtmmoney?></font></td>
								</tr>
								<tr><td colspan=8 height=1 bgcolor='#D2DEE8'></td></tr>
<?
		$tmmoney = 0; //월매출 초기화
		$vtmmoney = 0;
		$mcnt = 0;	//월주문수 초기화
	}

	$vytmoney = number_format($ytmoney);
?>
								<tr>
									<td colspan=3 align=center bgcolor='#EBF0F4' height=30><b><font color="#3399FF">
<?
	if($tyear=="") {
		echo $year_e;
	}
	else {
		echo $tyear;
	}
?>
										</font>년 &nbsp;총주문수 : <font color=#FF6600><?=$tcnt;?></font>건 &nbsp; 총매출 : 
										<font color=#FF6600>\<?=$vytmoney?></font>
									</td>
								</tr>
							</table>
							<p><center>
							<input type=button value=" 매출조회 " onclick="go()">&nbsp;
							
							</center>
							</form>
							<br><br>
<?php pkshop_admin_shell_end(); ?>
