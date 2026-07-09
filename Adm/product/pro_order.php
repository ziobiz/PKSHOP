<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include_once "../inc/admin_shell_lib.php";
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
<?php pkshop_admin_auto_shell_begin(); ?>
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
//-->
</script>


				<table width="1500" border="0" cellspacing="0" cellpadding="0">
				<form name="form" method="post" action="pro_order.php">
					<input type="hidden" name="sel_status" value="<?=$sel_status?>">
					
					<tr><td height=30></td></tr>
					<tr><td height=3></td></tr>
					<tr> 
						<td> 							
							<table width="1500" border="0" cellspacing="0" cellpadding="4">
<?
#####################################################################

if($ydate1=='')  $ydate1=date('Y');
if($mdate1=='')  $mdate1=date('m')-1;
if($ddate1=='')  $ddate1=date('d');

if($ydate2=='')  $ydate2=date('Y');
if($mdate2=='')  $mdate2=date('m');
if($ddate2=='')  $ddate2=date('d');

$wdate1 = mktime(0,0,0,$mdate1,$ddate1,$ydate1);
$wdate2 = mktime(23,59,59,$mdate2,$ddate2,$ydate2);


if($wdate1 !=""){
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


	$year_e = date("Y");
	$month_e = date("m");
	$day_e = date("d");

	$timestamp_s = mktime(0,0,0,$month_e,$day_e,$year_e);
	$timestamp_e = mktime(23,59,59,$month_e,$day_e,$year_e);

	$query = "SELECT count(ordernum) FROM $shop_order WHERE signdate>$timestamp_s and signdate<$timestamp_e and status!='주문대기'";
	
	$DB->get($query,$rs,$rn);

	
	
	$cnt1 = $rs[0][0];

	$timestamp_s = mktime(0,0,0,$month_e,1,$year_e);
	$timestamp_e = mktime(0,0,0,$month_e+1,1,$year_e);
	$query = "SELECT count(ordernum) FROM $shop_order WHERE signdate>$timestamp_s and signdate<$timestamp_e and status!='주문대기'";
	$DB->get($query,$rs,$rn);
	

	
	$cnt2 = $rs[0][0];
	
	$query = "SELECT count(ordernum) FROM $shop_order WHERE status='주문취소'";
	$DB->get($query,$rs,$rn);
	
	
	$cnt3 = $rs[0][0];
		
	
#####################################################################
?>
<tr>
<td height="20"> 
											<select name="ydate1" class="formbox3">
											<? for($i=2017;$i<=Date("Y");$i++){?>
											<option value="<?=$i?>" <?if($ydate1==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select><span class="text2">년</span>&nbsp;

											<select name="mdate1" class="formbox3">
											<?for($i=1;$i<13;$i++){?>
											<option value="<?=$i?>" <?if($mdate1==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select><span class="text2">월</span>&nbsp;

											<select name="ddate1" class="formbox3">
											<?for($i=1;$i<32;$i++){?>
											<option value="<?=$i?>" <?if($ddate1==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select><span class="text2">일</span>&nbsp;
											~
											<select name="ydate2" class="formbox3">
											<? for($i=2017;$i<=Date("Y");$i++){?>
											<option value="<?=$i?>" <?if($ydate2==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select><span class="text2">년</span>&nbsp;

											<select name="mdate2" class="formbox3">
											<?for($i=1;$i<13;$i++){?>
											<option value="<?=$i?>" <?if($mdate2==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select><span class="text2">월</span>&nbsp;

											<select name="ddate2" class="formbox3">
											<?for($i=1;$i<32;$i++){?>
											<option value="<?=$i?>" <?if($ddate2==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select><span class="text2">일</span>&nbsp;

											&nbsp;&nbsp;
											<!-- <select name="keyfield">
											<option value="ip" <?if ($keyfield=='ip') echo("selected");?>>아이피</option>
											</select>
											<input type="text" name="key" value="<?=$key?>"size="16" maxlength="16" class="adminbttn"> -->
											
											<input type="button"  value="검색" class="adminbttn" onClick="javascript:go_search()">
											<input type="hidden" name="level_l" value="<?=$level_l?>">
											<? $file_name=mktime(date("H"),date("i"),date("s"),date("Y"),date("m"),date("d"));?>
											<input type="hidden" name ="file_name" value="<?=$file_name?>">
											<input type="button" value="<?=$level_l?> 엑셀다운로드" onClick="javascript:go_excel();">
										</td>
</td>
								<tr> 
									<td height="20" align="center">
										오늘 주문한 고객 [ <?=$cnt1?> ]
										&nbsp;&nbsp;이달에 주문한 고객 [ <?=$cnt2?> ]
										&nbsp;&nbsp;주문 취소한 고객 [ <?=$cnt3?> ]
									</td>
								</tr>
							</table>
							<table width="1500" border="0" cellspacing="0" cellpadding="4">
								<tr> 
									<td height="20" width="462">
										결제 방법 
										&nbsp;<select name="sel_kind" style="font-size:12px;">
										<option value="" <?if ($sel_kind=='') echo("selected")?>>전체</option>
                         				<option value="2" <?if ($sel_kind=='2') echo("selected")?>>무통장</option>
										<option value="1" <?if ($sel_kind=='1') echo("selected")?>>신용카드</option>
										<option value="5" <?if ($sel_kind=='5') echo("selected")?>>포인트</option>
										</select>
										&nbsp;&nbsp;처리현황
										&nbsp;<select name="sel_status" style="font-size:12px;">
										<option value="">전체</option>
										<option value="주문접수" <?if ($sel_status=='주문접수'){ echo("selected");}?>>주문접수</option>										
										<option value="결제완료" <?if ($sel_status=='결제완료'){ echo("selected");}?>>결제완료</option>
										<option value="주문취소" <?if ($sel_status=='주문취소'){ echo("selected");}?>>주문취소</option>
										<option value="주문자취소" <?if ($sel_status=='주문자취소'){ echo("selected");}?>>주문자취소</option>
										<option value="배송중" <?if ($sel_status=='배송중'){ echo("selected");}?>>배송중</option>
										<option value="배송완료" <?if ($sel_status=='배송완료'){ echo("selected");}?>>배송완료</option>
										<option value="구매확정" <?if ($sel_status=='구매확정'){ echo("selected");}?>>구매확정</option>
										<option value="반송" <?if ($sel_status=='반송'){ echo("selected");}?>>반송</option>
										<option value="반품" <?if ($sel_status=='반품'){ echo("selected");}?>>반품</option>
										</select>
										&nbsp;&nbsp; 
										&nbsp;&nbsp; 
										<input type="button" value="정렬" class="adminbttn" onClick="go_search()">
									</td>
									<td height="20" width="322"> 
										&nbsp;<select name="keyfield" style="font-size:12px;">
										<option value="id" <?if ($keyfield=='id') echo("selected")?>>아이디</option>
										<option value="pay_name" <?if ($keyfield=='pay_name') echo("selected")?>>주문자</option>
										<option value="pay_mobile" <?if ($keyfield=='pay_mobile') echo("selected")?>>휴대폰번호</option>
										<option value="receive_name" <?if ($keyfield=='receive_name') echo("selected")?>>수취인</option>
										
										
										
										</select>
										<input type="text" name="key" value="<?=$key?>" size="16" maxlength="16" class="adminbttn">
										<input type="button" value="검색" class="adminbttn" onClick="go_search()" >
									</td>
								</tr>
								<tr>
									<td colspan="2" align="right">
									<select name="select_status"> -->
										<option value="주문접수" <?if($sel_status=="주문접수"){?>selected<?}?>  style="color:#000000;">주문접수</option>
										<option value="결제완료" <?if($sel_status=="결제완료"){?>selected<?}?> style="color:#cc0066;">결제완료</option>
										<option value="준비중" <?if($sel_status=="준비중"){?>selected<?}?> style="color:#339933;">준비중</option>
										<option value="배송중" <?if($sel_status=="배송중"){?>selected<?}?> style="color:#0033ff;">배송중</option>
										
										<option value="배송완료" <?if($sel_status=="배송완료"){?>selected<?}?> style="color:#000000;">배송완료</option>
										<option value="구매확정" <?if($sel_status=="구매확정"){?>selected<?}?> style="color:#000000;">구매확정</option> 
										<option value="주문취소" <?if($sel_status=="주문취소"){?>selected<?}?> style="color:#cc0066;">주문취소</option>
										<option value="주문자취소" <?if($sel_status=="주문자취소"){?>selected<?}?> style="color:#339933;">주문자취소</option> 
										<option value="반송" <?if($sel_status=="반송"){?>selected<?}?> style="color:#000000;">반송</option>
										<option value="반품" <?if($sel_status=="반품"){?>selected<?}?> style="color:#000000;">반품</option>
										<option value="주문대기" <?if($sel_status=="주문대기"){?>selected<?}?> style="color:#000000;">대기</option>
										<option value="취소" <?if($sel_status=="취소"){?>selected<?}?> style="color:#000000;">취소</option> -->
									 </select>
									<input type="button" value="변경" onClick="javascript:go_modify()" class="adminbttn">
									</td>
								</tr>
							</table>
							<table width="1500" border='0' cellspacing='0' cellpadding='0'>
								<tr><td colspan=9 height=3 bgcolor='#88B7DA'></td></tr>
								<tr align="center" bgcolor='#EBF0F4'>  
									<td width="64" height="25">주문번호</td>
									<td width="99" height="25">주문날짜</td>
									<td width="119" height="25">주문ID</td>
									<td width="117" height="25">주문자</td>
									<td width="118" height="25">주문자전화</td>
									
									<td width="115" height="25">결제방법</td>
									<td width="118" height="25">입금자명</td>
                                    
									<td width="118" height="25">입금금액(포인트사용)</td>
									<td width="103" height="25"><input type="checkbox" name="checkbox" onclick="select_all()"></td>
									<?if($sel_status=="주문취소" || $sel_status=="취소" || $sel_status=="주문자취소"){?>
									<td width="77" height="25">
										<a href="javascript:all_chk();" OnFocus="this.blur()">
										<B>all</B></a>
										<input type="button" value="삭제" onClick="javascript:go_del()" class="adminbttn">
									</td>
									<?}?>
								</tr>
								<tr><td colspan=9 height=1 bgcolor='#f0f0f0'></td></tr>
								<tr align="center" bgcolor='#EBF0F4'> 
									<td colspan="3" height="25" width="146">제품명</td>
									<td height="25" width="50">수량</td>
									<td height="25" width="50">입금일</td>
									<td height="25" width="50">색상</td>
									
									<td width="118" height="25" colspan="2">매출내역</td>

									<td height="25" width="90">판매가격</td>
								</tr>
								
								<tr align="center" bgcolor='#EBF0F4'> 
									<td colspan=9 height=25>옵션사항</td>
								</tr>


								<tr><td colspan=9 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr><td colspan=9 height=3></td></tr>

<?
#####################################################################

if ($sel_kind!="") $where_sql = "and kind='$sel_kind'";
if ($sel_status!="") $where_sql .= " and status='$sel_status'";

if($key=="") {
	$query = "SELECT * FROM $shop_order WHERE ordernum!='' $where_sql $where_date1 $where_date2 ORDER BY signdate DESC";
} else {
	$encoded_key = urlencode($key);
	$query = "SELECT * FROM $shop_order WHERE ordernum!='' and $keyfield LIKE '%$key%' $where_sql $where_date1 $where_date2 $theme_sql ORDER BY signdate DESC";
}


$DB->get($query,$rs,$rn);
$total_record =$rn;


if ($page=="") $page=1;
$num_per_page = 10;
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
$ii=0;

for($i = $first; $i <= $last; $i++) { 
	$ordernum =$rs[$i]["ordernum"];
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

	$signdate = date("Y-m-d H:i",$signdate);

	$status1=$status;
	if($status == "결제완료") {
				$status="<font color=#B60000>$status</font>";
	}else if($status == "주문접수" ) {
				$status="<font color=#33CC00>$status</font>";
	}else if($status == "결제실패" ) {
				$status="<font color=#FF0000>$status</font>";
	}else if($status == "입금확인") {
				$status="<font color=#0066CC>$status</font>";
	}else if($status == "입금완료") {
				$status="<font color=#993399>$status</font>";
	}else if($status == "입금확인메일발송") {
				$status="<font color=#CC9900>$status</font>";
	}else if($status == "주문취소") {
				$status="<font color=#000000>$status</font>";
	}else if($status == "배송예정") {
				$status="<font color=#CC66FF>$status</font>";
			
	}else if($status == "배송확인메일발송") {
				$status="<font color=#CC9900>$status</font>";
	}else if($status == "배송중") {
				$status="<font color=#009900>$status</font>";
	}	else if($status == "배송완료") {
				$status="<font color=#CC3300>$status</font>";
	}else if($status == "구매확정") {
				$status="<font color=#CC66FF>$status</font>";
	}	else if($status == "반송") {
				$status="<font color=#0099FF>$status</font>";
	}	else if($status == "반품") {
				$status="<font color=#006699>$status</font>";
	}else {
				$status="<font color=#555555>$status</font>";
	}
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
?>
								<tr align="center"> 
									<td height="26">&nbsp;<?=$ordernum?></a></td>
									<td height="26"><?=$signdate?></td>
									<td height="26"><a href="buyer_info.php?cmenu=order&ordernum=<?=$ordernum?>" class="text02"> &nbsp;<?=$id?></td>
									<td height="26">
										<a href="buyer_info.php?cmenu=order&ordernum=<?=$ordernum?>" class="text02"><?=$pay_name?><!-- <br>(<?=$company?>) --></a>

<?
// $query_etc = "SELECT etc1,etc2 from $member_table WHERE id='$id'";
// $DB->get($query_etc,$rs_etc,$rn_etc);

// $etc1 = $rs_etc[0][0];
// $etc2 = $rs_etc[0][1];

// If(strlen($etc1)>12){
// $klen=12-1;
// while(ord($etc1[$klen]) & 0x80) {$klen--;}
// 	$etc1=substr($etc1,0,12-((12+$klen+1)%2)).".";
// 	}else{
// 	$etc1=$etc1;
// }
?>
<!-- <?if($etc1!=""){?><font onclick="window.open('../member/member_event.php?id=<?=$id?>','','width=500,height=400')" style="cursor:hand;color:#ff6633" >[<?=$etc1?>]</font><?}?>
<?if($etc2!=""){?><font onclick="window.open('../member/member_event.php?id=<?=$id?>','','width=500,height=400')" style="cursor:hand;color:#0066ff">[기타1]</font><?}?>
<?if($etc1=="" && $etc2==""){?><font onclick="window.open('../member/member_event.php?id=<?=$id?>','','width=500,height=400')" style="cursor:hand;">[기타2]</font><?}?> -->
									</td>
									<td height="26"><?=$pay_tel?></td>
									<td height="26"><?=$kind?></td>
									<td height="26"><?=$in_name?></td>
                                        <td><?=number_format($qty)?> (<?=number_format($usepoint)?>)</td>
									<td height="26">
									<?=$status?>
									<input type="checkbox" name="check2<?=$ii?>" value="<?=$ordernum?>">
									<input type="hidden" name="check3<?=$ii?>" value="<?=$id?>">
									<input type="hidden" name="check4<?=$ii?>" value="<?=$status1?>">
									<input type="hidden" name="check5<?=$ii?>" value="<?=$signdate?>">


								

									
									</td>
                                
									<?if($sel_status=="주문취소" || $sel_status=="취소"){?>
									<td align="center"><input type="checkbox" name="check<?=$ii?>" value="<?=$ordernum?>"></td>
									<?}?>
								</tr>
<?
#####################################################################

$query_cc = "SELECT code,title,money,point,count,opt1,opt2,new_opt1,new_opt2,new_opt3,new_opt4,new_opt5 FROM $shop_sell WHERE ordernum='$ordernum'";
$DB->get($query_cc,$rs_cc,$rn_cc);
$total_record_cc = $rn_cc;
$total_money_cc=0;
for ($i_cc=0;$i_cc<$total_record_cc;$i_cc++) {
	
	$code_cc = $rs_cc[$i_cc][0];						$title_cc = $rs_cc[$i_cc][1];	
	$money_cc = $rs_cc[$i_cc][2];					$point2_cc = $rs_cc[$i_cc][3];
	$count_cc = $rs_cc[$i_cc][4];					$opt1_cc = $rs_cc[$i_cc][5];
	$opt2_cc = $rs_cc[$i_cc][6];						$new_opt1_cc = $rs_cc[$i_cc][7];
	$new_opt2_cc = $rs_cc[$i_cc][8];				$new_opt3_cc = $rs_cc[$i_cc][8];
	$new_opt4_cc = $rs_cc[$i_cc][10];				$new_opt5_cc = $rs_cc[$i_cc][11];					
					
	$sum_money_cc = $money_cc * $count_cc;						$point2_cc = $point2_cc * $count_cc;
	$total_money_cc = $total_money_cc + $sum_money_cc;	
	$total_money_num = $total_money_cc;
	$title_cc = stripslashes($title_cc);
	$money_cc =  number_format($money_cc);				$sum_money_cc =  number_format($sum_money_cc);


$query_o = "SELECT option_t1,option_t2,option_t3,option_t4,option_t5 from $shop_goods WHERE code='$code_cc'";

$DB->get($query_o,$rs_o,$rn_o);

$option_t1 = $rs_o[0]["option_t1"];
$option_t2 = $rs_o[0]["option_t2"];
$option_t3 = $rs_o[0]["option_t3"];
$option_t4 = $rs_o[0]["option_t4"];
$option_t5 = $rs_o[0]["option_t5"];

$total_point=$total_point+$point2;//포인트 합계 표시용
#####################################################################
?>
								<tr><td colspan=9 height=1 bgcolor='#f0f0f0'></td></tr>
								<tr align="center"> 
									<td colspan="3" height="26" width="146"><?=$title_cc?></td>
									<td height="25" width="50"><?=$count_cc?> EA</td>
									<td height="25" width="50"><?=$in_day?></td>
									<td height="25" width="50" colspan="2"><?=$opt2_cc?></td>
									<td> <?
									if ($i_cc == 0)
									{
									// echo $json_data['ALL_CASH'];
									}
									?></td>

									<td height="25" width="90"><?=$sum_money_cc?></td>
									
								</tr>
								<?if($new_opt1_cc!=""){?>
								<tr align="left" style="padding-left:170px;"> 
									<td colspan="9" height="26"><?if($new_opt1_cc!=""){?><b><?=$option_t1?></b> : <?=$new_opt1_cc?><?}?><?if($new_opt2_cc!=""){?> <br> <b><?=$option_t2?></b> : <?=$new_opt2_cc?><?}?><?if($new_opt3_cc!=""){?> <br> <b><?=$option_t3?></b> : <?=$new_opt3_cc?><?}?><?if($new_opt4_cc!=""){?> <br> <b><?=$option_t4?></b> : <?=$new_opt4_cc?><?}?><?if($new_opt5_cc!=""){?> <br> <b><?=$option_t5?></b> : <?=$new_opt5?><?}?></td>
								</tr>
								<?}?>
<?}?>
							<input type="hidden" name="check6<?=$ii?>" value="<?=$total_money_num?>">
								<tr><td colspan=9 height=1 bgcolor='#D2DEE8'></td></tr>
<?

   $article_num--;      
   $ii++;
}
$chk_num = $last-$first+1;
?>
							</table>
						</td>
					</tr>
				</table>
				<table width="1500" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
					<tr> 
						<td height="20" align="center"><font color="#666666">
 <?
#####################################################################

 $total_block = ceil($total_page/$page_per_block);
 $block = ceil($page/$page_per_block);
 $first_page = ($block-1)*$page_per_block;
 $last_page = $block*$page_per_block;
 if($total_block <= $block) {
 	$last_page = $total_page;
 }
 
 $mode="keyfield=$keyfield&key=$encoded_key&sel_kind=$sel_kind&sel_status=$sel_status&ydate1=$ydate1&mdate1=$mdate1&ddate1=$ddate1&ydate2=$ydate2&mdate2=$mdate2&ddate2=$ddate2";

 
  if ($page > 1) {
 	$page_num = $page - 1;
?>
							<a href="pro_order.php?<?=$mode?>&page=<?=$page_num?>" onMouseOver="status='이전페이지';return true;" onMouseOut="status=''">◀</a>

<?
 }
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
?>
 							<font color="#666666">&nbsp;<b><?=$direct_page?></b></font>
<?	
	} else {
?>
							&nbsp;<a href="pro_order.php?<?=$mode?>&page=<?=$direct_page?>" onMouseOver="status='go to page $direct_page';return true;" onMouseOut="status=''"><font color="#666666"><?=$direct_page?></font></a>
 <?	
	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
?>
							&nbsp;<a href="pro_order.php?<?=$mode?>&page=<?=$page_num?>" onMouseOver="status='다음페이지';return true;" onMouseOut="status=''">▶</a>
 
 <?
 }
 ?>
							</font>
						</td>
					</tr>
					<input type="hidden" name="page" value="<?=$page?>">   
					<input type="hidden" name="chk_num" value="<?=$chk_num?>">   
					</form>  
				</table>
				<br><br>
<?php pkshop_admin_shell_end(); ?>
