<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include_once "../inc/admin_shell_lib.php";
include "../common/user_function.php";

########## 데이터베이스에 연결한다. #################################

include "../inc/set_com.php";
?>
<?php pkshop_admin_auto_shell_begin(); ?>
<script language="javascript">
<!--
function go_modify() {
	document.form.action="buyer_info_ok.php";
	document.form.submit();
}
function go_list() {
	document.form.action="pro_order.php";
	document.form.submit();
}
//-->
</script> 

<?
#####################################################################

$query="SELECT pay_name,pay_tel,pay_mobile,pay_zip1,pay_zip2";
$query=$query.",pay_addr,pay_email,receive_name,receive_tel,receive_mobile,receive_zip1";
$query=$query.",receive_zip2,receive_addr,receive_email,receive_etc,kind,bank,pointout";
$query=$query.",in_name,in_year,in_month,in_day,charge,status,passwd,signdate,id,char_year";
$query=$query.",char_month,char_day,char_num,usepoint";
$query=$query." FROM ";
$query=$query." $shop_order WHERE ordernum='$ordernum'";

	
	$DB->get($query,$rs,$rn);
	
	
	
	
	
	$pay_name = $rs[0][0];								$pay_tel = $rs[0][1];
	$pay_mobile = $rs[0][2];							$pay_zip1 = $rs[0][3];
	$pay_zip2 = $rs[0][4];								$pay_addr = $rs[0][5];
	$pay_email = $rs[0][6];								$receive_name = $rs[0][7];
	$receive_tel = $rs[0][8];							$receive_mobile = $rs[0][9];
	$receive_zip1 = $rs[0][10];						$receive_zip2 = $rs[0][11];
	$receive_addr = $rs[0][12];						$receive_email = $rs[0][13];
	$receive_etc = $rs[0][14];							$kind = $rs[0][15];
	$bank = $rs[0][16];									$point = $rs[0][17];
	$in_name = $rs[0][18];								$in_year = $rs[0][19];
	$in_month = $rs[0][20];								$in_day = $rs[0][21];
	$charge = $rs[0][22];								$ostatus = $rs[0][23];
	$passwd = $rs[0][24];								$signdate = date("Y.m.d",$rs[0][25]);
	$id = $rs[0][26];										$char_year = $rs[0][27];
	$char_month = $rs[0][28];							$char_day = $rs[0][29];
	$char_num = $rs[0][30];	
	$usepoint = $rs[0][31];
	$curr_day = date("Y")."년 ".date("m")."월 ".date("d")."일";	
	$curr_year = date("Y");
	$curr_month = date("m");
	$curr_date = date("d");
	$receive_etc = str_replace( chr(13),"<br>",$receive_etc );

$ostatus_tmp=$ostatus;
#####################################################################
?>
				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0" class="left_margin30">
					<tr><td height=30></td></tr>
					<form name="form" method="post" action="buyer_info_ok.php">
					<tr>
						<td> 									
							<p>주문번호 : <?=$ordernum?> <?=$pay_name?>님의 주문내역입니다. (아이디 : <?=$id?>)</p>
							<b>&lt;주문자 정보&gt; </b> 
							<table width="700" border='0' cellspacing='0' cellpadding='0'>
								<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=2 height=5></td></tr>
								<tr> 
									<td width="115" height="30" align="center">이름</td>
									<td width="479" height="30">
										&nbsp;<?=$pay_name?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width="115" height="30" align="center">e-mail</td>
									<td width="479" height="30">
										&nbsp;<?=$pay_email?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width="115" height="30" align="center">전화번호</td>
									<td width="479" height="30">
										&nbsp;<?=$pay_tel?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<!-- <tr> 
									<td width="115" height="30" align="center">휴대폰</td>
									<td width="479" height="30">
										&nbsp;<?=$pay_mobile?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
								<tr> 
									<td width="115" height="30" align="center">우편번호</td>
									<td width="479" height="30">
										&nbsp;<?=$pay_zip1?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width="115" height="30" align="center">주소</td>
									<td width="479" height="30">
										&nbsp;<?=$pay_addr?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
							</table>
							<p> <b>&lt;주문상품 정보&gt; </b> 
							<table width="700" border='0' cellspacing='0' cellpadding='0'>
								<tr><td colspan=8 height=3 bgcolor='#88B7DA'></td></tr>
								<tr align="center" bgcolor='#EBF0F4'> 
									<td height="25" width="90">주문날짜</td>
									<td height="25" width="63">상품코드</td>
									<td height="25" width="146">상품명</td>
									<td height="25" width="50">수량</td>
									<td height="25" width="50">사이즈</td>
									<td height="25" width="50">색상</td>
									<td height="25" width="90">판매가격</td>
									<!-- <td height="25" width="50">현금가격</td> -->
									<!-- <td height="25" width="50">사용코인</td> -->
								</tr>
								<tr><td colspan=8 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr><td colspan=8 height=3></td></tr>
<?
#####################################################################

$query = "SELECT code,title,money,point,count,opt1,opt2,new_opt1,new_opt2,new_opt3,new_opt4,new_opt5,company,com_num,prices,coin FROM $shop_sell WHERE ordernum='$ordernum'";
$DB->get($query,$rs,$rn);
for ($i=0;$i<$total_record=$rn;$i++) {
	
	$code =$rs[$i][0];						$title =$rs[$i][1];	
	$money =$rs[$i][2];					$point2 =$rs[$i][3];
	$count =$rs[$i][4];					$opt1 =$rs[$i][5];
	$opt2 =$rs[$i][6];						$new_opt1 =$rs[$i][7];
	$new_opt2 =$rs[$i][8];				$new_opt3 =$rs[$i][8];
	$new_opt4 =$rs[$i][10];				$new_opt5 =$rs[$i][11];	
	$company =$rs[$i][12];				$com_num =$rs[$i][13];
	$prices  =$rs[$i][14];
	$coins   =$rs[$i][15];


	$sum_money = $money * $count;						$point2 = $point2 * $count;
	$total_money = $total_money + $sum_money;		$title = stripslashes($title);
	$total_money_num=$total_money;
	$money =  number_format($money)."$";				$sum_money =  number_format($sum_money)."$";

	$real_sale = $prices	* $count;	

	if ($real_sale < 50)
	{
		$real_sale = $real_sale + 3;
	}
	$view_sale =  number_format($real_sale)."$";
	$coin_total = $coins* $count;

$query_o = "SELECT option_t1,option_t2,option_t3,option_t4,option_t5 from $shop_goods WHERE code='$code'";
$DB->get($query_o,$rs_o,$rn_o);

$option_t1 = $rs_o[0]["option_t1"];
$option_t2 = $rs_o[0]["option_t2"];
$option_t3 = $rs_o[0]["option_t3"];
$option_t4 = $rs_o[0]["option_t4"];
$option_t5 = $rs_o[0]["option_t5"];

$total_point=$total_point+$point2;//포인트 합계 표시용
#####################################################################
?>
								<tr align="center"> 
									<td height="25" width="90"><?=$signdate?></td>
									<td height="25" width="63"><?=$code?></td>
									<td height="25" width="146"><?=$title?></td>
									<td height="25" width="50"><?=$count?> EA</td>
									<td height="25" width="50"><?=$opt1?></td>
									<td height="25" width="50"><?=$opt2?></td>
									<td height="25" width="90"><?=$sum_money?></td>
									<!-- <td height="25" width="90"><?=$view_sale?></td> -->
									<!-- <td height="25" width="90"><?=number_format($coin_total)?></td> -->
								</tr>
								
								<tr align="left" style="padding-left:170px;"> 
									<td colspan=4 height=25>
									<?if($new_opt1!=""){?>
									<?if($new_opt1!=""){?><b><?=$option_t1?></b> : <?=$new_opt1?><?}?><?if($new_opt2!=""){?> <br> <b><?=$option_t2?></b> : <?=$new_opt2?><?}?><?if($new_opt3!=""){?> <br> <b><?=$option_t3?></b> : <?=$new_opt3?><?}?><?if($new_opt4!=""){?> <br> <b><?=$option_t4?></b> : <?=$new_opt4?><?}?><?if($new_opt5!=""){?> <br> <b><?=$option_t5?></b> : <?=$new_opt5?><?}?>
									<?}?>
									</td>
									<td colspan=4 height=25 align="right">
										<select name="company<?=$i?>">
											<option value="CJ대한통운" <?if($company=="CJ대한통운"){?>selected<?}?>>CJ대한통운</option>
											<option value="우체국택배" <?if($company=="우체국택배"){?>selected<?}?>>우체국택배</option>
											<option value="한진택배" <?if($company=="한진택배"){?>selected<?}?>>한진택배</option>
											<option value="롯데택배" <?if($company=="롯데택배"){?>selected<?}?>>롯데택배</option>
											<option value="KG로지스" <?if($company=="KG로지스"){?>selected<?}?>>KG로지스</option>
											<option value="KGB택배" <?if($company=="KGB택배"){?>selected<?}?>>KGB택배</option>
											<option value="경동택배" <?if($company=="경동택배"){?>selected<?}?>>경동택배</option>
											<option value="일양로지스" <?if($company=="일양로지스"){?>selected<?}?>>일양로지스</option>
											<option value="로젠택배" <?if($company=="로젠택배"){?>selected<?}?>>로젠택배</option>
											<option value="편의점택배" <?if($company=="편의점택배"){?>selected<?}?>>편의점택배</option>
											<option value="대신택배" <?if($company=="대신택배"){?>selected<?}?>>대신택배</option>
											<option value="합동택배" <?if($company=="합동택배"){?>selected<?}?>>합동택배</option>
											<option value="건영택배" <?if($company=="건영택배"){?>selected<?}?>>건영택배</option>
										</select>
										<input type="text" name="com_num<?=$i?>" value="<?=$com_num?>">
										<input type="hidden" name="com_code<?=$i?>" value="<?=$code?>">
									</td>
								</tr>
								
								<tr><td colspan=8 height=1 bgcolor='#D2DEE8'></td></tr>

<?
#####################################################################

}
$total_settle = $total_money + $charge;
$total_input = $total_settle ;
$total_money =  number_format($total_money)."$";
$charge =  number_format($charge)."$";
$total_settle =  number_format($total_settle)."$";
$total_input =  number_format($total_input-$usepoint)."$";


	if ($kind=="2") { //kind 1: 무통장입금
		$tmp1 = "무통장입금";
		$tmp2 = "입금하실 금액 : $total_input &nbsp;&nbsp;&nbsp;";
	}
	else if ($kind=="1") { //kind 2: 카드결제
		$tmp1 = "카드결제";
		$tmp2 = "카드결제금액:$total_input &nbsp;&nbsp;&nbsp; 승인번호:$bank";
	}
	else if ($kind=="3") { //kind 3: 온라인입금
		$tmp1 = "계좌이체";
		$tmp2 = "입금하실 금액 : $total_input &nbsp;&nbsp;&nbsp; 입금하실 계좌명:$bank";
	}
	else if ($kind=="4") { //kind 4: 무통장입금 + 적립금
		$tmp1 = "무통장입금 + 적립금";
		$tmp2 = "입금하실 금액 : $total_input &nbsp;&nbsp;&nbsp; 입금하실 계좌명:$bank";
	}
	else if ($kind=="5") { //kind 5: 카드결제 + 적립금
		$tmp1 = "포인트";
		$tmp2 = "카드결제금액:$total_input &nbsp;&nbsp;&nbsp; 승인번호:$bank";
	}
	else if ($kind=="6") { //kind 6: 온라인입금 + 적립금
		$tmp1 = "온라인입금 + 적립금";
		$tmp2 = "입금하실 금액 : $total_input &nbsp;&nbsp;&nbsp; 입금하실 계좌명:$bank";
	}
	else if ($kind=="7") { //kind 7: 적립금
		$tmp1 = "적립금";
	}
	else {					//그외
		$tmp1 = "기타";
		$tmp2 = "입금하실 금액 : $total_input &nbsp;&nbsp;&nbsp; 입금하실 계좌명:$bank";
	}


if ($usepoint!="") $tmp2.="<br>&nbsp;&nbsp; (총합계 $total_settle - 포인트 $usepoint point)";


#####################################################################
?>
							<input type="hidden" name="com_no" value="<?=$total_record?>">
							</table>
							<br>
							<table width="700" border='0' cellspacing='0' cellpadding='0'>
								<tr align="center" bgcolor='#EBF0F4'> 
									<td height="25" width="60">합계금액</td>
									<td height="25" width="100" align="left">&nbsp;<?=$total_money?></td>
									<td height="25" width="50">배송비</td>
									<td height="25" width="100"align="left">&nbsp;<?=$charge?></td>
									<!-- <td height="25" width="50">포인트사용</td>
									<td height="25" width="100"align="left">&nbsp;<?=$usepoint?></td> -->
									<!-- <td height="25" width="50">코인적립</td>
									<td height="25" width="100"align="left">&nbsp;<?=$total_point?></td> -->
									<td height="25" width="40">총액</td>
									<td height="25" width="100" align="left">&nbsp;<?=$total_settle?></td>
								</tr>
								<tr><td colspan=8 height=3 bgcolor='#88B7DA'></td></tr>
							</table>
							<p><b>&lt;수취인 정보&gt;</b>
							<table width="700" border='0' cellspacing='0' cellpadding='0'>
								<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=2 height=5></td></tr>
								<tr> 
									<td width="120" height="30" align="center">이름</td>
									<td width="479" height="30">
										&nbsp;<?=$receive_name?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<!-- <tr> 
									<td width="120" height="30" align="center">e-mail</td>
									<td width="479" height="30">
										&nbsp;<?=$receive_email?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>-->
								<tr> 
									<td width="120" height="30" align="center">전화번호</td>
									<td width="479" height="30">
										&nbsp;<?=$receive_tel?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> 
								<!--
								<tr> 
									<td width="120" height="30" align="center">휴대폰</td>
									<td width="479" height="30">
										&nbsp;<?=$receive_mobile?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>-->
								<tr> 
									<td width="120" height="30" align="center">우편번호</td>
									<td width="479" height="30">
										&nbsp;<?=$receive_zip1?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width="120" height="30" align="center">주소</td>
									<td width="479" height="30">
										&nbsp;<?=$receive_addr?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width="120" height="30" align="center">특이사항</td>
									<td width="479" height=" 26"style="padding:10">
										<?if($receive_etc=="") echo "-"; else echo($receive_etc);?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
							</table>							
							 <p><b>&lt;지불&gt;</b> 
							<table width="700" border='0' cellspacing='0' cellpadding='0'>							
								<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=2 height=5></td></tr>
								<tr> 
									<td width="599" height="30" align="center" colspan=2>결제상세정보</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width="120" height="30" align="center">지불수단</td>
									<td width="479" height="30">
										&nbsp;<?=$tmp1?>&nbsp;(<?=$bank?>)
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
<?
		if($kind == "1" || $kind == "4" || $kind == 2) { //무통장 입금
?>
								<tr>
									<td width="120" height="30" align="center">입금할 금액</td>
									<td width="479" height="30">
										&nbsp;<font color=blue><?=$tmp2?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<!-- <tr>
									<td width="120" height="30" align="center">입금할 금액</td>
									<td width="479" height="30">
										&nbsp;<?=$bank?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
								<tr>
									<td width="120" height="30" align="center">입금자 이름</td>
									<td width="479" height="30">
										&nbsp;<?=$in_name?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr>
									<td width="120" height="30" align="center">포인트사용</td>
									<td width="479" height="30">
										&nbsp;<?=number_format($usepoint)?> 포인트
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<!-- <tr>
									<td width="120" height="30" align="center">입금 예정일</td>
									<td width="479" height="30">
										&nbsp;<?=$in_year?>년<?=$in_month?>월
										<?= $in_day?>일
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
<?
	    }
		else { //그외 결제 모두
?>
								<tr>
									<td width="120" height="30" align="center">결제금액</td>
									<td width="479" height="30">
										&nbsp;<font color=blue><?=$view_sale?></font>&nbsp;
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr>
									<td width="120" height="30" align="center">결제자 이름</td>
									<td width="479" height="30">
										&nbsp;<?=$in_name?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<!-- <tr>
									<td width="120" height="30" align="center">코인사용</td>
									<td width="479" height="30">
										&nbsp;<?=$coins?> GP
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
																<tr>
									<td width="120" height="30" align="center">입금일자</td>
									<td width="479" height="30">
										<?$in_date = $in_year."-".$in_month."-".$in_day?>
										&nbsp;<?=$in_date?>
									</td>
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
<?
		}
?>
							</table>
							<p><b>&lt;처리현황&gt;</b> 
							<table width="700" border='0' cellspacing='0' cellpadding='0'>
							
								<tr><td colspan=4 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=4 height=5></td></tr>
								<tr> 
									<td height="30" align="center" width="120">처리단계</td>
									<td colspan="3" height="30">
										&nbsp; <?=$curr_day?>
										 <?//if ($ostatus=='주문취소') {?>
										<!--  [<font color=red><b>주문취소</b></font>] &nbsp;*취소된 내용은 변경 불가능
										 <input type="hidden" name="ostatus" value="주문취소"> -->
										<?//}else{?>
										&nbsp;<select name="ostatus" style="font-size:12px;">
										<option value="" <?if ($ostatus=='') echo("selected")?>>전체</option>
										<option value="주문접수" <?if ($ostatus=='주문접수') echo("selected")?>>주문접수</option>
										<option value="결제완료" <?if ($ostatus=='결제완료') echo("selected")?>>결제완료</option>
										<option value="준비중" <?if ($ostatus=='준비중') echo("selected")?>>준비중</option>	
										<option value="주문취소" <?if ($ostatus=='주문취소') echo("selected")?>>주문취소</option>										
										<option value="주문자취소" <?if ($ostatus=='주문자취소') echo("selected")?>>주문자취소</option>										
										<option value="배송중" <?if ($ostatus=='배송중') echo("selected")?>>배송중</option>										
										<option value="배송완료" <?if ($ostatus=='배송완료') echo("selected")?>>배송완료</option>
										<option value="구매확정" <?if ($ostatus=='구매확정') echo("selected")?>>구매확정</option>
										<option value="반송" <?if ($ostatus=='반송') echo("selected")?>>반송</option>
										<option value="반품" <?if ($ostatus=='반품') echo("selected")?>>반품</option>								
										</select>
										<?//}?>
									</td>			
									<input type="hidden" name="ostatus_tmp" value="<?=$ostatus_tmp?>">
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td height="30" align="center" width="120">배송일</td>
									<td height="30" width="210">
										&nbsp;
										
										<select name="char_year" value="굴림" style="font-size:12px;">
										<?
											for($a=2002;$a<2101;$a++) {
										?>
										<option value="<?=$a?>" 
										<?
											if($char_year==$a) {
												echo("selected");
											}else if ($char_year=='' && $curr_year == $a) {
											echo("selected");
											}
										?>><?=$a?></option>
										<?
											}
										?>
										</select>년
										
										&nbsp;<select name="char_month" value="굴림" style="font-size:12px;">
										<?
											for($b=1;$b<13;$b++) {
											if($b<10) {
													$bb = "0".$b;
											}else {
													$bb = $b;
											}
										?>
										<option value="<?=$bb?>" 
										<?if($char_month==$bb) {
											echo("selected");
										 }else if ($char_month=='' && $curr_month == $bb) {
											echo("selected");
										}
										?>><?=$bb?></option>
										<?
										}
										?>
										</select>월
										&nbsp;<select name="char_day" value="굴림" style="font-size:12px;">
										<?	
											for($c=1;$c<32;$c++) {
											if($c<10) {
											$cc = "0".$c;
											}else {
											$cc = $c;
											}
										?>
											<option value="<?=$cc?>" 
										<?if($char_day==$cc) {
											echo("selected");
											}else if ($char_day=='' && $curr_date == $cc) {
												echo("selected");
											}
										?>><?=$cc?></option>
										<?
											}
										?>
										</select>일
									</td>
									<td height="30" align="center" width="120">송장번호</td>
									<td height="30">
										&nbsp;<input type="text" name="char_num" value="<?=$char_num?>" size="20" maxlength="20" style="border:1 solid #5A5A5A; font-size:12px;">
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								
							</table>
							<p><b></b> 
							<table width="600" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td align="center">
										<input type="button" value="확인" class="adminbttn" onClick="go_modify()">
										<input type="button" value="취소" class="adminbttn" onClick="history.go(-1)">
										<input type="button" value="목록" class="adminbttn" onClick="go_list()">
									</td>
								</tr>
							</table>
						</td>
					</tr>
								<input type="hidden" name="valid_user" value="<?=$id?>">
								<input type="hidden" name="total_money_num" value="<?=$total_money_num?>">
								<input type="hidden" name="signdate" value="<?=$signdate?>">
								<input type="hidden" name="ordernum" value="<?=$ordernum?>">
								<input type="hidden" name="pay_email" value="<?=$pay_email?>">
								<input type="hidden" name="pay_name" value="<?=$pay_name?>">
      							<input type="hidden" name="key" value="<?=$key?>">   
      							<input type="hidden" name="keyfield" value="<?=$keyfield?>">   
      							<input type="hidden" name="sel_kind" value="<?=$sel_kind?>">   
      							<input type="hidden" name="sel_status" value="<?=$sel_status?>">
								</form>  
				</table> 
				<br><br>
<?php pkshop_admin_shell_end(); ?>
