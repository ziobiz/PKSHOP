<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../common/user_function.php";

########## 데이터베이스에 연결한다. #################################


if($tyear == "") {	$year_e = date("Y"); }

#####################################################################
?>
<? 
if($PATH_TRANSLATED!='../admin/login/login.html'){

if($idok!="yes"){?>
<SCRIPT LANGUAGE="JavaScript">
<!--
alert("관리자만 접근하실수 있습니다.");
location="../login/login.html";
//-->
</SCRIPT>
<?
exit;	
}
}?>
<html>
<head>
<title>웹주인 관리자 모드</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="../image/style.css" type="text/css">

<head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

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
							
							<form name=dform action="./order_month_user.php" method=post>
							<input type="hidden" name="user_id" value="<?=$user_id?>">
							<table width="800" border='0' cellspacing='0' cellpadding='3'>
								<tr>
									<td align=center colspan=6>*월별매출현황&nbsp;&nbsp;
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
									<td class="ttext01" align=center><b>신용카드</td>
									<td class="ttext01" align=center><b>무통장입금</td>
									<!-- <td class="ttext01" align=center><b>휴대폰</td> -->
									<td class="ttext01" align=center><b>그래프(주문수)</td>
									<td class="ttext01" align=center width=150><b>월매출</td>
								</tr>
								<tr><td colspan=6 height=3 bgcolor='#88B7DA'></td></tr>


<?
#####################################################################
for($i=1;$i<13;$i++) {
	if($i < 10) {
		$ii = "0".$i;
	}else{
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
	
	$cond = "ss.ordernum=so.ordernum and ss.signdate>".$mkt." and ss.signdate <".$nmkt." and (so.status like '배송%' or so.status like '준비%')";	
?>
							<tr bgcolor='#EBF0F4'>
									<td align=center height=30><?=$ii?></td>
<?
	### 카드 매출 ##########################################################
	$query1 = "SELECT ss.ordernum,ss.code,ss.title,ss.money,ss.count,so.kind FROM $shop_sell as ss,$shop_order as so where so.id='$user_id' and kind='1' and $cond order by ss.ordernum desc";

	$result1= mysql_query($query1,$DBconn);
		if (!$result1) {
			error("QUERY_ERROR");
			exit;
		}
		  
		$total_record1 = mysql_num_rows($result1);

		$cnt1 = $total_record1;  //주문건수 초기화
		$mcnt1 = $total_record1; //월별 주문수
		$tcnt1 = $tcnt1 + $cnt1;  //토탈 주문수
		$bordnum1 = "";         //이전 주문번호 초기화
		$vtmmoney1 = 0;

		for($j = 0; $j < $total_record1; $j++) {
			$ordernum1 = mysql_result($result1,$j,0);
			$code1 = mysql_result($result1,$j,1);
			$title1 = mysql_result($result1,$j,2);
			$money1 = mysql_result($result1,$j,3);
			$count1 = mysql_result($result1,$j,4);
			$kind1 = mysql_result($result1,$j,5);

			//echo $ordernum."=".$nordernum."<p>";

			$tmoney1 = $money1 * $count1;		//주문별 매출
			$tmmoney1 = $tmmoney1 + $tmoney1;	//월총매출

			$vtmmoney1 = number_format($tmmoney1);

			//현재주문번호와 이전주문번호를 비교하여 같으면 같은 주문으로 간주
			$cordnum1 = $ordernum1;
			if($cordnum1 == $bordnum1) {
				$tcnt1 = $tcnt1 - 1;
				$mcnt1 = $mcnt1 - 1;
			}
			$bordnum1 = $cordnum1;
			
		}

		$ytmoney1 = $ytmoney1 + $tmmoney1; //년총매출 누적

		// 그래프 계산
		$gtotal1 = 10000000;	//100%가 천만원
		$graph1 = ($tmmoney1 * 600)/$gtotal1;

#####################################################################
?>
									<td align=center><?=$vtmmoney1?></td>
<?
	### 온라인 매출 ##########################################################
	$query2 = "SELECT ss.ordernum,ss.code,ss.title,ss.money,ss.count,so.kind FROM $shop_sell as ss,$shop_order as so where so.id='$user_id' and  kind='2' and $cond order by ss.ordernum desc";

	$result2= mysql_query($query2,$DBconn);
		if (!$result2) {
			error("QUERY_ERROR");
			exit;
		}
		  
		$total_record2 = mysql_num_rows($result2);

		$cnt2 = $total_record2;  //주문건수 초기화
		$mcnt2 = $total_record2; //월별 주문수
		$tcnt2 = $tcnt2 + $cnt2;  //토탈 주문수
		$bordnum2 = "";         //이전 주문번호 초기화
		$vtmmoney2 = 0;

		for($j = 0; $j < $total_record2; $j++) {
			$ordernum2 = mysql_result($result2,$j,0);
			$code2 = mysql_result($result2,$j,1);
			$title2 = mysql_result($result2,$j,2);
			$money2 = mysql_result($result2,$j,3);
			$count2 = mysql_result($result2,$j,4);
			$kind2 = mysql_result($result2,$j,5);

			//echo $ordernum."=".$nordernum."<p>";

			$tmoney2 = $money2 * $count2;		//주문별 매출
			$tmmoney2 = $tmmoney2 + $tmoney2;	//월총매출

			$vtmmoney2 = number_format($tmmoney2);

			//현재주문번호와 이전주문번호를 비교하여 같으면 같은 주문으로 간주
			$cordnum2 = $ordernum2;
			if($cordnum2 == $bordnum2) {
				$tcnt2 = $tcnt2 - 1;
				$mcnt2 = $mcnt2 - 1;
			}
			$bordnum2 = $cordnum2;
			
		}

		$ytmoney2 = $ytmoney2 + $tmmoney2; //년총매출 누적

		// 그래프 계산
		$gtotal2 = 10000000;	//100%가 천만원
		$graph2 = ($tmmoney2 * 600)/$gtotal2;

#####################################################################
?>
									<td align=center><?=$vtmmoney2?></td>
<!-- <?
	### 휴대폰 매출 ##########################################################
	$query3 = "SELECT ss.ordernum,ss.code,ss.title,ss.money,ss.count,so.kind FROM $shop_sell as ss,$shop_order as so where kind='3' and $cond order by ss.ordernum desc";

	$result3= mysql_query($query3,$DBconn);
		if (!$result3) {
			error("QUERY_ERROR");
			exit;
		}
		  
		$total_record3 = mysql_num_rows($result3);

		$cnt3 = $total_record3;  //주문건수 초기화
		$mcnt3 = $total_record3; //월별 주문수
		$tcnt3 = $tcnt3 + $cnt3;  //토탈 주문수
		$bordnum3 = "";         //이전 주문번호 초기화
		$vtmmoney3 = 0;

		for($j = 0; $j < $total_record3; $j++) {
			$ordernum3 = mysql_result($result3,$j,0);
			$code3 = mysql_result($result3,$j,1);
			$title3 = mysql_result($result3,$j,2);
			$money3 = mysql_result($result3,$j,3);
			$count3 = mysql_result($result3,$j,4);
			$kind3 = mysql_result($result3,$j,5);

			//echo $ordernum."=".$nordernum."<p>";

			$tmoney3 = $money3 * $count3;		//주문별 매출
			$tmmoney3 = $tmmoney3 + $tmoney3;	//월총매출

			$vtmmoney3 = number_format($tmmoney3);

			//현재주문번호와 이전주문번호를 비교하여 같으면 같은 주문으로 간주
			$cordnum3 = $ordernum3;
			if($cordnum3 == $bordnum3) {
				$tcnt3 = $tcnt3 - 1;
				$mcnt3 = $mcnt3 - 1;
			}
			$bordnum3 = $cordnum3;
			
		}

		$ytmoney3 = $ytmoney3 + $tmmoney3; //년총매출 누적

		// 그래프 계산
		$gtotal3 = 10000000;	//100%가 천만원
		$graph3 = ($tmmoney3 * 600)/$gtotal3;

#####################################################################
?>
									<td align=center><?=$vtmmoney3?></td> -->

<?
	### 전체 판매가격 ##########################################################
	$cond = "ss.ordernum=so.ordernum and ss.signdate>".$mkt." and ss.signdate <".$nmkt." and (so.status like '배송%' or so.status like '준비%')";	
	$query = "SELECT ss.ordernum,ss.code,ss.title,ss.money,ss.count,so.kind FROM $shop_sell as ss,$shop_order as so where so.id='$user_id' and $cond order by ss.ordernum desc";

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
		if($graph>380){
			$graph=380;
		}

#####################################################################
?>
								
									<td height=30>
										<img src="../image/graph1.gif" width=<?=$graph?> height=10>&nbsp;(<?=$mcnt?>)</td>
									<td align=center height=30><font color="#3399FF"><b>\<?=$vtmmoney?></font></td>
								</tr>
								<tr><td colspan=8 height=1 bgcolor='#D2DEE8'></td></tr>
<?
		$tmmoney1 = 0; //월매출 초기화
		$vtmmoney1 = 0;
		$mcnt1 = 0;	//월주문수 초기화
		$tmmoney2 = 0; //월매출 초기화
		$vtmmoney2 = 0;
		$mcnt2 = 0;	//월주문수 초기화
		$tmmoney3 = 0; //월매출 초기화
		$vtmmoney3 = 0;
		$mcnt3 = 0;	//월주문수 초기화
		$tmmoney = 0; //월매출 초기화
		$vtmmoney = 0;
		$mcnt = 0;	//월주문수 초기화
	}
?>


<?
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
										<font color=#FF6600>\<?=$vytmoney?></font>
									</td>
								</tr>
							</table>
							<p><center>
							</center>
							</form>
							<br><br>
<!-- 전체 테이블 end -->
</body>
</html>