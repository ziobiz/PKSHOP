<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../common/user_function.php";
########## 데이터베이스에 연결한다. #################################

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

?>
<script language="javascript">
<!--
function go_select(i) {
	document.form.sel_cate.value=i;
	document.form.action="product_search.php?chk_order=Y";
	document.form.submit();
}
function go_search() {
	document.form.action="product_search.php";
	document.form.submit();
}
//-->
</script>
<script>
function pok(x)
{
opener.document.form.<?=$relation_dis?>.value=x;
this.close(); 
}
</script>
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
<title>관련상품 선택</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../image/style.css" type="text/css">

<head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor='#FFFFFF' scroll="yes">
				
				<table width="800" border="0" cellspacing="0" cellpadding="0">
				<form name="form" method="post">
				<input type="hidden" name="relation_dis" value="<?=$relation_dis?>">
					<tr>
						<td>							
							<table width="800" border="0" cellspacing="0" cellpadding="4">
								<tr><td colspan="2" class='td14'>
								<img src="../image/icon2.gif" width=45 height=35 border=0><B>관련상품선택</B>
								</td></tr>
								<tr> 
									<td height="20" width="462"> 
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
										&nbsp;
									</td>
									<td height="20" width="322"> 
										<select name="keyfield" class="adminbttn">
										<option value="title" selected>상품명</option>
										<option value="code">상품코드</option>										
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
									<td width="125" height="26">최종카테고리</td>
									<td width="265" height="26">상품명</td>
									<td width="71" height="26">현재수량</td>
									<td width="65" height="26">판매가격</td>
									<td width="71" height="26">상품홍보</td>
									<td width="59" height="26"> 
										<input type="button" value="상품선택" class="adminbttn">
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
	}			
	$query = "SELECT code,code1,code2,code3,title,currnum,pricec,theme FROM $shop_goods $tmp_where ORDER BY signdate DESC";
}
//preg_match : 지정문자열을 찾아서 변환한다.
else if(!preg_match("[^[:space:]]+",$key)) {
	$query = "SELECT code,code1,code2,code3,title,currnum,pricec,theme FROM $shop_goods ORDER BY signdate DESC";
}else{
	$encoded_key = urlencode($key);
	$query = "SELECT code,code1,code2,code3,title,currnum,pricec,theme FROM $shop_goods WHERE $keyfield LIKE '%$key%' ORDER BY signdate DESC";
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
$mode="keyfield=$keyfield&key=$encoded_key&sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&chk_order=$chk_order&sel_cate=$sel_cate";
$ii=0;
for($i = $first; $i <= $last; $i++) { 
	$code =$rs[$i][0];
	$code1 =$rs[$i][1];
	$code2 =$rs[$i][2];
	$code3 =$rs[$i][3];
	$title =$rs[$i][4];
	$currnum =$rs[$i][5];
	$pricec =$rs[$i][6];
	$theme =$rs[$i][7];
	$title = stripslashes($title);
	
	$theme = split(",",$theme);

	if($theme[0]=='g') $theme_g = '일반상품';
	if($theme[1]=='r') $theme_r = '추천상품';
	if($theme[2]=='n') $theme_n = '비디오폰/CCTV';
	if($theme[3]=='b') $theme_b = '베스트상품';
	if($theme[4]=='p') $theme_p = '인기상품';
	$theme =  $theme_g." ".$theme_r." ".$theme_n." ".$theme_b." ".$theme_p;

	$pricec=str_replace(",","<br>", $pricec);
	
	if ($code2=="00") {
		$query2 = "SELECT cate1 FROM $shop_cate WHERE code1='$code1' and code2='00' and code3='00'";	
	}
	else if ($code3=="00") {
		$query2 = "SELECT cate2 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='00'";	
	}
	else {
		$query2 = "SELECT cate3 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3'";
	}
	$DB->get($query2,$rs2,$rn2);
	$cate_name = $rs[0][0];
	$cate_name = stripslashes($cate_name);
#####################################################################	
?>
								<tr align="center"> 
									<td width="45" height="26">&nbsp;<?=$article_num?></td>
									<td width="81" height="26">&nbsp;<?=$code?></td>
									<td width="125" height="26">&nbsp;<?=$cate_name?></td>
									<td width="265" height="26">
										<?=$title?>
									</td>
									<td width="71" height="26">&nbsp;<?=$currnum?></td>
									<td width="65" height="26">&nbsp;<?=$pricec?></td>
									<td width="71" height="26">&nbsp;<?=$theme?></td>
									<td width="59" height="26"> 
										<input type="button" value="상품선택" class="adminbttn" onclick="javascript:pok('<?=$code?>')">
									</td>
								</tr>
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
							<a href="product_search.php?<?=$mode?>&page=<?=$page_num?>&relation_dis=<?=$relation_dis?>" onMouseOver="status='이전페이지';return true;" onMouseOut="status=''"><font color="#666666">◀</font></a>
 
 <?
 }
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
?>
 							<font color="#666666">&nbsp;<b><?=$direct_page?></b></font>
<?
 	} else {
?>
 							&nbsp;<a href="product_search.php?<?=$mode?>&page=<?=$direct_page?>&relation_dis=<?=$relation_dis?>" onMouseOver="status='go to page <?=$direct_page?>';return true;" onMouseOut="status=''"><font color="#666666"><?=$direct_page?></font></a>
<?
	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
?>
 							&nbsp;<a href="product_search.php?<?=$mode?>&page=<?=$page_num?>&relation_dis=<?=$relation_dis?>" onMouseOver="status='다음페이지';return true;" onMouseOut="status=''"><font color="#666666">▶</font></a>
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
</body>
</html>