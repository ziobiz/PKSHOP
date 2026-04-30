<?include "../common/dbconn.php";?>
<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/user_function.php";
########## 데이터베이스에 연결한다. #################################

include "../inc/top_menu.php";
include "../inc/left_menu_product.php"; 
	if ($sel_cate==""){
		$sel_code1="";
		$sel_code2="";
		$sel_code3="";
	}else if ($sel_cate=="1"){
	$sel_code2="";
	$sel_code3="";
	}else if ($sel_cate=="2") {
	$sel_code3="";
}

$shop_img="../shop_img/";
$shop_img_lode="../shop_img/";

?>
<script language="javascript">
<!--
function go_del() {
	document.form.action="products_del.php";
	document.form.submit();
}
function go_tree() {
	document.form.action="../category/category_tree.php";
	document.form.submit();
}

function go_select(i) {
	document.form.sel_cate.value=i;
	document.form.action="products_price.php?chk_order=Y";
	document.form.submit();
}
function go_search() {
	document.form.action="products_price.php";
	document.form.submit();
}
//-->
</script>


				
				<table width="800" border="0" cellspacing="0" cellpadding="0">
				<form name="form" method="post">
					<tr>
						<td>							
							<table width="800" border="0" cellspacing="0" cellpadding="4">
								<tr><td height=30 colspan="2"></td></tr>
								<tr><td colspan="2" class='td14'>
								<img src="../image/icon2.gif" width=45 height=35 border=0><B>상품월별매출</B>
								</td></tr>
								<tr> 
									<td height="20" width="550"> 
										<select name="sel_code1" class="adminbttn" OnChange="go_select('1');">
										<option value="" selected>1 차 카테고리명</option>
<?
#####################################################################

$query = "SELECT cate1,code1 FROM $shop_cate WHERE code2='00' and code3='00' ORDER BY rank";
$DB->get($query,$rs,$rn);
$total_record =$rn;

for ($i=0;$i<$total_record=$rn;$i++){
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($sel_code1==$g_code){
		$oselect = "selected";
	}else{
		$oselect = "";
	}
#####################################################################
	?>

										<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?         
}
?>

										</select>
										&nbsp;
										<select name="sel_code2" class="adminbttn" OnChange="go_select('2');">
										<option value="" selected>2 차 카테고리명</option>
<?
#####################################################################

$query = "SELECT cate2,code2 FROM $shop_cate WHERE code1='$sel_code1' and code2!='00' and code3='00' ORDER BY rank";
$DB->get($query,$rs,$rn);
$total_record =$rn;

for ($i=0;$i<$total_record=$rn;$i++){
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($sel_code2==$g_code){
		$oselect = "selected";
	}else{
		$oselect = "";
	}

#####################################################################
?>
										<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?                  
}
?>

										</select>
										&nbsp;
										<select name="sel_code3" class="adminbttn" OnChange="go_select('3');">
										<option value="" selected>3 차 카테고리명</option>
<?
#####################################################################]

$query = "SELECT cate3,code3 FROM $shop_cate WHERE code1='$sel_code1' and code2='$sel_code2' and code3!='00' ORDER BY rank";
$DB->get($query,$rs,$rn);
$total_record =$rn;

for ($i=0;$i<$total_record=$rn;$i++){
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($sel_code3==$g_code){
		$oselect = "selected";
	}else{
		$oselect = "";
	}
	
#####################################################################
	?>
	
										<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?               
}
?>
										</select>
										<select name="sel_out" class="adminbttn" OnChange="go_select('4');">
											<option value="N">전체</option>
											<option value="Y" <?if($sel_out=="Y"){?>selected<?}?>>품절</option>
										</select>
										&nbsp;
										<br>

<?
if($tday == "") {
	$year_e = date("Y");
	$month_e = date("m");
	$day_e= date("d");

	$mkt = mktime(0,0,0,$month_e,$day_e,$year_e); //현재날짜를 저장형태로 받기
	$nmkt = mktime(0,0,0,$month_e,$day_e+1,$year_e); //현재날짜다음날

	$cond = "ss.ordernum=so.ordernum and ss.signdate>".$mkt." and ss.signdate <".$nmkt." and (so.status = '배송중' or so.status = '배송완료')";	
	
}else {
	$tdate = mktime(0,0,0,$tmonth,$tday,$tyear); //선택된 날짜 이날부터
	$ydate = mktime(0,0,0,$emonth,$eday+1,$eyear); //선택된 날짜 이날까지 다음날

	$cond = "ss.ordernum=so.ordernum and ss.signdate>".$tdate." and ss.signdate <".$ydate." and (so.status = '배송중' or so.status = '배송완료')";	
}								
?>
										<select name=tyear>
										<?
											for($a=2002;$a<2101;$a++) {
										?>
											<option value="<?=$a?>" <?if($year_e == $a || $tyear == $a) echo "selected"?>><?echo $a?></option>
										<?
											}
										?>
										</select>년&nbsp;
										<select name=tmonth>
										<?
											for($b=1;$b<13;$b++) {
											if($b<10) {
											$bb = "0".$b;
											}else {
												$bb = $b;
											}
										?>
										<option value="<?=$bb?>" <?if($month_e == $bb || $tmonth == $bb) echo "selected"?>><?echo $bb?></option>
										<?
											}
										?>
										</select>월&nbsp;
										<select name=tday>
										<?
											for($c=1;$c<32;$c++) {
											if($c<10) {
												$cc = "0".$c;
											}else {
												$cc = $c;
											}
										?>
										<option value="<?=$cc?>" <?if($day_e == $cc || $tday == $cc) echo "selected"?>><?echo $cc?></option>
										<?
											}
										?>
										</select>일
										&nbsp; ~ &nbsp;
										<select name=eyear>
										<?
											for($d=2002;$d<2101;$d++) {
										?>
										<option value="<?echo $d?>" <?if($year_e == $d || $eyear == $d) echo "selected"?>><?echo $d?></option>
										<?
											}
										?>
										</select>년&nbsp;
										<select name=emonth>
										<?
											for($e=1;$e<13;$e++) {
											if($e<10) {
												$ee = "0".$e;
											}else {
												$ee = $e;
											}
										?>
										<option value="<?=$ee?>" <?if($month_e == $ee || $emonth == $ee) echo "selected"?>><?echo $ee?></option>
										<?
											}
										?>
										</select>월&nbsp;
										<select name=eday>
										<?
											for($f=1;$f<32;$f++) {
											if($f<10) {
												$ff = "0".$f;
											}else {
												$ff = $f;
											}
										?>
										<option value="<?=$ff?>" <?if($day_e == $ff || $eday == $ff) echo "selected"?>><?echo $ff?></option>
										<?
											}
										?>
										</select>일&nbsp;
									</td>
									<td height="20" width="250"> 
										<select name="keyfield" class="adminbttn">
										<option value="code">상품코드</option>
										<option value="title" selected>상품명</option>
										</select>
										<input type="text" name="key" value="<?=$key?>" size="16" maxlength="16" class="adminbttn">
										<input type="button" value="검색" class="adminbttn"  onClick="javascript:go_search()">
									</td>
								</tr>
							</table>
							<table width="800" border='0' cellspacing='0' cellpadding='0'>
								<tr><td colspan=8 height=3 bgcolor='#88B7DA'></td></tr>
								<tr align="center" bgcolor='#EBF0F4'> 
									<td width="45" height="26">번호</td>
									<td width="81" height="26">상품코드</td>
									<td width="110" height="26">최종카테고리</td>
									<td width="230" height="26">상품명</td>
									<td width="121" height="26">남은수량</td>
									<td width="65" height="26">판매가격</td>
									<td width="71" height="26">상품홍보</td>
									<td width="59" height="26"> 
										<input type="button" value="삭제" class="adminbttn" onClick="javascript:go_del()">
									</td>
								</tr>
								<tr><td colspan=8 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr><td colspan=8 height=3></td></tr>
<?
#####################################################################

if ($chk_order=="Y") {
	if ($sel_code1!="") { 
		$tmp_where = "WHERE code1='$sel_code1'";
		if ($sel_code2!="") {
			$tmp_where .= " and code2='$sel_code2'";
			if ($sel_code3!="") {
				$tmp_where .= " and code3='$sel_code3'";
			}
		}		
		if($sel_out!="N"){
			$tmp_where .= " and soldout='$sel_out'";
		}
	}else{
		if($sel_out!="N"){
			$tmp_where = " where soldout='$sel_out'";
		}
	}
	$query = "SELECT No,code,code1,code2,code3,title,currnum,pricec,theme,order1,order2,order3,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,imgl,theme_s FROM $shop_goods $tmp_where ORDER BY signdate DESC";
}
//preg_match : 지정문자열을 찾아서 변환한다.
else if(!preg_match("[^[:space:]]+",$key)) {
	$query = "SELECT No,code,code1,code2,code3,title,currnum,pricec,theme,order1,order2,order3,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,imgl,theme_s FROM $shop_goods ORDER BY signdate DESC";
}else{
	$encoded_key = urlencode($key);
	$query = "SELECT No,code,code1,code2,code3,title,currnum,pricec,theme,order1,order2,order3,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,imgl,theme_s FROM $shop_goods WHERE $keyfield LIKE '%$key%' ORDER BY signdate DESC";
}

$DB->get($query,$rs,$rn);
if (!$result) {
	error("QUERY_ERROR");
	exit;
}
$total_record = $rn;


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
$mode="keyfield=$keyfield&key=$encoded_key&sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&chk_order=$chk_order&sel_cate=$sel_cate&sel_out=$sel_out&tmonth=$tmonth&tday=$tday&tyear=$tyear&emonth=$emonth&eday=$eday&eyear=$eyear";

$ii=0;
while($row = mysql_fetch_row($result)){

	$No = $rs[0][0];
	$code = $row[1];
	$code1 = $row[2];
	$code2 = $row[3];
	$code3 = $row[4];
	$title = $row[5];
	$currnum = $row[6];
	$pricec = $row[7];
	$theme = $row[8];
	$order1 = $row[9];
	$order2 = $row[10];
	$order3 = $row[11];
	$theme_g = $row[12];
	$theme_n = $row[13];
	$theme_r = $row[14];
	$theme_f = $row[15];
	$theme_x = $row[16];
	$theme_y = $row[17];
	$theme_z = $row[18];
	$imgl = $row[19];
	$theme_s = $row[20];
	$title = stripslashes($title);

	if ($theme_g=="g") $theme_g="일반상품";
	if ($theme_n=="n") $theme_n="비디오폰/CCTV";
	if ($theme_r=="r") $theme_r="베스트제품";
	if ($theme_f=="f") $theme_f="기타부자재";
	if ($theme_x=="x") $theme_x="디지털키";
	if ($theme_y=="y") $theme_y="이모빌/리모콘";
	if ($theme_z=="z") $theme_z="인기상품";
	if ($theme_s=="s") $theme_z="세일상품";

	if ($theme_g=="" && $theme_n=="" && $theme_r=="" && $theme_f=="" && $theme_x=="" && $theme_y=="" && $theme_z=="" && $theme_s=="") $theme_g="일반상품";

	if($theme_g!="") $theme_str = $theme_str.$theme_g."<br>";
	if($theme_n!="") $theme_str = $theme_str.$theme_n."<br>";
	if($theme_r!="") $theme_str = $theme_str.$theme_r."<br>";
	if($theme_f!="") $theme_str = $theme_str.$theme_f."<br>";
	if($theme_x!="") $theme_str = $theme_str.$theme_x."<br>";
	if($theme_y!="") $theme_str = $theme_str.$theme_y."<br>";
	if($theme_z!="") $theme_str = $theme_str.$theme_z."<br>";
	if($theme_s!="") $theme_str = $theme_str.$theme_s."<br>";


	if ($code2=="00") {
		$query2 = "SELECT cate1 FROM $shop_cate WHERE code1='$code1' and code2='00' and code3='00'";	
	}
	else if ($code3=="00") {
		$query2 = "SELECT cate2 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='00'";	
	}
	else {
		$query2 = "SELECT cate3 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3'";
	}
	$result2 = mysql_query($query2,$DBconn);
	if(!$result2) {
   	error("QUERY_ERROR");
   	exit;
	}	
	$row2 = mysql_fetch_row($result2);
	$cate_name = $row2[0];
	$cate_name = stripslashes($cate_name);
#####################################################################	


?>
								<tr align="center"> 
									<td width="45" height="26">&nbsp;<?=$article_num?></td>
									<td width="81" height="26">&nbsp;<?=$code?></td>
									<td  height="26">&nbsp;<?=$cate_name?></td>
									<td  height="26">
<?
if($sel_out=="Y"){
	$filename = $shop_img.$imgl;
	if(file_exists($filename)) {
?>
											<img src="<?=$filename?>" width=80 height=80>
											
<?}}?>
										<?=$title?>
									</td>
									<td  height="26">&nbsp;<?=$currnum?> / <?=$warnnum?><br><?=$color?></td>
									<td  height="26">&nbsp;<?=$pricec?></td>
									<td  height="26">&nbsp;<?=$theme_str?></td>
									<td width="59" height="26"> 
										<input type="checkbox" name="check<?=$ii?>" value="<?=$code?>">
									</td>
								</tr>
								<tr><td colspan=8 height=10 align="center">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" height=10>
									<tr bgcolor='#EBF0F4'>
								
								<td align="right">
								
								<?
								### 현재달 판매가격 ##########################################################

								


								$query_P1 = "SELECT SUM(count) FROM $shop_sell as ss,$shop_order as so where ss.code='$code' and $cond order by ss.ordernum desc";

								$result_P1= mysql_query($query_P1,$DBconn);	
								
								$row_P1 = mysql_fetch_row($result_P1);	

								$count=$row_P1[0];
								
								

								

								#####################################################################
								?>								
								판매수량 [<?=$count?>]
								</td>	
								<td width="206"></td>
								</tr>
								</table>
								</td></tr>
								<tr><td colspan=8 height=1 bgcolor='#D2DEE8'></td></tr>

<?           
#####################################################################
   $article_num--;      
   $ii++;
}
$chk_num = $last-$first+1;
#####################################################################
?>         

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
// $mode="keyfield=$keyfield&key=$encoded_key&sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&chk_order=$chk_order&sel_cate=$sel_cate";
  if ($page > 1) {
 	$page_num = $page - 1;
#####################################################################
?>
							<a href="products_price.php?<?=$mode?>&page=<?=$page_num?>" onMouseOver="status='이전페이지';return true;" onMouseOut="status=''"><font color="#666666">◀</font></a>
 
 <?
 }
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
?>
 							<font color="#666666">&nbsp;<b><?=$direct_page?></b></font>
<?
 	} else {
?>
 							&nbsp;<a href="products_price.php?<?=$mode?>&page=<?=$direct_page?>" onMouseOver="status='go to page <?=$direct_page?>';return true;" onMouseOut="status=''"><font color="#666666"><?=$direct_page?></font></a>
<?
	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
?>
 							&nbsp;<a href="products_price.php?<?=$mode?>&page=<?=$page_num?>" onMouseOver="status='다음페이지';return true;" onMouseOut="status=''"><font color="#666666">▶</font></a>
 <?
 }
 ?>
          
							 </font>
						</td>
					</tr>
					<input type="hidden" name="chk_num" value="<?=$chk_num?>">   
					<input type="hidden" name="sel_cate" value="<?=$sel_cate?>">   
					</form>
				</table>
				<br><br>
<? include "../inc/down_menu.php"; ?>
