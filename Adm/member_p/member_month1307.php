<?
header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=1307-매출자료.xls" );  //엑셀 파일이름 지정
header( "Content-Description: PHP4 Generated Data" );
?>

<?
#####################################################################

include "../common/user_function.php";
include "../common/dbconn.php";

$encoded_key = urlencode($key);
$query = "SELECT id,name,passwd,email,signdate,dis1,company,member_cnt from $member_table ";

$query = $query."ORDER BY signdate DESC";	


$DB->get($query,$rs,$rn);

if ($page=="") $page=1;
$num_per_page = 5000;
$page_per_block = 10;

if(!$total_record) {
 	$first = 1;
 	$last = 0;   
} else {
 	$first = $num_per_page*($page-1);
 	$last = $num_per_page*$page;
 
 	$IsNext = $total_record - $last;
 	if($IsNext > 0) {
 		$last -= 1;
 	} else {
 		$last = $total_record - 1;
 	}      
}
 
$total_page = ceil($total_record/$num_per_page);
$article_num = $total_record - $num_per_page*($page-1);
$mode="keyfield=$keyfield&key=$encoded_key&sex=$sex&job=$job&dis=$dis&member_count=$member_count";

#####################################################################
?>

<script language="javascript">
<!--
function go_del() {
	ans = confirm('정말로 삭제하시겠습니까?');
	if (ans == true ) {
		document.form.action="member_del.php";
		document.form.submit();
	}	
}

function go_del1(kk) {
	ans = confirm('정말로 변경하시겠습니까?');
	if (ans == true ) {
		document.form.action=kk;
		document.form.submit();
	}	
}

function go_search() {
	document.form.action="member.php?dis=<?=$dis?>";
	document.form.submit();
}

function go_mail(tmp_mail) {
	document.location = "mailing.php?to_name=" + tmp_mail;
}
//-->
</script>

						 

								<table width="800" border='1' cellspacing='0' cellpadding='0'>
	
									<tr align="center"> 
										<td width="50" height="30">번호</td>
										<td width="100" height="30">아이디</td>
										<td width="150" height="30">이름</td>
										<td width="200" height="30">07월 매출</td>
										</td>
									</tr>
							
<?
#####################################################################

$ii=0;
for($i = $first; $i <= $last; $i++) { 
	$id =$rs[$i][0];
	$name =$rs[$i][1];
	$passwd =$rs[$i][2];
	$email =$rs[$i][3];
	$signdate =$rs[$i][4];
	$dis1 =$rs[$i][5];
	$company =$rs[$i][6];
	$member_cnt =$rs[$i][7];
	$signdate = date("Y-m-d",$signdate);

	if(($i+1)%2==0){
		$kk_bgcolor="#FFFFFF";
	}else{
		$kk_bgcolor="#F6F6F6";
	}

$vtmmoney=0;
	
#####################################################################
?>
								<tr align="center"> 
									<td height="30"><?=$article_num?></td>
									<td height="30"><?=$id?> [<?=$dis1?>]</td>
									<td height="30"><?=$name?>[<?=$company?>]</td>
									
									<td height="30"><?
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
								### 현재달 판매가격 ##########################################################

								$mkt = mktime(0,0,0,7,1,2013);
								$nmkt = mktime(23,59,59,7,31,2013);

								$cond = "ss.ordernum=so.ordernum and ss.signdate>".$mkt." and ss.signdate <".$nmkt." ";	
								$query_P = "SELECT ss.ordernum,ss.code,ss.title,ss.money,ss.count,so.kind FROM $shop_sell as ss,$shop_order as so where so.id='$id' and $cond order by ss.ordernum desc";

								
$DB->get($query_P,$rs_p,$rn_p);

								$cnt = $total_record_P;  //주문건수 초기화
								$mcnt = $total_record_P; //월별 주문수
								$tcnt = $tcnt + $cnt;  //토탈 주문수
								$bordnum = "";         //이전 주문번호 초기화
								$tmmoney = 0;
								$vtmmoney = 0;

								for($j = 0; $j < $total_record_P; $j++) {
									$ordernum = mysql_result($result_P,$j,0);
									$code = mysql_result($result_P,$j,1);
									$title = mysql_result($result_P,$j,2);
									$money = mysql_result($result_P,$j,3);
									$count = mysql_result($result_P,$j,4);
									$kind = mysql_result($result_P,$j,5);

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

								#####################################################################
								?>								
								<?=$vtmmoney?>

									</td>
								</tr>
								

<?


				
	
   $article_num--;
   $ii++;
        
}              
$chk_num = $last-$first+1;
?>
							</table>
				