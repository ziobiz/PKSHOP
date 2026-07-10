<?
#####################################################################
// error_reporting( E_ALL );
//   ini_set( "display_errors", 1 );

include "../common/user_function.php";
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_member.php";

$encoded_key = urlencode($key);
$query = "SELECT *from $member_table where 1=1 ";

if($key != ""){
	if($keyfield=="C_ADDR"){
		$query = $query." and (C_ADDR LIKE '%$key%' or C_ADDR2 LIKE '%$key%') ";
	}else{
		$query = $query." and $keyfield LIKE '%$key%' ";
	}
}

// if($sex!='0' and $sex!=''){
// 	$query = $query."and sex='$sex' ";
// }

// if($job!='0' and $job!=''){
// 	$query = $query."and job='$job' ";
// }


if($member_count=="1"){
	$query = $query."ORDER BY c_code DESC";	
}else if($member_count=="2"){
	$query = $query."ORDER BY c_code";	
}else{
	$query = $query."ORDER BY c_date DESC";	
}

$DB->get($query,$rs,$rn);
$total_record=$rn;
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

function go_status(kk) {
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
				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0" class="left_margin30">
				
					<tr><td height=30></td></tr>
					<tr><td>
							<table width="100%" border=0 cellpadding=0 cellspacing=0>
								</table>
					</td></tr>
					<form name="form" method="post">
					<tr><td height=3></td></tr>
					<tr>
						<td>							 
								<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="4">
									<tr> 
										
										<td height="20" align="left"> 
											
											
											<!-- 직업 
											<select size="1" name="job">
											<option value="0" <?if($job=="0" || $job==""){?>selected<?}?>>무직</option>     
											 <option value="1" <?if($job=="1"){?>selected<?}?>>학생</option>     
											 <option value="2" <?if($job=="2"){?>selected<?}?>>컴퓨터/인터넷</option> 
											 <option value="3" <?if($job=="3"){?>selected<?}?>>언론</option>     
											 <option value="4" <?if($job=="4"){?>selected<?}?>>공무원</option>     
											 <option value="5" <?if($job=="5"){?>selected<?}?>>군인</option>     
											 <option value="6" <?if($job=="6"){?>selected<?}?>>서비스업</option>     
											 <option value="7" <?if($job=="7"){?>selected<?}?>>교육</option>     
											 <option value="8" <?if($job=="8"){?>selected<?}?>>금융/증권/보험업</option>     
											 <option value="9" <?if($job=="9"){?>selected<?}?>>유통업</option>     
											 <option value="10" <?if($job=="10"){?>selected<?}?>>예술</option>     
											 <option value="11" <?if($job=="11"){?>selected<?}?>>의료</option>     
											 <option value="12" <?if($job=="12"){?>selected<?}?>>법률</option>     
											 <option value="13" <?if($job=="13"){?>selected<?}?>>건설업</option>     
											 <option value="14" <?if($job=="14"){?>selected<?}?>>제조업</option>     
											 <option value="15" <?if($job=="15"){?>selected<?}?>>부동산업</option>     
											 <option value="16" <?if($job=="16"){?>selected<?}?>>운송업</option>     
											 <option value="17" <?if($job=="17"){?>selected<?}?>>농/수/임/광산업</option>     
											 <option value="18" <?if($job=="18"){?>selected<?}?>>가사</option>     
											 <option value="19" <?if($job=="19"){?>selected<?}?>>기타</option> 											
											</select> -->
											&nbsp;&nbsp;
											<select name="keyfield">
											<option value="C_ID" <?if ($keyfield=='C_ID') echo("selected");?>>아이디</option>
											<option value="C_NAME" <?if ($keyfield=='C_NAME') echo("selected");?>>이름</option>
											<option value="C_ADDR" <?if ($keyfield=='C_ADDR') echo("selected");?>>주소</option>
											<option value="C_HAND" <?if ($keyfield=='C_HAND') echo("selected");?>>휴대폰번호</option> 
											
											</select>
											<input type="text" name="key" value="<?=$key?>"size="16" maxlength="16" class="adminbttn">
											
											<input type="button"  value="검색" class="adminbttn" onClick="javascript:go_search()">
										</td>
									</tr>
									<!-- <tr>
										<td>
										<table width="800" border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td>
													<b><<a href="member.php?dis=<?=$dis?>"><font color="#CC0000">[가입일순]</font></a>&nbsp;
													 <a href="member.php?dis=<?=$dis?>&member_count=2"><font color="#006DDB">[접속수 내림정렬]</a></font>&nbsp;
													<a href="member.php?dis=<?=$dis?>&member_count=1"><font color="#EA7500">[접속수 올림정렬]</a></font></b> 
												</td>
												<td align="right">
												<input type="button" value="일반회원변경" class="adminbttn" onClick="javascript:go_status('member_edit.php?<?=$mode?>&page=<?=$page?>&sel_dis=0')">
												<input type="button" value="판매회원변경" class="adminbttn" onClick="javascript:go_status('member_edit.php?<?=$mode?>&page=<?=$page?>&sel_dis=1')">
												<input type="button" value="대기회원변경" class="adminbttn" onClick="javascript:go_status('member_edit.php?<?=$mode?>&page=<?=$page?>&sel_dis=2')">
												</td>
											</tr>
										</table>
										</td>
									</tr> -->
								</table>
								<table width="900" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=7 height=3 bgcolor='#88B7DA'></td></tr>
									<tr align="center" bgcolor='#EBF0F4'> 
										<td width="50" height="30">번호</td>
										<td width="80" height="30">아이디</td>
										<td width="100" height="30">이름</td>
										<td width="100" height="30">핸드폰</td>
										<td width="250" height="30">주소</td>
										<td width="200" height="30">이메일</td>
										<td width="90" height="30">가입일</td>
										<!-- <td width="40" height="30"> 
											 <input type="button" value="삭제" class="adminbttn" onClick="javascript:go_del('member_del.php?<?=$mode?>&page=<?=$page?>')"> 
										</td> -->
									</tr>
									<tr><td colspan=7 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr><td colspan=7 height=3></td></tr>
<?
#####################################################################

$ii=0;
for($i = $first; $i <= $last; $i++) { 
	$id =$rs[$i]["C_ID"];
	$name =$rs[$i]["C_NAME"];
	$passwd =$rs[$i]["c_pass"];
	$email =$rs[$i]["C_EMAIL"];
	$signdate =$rs[$i]["C_DATE"];
	$dis1 =$rs[$i][5];
	$company =$rs[$i][6];
	$member_cnt =$rs[$i][7];
	$etc1 =$rs[$i][8];
	$etc2 =$rs[$i][9];
	$handphone =$rs[$i]["C_HAND"];
	$zip =$rs[$i]["C_ZIP"];
	$addr =$rs[$i]["C_ADDR"];
	$addr2 =$rs[$i]["C_ADDR2"];

	//if($etc1!="") $etc1="<font color='#ff0000'>[E]</font>";
	//if($etc2!="") $etc2="<font color='#0000ff'>[M]</font>";
	if($dis1=="0" || $dis1=="") $dis1="미승인";
	if($dis1=="1") $dis1="승인";
	// $signdate = date("Y-m-d",$signdate);

	if(($i+1)%2==0){
		$kk_bgcolor="#FFFFFF";
	}else{
		$kk_bgcolor="#F6F6F6";
	}

	
#####################################################################
?>
								<tr align="center"> 
									<td height="30"><?=$article_num?></td>
									<td height="30"><?=$id?> </td>
									<td height="30"><B><?=$name?></B><!-- <a href="../product/products.php?soldout=A&P_id=<?=$id?>" target="_blank">[상품]</a> -->
										</a>
									</td>
									<td><?=$handphone?></td>
									<td height="30" align="left">[<?=$zip?>] <?=$addr?> <?=$addr2?></td>
									<td height="30" align="right"><?=$email?>
										<!-- <input type="button" value="메일발송" class="adminbttn" onClick="javascript:go_mail('<?=$email?>')"> -->
										 </td>
									<td height="30"><?=$signdate?></td>
									<!-- <td height="30"> 
										<input type="checkbox" name="check<?=$ii?>" value="<?=$id?>">
									</td> -->
								</tr>
								<!-- <tr><td colspan=7 height=10 align="center">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" height=10>
									<tr bgcolor='#EBF0F4'>
										<td width="160">
								
								
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
								### 현재달 판매가격 ##########################################################

								$mkt = mktime(0,0,0,date("m")-2,1,date("Y"));
								$nmkt = mktime(0,0,0,date("m")-1,1,date("Y"));

								$cond = "ss.ordernum=so.ordernum and ss.signdate>".$mkt." and ss.signdate <".$nmkt." and  so.status='배송완료'";	
								$query_P = "SELECT ss.ordernum,ss.code,ss.title,ss.money,ss.count,so.kind FROM $shop_sell as ss,$shop_order as so where so.id='$id' and $cond order by ss.ordernum desc";
								
$DB->get($query_P,$rs_p,$rn_p);
$total_record_P=$rn_p;
								$cnt = $total_record_P;  //주문건수 초기화
								$mcnt = $total_record_P; //월별 주문수
								$tcnt = $tcnt + $cnt;  //토탈 주문수
								$bordnum = "";         //이전 주문번호 초기화
								$vtmmoney = 0;

								for($j = 0; $j < $total_record_P; $j++) {
									$ordernum = $rs_p[$j][0];
									$code = $rs_p[$j][1];
									$title = $rs_p[$j][2];
									$money = $rs_p[$j][3];
									$count = $rs_p[$j][4];
									$kind = $rs_p[$j][5];

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
								<?=date("m")-2?>월 : <?=$vtmmoney?> (<?=$mcnt?>건)
								</td>
								<td width="160">

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
								### 현재달 판매가격 ##########################################################

								$mkt = mktime(0,0,0,date("m")-1,1,date("Y"));
								$nmkt = mktime(0,0,0,date("m"),1,date("Y"));

								$cond = "ss.ordernum=so.ordernum and ss.signdate>".$mkt." and ss.signdate <".$nmkt." and so.status='배송완료'";	
								$query_P = "SELECT ss.ordernum,ss.code,ss.title,ss.money,ss.count,so.kind FROM $shop_sell as ss,$shop_order as so where so.id='$id' and $cond order by ss.ordernum desc";

$DB->get($query_P,$rs_p,$rn_p);
$total_record_P=$rn_p;
								$cnt = $total_record_P;  //주문건수 초기화
								$mcnt = $total_record_P; //월별 주문수
								$tcnt = $tcnt + $cnt;  //토탈 주문수
								$bordnum = "";         //이전 주문번호 초기화
								$vtmmoney = 0;

								for($j = 0; $j < $total_record_P; $j++) {
									$ordernum = $rs_p[$j][0];
									$code = $rs_p[$j][1];
									$title = $rs_p[$j][2];
									$money = $rs_p[$j][3];
									$count = $rs_p[$j][4];
									$kind = $rs_p[$j][5];

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
								<?=date("m")-1?>월 : <?=$vtmmoney?> (<?=$mcnt?>건)
								</td>
								<td width="160">
								
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

								### 현재달 판매가격 ##########################################################

								$mkt = mktime(0,0,0,date("m"),1,date("Y"));
								$nmkt = mktime(0,0,0,date("m")+1,1,date("Y"));

								$cond = "ss.ordernum=so.ordernum and ss.signdate>".$mkt." and ss.signdate <".$nmkt." and so.status='배송완료'";	
								$query_P = "SELECT ss.ordernum,ss.code,ss.title,ss.money,ss.count,so.kind FROM $shop_sell as ss,$shop_order as so where so.id='$id' and $cond order by ss.ordernum desc";

$DB->get($query_P,$rs_p,$rn_p);
$total_record_P=$rn_p;
								$cnt = $total_record_P;  //주문건수 초기화
								$mcnt = $total_record_P; //월별 주문수
								$tcnt = $tcnt + $cnt;  //토탈 주문수
								$bordnum = "";         //이전 주문번호 초기화
								$vtmmoney = 0;

								for($j = 0; $j < $total_record_P; $j++) {
									$ordernum = $rs_p[$j][0];
									$code = $rs_p[$j][1];
									$title = $rs_p[$j][2];
									$money = $rs_p[$j][3];
									$count = $rs_p[$j][4];
									$kind = $rs_p[$j][5];

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
								<?=date("n")?>월 : <?=$vtmmoney?> (<?=$mcnt?>건)
								</td>
								<td width="220">

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

								### 현재달 판매가격 ##########################################################

								$mkt = mktime(0,0,0,date("m"),1,date("Y"));
								$nmkt = mktime(0,0,0,date("m")+1,1,date("Y"));

								$cond = "ss.ordernum=so.ordernum and so.status='배송완료'";	
								$query_P = "SELECT ss.ordernum,ss.code,ss.title,ss.money,ss.count,so.kind FROM $shop_sell as ss,$shop_order as so where so.id='$id' and $cond order by ss.ordernum desc";

$DB->get($query_P,$rs_p,$rn_p);
$total_record_P=$rn_p;
								$cnt = $total_record_P;  //주문건수 초기화
								$mcnt = $total_record_P; //월별 주문수
								$tcnt = $tcnt + $cnt;  //토탈 주문수
								$bordnum = "";         //이전 주문번호 초기화
								$vtmmoney = 0;

								for($j = 0; $j < $total_record_P; $j++) {
									$ordernum = $rs_p[$j][0];
									$code = $rs_p[$j][1];
									$title = $rs_p[$j][2];
									$money = $rs_p[$j][3];
									$count = $rs_p[$j][4];
									$kind = $rs_p[$j][5];

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

								

								##################################################################
								if($member_cnt==0){
									$member_cnt=1;
								}
								if($mcnt>0){
									$all_p=($mcnt/$member_cnt)*100;
								}else{
									$all_p=0;
								}
								?>
								 전체 : <?=$vtmmoney?> (<?=$mcnt?>건)
								</td>
								<td>

								<a href="#" onclick="window.open('../product/order_month_user.php?Sub_No=1&user_id=<?=$id?>&sel_status=주문접수','','width=800,height=600');">매출통계(<?=floor($all_p)?>%)</a>
								</td>
								</tr>
								</table>
								</td></tr> -->
								<tr><td colspan=7 height=1 bgcolor='#D2DEE8'></td></tr>

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
				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
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

if($page!='1'){
	echo "<a href=\"member.php?$mode&page=1\" onMouseOver=\"status='';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">처음</a>&nbsp;";
}
 if ($page > 1) {
 	$page_num = $page - 1;
 	echo "<a href=\"member.php?$mode&page=$page_num\" onMouseOver=\"status='이전페이지';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">◀</font></a>&nbsp;";
 }
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
 		echo "<font color=\"#666666\">&nbsp;<b>$direct_page</b></font>&nbsp;";
 	} else {
 		echo "&nbsp;<a href=\"member.php?$mode&page=$direct_page\" onMouseOver=\"status='go to page $direct_page';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">$direct_page</font></a>&nbsp;";
 	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
 	echo "&nbsp;<a href=\"member.php?$mode&page=$page_num\" onMouseOver=\"status='다음페이지';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">▶</font></a>&nbsp;";
 }
if($page!=$total_page){
	echo "<a href=\"member.php?$mode&page=$total_page\" onMouseOver=\"status='';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">마지막</a>";
}
 ?>
							</font> 
						</td>
					</tr>
					<input type="hidden" name="chk_num" value="<?echo($chk_num)?>">  
					</form>  
				</table>
				<br><br>
<? include "../inc/down_menu.php"; ?>
