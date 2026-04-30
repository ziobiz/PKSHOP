<?

// error_reporting( E_ALL );
//   ini_set( "display_errors", 1 );

########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../common/user_function.php";
########## 데이터베이스에 연결한다. #################################
include "../inc/top_menu.php";
include "../inc/left_menu_product.php"; 

$chk_order = $_GET["chk_order"];
$sel_cate = $_REQUEST["sel_cate"];
if($_REQUEST["sel_code1"] !="" || $_REQUEST["sel_code2"] !="" || $_REQUEST["sel_code3"] !="" || $_REQUEST["sel_code4"] !=""){
$sel_code1 = $_REQUEST["sel_code1"];
$sel_code2 = $_REQUEST["sel_code2"];
$sel_code3 = $_REQUEST["sel_code3"];
$sel_code4 = $_REQUEST["sel_code4"];
}else{
$sel_code1 = $_GET["sel_code1"];
$sel_code2 = $_GET["sel_code2"];
$sel_code3 = $_GET["sel_code3"];
$sel_code4 = $_GET["sel_code4"];
}
$soldout = $_GET["soldout"];
$mode = $_GET["mode"];
if($_REQUEST["keyfield"] !="" || $_REQUEST['key'] !="" || $_REQUEST["page"] !=""){
$keyfield = $_REQUEST['keyfield'];
$key = $_REQUEST['key'];
}else{
$keyfield = $_GET['keyfield'];
$key = $_GET['key'];
$page_num =$_GET["page"];
}




	if ($sel_cate==""){
		$sel_code1="";
		$sel_code2="";
		$sel_code3="";
		$sel_code4="";
	}else if ($sel_cate=="1"){
		$sel_code2="";
		$sel_code3="";
		$sel_code4="";
	}else if ($sel_cate=="2") {
		$sel_code3="";
		$sel_code4="";
	}else if ($sel_cate=="3") {
		$sel_code4="";
	}

?>
<script language="javascript">
<!--
function go_del() {
	document.form.action="products_del.php";
	document.form.submit();
}

function go_out() {
	document.form.action="products_out.php";
	document.form.submit();
}
//우선순위 정렬
function go_sort(str) {
	document.form.action="products_sort.php?init="+str;
	document.form.submit();
}
function go_tree() {
	document.form.action="../category/category_tree.php";
	document.form.submit();
}

function go_select(i) {
	str="document.form.sel_code"+i+".value!=''";
	if(eval(str)){
		document.form.sel_cate.value=i;
	}
	document.form.action="products.php?chk_order=Y";
	document.form.submit();
}
function go_search() {
	document.form.action="products.php";
	document.form.submit();
}
//-->
</script>
				
				<table width="900" border="0" cellspacing="0" cellpadding="0">
				<form name="form" method="post">
				<input type="hidden" name="soldout" value="<?=$soldout?>">
					<tr>
						<td>							
							<table width="900" border="0" cellspacing="0" cellpadding="4">
								<tr><td height=30 colspan="2"></td></tr>
								<tr><td colspan="2" class='td14' align="left">
								<img src="../image/icon2.gif" width=45 height=35 border=0><B><?if($soldout=="Y"){?>대기<?}else{?>전체<?}?>상품관리</B>
								</td></tr>
								<tr><td colspan="3" align="right">&nbsp;<?if($sel_code1==""){?><input type="button" value="우선순위초기화<?if($sel_cate){?>(<?=$sel_cate?>차)<?}?>" onClick="javascript:go_sort('init')" style="width:88px;border:1px #c9c9c9 solid;background-color:#e6e6e6;cursor:hand;"><?}?></td></tr>
								<tr> 
									<td height="20" width="583" align="left"> 
										<select name="sel_code1" class="adminbttn" OnChange="go_select('1');">
										<option value="" selected>1 차 카테고리명</option>
<?
#####################################################################

$query = "SELECT cate1,code1 FROM $shop_cate WHERE code2='00' and code3='00' and code4='00' ORDER BY order_rank";

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

$query = "SELECT cate2,code2 FROM $shop_cate WHERE code1='$sel_code1' and code2!='00' and code3='00' and code4='00' ORDER BY order_rank";
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

$query = "SELECT cate3,code3 FROM $shop_cate WHERE code1='$sel_code1' and code2='$sel_code2' and code3!='00' and code4='00' ORDER BY order_rank";
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
										<select name="sel_code4" class="adminbttn" OnChange="go_select('4');">
										<option value="" selected>4 차 카테고리명</option>
<?
#####################################################################]

$query = "SELECT cate4,code4 FROM $shop_cate WHERE code1='$sel_code1' and code2='$sel_code2' and code3='$sel_code3' and code4!='00' ORDER BY order_rank";
$DB->get($query,$rs,$rn);
$total_record =$rn;

for ($i=0;$i<$total_record=$rn;$i++){
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($sel_code4==$g_code){
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

									</td>
									<td height="20" width="322" align="right"> 
										
										<select name="keyfield" class="adminbttn">
										<option <?=$keyfield == "code" ? " selected " : ""?> value="code" >상품코드</option>
										<option <?=$keyfield == "title" ? " selected " : ""?> value="title">상품명</option>
										</select>
										<input type="text" name="key" value="<?=$key?>" size="16" maxlength="16" class="adminbttn">
										<input type="hidden" name="soldout" value="<?=$soldout?>">
										<input type="button" value="검색" class="adminbttn"  onClick="javascript:go_search()">
									</td>
								</tr>
							</table>
							<table width="900" border='0' cellspacing='0' cellpadding='0'>
								<tr><td colspan=10 height=3 bgcolor='#88B7DA'></td></tr>
								<tr align="center" bgcolor='#EBF0F4'> 
									<td width="45" height="26">번호</td>
									<td width="150" height="26">상품코드</td>
									<td width="110" height="26">최종카테고리</td>
									<td width="210" height="26">상품명</td>
									<!-- <td width="71" height="26">현재/재고</td> -->
									<td width="85" height="26">판매가격</td>
									<td width="85" height="26">RV퍼센트</td>
									<td width="85" height="26">MNSS</td>

									<td width="71" height="26">상품홍보</td>
									<td width="88" height="26">
									<?if($sel_code1==""){?>
										<input type="button" value="우선순위<?if($sel_cate){?>(<?=$sel_cate?>차)<?}?> 변경" onClick="javascript:go_sort()" style="width:88px;border:1px #c9c9c9 solid;background-color:#e6e6e6;cursor:hand;">
										<?}else{?>우선순위<?}?>
									</td>
									
									<td width="59" height="26"> 
										<input type="button" value="삭제" class="adminbttn" onClick="javascript:go_del()" style="border:1px #c9c9c9 solid;background-color:#e6e6e6;cursor:hand;">
									</td>
									<td width="59" height="26"> 
										<?if($soldout=="Y"){?>
										<input type="button" value="등록변경" class="adminbttn" onClick="javascript:go_out()" style="border:1px #c9c9c9 solid;background-color:#e6e6e6;cursor:hand;">
										<?}?>
									</td>
								</tr>
								<tr><td colspan=10 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr><td colspan=10 height=3></td></tr>
<?
#####################################################################

if($soldout=="Y"){
	$tmp_where="where soldout='Y'";
}else{
	$tmp_where="where soldout<>''";
}


if($P_id!=""){
	$tmp_where .=" P_id='$P_id'";
}

if ($chk_order=="Y") {
	if ($sel_code1!="") { 
		$tmp_where .= " and code1='$sel_code1'";
		$tmp_order = "ORDER BY order1";
		if ($sel_code2!="") {
			$tmp_where .= " and code2='$sel_code2'";
			$tmp_order = "ORDER BY order2";
			if ($sel_code3!="") {
				$tmp_where .= " and code3='$sel_code3'";
				$tmp_order = "ORDER BY order3";

				if ($sel_code4!="") {
					$tmp_where .= " and code4='$sel_code4'";
					$tmp_order = "ORDER BY order4";
				}

			}
		}		
	}			
	$query = "SELECT No,code,code1,code2,code3,title,currnum,pricec,theme,order1,order2,order3,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,theme_s,code4,order4,prices,priced,c_pv,c_dis FROM $shop_goods $tmp_where $tmp_order";
	$query1 = "SELECT coin_price FROM $coin_goods $tmp_order";
}
//preg_match : 지정문자열을 찾아서 변환한다.
else if($key == "") {
	$query = "SELECT No,code,code1,code2,code3,title,currnum,pricec,theme,order1,order2,order3,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,theme_s,code4,order4,prices,priced,c_pv,c_dis FROM $shop_goods $tmp_where ORDER BY signdate DESC";
	$query1 = "SELECT coin_price FROM $coin_goods ORDER BY signdate DESC";
}else{
	$encoded_key = urlencode($key);
	$query = "SELECT No,code,code1,code2,code3,title,currnum,pricec,theme,order1,order2,order3,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,theme_s,code4,order4,prices,priced,c_pv,c_dis FROM $shop_goods $tmp_where and $keyfield LIKE '%$key%' ORDER BY signdate DESC";
	$query1 = "SELECT coin_price FROM $coin_goods and $keyfield LIKE '%$key%' ORDER BY signdate DESC";
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
$mode="keyfield=$keyfield&key=$encoded_key&sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&sel_code4=$sel_code4&chk_order=$chk_order&sel_cate=$sel_cate&soldout=$soldout";
$ii=0;
for($i = $first; $i <= $last; $i++) { 
	$No =$rs[$i][0];
	$code =$rs[$i][1];
	$code1 =$rs[$i][2];
	$code2 =$rs[$i][3];
	$code3 =$rs[$i][4];
	$title =$rs[$i][5];
	$currnum =$rs[$i][6];
	$pricec =$rs[$i][7];
	$theme =$rs[$i][8];
	$order1 =$rs[$i][9];
	$order2 =$rs[$i][10];
	$order3 =$rs[$i][11];
	$theme_g =$rs[$i][12];
	$theme_n =$rs[$i][13];
	$theme_r =$rs[$i][14];
	$theme_f =$rs[$i][15];
	$theme_x =$rs[$i][16];
	$theme_y =$rs[$i][17];
	$theme_z =$rs[$i][18];
	$theme_s =$rs[$i][19];
	$code4 =$rs[$i][20];
	$order4 = $rs[$i][21];
	$prices = $rs[$i][22];
	$priced = $rs[$i][23];
	$c_pv = $rs[$i][24];
	$c_dis = $rs[$i][25];
	$title = stripslashes($title);

	if ($theme_g=="g") $theme_g="일반상품";
	if ($theme_n=="n") $theme_n="추천상품";
	if ($theme_r=="r") $theme_r="베스트상품";
	if ($theme_f=="f") $theme_f="HOT상품";
	if ($theme_x=="x") $theme_x="추천상품";
	if ($theme_y=="y") $theme_y="특가상품";
	if ($theme_z=="z") $theme_z="테마";
	if ($theme_s=="s") $theme_s="세일상품";

	if ($theme_g=="" && $theme_n=="" && $theme_r=="" && $theme_f=="" && $theme_x=="" && $theme_y=="" && $theme_z=="" && $theme_s=="") $theme_g="일반상품";

	if($c_dis == 1){
		$theme_g="재구매상품";
	}

	if($theme_g!="") $theme_str = $theme_str.$theme_g."<br>";
	if($theme_n!="") $theme_str = $theme_str.$theme_n."<br>";
	if($theme_r!="") $theme_str = $theme_str.$theme_r."<br>";
	if($theme_f!="") $theme_str = $theme_str.$theme_f."<br>";
	if($theme_x!="") $theme_str = $theme_str.$theme_x."<br>";
	if($theme_y!="") $theme_str = $theme_str.$theme_y."<br>";
	if($theme_z!="") $theme_str = $theme_str.$theme_z."<br>";
	if($theme_s!="") $theme_str = $theme_str.$theme_s."<br>";

	

	if ($code2=="00") {
		$query2 = "SELECT cate1 FROM $shop_cate WHERE code1='$code1' and code2='00' and code3='00' and code4='00'";	
	}
	else if ($code3=="00") {
		$query2 = "SELECT cate2 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='00' and code4='00'";	
	}
	else if ($code4=="00") {
		$query2 = "SELECT cate3 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='00'";
	}
	else {
		$query2 = "SELECT cate4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='$code4'";
	}
	
	$DB->get($query2,$rs2,$rn2);
	
	$cate_name = $rs2[0][0];
	$cate_name = stripslashes($cate_name);
	
	if ($sel_code1!="") { 
		$g_order=$order1;
		if ($sel_code2!="") {
			$g_order=$order2;
			if ($sel_code3!="") {
				$g_order=$order3;
				if ($sel_code4!="") {
					$g_order=$order4;
				}
			}
		}		
	}else{
		$g_order=$order1;
	}
#####################################################################	
?>
								<tr align="center">
									<td width="45" height="26">&nbsp;<?=$article_num?><br>
									</td>
									<td width="61" height="26">&nbsp;<?=$code?>
									<?if($code1=="01"){?><!-- <br>&nbsp;<span onclick="window.open('../member_p/member.php?id=<?=$code?>','','width=800,height=700')" style="cursor:hand;cursor:pointer">[이벤트기록]</span> --><?}?></td>
									<td width="125" height="26">&nbsp;<?=$cate_name?></td>
									<td width="215" height="26">
										<a href="pro_info.php?<?=$mode?>&page=<?=$page?>&code=<?=$code?>&No=<?=$No?>"><?=$title?></a>
									</td>
									<!-- <td width="71" height="26">&nbsp;<?=$currnum?> / <?=$warnnum?><br><?=$color?></td> -->
									<td width="65" height="26">&nbsp;<?=$pricec?></td>
									<td width="65" height="26">&nbsp;<?=$c_pv?>%</td>
									<td width="71" height="26">&nbsp;<?=$theme_str?></td>
									<td width="70" height="26" align="center">&nbsp;
<?if($sel_code1 ==""){?>

<?
####################################################################
if($soldout=="Y"){
	$tmp_where="where soldout='Y'";
}else if($soldout=="N"){
	$tmp_where="where soldout='K'";
}else{
	$tmp_where="where soldout='N'";
}
$soldout_tmp= $tmp_where;
if($sel_cate==1){
	$order="order1";
	$order_tmp=$soldout_tmp;
}else if($sel_cate==2){
	$order="order2";
	$order_tmp=$soldout_tmp." and code2!='00'";
}else if($sel_cate==3){
	$order="order3";
	$order_tmp=$soldout_tmp." and code3!='00'";
}else if($sel_cate==4){
	$order="order4";
	$order_tmp=$soldout_tmp." and code4!='00'";
}else {
	$order="order1";
	$order_tmp=$soldout_tmp;
	$sel_cate==1;
}

//$sel_num="sel_".$No;
//echo $sel_num;
// echo "select count($order) as total_order from $shop_goods $order_tmp";
?>

<!-- $No를 $sel[] 과 no[]의 공통 키값으로 활용 -->

									<select name="sel[<?=$No?>]" size="1" class="adminbttn">
										<option value="99999" selected><?if($sel_cate){?><?=$sel_cate?>차 변경<?}else{?>전체<?}?></option>
<?

$DB->get("select count($order) as total_order from $shop_goods $order_tmp",$rss,$rnn);
$total_order=$rss[0]["total_order"];

for ($j=0;$j<$total_order;$j++) {
	// echo $$order;
	if ($$order==$j+1) $oselect = "selected";
	else $oselect = "";

#####################################################################
?>
										<option value="<?=$j+1?>" <?=$oselect?>><?=$j+1?></option>

<?}?>
										</select>
<?}else{?>---<?}?>
									</td>
									<td></td>
									<input type="hidden" name="no[<?=$No?>]" value="<?=$No?>"> 
									<td  height="26" colspan="2"> 
										<input type="checkbox" name="check<?=$ii?>" value="<?=$No?>">삭제시체크
									</td>
								</tr>
								<tr><td colspan=10 height=1 bgcolor='#D2DEE8'></td></tr>

<?           
#####################################################################
   $article_num--;      
   $ii++;
   $theme_str="";
}
$chk_num = $last-$first+1;
#####################################################################
?>         

							</table>
						</td>
					</tr>
				</table> 
				<table width="800" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
					<tr><td height="20" align="right">*카테고리 선택후에는 각 카테고리별 우선순위로 정렬됩니다.<br />*오래전 입력한 자료를 앞부분에 노출시키고자 할때 우선순위를 활용합니다.<br />*우선순위가 같은 경우는 기본인 등록순으로 정렬됩니다.</td></tr>
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
 $mode="keyfield=$keyfield&key=$encoded_key&sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&sel_code4=$sel_code4&chk_order=$chk_order&sel_cate=$sel_cate&soldout=$soldout";
  if ($page > 1) {
 	$page_num = $page - 1;
#####################################################################
?>
							<a href="products.php?<?=$mode?>&page=<?=$page_num?>" onMouseOver="status='이전페이지';return true;" onMouseOut="status=''"><font color="#666666">◀</font></a>
 
 <?
 }
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
?>
 							<font color="#666666">&nbsp;<b><?=$direct_page?></b></font>
<?
 	} else {
?>
 							&nbsp;<a href="products.php?<?=$mode?>&page=<?=$direct_page?>" onMouseOver="status='go to page <?=$direct_page?>';return true;" onMouseOut="status=''"><font color="#666666"><?=$direct_page?></font></a>
<?
	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
?>
 							&nbsp;<a href="products.php?<?=$mode?>&page=<?=$page_num?>" onMouseOver="status='다음페이지';return true;" onMouseOut="status=''"><font color="#666666">▶</font></a>
 <?
 }
 ?>
          
							 </font>
						</td>
					</tr>
					<input type="hidden" name="chk_num" value="<?=$chk_num?>">   
					<input type="hidden" name="sel_cate" value="<?=$sel_cate?>">
					<input type="hidden" name="num_per_page" value="<?=$num_per_page?>">
					</form>
				</table>
				<br><br>
<? include "../inc/down_menu.php"; ?>
