<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../common/user_function.php";

########## 데이터베이스에 연결한다. #################################

include "../inc/top_menu.php";
include "../inc/left_menu_sell.php";

if ($year_e=="" ) {
	
	$year_e = date("Y");
	$month_e = date("m");
	$day_e = date("d");

	$timestamp_s = mktime(0,0,0,$month_e-1,$day_e,$year_e);
	$timestamp_e = mktime(23,59,59,$month_e,$day_e,$year_e);
	$year_s = date("Y",$timestamp_s);
	$month_s = date("m",$timestamp_s);
	$day_s = date("d",$timestamp_s);
	$kind = "2";

}else {
	$timestamp_s = mktime(0,0,0,$month_s,$day_s,$year_s);
	$timestamp_e = mktime(23,59,59,$month_e,$day_e,$year_e);
}

if ($sel_cate=="" || $sel_cate=="r") {
	$sel_code1="00";
	$sel_code2="00";
	$sel_code3="00";
	$sel_code4="00";
}else if ($sel_cate=="1") {
	$sel_code2="00";
	$sel_code3="00";
	$sel_code4="00";
}else if ($sel_cate=="2") {
	$sel_code3="00";
	$sel_code4="00";
}else if ($sel_cate=="3") {
	$sel_code4="00";
}

#####################################################################
?>

<script language="javascript">
<!--
function go_reset() {
	location="offer.php";
}
function go_char() {
	document.form.action="offer.php";
	document.form.submit();
}
function go_select(i) {
	document.form.sel_cate.value=i;
	document.form.action="offer.php";
	document.form.submit();
}
function go_search() {
	document.form.action="offer.php?smod=smod2";
	document.form.submit();
}
function go_rank() {
	document.form.sel_cate.value='r';
	document.form.action="offer.php";
	document.form.submit();
}
//-->
</script>


				<table width="800" border="0" cellspacing="0" cellpadding="0">
					<tr><td height=30></td></tr>
					<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>매출관리</b></td>
								</tr>
							</table>
					</td></tr>
					<tr><td height=3></td></tr>
					<tr><td height=3 bgcolor='#88B7DA'></td></tr>
					<tr> 
						<td align=left> 							
							<table width="800" border='0' cellspacing='0' cellpadding='0'>
      						<form name="form" method="post">
								<tr>
									<td width="100" align="center" bgcolor='#EBF0F4'>상품별</td>
									<td width="700" align="left">
										<table width="700" cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td width="500" height="30">
													&nbsp;<select name="sel_code1" style="font-size:12px;" OnChange="go_select('1');">
													<option value="00" selected>1차카테고리</option>
<?
#####################################################################

$query = "SELECT cate1,code1 FROM $shop_cate WHERE code2='00' and code3='00' and code4='00' ORDER BY order_rank";

$DB->get($query,$rs,$rn);


$total_record = $rn;

for ($i=0;$i<$total_record=$rn;$i++) {
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($sel_code1==$g_code) $oselect = "selected";
	else $oselect = "";

#####################################################################
?>
	
													<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?               
}
?>

													</select>
													<select name="sel_code2" style="font-size:12px;" OnChange="go_select('2');">
													<option value="00" selected>2차카테고리</option>
<?
#####################################################################

$query = "SELECT cate2,code2 FROM $shop_cate WHERE code1='$sel_code1' and code2!='00' and code3='00' and code4='00' ORDER BY order_rank";
$DB->get($query,$rs,$rn);
$total_record =$rn;

for ($i=0;$i<$total_record=$rn;$i++) {
	$curr_i=$i+1;
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($sel_code2==$g_code) $oselect = "selected";
	else $oselect = "";
?>
            										<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?              
}
?>
													</select>
													<select name="sel_code3" style="font-size:12px;" OnChange="go_select('3');">
													<option value="00" selected>3차카테고리</option>
<?
#####################################################################

$query = "SELECT cate3,code3 FROM $shop_cate WHERE code1='$sel_code1' and code2='$sel_code2' and code3!='00' and code4='00' ORDER BY order_rank";
$DB->get($query,$rs,$rn);

for ($i=0;$i<$total_record=$rn;$i++) {
	$curr_i=$i+1;
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($sel_code3==$g_code) $oselect = "selected";
	else $oselect = "";

#####################################################################
?>
													<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?
}
?>
													</select>
													<select name="sel_code4" style="font-size:12px;" OnChange="go_select('4');">
													<option value="00" selected>4차카테고리</option>
<?
#####################################################################

$query = "SELECT cate4,code4 FROM $shop_cate WHERE code1='$sel_code1' and code2='$sel_code2' and code3='$sel_code3' and code4!='00' ORDER BY order_rank";
$DB->get($query,$rs,$rn);

for ($i=0;$i<$total_record=$rn;$i++) {
	$curr_i=$i+1;
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($sel_code4==$g_code) $oselect = "selected";
	else $oselect = "";

#####################################################################
?>
													<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?
}
?>
													</select>
													<select name="sel_goods" style="font-size:12px;">
													<option value="" selected>상품리스트</option>
<?
#####################################################################

$query = "SELECT code,title FROM $shop_goods WHERE code1='$sel_code1' and code2='$sel_code2' and code3='$sel_code3' and code4='$sel_code4' ORDER BY signdate desc";
$DB->get($query,$rs,$rn);
$total_record =$rn;

for ($i=0;$i<$total_record=$rn;$i++) {
	$code =$rs[$i][0];
	$title =$rs[$i][1];
	$title = stripslashes($title);

	if ($code==$sel_goods) $oselect = "selected";
	else $oselect = "";

#####################################################################
?>

													<option value="<?=$code?>" <?=$oselect?>><?=$title?></option>
<?
}
?>
													</select>
												</td>
												<td width="200">
													<input type="button" value="검색" class="adminbttn" onClick="go_select(3)">
													<input type="button" value="검색초기화" class="adminbttn" onClick="go_reset()">
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr><td colspan=8 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr>
									<td width="100" align="center" height="30" bgcolor='#EBF0F4'>날짜별</td>
									<td width="700" align="left">
										<table width="700" cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td width="500" class="text03">
													&nbsp;<select name="year_s" value="굴림" style="font-size:12px;">
												<?
													for($a=2002;$a<2101;$a++) {
												?>
														<option value="<?=$a?>" 
												<?
														if($year_s==$a) {
														echo("selected");
														}else if ($year_s=='') {
														echo("selected");
														}
												?>><?=$a?></option>
												<?
													}
												?>
													</select>년
													&nbsp;<select name="month_s" value="굴림" style="font-size:12px;">
												<?
													for($b=1;$b<13;$b++) {
													if($b<10) {
														$bb = "0".$b;
													}else {
													$bb = $b;
													}
												?>
													<option value="<?=$bb?>" 
													<?if($month_s==$bb) {
													echo("selected");
													}else if ($month_s=='') {
													echo("selected");
													}
												?>><?=$bb?></option>
												<?
													}
												?>
													</select>월
													&nbsp;<select name="day_s" value="굴림" style="font-size:12px;">
												<?	
													for($c=1;$c<32;$c++) {
													if($c<10) {
													$cc = "0".$c;
													}else {
													$cc = $c;
													}
												?>
													<option value="<?=$cc?>" 
													<?if($day_s==$cc) {
													echo("selected");
													}else if ($day_s=='') {
													echo("selected");
													}
												?>><?=$cc?></option>
												<?
													}
												?>
													</select>일 ~
													&nbsp;<select name="year_e" value="굴림" style="font-size:12px;">
												<?
													for($d=2002;$d<2101;$d++) {
												?>
														<option value="<?=$d?>" 
												<?
														if($year_e==$d) {
														echo("selected");
														}else if ($year_e=='') {
														echo("selected");
														}
												?>><?=$d?></option>
												<?
													}
												?>
												</select>년
												&nbsp;<select name="month_e" value="굴림" style="font-size:12px;">
												<?
													for($e=1;$e<13;$e++) {
													if($e<10) {
														$ee = "0".$e;
													}else {
													$ee = $e;
													}
												?>
													<option value="<?=$ee?>" 
													<?if($month_e==$ee) {
													echo("selected");
													}else if ($month_e=='') {
													echo("selected");
													}
												?>><?=$ee?></option>
												<?
													}
												?>
													</select>월
										            &nbsp;<select name="day_e" value="굴림" style="font-size:12px;">
												<?	
													for($f=1;$f<32;$f++) {
													if($f<10) {
													$ff = "0".$f;
													}else {
													$ff = $f;
													}
												?>
													<option value="<?=$ff?>" 
													<?if($day_e==$ff) {
													echo("selected");
													}else if ($day_e=='') {
													echo("selected");
													}
												?>><?=$ff?></option>
												<?
													}
												?>
													 </select>일
												</td>
												<td width="200">
													<input type="button" value="검색" class="adminbttn" onClick="go_search()">
													<input type="button" value="검색초기화" class="adminbttn" onClick="go_reset()">
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr><td colspan=8 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr>
									<td width="100" align="center" height="30" bgcolor='#EBF0F4'>순위별</td>
									<td width="700" align="left">
										<table width="700" cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td width="500">
													&nbsp;<select name="sel_rank" style="font-size:12px;">
													<option value="num" <?if ($sel_rank=='num') echo("selected")?>>판매량</option>
													<option value="money" <?if ($sel_rank=='money') echo("selected")?>>매출액</option>
													</select>
													<select name="sel_term" style="font-size:12px;">
													<option value="day" <?if ($sel_term=='day') echo("selected")?>>당일</option>
													<option value="week" <?if ($sel_term=='week') echo("selected")?>>주별</option>
													<option value="month" <?if ($sel_term=='month') echo("selected")?>>월별</option>
													<option value="year" <?if ($sel_term=='year') echo("selected")?>>연별</option>
													</select>
												</td>
												<td width="200">
													<input type="button" value="검색" class="adminbttn" onClick="go_rank()">
													<input type="button" value="검색초기화" class="adminbttn" onClick="go_reset()">
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr><td colspan=8 height=1 bgcolor='#D2DEE8'></td></tr>
<?
#####################################################################

if ($sel_cate=='r') {

	$year_ee = date("Y");
	$month_ee = date("m");
	$day_ee= date("d");
	
	if ($sel_term=="day") $timestamp_ss = mktime(0,0,0,$month_ee,$day_ee,$year_ee);
	else if ($sel_term=="week") $timestamp_ss = mktime(0,0,0,$month_ee,$day_ee-7,$year_ee);
	else if ($sel_term=="month") $timestamp_ss = mktime(0,0,0,$month_ee-1,$day_ee,$year_ee);
	else if ($sel_term=="year") $timestamp_ss = mktime(0,0,0,$month_ee,$day_ee,$year_ee-1);
	
	$timestamp_ee = mktime(23,59,59,$month_ee,$day_ee,$year_ee);

	if ($sel_rank=="num") $order_sql = "5 desc";
	else  $order_sql = "4 desc";

	$query = "SELECT ordernum,code,title,SUM(money*count),SUM(count),signdate FROM $shop_sell WHERE signdate>$timestamp_ss and signdate<$timestamp_ee GROUP BY code ORDER BY $order_sql LIMIT 30";
	$sel_cate="";
}
else {
	if ($sel_code1!="00") {
		$where_sql = "and code1='$sel_code1'";
		if ($sel_code2!="00") {
			$where_sql .= " and code2='$sel_code2'";
			
			if ($sel_code3!="00") {
				$where_sql .= " and code3='$sel_code3'";
				if ($sel_code4!="00") {
					$where_sql .= " and code4='$sel_code4'";
				}else{
					$where_sql .= " and code4!='00'";
				}
			}else {
				$where_sql .= " and code3!='00'";
			}

		}else {
			$where_sql .= " and code2!='00'";		
		}		
	}			
	if ($sel_goods!="") $where_sql .= " and code='$sel_goods'";
	$query = "SELECT ordernum,code,title,money*count,count,signdate FROM $shop_sell WHERE signdate>$timestamp_s and signdate<$timestamp_e $where_sql ORDER BY signdate DESC";
}

$DB->get($query,$rs,$rn);
$total_record =$rn;

#####################################################################
?>
								<input type="hidden" name="page" value="<?=$page?>">   
								<input type="hidden" name="chk_num" value="<?=$chk_num?>">   
								<input type="hidden" name="sel_cate" value="<?=$sel_cate?>">   
								</form>  
							</table>
							<br><br>
							<table width="800" border='0' cellspacing='0' cellpadding='0'>
								<tr><td colspan=5 height=3 bgcolor='#88B7DA'></td></tr>
								<tr align="center" bgcolor='#EBF0F4'> 
									<td width="100" height="30" align="center" class="ttext01">번호</td>
									<td width="100" align="center" class="ttext01">날짜</td>
									<td width="400" align="center" class="ttext01">상품명</td>
									<td width="100" align="center" class="ttext01">매출액</td>
									<td width="100" align="center" class="ttext01">주문수</td>
								</tr>
								<tr><td colspan=5 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr><td colspan=5 height=3></td></tr>
<?
#####################################################################

if ($page=="") $page=1;
$num_per_page = 30;
$page_per_block = 20;

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

for($i = $first; $i <= $last; $i++) { 
	$ordernum =$rs[$i][0];
	$code =$rs[$i][1];
	$title =$rs[$i][2];
	$money =$rs[$i][3];
	$count =$rs[$i][4];
	$signdate =$rs[$i][5];
	$title = stripslashes($title);
//	$money = $money * $count;
	$total_money=$total_money+$money;
	
	$money =  number_format($money)."$";
	$signdate = date("Y.m.d",$signdate);
	
	$chkquery = "SELECT status FROM $shop_order WHERE ordernum=$ordernum";
	$chkresult = mysql_query($chkquery,$DBconn);
	if(!$chkresult) {
	   error("QUERY_ERROR");
	   exit;
	}
	$row = mysql_fetch_row($chkresult);
	$chkstatus = $rs[0][0];
	$chkstatus =trim($chkstatus );
	if($chkstatus == "결제완료" || $chkstatus == "입금확인" || $chkstatus == "배송완료" || $chkstatus == "배송중") {
#####################################################################
?>
								<tr>
									<td align="center" height="30"><?=$article_num?></td>
									<td align="center"><?=$signdate?></a></td>
									<td align="center">
										<a href="buyer_info.php?cmenu=order&ordernum=<?=$ordernum?>" class="text02"><?=$title?> <?=$total_money?></a>
									</td>
									<td align="center"><?=$money?></td>
									<td align="center"><?=$count?></td>
								</tr>
								<tr><td colspan=5 height=1 bgcolor='#D2DEE8'></td></tr>
<?
	}
   $article_num--;      
}
$chk_num = $last-$first+1;
?>   		
								<tr bgcolor="#EDEDDA">
									<td colspan="5"><?=$total_money?></td>									
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table width="800" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
					<tr> 
						<td height="20" align="center">
							<font color="#666666">
 <?
 ####################################################################

 $total_block = ceil($total_page/$page_per_block);
 $block = ceil($page/$page_per_block);
 $first_page = ($block-1)*$page_per_block;
 $last_page = $block*$page_per_block;
 if($total_block <= $block) {
 	$last_page = $total_page;
 }
 

 if($smod=="smod2"){				         											$mode="smod=$smod&year_s=$year_s&month_s=$month_s&day_s=$day_s&year_e=$year_e&month_e=$month_e&day_e=$day_e";

}else if($sel_cate="i"){
$mode="smod=$smod&sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&sel_code4=$sel_code4";

}else{
		$mode="keyfield=$keyfield&key=$encoded_key&sel_kind=$sel_kind&sel_status=$sel_status";
}

  if ($page > 1) {
 	$page_num = $page - 1;
?>

							<a href="offer.php?<?=$mode?>&page=<?=$page_num?>" onMouseOver="status='이전페이지';return true;" onMouseOut="status=''">◀</a>

<?
 }
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
?>

							<font color="#666666">&nbsp;<b><?=$direct_page?></b></font>

<?
	} else {
?>
 							&nbsp;<a href="offer.php?<?=$mode?>&page=<?=$direct_page?>" onMouseOver="status='go to page <?=$direct_page?>';return true;" onMouseOut="status=''"><font color="#666666"><?=$direct_page?></font></a>
 <?	
	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
?>
 	
							&nbsp;<a href="offer.php?<?=$mode?>&page=<?=$page_num?>" onMouseOver="status='다음페이지';return true;" onMouseOut="status=''">▶</a>
 
 <?
 }
 ?>
          
							</font>
						</td>
					</tr>
				</table>
				<br><br>
<? include "../inc/down_menu.php"; ?>
