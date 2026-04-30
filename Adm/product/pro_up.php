<? 


include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";

$shop_img="../../shop_img";
$shop_img_lode="../../shop_img";

?>
					<script type="text/javascript" src="se2/js/HuskyEZCreator.js" charset="utf-8"></script>
					<table width=800 border=0 cellpadding=0 cellspacing=0>
						<tr><td height=30></td></tr>
						<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>상품등록</b></td>
								</tr>
							</table>
						</td></tr>
						<tr><td height=3></td></tr>
						<tr>
							<td valign=top>
							
<!-- 게시판 begin -->
<script language="javascript">
<!--
function go_select(i) {
	document.form.action="pro_up.php?sel_cate=" + i;
	document.form.submit();
}

function regist() {
	code1 = document.form.code1.value;
	if (code1=="00")	{
		alert('1차 카테고리는 반드시 입력하십시요');
		return;
	}
	title = document.form.title.value;
	if (title=="")	{
		alert('상품명은 반드시 입력하십시요');
		return;
	}
	if(document.form.country.value ==""){
		alert("국가를 선택해주세요");
		return false;
	}
	oEditors.getById["detail"].exec("UPDATE_CONTENTS_FIELD", []);
	document.form.action="pro_up_ok.php";
	document.form.submit();
	
}

//-->
</script>
							<table width="800" border='0' cellspacing='0' cellpadding='0'  bordercolor='#FBFFCF' >
								<form name="form" method="post" action="./pro_up_ok.php" ENCTYPE="multipart/form-data">
									<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
									<tr><td colspan=2 height=5></td></tr>
									<tr> 
										<td width="150" height="30" align="center">카테고리</td>
										<td width="550" height="30" align="left">
											&nbsp;&nbsp; 
											<select name="code1" class="adminbttn" size="1" OnChange="go_select('1');">
											<option value="00" selected>1 차 카테고리</option>
<?
#####################################################################
if ($sel_cate=="1"){
	$code2="";
	$code3="";
	$code4="";
}
else if ($sel_cate=="2"){
	$code3="";
	$code4="";
}
else if ($sel_cate=="3"){
	$code4="";
}
$query = "SELECT cate1,code1 FROM $shop_cate WHERE code2='00' and code3='00' and code4='00' ORDER BY order_rank";

$DB->get($query,$rs,$rn);
for ($i=0;$i<$total_record=$rn;$i++) {
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($code1==$g_code) $oselect = "selected";
	else $oselect = "";
#####################################################################
?>
											<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?        
}

?>

											</select>
											&nbsp;&nbsp; 
											<select name="code2" class="adminbttn" OnChange="go_select('2');">
											<option value="00" selected>2 차 카테고리</option>
<?
#####################################################################
$query = "SELECT cate2,code2 FROM $shop_cate WHERE code1='$code1' and code2!='00' and code3='00' and code4='00' ORDER BY order_rank";
$DB->get($query,$rs,$rn);

for ($i=0;$i<$total_record=$rn;$i++) {
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($code2==$g_code) $oselect = "selected";
	else $oselect = "";
#####################################################################
?>
											<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?           
}
?>
											</select>
											&nbsp;&nbsp; 
											<select name="code3" class="adminbttn" OnChange="go_select('3');">
											<option value="00" selected>3 차 카테고리</option>
<?
#####################################################################
$query = "SELECT cate3,code3 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3!='00'  and code4='00'ORDER BY order_rank";
$DB->get($query,$rs,$rn);

for ($i=0;$i<$total_record=$rn;$i++) {
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($code3==$g_code) $oselect = "selected";
	else $oselect = "";
?>
											<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?      
}
?>

											</select>
											&nbsp;&nbsp; 
											<select name="code4" class="adminbttn" OnChange="go_select('4');">
											<option value="00" selected>4 차 카테고리</option>
<?
#####################################################################
$query = "SELECT cate4,code4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4!='00'ORDER BY order_rank";
$DB->get($query,$rs,$rn);

for ($i=0;$i<$total_record=$rn;$i++) {
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($code4==$g_code) $oselect = "selected";
	else $oselect = "";
?>
											<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?      
}
?>

											</select>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
<?
#####################################################################
if ($code_copy=="") {

	if ($sel_cate=="1"){
		$code=$code1."000000";
	}else if ($sel_cate=="2"){
		$code=$code1.$code2."0000";
	}else if ($sel_cate=="3"){
		$code=$code1.$code2.$code3."00";
	}else if ($sel_cate=="4") {
		$code=$code1.$code2.$code3.$code4;
	}

	$DB->get("SELECT max(code) FROM $shop_goods WHERE code LIKE '$code%' ",$row,$ros);
	if($row[0][0]) {	
		$new_code = substr($row[0][0],-3);
		$new_code = $new_code + 1;
		$new_code = sprintf("%03d",$new_code);
	} else {
		$new_code = "001";
	}   

	if ($code!="") $code=$code.$new_code;

}else{

		$new_code = substr($code_copy,-3);
		$new_code = $new_code + 1;
		$new_code = sprintf("%03d",$new_code);

		$code_copy_tmp = substr($code_copy,0,6);

		$code=$code_copy_tmp.$new_code;
}
#####################################################################
?>
									<tr> 
										<td height="30" align="center">상품코드</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="code" value="<?echo($code)?>" size="16" maxlength="15" class="adminbttn" readonly><font color="#003366">* 자동 생성되는 코드입니다.</font>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
<?
#####################################################################

$DB->get("select count(order1) as total_order1 from $shop_goods",$row_num1,$ros_num1);
$total_order1=$row_num1[0]["total_order1"] + 1;

$DB->get("select count(order2) as total_order2 from $shop_goods where code2!='00'",$row_num2,$ros_num2);
$total_order2=$row_num2[0]["total_order2"] + 1;


$DB->get("select count(order2) as total_order2 from $shop_goods where code3!='00'",$row_num3,$ros_num3);
$total_order3=$row_num3[0]["total_order3"] + 1;

$DB->get("select count(order2) as total_order2 from $shop_goods where code4!='00'",$row_num4,$ros_num4);
$total_order4=$row_num4[0]["total_order4"] + 1;
#####################################################################
?>
									
									<tr> 
										<td height="30" align="center">상품명</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="title" value="<?=$title?>" size="55" maxlength="100" class="adminbttn">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									 <tr> 
										<td height="30" align="center">상품구분</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											일반제품 <input type="radio" name="dis" value="0" checked class="adminbttn">
											&nbsp;&nbsp; 
											재구매제품 <input type="radio" name="dis" value="1"  class="adminbttn">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> 
									
									<tr> 
										<td height="30" align="center">제조사</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="company" value="<?=$company?>" size="30" maxlength="30" class="adminbttn">
										</td>
									</tr>
									
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr>
									<tr> 
										<td height="30" align="center">국가</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<select name="country" id="country">
												<option <?=$country =="" ? " selected " : ""?> value="">선택</option>
												<option <?=$country =="82" ? " selected " : ""?> value="82">KOREA</option>
												<option <?=$country =="66" ? " selected " : ""?> value="66">THAILAND</option>
												<option <?=$country =="91" ? " selected " : ""?> value="91">INDIA </option>
												<option <?=$country =="1" ? " selected " : ""?> value="1">USA</option>
												<option <?=$country =="81" ? " selected " : ""?> value="81">JAPAN </option>
												<option <?=$country =="86" ? " selected " : ""?> value="86">CHINA</option>
												<option <?=$country =="84" ? " selected " : ""?> value="84">VIETNAM </option>
												<option <?=$country =="62" ? " selected " : ""?> value="62">INDONESIA </option>
												
												
											</select>
										</td>
									</tr>		
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr>								
<!-- 입력 예) -->
									<tr> 
										<td height="120" align="center"><font color="#2657d9">색상/종류<br>사이즈/규격<br>입력 예)</font></td>
										<td height="120" align="left">
											&nbsp;&nbsp;
											<input type="text" name="color_s" value="하늘색,핑크색,블랙,화이트" size="85" class="adminbttn" style="color:silver;"onFocus="this.blur();">&nbsp;<!-- <input name="size_opt_s" type="checkbox" checked onFocus="this.blur();">필수여부 -->
											<font color="#ff3300"><br>&nbsp;&nbsp;&nbsp;&nbsp;(예: 하늘색,핑크색,...) <b>,</b>(콤마)로 구분</font><br><br>&nbsp;&nbsp;&nbsp;<font color="#2657d9">색상과 사이즈 옵션은 금액이나 포인트 계산에 영향을 미치지 않는 옵션을 표현하는데 이용해주세요.<br>&nbsp;&nbsp;&nbsp;금액이나 포인트에 변화가 있는 옵션의 경우는 아래의 추가 옵션을 이용해주세요.</font>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr>
<!-- 일력 예) 끝 -->
									<tr> 
										<td height="30" align="center">색상/종류</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="color" value="<?=$color?>" size="85" class="adminbttn">
											<font color="#003366">&nbsp;<!-- <input name="color_opt" type="checkbox" value="Y" <?if($color_opt=="Y"){?>checked<?}?>>&nbsp;필수여부 --></td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										<td height="30" align="center">사이즈/규격</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="size" value="<?=$size?>" size="85" class="adminbttn">
											<font color="#003366">&nbsp;<!-- <input name="size_opt" type="checkbox" value="Y" <?if($size_opt=="Y"){?>checked<?}?>>필수여부 --></td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<!-- <tr> 
										<td height="30" align="center">묶음</td>
										<td height="30">
											&nbsp;&nbsp; 
											묶음갯수 : <input type="text" name="opt_num" value="<?=$opt_num?>" size="85" class="adminbttn"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;예)1,2,3,5,10,20,30,50,100  ,(콤마)로 구분 <br>
											&nbsp;&nbsp;설명문구 : <input type="text" name="opt_num_str" value="<?=$opt_num_str?>" size="85" class="adminbttn"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;예)(최소구매단위는 10개 입니다)</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr> -->
									<tr> 
										<td height="30" align="center">원산지</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="home" value="<?=$home?>" size="30" class="adminbttn">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<!-- <tr> 
										<td height="30" align="center">유통기한</td>
										<td height="30">
											&nbsp;&nbsp; 
											<input type="text" name="shelf" value="<?=$shelf?>" size="30" class="adminbttn">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr>  -->
<!-- 상품홍보 및 이벤트 -->
									<tr> 
										<td height="30" align="center">상품홍보</td>
										<td height="30" style="padding-left:10px;" align="left">
										<table width="600" border='0' cellspacing='0' cellpadding='0'>
												<tr>
													<td width="110">
														<input type="checkbox" name="theme_g" value="g" <?if($theme_g=="g" || ($theme_g=="" && $theme_n=="" && $theme_r=="" && $theme_f=="" && $theme_x=="" && $theme_y=="" && $theme_z=="" && $theme_s=="")){?>checked<?}?>>기본상품</td>
													 <td width="110">
														<input type="checkbox" name="theme_n" value="n" <?if($theme_n=="n" ){?>checked<?}?>>추천상품
													</td> 
													<td width="110">
														<input type="checkbox" name="theme_r" value="r" <?if($theme_r=="r" ){?>checked<?}?>>BEST제품
													</td>
													<td width="110">
														<input type="checkbox" name="theme_f" value="f" <?if($theme_f=="f"){?>checked<?}?>>HOT제품
													</td>
													<td width="110"></td>
													<td>&nbsp;</td>
												</tr>
												
											</table>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<!-- <tr> 
										<td height="30" align="center">이벤트</td>
									<td height="30">
											&nbsp;&nbsp; 
											<input type="checkbox" name="event1" value="Y" <?if($event1=="Y"){?>checked<?}?>>&nbsp;<input type="text" name="event1_str" value="<?=$event1_str?>" size="22">
											&nbsp;&nbsp; 
											<input type="checkbox" name="event2" value="Y" <?if($event2=="Y"){?>checked<?}?>>&nbsp;<input type="text" name="event2_str" value="<?=$event2_str?>" size="22"> 
											&nbsp;&nbsp; 											
											<input type="checkbox" name="event3" value="Y" <?if($event3=="Y"){?>checked<?}?>>&nbsp;<input type="text" name="event3_str" value="<?=$event3_str?>" size="22"><br>
											&nbsp;&nbsp; 											
											<input type="checkbox" name="event4" value="Y" <?if($event4=="Y"){?>checked<?}?>>&nbsp;<input type="text" name="event4_str" value="<?=$event4_str?>" size="22">
											&nbsp;&nbsp; 											
											<input type="checkbox" name="event5" value="Y" <?if($event5=="Y"){?>checked<?}?>>&nbsp;<input type="text" name="event5_str" value="<?=$event5_str?>" size="22"><br>
											<font color="#003366">&nbsp;&nbsp;&nbsp;(예: <input type="checkbox" name="event1_tmp" value="e1_tmp" checked >&nbsp;<input type="text" name="event1_str_tmp" size="22" value="광복절특가" onFocus="this.blur()" style="color:#2657d9;">)</font>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
									<!-- <tr> 
										<td height="30" align="center">
											아이콘등록
										</td>
										<td height="55"  style="padding-left:10px;">
											<table width="600" border='0' cellspacing='0' cellpadding='0'>
												<tr>
													<td width="45"><img src="../image/icon_01.gif"></td>
													<td width="250">
														<input type="radio" name="recommend" value="Y" <?if($recommend=="Y"){?>checked<?}?>>사용함
														<input type="radio" name="recommend" value="N" <?if($recommend=="N" || $recommend==""){?>checked<?}?>>사용안함&nbsp;
													</td>
													<td width="45"><img src="../image/icon_02.gif"></td>
													<td width="250">
														<input type="radio" name="new" value="Y"			<?if($new=="Y"){?>checked<?}?>>사용함
														<input type="radio" name="new" value="N" <?if($new=="N" || $new==""){?>checked<?}?>>사용안함&nbsp;
													</td>
												</tr>
												<tr>
												<td><img src="../image/icon_03.gif"></td>
												<td>
													<input type="radio" name="cut" value="Y" <?if($cut=="Y"){?>checked<?}?>>사용함
													<input type="radio" name="cut" value="N" <?if($cut=="N" || $cut==""){?>checked<?}?>>사용안함&nbsp;&nbsp;</td>
												<td><img src="../image/icon_04.gif"></td>
												<td>
													<input type="radio" name="best" value="Y" <?if($best=="Y"){?>checked<?}?>>사용함
													<input type="radio" name="best" value="N" <?if($best=="N" || $best==""){?>checked<?}?>>사용안함&nbsp;
												</td>
											</tr>
											</table>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr>  -->
<!-- 현금결제 -->
									<!-- <tr> 
										<td height="30" align="center">현금결제</td>
										<td height="30">
											&nbsp;&nbsp;
											<input type="radio" name="price_dis" value="Y" <?if($price_dis=="Y"){?>checked<?}?>>사용함
											<input type="radio" name="price_dis"  value="N"  <?if($price_dis=="N" || $price_dis==""){?>checked<?}?>>사용안함&nbsp;
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->

									<!-- <tr> 
										<td height="30" align="center">입고가격/날짜</td>
										<td height="30">
											&nbsp;&nbsp; 
											<input type="text" name="feature" value="<?=$feature?>" size="50" class="adminbttn">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
									
<!-- 가격 -->


									<input type="hidden" name="pr_kind" value="main">
									<!-- <tr>  -->
									<!-- <td width="115" height="30" align="center">제품종류</td> -->
									
									<!-- <td width="585" height="30" align="left">
										&nbsp;&nbsp;
										<select name="pr_kind" class="adminbttn" size="1" >
										<option value="main" selected>메인제품</option>
										<option value="resell">재구매제품</option>

										</select>
										</td>
									</tr> -->
									<!-- <tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->


									<tr> 
										<td height="30" align="center">판매가격</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="pricec" value="<?=$pricec?>" size="30" class="adminbttn">
											원
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									
									<tr> 
										<td height="30" align="center">할인가격</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="prices" value="<?=$priced?>" size="30"  class="adminbttn" > 원
										</td>
									</tr>
									<tr> 
										<td height="30" align="center">실판매가격</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="priced" value="<?=$priced?>" size="30"  class="adminbttn" > 원
										</td>
									</tr>
									<tr> 
										<td height="30" align="center">RV 퍼센트(숫자만 입력해주세요)</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="number" name="c_pv" value="<?=$c_pv?>" size="30"  class="adminbttn" > %
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr> 
									<tr> 
										<td height="30" align="center">포인트 전용 구매 </td>
										<td height="55" style="padding-left:10px;" align="left">
										<table width="600" border='0' cellspacing='0' cellpadding='0'>
											<tr>
													<td width="110">
														<input type="checkbox" name="onlypoint" value="1" <?if($onlypoint == "1"){?>checked<?}?>>포인트 전용 구매(체크시 포인트로만 구매 가능합니다)
													</td>
													
												</tr>
											</table>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<!-- <tr> 
										<td height="30" align="center">코인수량</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="coin" value="<?=$priced?>" size="30"  class="adminbttn" > 
										</td>
									</tr>



									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
 									<tr>  
 										<td height="30" align="center">수당지급률</td>
 										<td height="30" align="left">
											&nbsp;&nbsp;  
											<input type="text" name="point" value="<?=$priced?>" size="30"  class="adminbttn">
 										</td> 
									</tr> 
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
<!--									<tr> 
										<td height="30" align="center">부가세</td>
										<td height="30" align="left">&nbsp;&nbsp; 
											<input type="text" name="fee" value="" size="16" maxlength="16" class="adminbttn">&nbsp;&nbsp;원&nbsp;&nbsp;										</td>
									</tr>-->
									<tr><td colspan=3 height=10></td></tr>

<!-- 예 -->									
									<tr> 
										<td height="30" align="center"><font color="#2657d9">추가옵션 예)</font></td>
										<td height="60" colspan="2" align="left">
										<table width="600" border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td width="120">옵션명1</td><td width="480"><input type="text" name="option_t1_s" value="신발사이즈" size="45" class="adminbttn" onFocus="this.blur();"  style="color:silver;"><!-- &nbsp;<input name="add_opt1_s" type="checkbox" checked>&nbsp;필수여부 --></td>
											</tr>

											<tr>
												<td width="120">&nbsp;</td>
												<td width="480">
													<table width="480" border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td align="center" width="300">옵션사항</td><td align="center" width="225">증/차감가격</td><!-- <td align="center"  width="75">코인적립</td> -->
														</tr>
														<?
															$str1="240mm\r\n245mm\r\n250mm(+3000원)\r\n260mm(+5000원)";
															$str2="0\r\n0\r\n3000\r\n5000";
															//$str3="0\r\n0\r\n30\r\n0";
														?>
														<tr>
															<td><textarea name="option_n1_s" rows="7" cols="35" class="adminbttn" onFocus="this.blur();"  style="color:silver;"><?=$str1?></textarea></td>
															<td><textarea name="option_p1" rows="7" cols="20" class="adminbttn" onFocus="this.blur();"  style="color:silver;"><?=$str2?></textarea></td>
															<!-- <td><textarea name="option_k1" rows="7" cols="12" class="adminbttn" onFocus="this.blur();"  style="color:silver;"><?=$str3?></textarea></td> -->
														</tr>
														<tr>
															<td height="30" colspan="3"><font color="#ff3300">엔터로 옵션사항, 증/차감금액, 코인적립을 구분하여 주세요. </font></td>
														</tr>
													</table>
												</td>
											</tr>
										</table></td>
									</tr>

									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr>
<!-- 추가옵션 -->
									<tr> 
										<td height="30" align="center">추가옵션1</td>
										<td height="60" colspan="2" align="left">
										<table width="600" border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td width="60" height="35" align="left">옵션명1 :&nbsp;</td>
												<td width="540"><input type="text" name="option_t1" value="<?=$option_t1?>" size="70" class="adminbttn">&nbsp;<!-- <input name="add_opt1" type="checkbox" value="Y" <?if($add_opt1=="Y"){?>checked<?}?>>&nbsp;필수여부 --></td>
											</tr>

											<tr>
												<td colspan="2">
													<table width="600" border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td width="300" align="center">옵션사항</td><td width="200" align="center">증/차감가격</td><!-- <td width="100" align="center">코인적립</td> -->
														</tr>
														<tr>
															<td><textarea name="option_n1" rows="7" cols="45" class="adminbttn"><?=$option_n1?></textarea></td>
															<td><textarea name="option_p1" rows="7" cols="28" class="adminbttn"><?=$option_p1?></textarea></td>
															<!-- <td><textarea name="option_k1" rows="7" cols="14" class="adminbttn"><?=$option_k1?></textarea></td> -->
														</tr>
													</table>
												</td>
											</tr>
										</table></td>
									</tr>
									<tr><td colspan=3 height=10></td></tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr> 
										<td height="30" align="center">추가옵션2</td>
										<td height="60" colspan="2" align="left">
										<table width="600" border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td width="60" height="35" align="left">옵션명2 :&nbsp;</td>
												<td width="540"><input type="text" name="option_t2" value="<?=$option_t2?>" size="70" class="adminbttn">&nbsp;<!-- <input name="add_opt2" type="checkbox" value="Y" <?if($add_opt2=="Y"){?>checked<?}?>>&nbsp;필수여부 --></td>
											</tr>

											<tr>
												<td colspan="2">
													<table width="600" border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td width="300" align="center">옵션사항</td><td width="200" align="center">증/차감가격</td><!-- <td width="100" align="center">코인적립</td> -->
														</tr>
														<tr>
															<td><textarea name="option_n2" rows="7" cols="45" class="adminbttn"><?=$option_n2?></textarea></td>
															<td><textarea name="option_p2" rows="7" cols="28" class="adminbttn"><?=$option_p2?></textarea></td>
															<!-- <td><textarea name="option_k2" rows="7" cols="14" class="adminbttn"><?=$option_k2?></textarea></td> -->
														</tr>
													</table>
												</td>
											</tr>
										</table></td>
									</tr>
									<tr><td colspan=3 height=10></td></tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr> 
										<td height="30" align="center">추가옵션3</td>
										<td height="60" colspan="2" align="left">
										<table width="600" border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td width="60" height="35" align="left">옵션명3 :&nbsp;</td>
												<td width="540"><input type="text" name="option_t3" value="<?=$option_t3?>" size="70" class="adminbttn">&nbsp;<!-- <input name="add_opt3" type="checkbox" value="Y" <?if($add_opt3=="Y"){?>checked<?}?>>&nbsp;필수여부 --></td>
											</tr>

											<tr>
												<td colspan="2">
													<table width="600" border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td width="300" align="center">옵션사항</td><td width="200" align="center">증/차감가격</td><!-- <td width="100" align="center">코인적립</td> -->
														</tr>
														<tr>
															<td><textarea name="option_n3" rows="7" cols="45" class="adminbttn"><?=$option_n3?></textarea></td>
															<td><textarea name="option_p3" rows="7" cols="28" class="adminbttn"><?=$option_p3?></textarea></td>
															<!-- <td><textarea name="option_k3" rows="7" cols="14" class="adminbttn"><?=$option_k3?></textarea></td> -->
														</tr>
													</table>
												</td>
											</tr>
										</table></td>
									</tr>
									<tr><td colspan=3 height=10></td></tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr> 
										<td height="30" align="center">추가옵션4</td>
										<td height="60" colspan="2" align="left">
										<table width="600" border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td width="60" height="35" align="left">옵션명4 :&nbsp;</td>
												<td width="540"><input type="text" name="option_t4" value="<?=$option_t4?>" size="70" class="adminbttn">&nbsp;<!-- <input name="add_opt4" type="checkbox" value="Y" <?if($add_opt4=="Y"){?>checked<?}?>>&nbsp;필수여부 --></td>
											</tr>

											<tr>
												<td colspan="2">
													<table width="600" border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td width="300" align="center">옵션사항</td><td width="200" align="center">증/차감가격</td><!-- <td width="100" align="center">코인적립</td> -->
														</tr>
														<tr>
															<td><textarea name="option_n4" rows="7" cols="45" class="adminbttn"><?=$option_n4?></textarea></td>
															<td><textarea name="option_p4" rows="7" cols="28" class="adminbttn"><?=$option_p4?></textarea></td>
															<!-- <td><textarea name="option_k4" rows="7" cols="14" class="adminbttn"><?=$option_k4?></textarea></td> -->
														</tr>
													</table>
												</td>
											</tr>
										</table></td>
									</tr>
									<tr><td colspan=3 height=10></td></tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr> 
										<td height="30" align="center">추가옵션5</td>
										<td height="60" colspan="2" align="left">
										<table width="600" border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td width="60" height="35" align="left">옵션명5 :&nbsp;</td>
												<td width="540"><input type="text" name="option_t5" value="<?=$option_t5?>" size="70" class="adminbttn">&nbsp;<!-- <input name="add_opt5" type="checkbox" value="Y" <?if($add_opt5=="Y"){?>checked<?}?>>&nbsp;필수여부 --></td>
											</tr>

											<tr>
												<td colspan="2">
													<table width="600" border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td width="300" align="center">옵션사항</td><td width="200" align="center">증/차감가격</td><!-- <td width="100" align="center">코인적립</td> -->
														</tr>
														<tr>
															<td><textarea name="option_n5" rows="7" cols="45" class="adminbttn"><?=$option_n5?></textarea></td>
															<td><textarea name="option_p5" rows="7" cols="28" class="adminbttn"><?=$option_p5?></textarea></td>
															<!-- <td><textarea name="option_k5" rows="7" cols="14" class="adminbttn"><?=$option_k5?></textarea></td> -->
														</tr>
													</table>
												</td>
											</tr>
										</table></td>
									</tr>
									<tr><td colspan=3 height=10></td></tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr> 
										<td height="30" align="center">현재수량</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="currnum" value="<?=$currnum?>" size="16" maxlength="16" class="adminbttn">개
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										<td height="30" align="center">재고경고수량</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="warnnum" value="<?=$warnnum?>" size="16" maxlength="16" class="adminbttn">개<font color="#003366"> * 재고가 경고수량으로 떨어지면 관리자가 파악 가능 합니다.</font>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr>
<!-- 관련상품 -->
									<!-- <tr> 
										<td width="115" height="30" align="center">관련상품1</td>
										<td width="479" height="30">
											&nbsp;&nbsp;
											<input type="text" name="relation1" value="<?=$relation1?>" size="15" maxlength="30" class="adminbttn"> <input type="button" value="상품검색" class="adminbttn" onclick="javascript:window.open('product_search.php?relation_dis=relation1','','width=820,height=500');">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr> 
										<td width="115" height="30" align="center">관련상품2</td>
										<td width="479" height="30">
											&nbsp;&nbsp;
											<input type="text" name="relation2" value="<?=$relation2?>" size="15" maxlength="30" class="adminbttn"> <input type="button" value="상품검색" class="adminbttn" onclick="javascript:window.open('product_search.php?relation_dis=relation2','','width=820,height=500');">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr> 
										<td width="115" height="30" align="center">관련상품3</td>
										<td width="479" height="30">
											&nbsp;&nbsp;
											<input type="text" name="relation3" value="<?=$relation3?>" size="15" maxlength="30" class="adminbttn"> <input type="button" value="상품검색" class="adminbttn" onclick="javascript:window.open('product_search.php?relation_dis=relation3','','width=820,height=500');">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr> 
										<td width="115" height="30" align="center">관련상품4</td>
										<td width="479" height="30">
											&nbsp;&nbsp;
											<input type="text" name="relation4" value="<?=$relation4?>" size="15" maxlength="30" class="adminbttn"> <input type="button" value="상품검색" class="adminbttn" onclick="javascript:window.open('product_search.php?relation_dis=relation4','','width=820,height=500');">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
									

									<!-- <tr> 
										<td height="30" align="center">상품리스트</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="imgl" value="<?=$imgl?>" size="50">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr>
									<tr> 
										<td height="30" align="center">중간이미지</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="imgm" value="<?=$imgm?>" size="50">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr> -->
	<!-- 리스트이미지, 중간이미지 -->
									<tr>
										<td colspan=3><table width="800" border='0' cellspacing='0' cellpadding='0'>
												<tr>
													<td width="345" align="right"><table width="250" border='0' cellspacing='0' cellpadding='0'>
															<tr>
																<td width="250"><table width="250" border='0' cellspacing='0' cellpadding='0'>
																		<tr>
																			<td width="100" height="100">
																				<?if($imgl){?>&nbsp;&nbsp;<img src="<?=$shop_img.$imgl?>" width=100 height=100><?}?>
																			</td>
																			<td width="150" align="center" valing="middle">
																				<b>상품리스트</b><br />(175*175)
																			</td>
																		
																		</tr>
																		</table>
																</td>
															</tr>
															<tr>
																<td width="250" colspan="2" align="right">
																	<input type="file" name="imgl" size="25" maxlength="30" value="$imgl" class="adminbttn"> 
											<input type="hidden" name='imgl_copy' value="<?=$imgl?>">
																</td>
															</tr>
															</table>
													</td>
													<td width="30">&nbsp;</td>
													<td width="345" align="right"><table width="250" border='0' cellspacing='0' cellpadding='0'>
															<tr>
																<td width="250"><table width="250" border='0' cellspacing='0' cellpadding='0'>
																		<tr>
																			<td width="100" height="100">
																				<?if($imgm){?>&nbsp;&nbsp;<img src="<?=$shop_img.$imgm?>" width=100 height=100><?}?>
																			</td>
																			<td align="center" valing="middle">
																				<b>상세설명 1</b><br />(275*275)
																			</td>
																			
																		</tr>
																		</table>
																</td>
															</tr>
															<tr>
																<td width="250" colspan="2" align="right">
																	<input type="file" name="imgm" size="25" maxlength="30" value="$imgm"class="adminbttn"> 
											<input type="hidden" name='imgm_copy' value="<?=$imgm?>">
																</td>
															</tr>
															</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>	
									


<!-- 상세이미지1, 상세이미지2 -->
									<tr>
										<td colspan=3><table width="800" border='0' cellspacing='0' cellpadding='0'>
												<tr>
													<td width="345" align="right"><table width="250" border='0' cellspacing='0' cellpadding='0'>
															<tr>
																<td width="250"><table width="250" border='0' cellspacing='0' cellpadding='0'>
																		<tr>
																		
																			<td width="100" height="100">
																				<?if($imgb1){?>&nbsp;&nbsp;<img src="<?=$shop_img.$imgb1?>" width=100 height=100><?}?>
																			</td>
																			<td align="center" valing="middle">
																				<b>상세설명 2</b><br />(275*275)
																			</td>

																		</tr>
																		</table>
																</td>
															</tr>
															<tr>
																<td width="250" colspan="2" align="right">
																	<input type="file" name="imgb1" size="25" maxlength="30" class="adminbttn"> 
											<input type="hidden" name='imgb1_copy' value="<?=$imgb1?>">
																</td>
															</tr>
															</table>
													</td>
													<td width="30">&nbsp;</td>
													<td width="345" align="right"><table width="250" border='0' cellspacing='0' cellpadding='0'>
															<tr>
																<td width="250"><table width="250" border='0' cellspacing='0' cellpadding='0'>
																		<tr>
																			<td width="100" height="100">
																				<?if($imgb3){?>&nbsp;&nbsp;<img src="<?=$shop_img.$imgb3?>" width=100 height=100><?}?>
																			</td>
																			<td align="center" valing="middle">
																				<b>상세설명 3</b><br />(275*275)
																			</td>
																			
																		</tr>
																		</table>
																</td>
															</tr>
															<tr>
																<td width="250" colspan="2" align="right">
																	<input type="file" name="imgb3" size="25" maxlength="30" class="adminbttn"> 
											<input type="hidden" name='imgb3_copy' value="<?=$imgb3?>">
																</td>
															</tr>
															</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>

									



									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr>
					
								<!-- 내 용 -->

								<tr><td colspan=3 height=10></td></tr>
								<!-- <tr> 
										<td height="30" align="center">이벤트내용</td>
										<td height="30">
											&nbsp;&nbsp; 
											<textarea name="event_str" cols="92"  rows="10"><?=$event_str?></textarea>
										</td>
									</tr>
									<tr><td colspan=3 height=10></td></tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr><td colspan=3 height=10></td></tr> -->
								<tr>
									<td colspan="3" align="center">
										&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="detail" id="detail" rows="10" cols="100"><?=$detail?></textarea>
									</td>
								</tr>
								<script type="text/javascript">
									var oEditors = [];
									nhn.husky.EZCreator.createInIFrame({
										oAppRef: oEditors,
										elPlaceHolder: "detail",
										sSkinURI: "se2/SmartEditor2Skin.html",
										fCreator: "createSEditor2"
									});
								</script>
								<tr><td colspan=3 height=10></td></tr>					
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									<!-- 판매아이디 등록시 -->
									<!-- <tr> 
										<td width="115" height="30" align="center">판매아이디</td>
										<td width="479" height="30">
											&nbsp;&nbsp;
											<select name="p_id">
												<option value="admin"<?if($p_id=="admin"){?>selected<?}?>>admin</option>
												<?
												// $query = "SELECT id,name from $member_table where dis='1' ORDER BY signdate DESC";	
												// $DB->get($query,$rs,$rn);
												
												// for($i = 0; $i < $total_record=$rn; $i++) { 
												// 	$id =$rs[$i][0];
												// 	$name =$rs[$i][1];
												?>
												<option value="<?=$id?>" <?if($p_id==$id){?>selected<?}?>><?=$id?>(<?=$name?>)</option>
												<?
												// }
											?>
											</select>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
									<input type="hidden" name="p_id" value="admin">


									<tr> 
										<td width="115" height="30" align="center">판매대기</td>
										<td width="479" height="30" align="left">
											&nbsp;&nbsp;
											<input type="checkbox" name="soldout" value="Y" <?if ($soldout=="Y") echo("checked")?>>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									
									<tr> 
										<td colspan="2" height="40" align="center"> 
											<input type="button" value="등록하기" class="adminbttn" onClick="javascript:regist()">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									</form>  
								</table>
								<br><br>
							</td>
						</tr>
					</table> 					
<!-- 게시판 end -->
							</td>
						</tr>
						<tr><td height=40></td></tr>
					</table>

<? include "../inc/down_menu.php"; ?>		