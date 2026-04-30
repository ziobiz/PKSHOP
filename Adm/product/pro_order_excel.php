<?
header("Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=order.xls" );  //엑셀 파일이름 지정
header( "Content-Description: PHP4 Generated Data" );

// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
// include "../common/user_function.php";
include "../inc/set_com.php";

########## 데이터베이스에 연결한다. #################################


$wdate1 = mktime(0,0,0,$mdate1,$ddate1,$ydate1);
$wdate2 = mktime(23,59,59,$mdate2,$ddate2,$ydate2);

$wdate3 = Date("Y-m-d",$wdate1);
$wdate4 = Date("Y-m-d",$wdate2);



if($mdate1!='' || $ddate1!='' || $ydate1!=''){
	$where_date1 = " and signdate > '$wdate1'";
}else{
	$where_date1 = "";
}

if($mdate2!='' || $ddate2!='' || $ydate2!=''){
	if($where_date1==''){
		$where_date2 = " and signdate < '$wdate2'";
	}else{
		$where_date2 = " and signdate < '$wdate2'";
	}
}else{
	$where_date2 = "";
}

?>



<html>
<head>
<title>관리자 모드</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?

$query = "SELECT * FROM $shop_order WHERE ordernum!='' $where_date1 $where_date2 ";



if($sel_status==""){
	$query=$query."ORDER BY signdate DESC";
}else{
	$query=$query."and status='$sel_status' ORDER BY signdate DESC";
}

$DB->get($query,$rs,$rn);
// echo "$query";
//exit;

  
$total_record = $rn;

#####################################################################
?>


				
							<table width="800" border='1' cellspacing='0' cellpadding='0'>
								
								<tr>
<!-- 									<td align=center>송화인</td> -->
<!-- 									<td align=center>송화인연락처</td> -->
<!-- 									<td align=center>송화인주소</td> -->
									<td align=center>주문자 아이디</td>
									<td align=center>주문자 이름</td>
									<td align=center>주문날짜</td>
									<td align=center>주문번호</td>
									<td align=center>상품명</td>
									<td align=center>수량</td>
									<td align=center>사이즈</td>
									<td align=center>상품금액</td>
									<td align=center>입금할금액</td>
									<td align=center>포인트</td>
									<td align=center>결제총액</td>
									<td align=center>입금자이름</td>
									<td align=center>처리단계</td>
									<td align=center>수화인</td>
									<td align=center>받을연락처</td>
									<td align=center>우편번호</td>
									<td align=center>받을 주소</td>
									<td align=center>특이사항</td>
									<td align=center>운송장번호</td>

								</tr>
								
<?
#####################################################################

$cnt = $total_record;  //주문건수 초기화
for($i = 0; $i < $total_record; $i++) {
	$ordernum =$rs[$i]["ordernum"];
  	$receive_name =$rs[$i]["receive_name"];
	$receive_zip1 =$rs[$i]["receive_zip1"];
	$receive_addr =$rs[$i]["receive_addr"];
	$receive_tel =$rs[$i]["receive_tel"];
	$status =$rs[$i]["status"];
	$pointout =$rs[$i]["pointout"];
	$signdate =$rs[$i]["signdate"];
	$in_day  =$rs[$i]["in_day"];
	$id  =$rs[$i]["id"];
	$pay_name  =$rs[$i]["pay_name"];
	$charge  =$rs[$i]["charge"];
	$usepoint  =$rs[$i]["usepoint"];
	$in_name  =$rs[$i]["in_name"];
	$receive_zip1  =$rs[$i]["receive_zip1"];
	$receive_addr  =$rs[$i]["receive_addr"];
	$char_num  =$rs[$i]["char_num"];
	$signdate = date("Y-m-d H:i",$signdate);

	$receive_tel="$receive_tel";


	
	$query_p = "SELECT code,title,money,point,count,opt1,opt2,new_opt1,new_opt2,new_opt3,new_opt4,new_opt5,company,com_num FROM $shop_sell WHERE ordernum='$ordernum'";
	$DB->get($query_p,$result_p,$total_record_p);
	
	$Total_title="";
	$count_title=0;	
	$opt1_title="";
    
	for ($i_t=0;$i_t<$total_record_p;$i_t++) {
	
		$code_t = $result_p[$i_t][0];						$title_t = $result_p[$i_t][1];	
		$money_t = $result_p[$i_t][2];					$point2_t = $result_p[$i_t][3];
		$count_t = $result_p[$i_t][4];					$opt1_t = $result_p[$i_t][5];
		$opt2_t = $result_p[$i_t][6];						$new_opt1_t = $result_p[$i_t][7];
		$new_opt2_t = $result_p[$i_t][8];				$new_opt3_t = $result_p[$i_t][8];
		$new_opt4_t = $result_p[$i_t][1];				$new_opt5_t = $result_p[$i_t][1];					
						
		$sum_money_t = $money_t * $count_t;						$point2_t = $point2_t * $count_t;
		$total_money_t = $total_money_t + $sum_money_t;		$title = stripslashes($title);
		$money_t =  number_format($money_t)."원";				$sum_money_t =  number_format($sum_money_t)."원";

	}
	for ($i_p=0;$i_p<$total_record_p;$i_p++) {				
		$code_p = $result_p[$i_p][0];						$title_p = $result_p[$i_p][1];	
		$money_p = $result_p[$i_p][2];					$point2_p = $result_p[$i_p][3];
		$count_p = $result_p[$i_p][4];					$opt1_p = $result_p[$i_p][5];
		$opt2_p = $result_p[$i_p][6];						$new_opt1_p = $result_p[$i_p][7];
		$new_opt2_p = $result_p[$i_p][8];				$new_opt3_p = $result_p[$i_p][8];
		$new_opt4_p = $result_p[$i_p][1];				$new_opt5_p = $result_p[$i_p][1];	
		$company = $result_p[$i_p][1];				$com_num = $result_p[$i_p][1];
					
		$sum_money_p = $money_p * $count_p;						$point2_p = $point2_p * $count;
		$total_money = $total_money + $sum_money_p;	         $title_p = stripslashes($title_p);
		$money =  number_format($money)."원";				$sum_money =  number_format($sum_money)."원";
						
		$query_o = "SELECT option_t1,option_t2,option_t3,option_t4,option_t5 from $shop_goods WHERE code='$code'";
		
		$DB->get($query_o,$result_o,$total_record_o);
		$option_t1 = $result_o[0]['option_t1'];
		$option_t2 = $result_o[0]['option_t2'];
		$option_t3 = $result_o[0]['option_t3'];
		$option_t4 = $result_o[0]['option_t4'];
		$option_t5 = $result_o[0]['option_t5'];

		$total_point=$total_point+$point2;//포인트 합계 표시용
	
	
#####################################################################
?>
								<?if($i_p==0){?>
								<tr>
<!-- 									<td align=center rowspan=<?=$total_record_p?>>(주)coalcobalt</td> -->
<!-- 									<td align=center rowspan=<?=$total_record_p?>>02-@@@-@@</td> -->
<!-- 									<td align=center rowspan=<?=$total_record_p?>>@@@@@ (신사동)</td> -->
									<td align=center rowspan=<?=$total_record_p?>><?=$id?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=$pay_name?></td>
									<td align=center ><?=$signdate?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=$ordernum?></td>
									<td align=center rowspan=<?=$total_record_p?>  ><?=$title_p?></td>
									<td align=center rowspan=<?=$total_record_p?>  ><?=$count_p?></td>		
									<td align=center rowspan=<?=$total_record_p?>  ><?=$opt1_p?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=number_format($total_money_t)?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=number_format($total_money_t+$charge-$usepoint)?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=number_format($usepoint)?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=number_format($total_money_t+$charge)?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=$in_name?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=$status?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=$receive_name?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=$receive_tel?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=$receive_zip1?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=$receive_addr?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=$pay_etc?></td>
									<td align=center rowspan=<?=$total_record_p?>><?=$char_num?></td>


<!-- 									<td align=center rowspan=<?=$total_record_p?>><?=$in_day?></td> -->
<!-- 									<td align=center rowspan=<?=$total_record_p?>><?=$receive_zip1?></td> -->
<!-- 									<td align=center rowspan=<?=$total_record_p?>><?=$receive_addr?></td> -->
<!-- 									<td align=center rowspan=<?=$total_record_p?>></td> -->
									<!-- <td align=center rowspan=<?=$total_record_p?>>&nbsp;<?=$receive_tel?></td> -->
<!-- 									<td align=center rowspan=<?=$total_record_p?>></td> -->
<!-- 									<td align=center rowspan=<?=$total_record_p?>></td> -->
<!-- 									<td align=center rowspan=<?=$total_record_p?>></td> -->
									
								<?}else{?>
								<tr>
								<?}?>
									
									
									
									<!-- <td align=center><?=$in_day?></td> -->
																
									
<!-- 									<td align=center>[<?=$company?>]<?=$com_num?></td> -->


								<?if($i_p==0){?>
								
<!-- 									<td align=center rowspan=<?=$total_record_p?>><?=number_format($pointout)?></td> -->
									<!-- <td align=center rowspan=<?=$total_record_p?>><?=number_format($total_money_t-$pointout)?></td> -->
									<!-- <td align=center rowspan=<?=$total_record_p?>><?=$status?></td> -->
								</tr>
								<?}else{?>
								</tr>
								<?}?>
									
								
<?
	}
?>
								
									
<?
$total_money_t=0;
}
	

#####################################################################
?>
							
							</table>
							