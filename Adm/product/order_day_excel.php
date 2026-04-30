<?

// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=sales.xls" );  //엑셀 파일이름 지정
header( "Content-Description: PHP4 Generated Data" );
?>

<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../common/user_function.php";

########## 데이터베이스에 연결한다. #################################

$month_e = $_REQUEST["month_e"];
$day_e = $_REQUEST["day_e"];
$year_e = $_REQUEST["year_e"];
$tmonth = $_REQUEST["tmonth"];
$tday = $_REQUEST["tday"];
$tyear = $_REQUEST["tyear"];
$emonth = $_REQUEST["emonth"];
$eday = $_REQUEST["eday"];
$eyear = $_REQUEST["eyear"];
?>



<html>
<head>
<title>웹주인 관리자 모드</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
if($kkid!=""){
	$kk_query=" and so.id='$kkid'";
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

$query = "SELECT ss.code,ss.title,ss.count,ss.opt1,ss.money,so.id,so.pay_name,so.ordernum,ss.signdate,so.status,so.kind FROM $shop_sell as ss,$shop_order as so where $cond $kk_query order by ss.ordernum desc";


$DB->get($query,$rs,$rn);

$total_record = $rn;

#####################################################################
?>


				
							<table width="800" border='1' cellspacing='0' cellpadding='0'>
								
								<tr>
									<td align=center>번호</td>
									<td align=center>주문날짜</td>
									<td align=center>주문번호</td>
									<td align=center>주문ID</td>
									<td align=center>주문자</td>
									<td align=center>상품명</td>
									<td align=center>제조사</td>
									<td align=center>수량</td>
									<td align=center>사이즈</td>
									<td align=center>판매가격</td>
									<td align=center>합계금액</td>
									<td align=center>지불수단</td>
								</tr>
								
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
									<td align=center><?=$ii?></td>
									<td align=center><?=$signdate?></td>
									<td align=center><?=$ordernum?></td>
									<td align=center><?=$id?></td>
									<td align=center><?=$name?></td>
									<td align=center><?=$title?></td>
									<td align=center><?=$company?></td>
									<td align=center><?=$count?></td>
									<td align=center><?if($size != "") echo $size; else echo "없음";?></td>
									<td align=center>\<?=$vmoney?></td>
									<td align=center><font color="#3399FF"><b>\<?=$vtmoney?></font></td>
									<td align=center>
										<?if($kind=="2"){?>
										무통장
										<?}else if($kind=="3"){?>
										계좌이체
										<?}else{?>
										카드
										<?}?>
									</td>
								</tr>
								
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
									<td align=center colspan=11  class="text02" height=30>
										<b>주문수 <font color=#FF6600>[<?=$cnt?>]</font>건 &nbsp;&nbsp; 매출 <font color=#FF6600>[\<?=$vtotal_day?>]</font>
									</td>
								</tr>
							</table>
							