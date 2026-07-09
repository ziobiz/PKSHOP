<?
$sel_code=$_REQUEST["sel_code"];



// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../common/user_function.php";
########## 데이터베이스에 연결한다. #################################

include "../inc/top_menu.php";
include "../inc/left_menu_product.php";


$shop_img="//pentakleva.shop/upload/";
$shop_img_lode="//pentakleva.shop/upload/";

if($first!="Y") {
	$query="select No,code1,code2,code3,code,title,info,company,color,size,home,shelf,theme,event,event_str,new,pricec,prices,priced,point,point_dis,currnum,warnnum,imgl,imgm,imgb1,imgb2,imgb3,imgb4,imgb5,detail,feature,signdate,soldout,rank,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,order1,order2,order3,color_opt,size_opt,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5,relation,price_dis,best,cut,recommend,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,rank_g,rank_n,rank_r,rank_f,rank_x,rank_y,rank_z,opt_num,opt_num_str,theme_s,rank_s,code4,order4,p_id,esigndate,coin,pr_kind,c_pv,country,onlypoint,c_dis";

	$query=$query." FROM ";
	$query=$query." $shop_goods where No='$No'";

	$DB->get($query,$rs,$rn);

$No = $rs[0][0];					$code1 = $rs[0][1];
$code2 = $rs[0][2];				$code3 = $rs[0][3];
$code = $rs[0][4];				$title = $rs[0][5];
$info = $rs[0][6];					$company = $rs[0][7];
$color = $rs[0][8];				$size = $rs[0][9];
$home = $rs[0][10];				$shelf = $rs[0][11];
$theme = $rs[0][12];				$event = $rs[0][13];
$event_str = $rs[0][14];			$new = $rs[0][15];
$pricec = $rs[0][16];				$sprice = $rs[0][17];
$priced = $rs[0][18];				$point = $rs[0][19];
$point_dis = $rs[0][20];			$currnum = $rs[0][21];
$warnnum = $rs[0][22];			$imgl = $rs[0][23];
$imgm = $rs[0][24];				$imgb1 = $rs[0][25];
$imgb2 = $rs[0][26];				$imgb3 = $rs[0][27];
$imgb4 = $rs[0][28];				$imgb5 = $rs[0][29];
$detail = $rs[0][30];				$feature = $rs[0][31];
$signdate = $rs[0][32];			$soldout = $rs[0][33];
$rank = $rs[0][34];				$option_t1 = $rs[0][35];
$option_n1 = $rs[0][36];			$option_p1 = $rs[0][37];
$option_k1 = $rs[0][38];			$option_t2 = $rs[0][39];
$option_n2 = $rs[0][40];			$option_p2 = $rs[0][41];
$option_k2 = $rs[0][42];			$option_t3 = $rs[0][43];
$option_n3 = $rs[0][44];			$option_p3 = $rs[0][45];
$option_k3 = $rs[0][46];			$option_t4 = $rs[0][47];
$option_n4 = $rs[0][48];			$option_p4 = $rs[0][49];
$option_k4 = $rs[0][50];			$option_t5 = $rs[0][51];
$option_n5 = $rs[0][52];			$option_p5 = $rs[0][53];
$option_k5 = $rs[0][54];			$order1 = $rs[0][55];
$order2 = $rs[0][56];				$order3 = $rs[0][57];
$color_opt = $rs[0][58];			$size_opt = $rs[0][59];
$add_opt1 = $rs[0][60];			$add_opt2 = $rs[0][61];
$add_opt3 = $rs[0][62];			$add_opt4 = $rs[0][63];
$add_opt5 = $rs[0][64];			$relation = $rs[0][65];
$price_dis = $rs[0][66];			$best = $rs[0][67];
$cut = $rs[0][68];					$recommend = $rs[0][69];
$theme_g = $rs[0][70];			$theme_n = $rs[0][71];
$theme_r = $rs[0][72];			$theme_f = $rs[0][73];
$theme_x = $rs[0][74];			$theme_y = $rs[0][75];
$theme_z = $rs[0][76];			$rank_g = $rs[0][77];
$rank_n = $rs[0][78];				$rank_r = $rs[0][79];
$rank_f = $rs[0][80];				$rank_x = $rs[0][81];
$rank_y = $rs[0][82];				$rank_z = $rs[0][83];
$opt_num = $rs[0][84];			$opt_num_str = $rs[0][85];
$theme_s = $rs[0][86];			$rank_s = $rs[0][87];
$code4 = $rs[0][88];				$order4 = $rs[0][89];
$p_id = $rs[0][90];				$esigndate = $rs[0][91];
$coin = $rs[0][92];				$pr_kind = $rs[0][93];
$c_pv = $rs[0][94];
$country = $rs[0][95];
$onlypoint = $rs[0][96];
$dis = $rs[0][97];


$M_Year = date("Y",$esigndate);
$M_Month = date("m",$esigndate);
$M_Day = date("d",$esigndate);

// $query1 = "SELECT coin_price FROM $coin_goods where No='$No'";
// $DB->get($query1,$rs1,$rn1);


$value1 = $rs1[0][0];
$prices = $value1[0];

}

	$old_imgl!="" ? $imgl=$old_imgl : $imgl=$imgl;
	$old_imgm!="" ? $imgm=$old_imgm : $imgm=$imgm;
	$old_imgb1!="" ? $imgb1=$old_imgb1 : $imgb1=$imgb1;
	$old_imgb2!="" ? $imgb2=$old_imgb2 : $imgb2=$imgb2;
	$old_imgb3!="" ? $imgb3=$old_imgb3 : $imgb3=$imgb3;
	$old_imgb4!="" ? $imgb4=$old_imgb4 : $imgb4=$imgb4;
	$old_imgb5!="" ? $imgb5=$old_imgb5 : $imgb5=$imgb5;

	$title = stripslashes($title);                $title = htmlspecialchars($title);
	$info = stripslashes($info);                  $info = htmlspecialchars($info);
	$detail = stripslashes($detail);              
	$feature = stripslashes($feature);
	
	$event_tmp=explode(',',$event);
	$event1=$event_tmp[0];$event2=$event_tmp[1];$event3=$event_tmp[2];$event4=$event_tmp[3];$event5=$event_tmp[4];

	$event_str_tmp=explode(',',$event_str);
	$event1_str=$event_str_tmp[0];$event2_str=$event_str_tmp[1];$event3_str=$event_str_tmp[2];$event4_str=$event_str_tmp[3];$event5_str=$event_str_tmp[4];

	//$theme_tmp=explode(',',$theme);
	//$theme_g=$theme_tmp[0];$theme_r=$theme_tmp[1];$theme_n=$theme_tmp[2];$theme_b=$theme_tmp[3];$theme_p=$theme_tmp[4];

	$relation=explode('-',$relation);
	$relation1=$relation[0];$relation2=$relation[1];$relation3=$relation[2];$relation4=$relation[3];$relation5=$relation[4];

$aoption_p1 = explode("\n",$option_p1);

// var_dump($aoption_p1);
foreach($aoption_p1 as $tmp_str){
	$tmp_str1 = preg_replace("/[^\d | ^. | ^-]/", "", $tmp_str);
	//echo $tmp_str." : ".$tmp_str1."<br>";
}
#####################################################################
?>
<script language="javascript">
<!--
function go_select(i) {
	document.form.sel_code.value=i;
	document.form.action="pro_info.php?sel_code=" + i + "&No=" + <?=$No?>;
	document.form.submit();
}

function go_stock(i) {
	document.form.action="pro_buylist.php";
	document.form.submit();
}
function go_modify() {
	if(document.form.country.value ==""){
		alert("국가를 선택해주세요");
		return false;
	}
	oEditors.getById["detail"].exec("UPDATE_CONTENTS_FIELD", []);
	document.form.action="pro_info_ok.php";	
	document.form.submit();
}
function go_list(theme) {	
	if (theme=="n") document.form.action="pro_new.php";
	else if (theme=="r") document.form.action="pro_propose.php";
	else if (theme=="f") document.form.action="pro_like.php";
	else if (theme=="x") document.form.action="pro_x.php";
	else if (theme=="y") document.form.action="pro_y.php";
	else if (theme=="z") document.form.action="pro_z.php";
	else document.form.action="products.php";
	document.form.submit();
}

//-->
</script>


				<script type="text/javascript" src="se2/js/HuskyEZCreator.js" charset="utf-8"></script>
				<table width="800" border="0" cellspacing="0" cellpadding="0">
					<tr><td height=30></td></tr>
					<tr><td>
							<table width='800' border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>상품정보</b></td>
									<td align="right"><!-- <? include './copy_goods.php';?> --></td>
								</tr>
							</table>
					</td></tr>
					<tr><td height=3></td></tr>
					<?
					
					if ($sel_code=="1") {
						$code1=$_POST["code1"];
						$code2="";
						$code3="";
						$code4="";
					}else if ($sel_code=="2") {
						$code1=$_POST["code1"];
						$code2=$_POST["code2"];
						$code3="";
						$code4="";
					}else if ($sel_code=="3") {
						$code1=$_POST["code1"];
						$code2=$_POST["code2"];
						$code3=$_POST["code3"];
						$code4="";
					}else if ($sel_code=="4") {
						$code1=$_POST["code1"];
						$code2=$_POST["code2"];
						$code3=$_POST["code3"];
						$code4=$_POST["code4"];
						
					}
					
					?>
					<tr>
						<td>							
							<table width="800" border='0' cellspacing='0' cellpadding='0'>
							<form name="form" method="post" ENCTYPE="multipart/form-data">
							<input type='hidden' name='No' value='<?=$No?>'>
								<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
									<tr><td colspan=2 height=5></td></tr>
								<tr> 
									<td width="115" height="30" align="center">카테고리</td>
									<td width="585" height="30" align="left">
										&nbsp;&nbsp;
										<input type="hidden" name="code1_tmp" value="<?=$code1?>">
										<select name="code1" class="adminbttn" size="1" OnChange="go_select('1');">
										<option value="00" selected>1 차 카테고리</option>
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
										<input type="hidden" name="code2_tmp" value="<?=$code2?>">
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
?>
										<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>
<?           
}
?>
										</select>
										&nbsp;&nbsp;
										<input type="hidden" name="code3_tmp" value="<?=$code3?>">
										<select name="code3" class="adminbttn" size="1" OnChange="go_select('3');">
										<option value="00" selected>3 차 카테고리</option>
<?
#####################################################################
$query = "SELECT cate3,code3 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3!='00' and code4='00' ORDER BY order_rank";
$DB->get($query,$rs,$rn);
$total_record =$rn;

for ($i=0;$i<$total_record=$rn;$i++) {
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($code3==$g_code) $oselect = "selected";
	else $oselect = "";

#####################################################################
?>
										<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>

<?              
}
?>


										</select>&nbsp;&nbsp;
										<input type="hidden" name="code4_tmp" value="<?=$code4?>">
										<select name="code4" class="adminbttn" size="1" OnChange="go_select('4');">
										<option value="00" selected>4 차 카테고리</option>
<?
#####################################################################
$query = "SELECT cate4,code4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4!='00' ORDER BY order_rank";
$DB->get($query,$rs,$rn);
$total_record =$rn;

for ($i=0;$i<$total_record=$rn;$i++) {
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($code4==$g_code) $oselect = "selected";
	else $oselect = "";

#####################################################################
?>
										<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>

<?              
}
?>


										</select></td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

							
									<tr>
										<td width="115" height="30" align="center">상품코드</td>
										<td width="479" height="30" align="left">
											&nbsp;&nbsp;
											<input type="text" name="code" value="<?echo($code)?>" size="16" maxlength="15" class="adminbttn" readonly><font color="#003366">* 자동 생성되는 코드입니다.</font>
											<input type="hidden" name="code_Ori" value="<?=$code_Ori?>">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<input type="hidden" name="order1" value="<?=$order1?>">
									<input type="hidden" name="order2" value="<?=$order2?>">
									<input type="hidden" name="order3" value="<?=$order3?>">
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
											일반제품 <input type="radio" name="dis" value="0" <?if($dis=="0"){?>checked<?}?> class="adminbttn">
											&nbsp;&nbsp; 
											재구매제품 <input type="radio" name="dis" value="1" <?if($dis=="1"){?>checked<?}?> class="adminbttn">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> 
									<!-- <tr> 
										<td height="30" align="center">상품주소</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="info" value="<?=$info?>" size="72" maxlength="200" class="adminbttn">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>  -->
									
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
												<option <?=$country =="82" ? " selected " : ""?> value="82">KOREA</option>
												<option <?=$country =="66" ? " selected " : ""?> value="66">THAILAND</option>
												<option <?=$country =="91" ? " selected " : ""?> value="91">INDIA </option>
												<option <?=$country =="" || $country =="1" ? " selected " : ""?>  value="1" >USA</option>
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
											<input type="text" name="color_s" value="하늘색,핑크색,블랙,화이트" size="85" class="adminbttn" style="color:silver;"onFocus="this.blur();"><!-- &nbsp;<input name="size_opt_s" type="checkbox" checked onFocus="this.blur();">필수여부 -->
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
											<!-- <font color="#003366">&nbsp;<input name="color_opt" type="checkbox" value="Y" <?if($color_opt=='Y'){?>checked<?}?>>&nbsp;필수여부
											<input name="color_opt_tmp" type="hidden" value="<?=$color_opt?>" size="50"> -->
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										<td height="30" align="center">사이즈/규격</td>
										<td height="30" align="left">
											&nbsp;&nbsp; 
											<input type="text" name="size" value="<?=$size?>" size="85" class="adminbttn">
											<!-- <font color="#003366">&nbsp;<input name="size_opt" type="checkbox" value="Y" <?if($size_opt=='Y'){?>checked<?}?>>필수여부
											<input name="size_opt_tmp" value="<?=$size_opt?>" type="hidden" size="50"> -->
										</td>
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
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr> --> 

<!-- 상품홍보 및 이벤트 -->
									<tr> 
										<td height="30" align="center">상품홍보</td>
										<td height="55" style="padding-left:10px;" align="left">
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
														<input type="radio" name="recommend" value="N" <?if($recommend=="N" || $recommend==""){?>checked<?}?>>사용안함
													</td>
													<td width="45"><img src="../image/icon_02.gif"></td>
													<td width="250">
														<input type="radio" name="new" value="Y"			<?if($new=="Y"){?>checked<?}?>>사용함
														<input type="radio" name="new" value="N" <?if($new=="N" || $new==""){?>checked<?}?>>사용안함&nbsp;&nbsp;
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
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr> -->
<!-- 현금결제 -->
									<!-- <tr> 
										<td height="30" align="center">현금결제</td>
										<td height="30">
											&nbsp;&nbsp;
											<input type="radio" name="price_dis" value="Y" <?if($price_dis=="Y"){?>checked<?}?>>사용함
											<input type="radio" name="price_dis"  value="N"  <?if($price_dis=="N" || $price_dis==""){?>checked<?}?>>사용안함&nbsp;
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr> 
										<td height="30" align="center">입고가격/날짜</td>
										<td height="30">
											&nbsp;&nbsp; 
											<input type="text" name="feature" value="<?=$feature?>" size="50" class="adminbttn">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
									
<!-- 가격 -->

<input type="hidden" name="pr_kind" value="main">
									<!-- <tr> 
									<td width="115" height="30" align="center">제품종류</td>
									<td width="585" height="30" align="left">
										&nbsp;&nbsp;
										<select name="pr_kind" class="adminbttn" size="1" >
										<option value="main" <?if ($pr_kind=="main"){?>selected<?}?>>메인제품</option>
										<option value="resell" <?if ($pr_kind=="resell"){?>selected<?}?>>재구매제품</option>

										</select>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->

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
											<input type="text" name="prices" value="<?=$sprice?>" size="30"  class="adminbttn" > 원
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
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
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
											<input type="text" name="coin" value="<?=$coin?>" size="30"  class="adminbttn" > 
										</td>
									</tr> -->

									<!-- <tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
 									<tr>  
 										<td height="30" align="center">수당지급률</td>
 										<td height="30" align="left">
											&nbsp;&nbsp;  
											<input type="text" name="point" value="<?=$point?>" size="30"  class="adminbttn">
 										</td> 
									</tr>  -->
<!--									<tr> 
										<td height="30" align="center">부가세</td>
										<td height="30" align="left">&nbsp;&nbsp; 
											<input type="text" name="fee" value="" size="16" maxlength="16" class="adminbttn">&nbsp;&nbsp;원&nbsp;&nbsp;										</td>
									</tr>-->
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr> 
									<tr><td colspan=3 height=10></td></tr>
									<!-- <tr> 
										<td height="30" align="center">코인적립</td>
										<td height="30" align="left">&nbsp;&nbsp; 
											<input type="text" name="point" value="<?=$point?>" size="16" maxlength="16" class="adminbttn">&nbsp;&nbsp;<input type="radio" name="point_dis" value="wo" <?if($point_dis=="wo" || $point_dis==""){?>checked<?}?>>원&nbsp;&nbsp;<input type="radio" name="point_dis"  value="pe" <?if($point_dis=="pe"){?>checked<?}?>>% (추가옵션의 코인적립에도 적용됩니다.)
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr>-->
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
															<td><textarea name="option_n1_s" rs[0]s="7" cols="35" class="adminbttn" onFocus="this.blur();"  style="color:silver;"><?=$str1?></textarea></td>
															<td><textarea name="option_p1" rs[0]s="7" cols="20" class="adminbttn" onFocus="this.blur();"  style="color:silver;"><?=$str2?></textarea></td>
															<!-- <td><textarea name="option_k1" rs[0]s="7" cols="12" class="adminbttn" onFocus="this.blur();"  style="color:silver;"><?=$str3?></textarea></td> -->
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
												<td width="540"><input type="text" name="option_t1" value="<?=$option_t1?>" size="70" class="adminbttn"><!-- &nbsp;<input name="add_opt1" type="checkbox" value="Y" <?if($add_opt1=="Y"){?>checked<?}?>>&nbsp;필수여부 --></td>
											</tr>

											<tr>
												<td colspan="2">
													<table width="600" border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td width="300" align="center">옵션사항</td><td width="200" align="center">증/차감가격</td><!-- <td width="100" align="center">코인적립</td> -->
														</tr>
														<tr>
															<td><textarea name="option_n1" rs[0]s="7" cols="45" class="adminbttn"><?=$option_n1?></textarea></td>
															<td><textarea name="option_p1" rs[0]s="7" cols="28" class="adminbttn"><?=$option_p1?></textarea></td>
															<!-- <td><textarea name="option_k1" rs[0]s="7" cols="14" class="adminbttn"><?=$option_k1?></textarea></td> -->
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
												<td width="540"><input type="text" name="option_t2" value="<?=$option_t2?>" size="70" class="adminbttn"><!-- &nbsp;<input name="add_opt2" type="checkbox" value="Y" <?if($add_opt2=="Y"){?>checked<?}?>>&nbsp;필수여부 --></td>
											</tr>

											<tr>
												<td colspan="2">
													<table width="600" border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td width="300" align="center">옵션사항</td><td width="200" align="center">증/차감가격</td><!-- <td width="100" align="center">코인적립</td> -->
														</tr>
														<tr>
															<td><textarea name="option_n2" rs[0]s="7" cols="45" class="adminbttn"><?=$option_n2?></textarea></td>
															<td><textarea name="option_p2" rs[0]s="7" cols="28" class="adminbttn"><?=$option_p2?></textarea></td>
															<!-- <td><textarea name="option_k2" rs[0]s="7" cols="14" class="adminbttn"><?=$option_k2?></textarea></td> -->
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
												<td width="540"><input type="text" name="option_t3" value="<?=$option_t3?>" size="70" class="adminbttn"><!-- &nbsp;<input name="add_opt3" type="checkbox" value="Y" <?if($add_opt3=="Y"){?>checked<?}?>>&nbsp;필수여부 --></td>
											</tr>

											<tr>
												<td colspan="2">
													<table width="600" border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td width="300" align="center">옵션사항</td><td width="200" align="center">증/차감가격</td><!-- <td width="100" align="center">코인적립</td> -->
														</tr>
														<tr>
															<td><textarea name="option_n3" rs[0]s="7" cols="45" class="adminbttn"><?=$option_n3?></textarea></td>
															<td><textarea name="option_p3" rs[0]s="7" cols="28" class="adminbttn"><?=$option_p3?></textarea></td>
															<!-- <td><textarea name="option_k3" rs[0]s="7" cols="14" class="adminbttn"><?=$option_k3?></textarea></td> -->
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
												<td width="540"><input type="text" name="option_t4" value="<?=$option_t4?>" size="70" class="adminbttn"><!-- &nbsp;<input name="add_opt4" type="checkbox" value="Y" <?if($add_opt4=="Y"){?>checked<?}?>>&nbsp;필수여부 --></td>
											</tr>

											<tr>
												<td colspan="2">
													<table width="600" border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td width="300" align="center">옵션사항</td><td width="200" align="center">증/차감가격</td><!-- <td width="100" align="center">코인적립</td> -->
														</tr>
														<tr>
															<td><textarea name="option_n4" rs[0]s="7" cols="45" class="adminbttn"><?=$option_n4?></textarea></td>
															<td><textarea name="option_p4" rs[0]s="7" cols="28" class="adminbttn"><?=$option_p4?></textarea></td>
															<!-- <td><textarea name="option_k4" rs[0]s="7" cols="14" class="adminbttn"><?=$option_k4?></textarea></td> -->
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
												<td width="540"><input type="text" name="option_t5" value="<?=$option_t5?>" size="70" class="adminbttn"><!-- &nbsp;<input name="add_opt5" type="checkbox" value="Y" <?if($add_opt5=="Y"){?>checked<?}?>>&nbsp;필수여부 --></td>
											</tr>

											<tr>
												<td colspan="2">
													<table width="600" border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td width="300" align="center">옵션사항</td><td width="200" align="center">증/차감가격</td><!-- <td width="100" align="center">코인적립</td> -->
														</tr>
														<tr>
															<td><textarea name="option_n5" rs[0]s="7" cols="45" class="adminbttn"><?=$option_n5?></textarea></td>
															<td><textarea name="option_p5" rs[0]s="7" cols="28" class="adminbttn"><?=$option_p5?></textarea></td>
															<!-- <td><textarea name="option_k5" rs[0]s="7" cols="14" class="adminbttn"><?=$option_k5?></textarea></td> -->
														</tr>
													</table>
												</td>
											</tr>
										</table></td>
									</tr>
									<tr><td colspan=3 height=10></td></tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									<tr><td colspan=3 height=1 bgcolor='#88B7DA'></td></tr>
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
										<td width="115" height="30" align="center">작은상품리스트</td>
										<td width="479" height="30">
											
<?
########## 파일이 존재하는지 검사할 자료실의 디렉토리를 설정한다. ###
	
	$savedir = "$shop_img_lode";

#####################################################################

	$filename_jpg = $code . "_s.jpg";
	$filename_gif = $code . "_s.gif";
	if(file_exists("$savedir/$filename_jpg")) {

?>
											&nbsp;&nbsp;<img src="<?=$shop_img.$filename_jpg?>" width=100 height=100>
											<input type="hidden" name='old_imgs' value="<?=$shop_img.$filename_jpg?>">
<?
	}
	if(file_exists("$savedir/$filename_gif")) {
?>
											&nbsp;&nbsp;<img src="<?=$shop_img.$filename_gif?>" width=100 height=100>
											<input type="hidden" name='old_imgs' value="<?=$shop_img.$filename_gif?>">
<?
	}
?>
											&nbsp;&nbsp;
											<input type="file" name="imgs" size="30" maxlength="30" class="adminbttn">
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
											<input type="hidden" name='old_imgl' value="<?=$imgl?>">
																			</td>
																			<td width="150" align="center" valing="middle">
																				<b>상품리스트</b><br />(175*175)<br /><input type='checkbox' name='F_l' value='0'>삭제
																			</td>
																			
																		</tr>
																		</table>
																</td>
															</tr>
															<tr>
																<td width="250" colspan="2" align="right">
																	<input type="file" name="imgl" size="25" maxlength="30" class="adminbttn"> 
											
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
																			<input type="hidden" name='old_imgm' value="<?=$imgm?>">
																			</td>
																			<td align="center" valing="middle">
																				<b>상세설명 1</b><br />(275*275)<br /><input type='checkbox' name='F_m' value='0'>삭제
																			</td>
																			
																		</tr>
																		</table>
																</td>
															</tr>
															<tr>
																<td width="250" colspan="2" align="right">
																	<input type="file" name="imgm" size="25" maxlength="30" class="adminbttn"> 
											
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
																<input type="hidden" name='old_imgb1' value="<?=$imgb1?>">
																			</td>
																			<td align="center" valing="middle">
																				<b>상세설명 2</b><br />(275*275)<br /><input type='checkbox' name='F_b1' value='0'>삭제
																			</td>
																			
																		</tr>
																		</table>
																</td>
															</tr>
															<tr>
																<td width="250" colspan="2" align="right">
																	<input type="file" name="imgb1" size="25" maxlength="30" class="adminbttn"> 
											
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
											<input type="hidden" name='old_imgb3' value="<?=$imgb3?>">
																			</td>
																			<td align="center" valing="middle">
																				<b>상세설명 3</b><br />(275*275)<br /><input type='checkbox' name='F_b3' value='0'>삭제
																			</td>
																			
																		</tr>
																		</table>
																</td>
															</tr>
															<tr>
																<td width="250" colspan="2" align="right">
																	<input type="file" name="imgb3" size="25" maxlength="30" class="adminbttn"> 
											
																</td>
															</tr>
															</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

									

									<!-- <tr>
										<td width="115" height="30" align="center">모션이미지</td>
										<td width="479" height="30">
											
<?

	$filename_jpg = $code . "_motion.jpg";
	$filename_gif = $code . "_motion.gif";
	if(file_exists("$savedir/$filename_jpg")) {

?>
											&nbsp;&nbsp;<img src="<?=$shop_img.$filename_jpg?>" width=100 height=100>
											<input type="hidden" name='old_imgmotion' value="<?=$shop_img.$filename_jpg?>">
											
<?
	}
	if(file_exists("$savedir/$filename_gif")) {
?>
											&nbsp;&nbsp;<img src="<?=$shop_img.$filename_gif?>" width=100 height=100>
											<input type="hidden" name='old_imgmotion' value="<?=$shop_img.$filename_gif?>">
<?
	}
?>
											&nbsp;&nbsp;
											<input type="file" name="imgmotion" size="30" maxlength="30" class="adminbttn">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr>
										<td width="115" height="30" align="center">기타이미지</td>
										<td width="479" height="30">
											
<?

	$filename_jpg = $code . "_etc.jpg";
	$filename_gif = $code . "_etc.gif";
	if(file_exists("$savedir/$filename_jpg")) {

?>
											&nbsp;&nbsp;<img src="<?=$shop_img.$filename_jpg?>" width=100 height=100>
											<input type="hidden" name='old_imgetc' value="<?=$shop_img.$filename_jpg?>">
											
<?

	}
	if(file_exists("$savedir/$filename_gif")) {

?>
											&nbsp;&nbsp;<img src="<?=$shop_img.$filename_gif?>" width=100 height=100>
											<input type="hidden" name='old_imgetc' value="<?=$shop_img.$filename_gif?>">
<?
	}
?>
											&nbsp;&nbsp;
											<input type="file" name="imgetc" size="30" maxlength="30" class="adminbttn">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
								<!-- <tr><td colspan=3 height=10></td></tr>
								<tr> 
										<td height="30" align="center">이벤트내용</td>
										<td height="30">
											&nbsp;&nbsp; 
											<textarea name="event_str" cols="92"  rs[0]s="10"><?=$event_str?></textarea>
										</td>
									</tr>
									<tr><td colspan=3 height=10></td></tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
								<tr><td colspan=3 height=10></td></tr>
								<tr>
									<td colspan="3" align="center">
										&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="detail" id="detail" rs[0]s="10" cols="100"><?=$detail?></textarea>
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
								
								
								<!-- 판매아이디 등록시 -->
									<!-- <tr> 
										<td width="115" height="30" align="center">판매아이디</td>
										<td width="479" height="30" align="left">
											&nbsp;&nbsp;
											<select name="p_id">
												<option value="admin"<?if($p_id=="admin"){?>selected<?}?>>admin</option>
												<?
												// $query = "SELECT id,name from $member_table where dis='1' ORDER BY signdate DESC";	
												// $DB->get($query,$rs,$rn);
												// if(!$result) {
												// error("QUERY_ERROR");
												// exit;
												// }
												// $total_record = mysql_num_rs[0]s($result);
												// for($i = 0; $i < $total_record; $i++) { 
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
									<input type="hidden" name="p_id" value="<?=$p_id?>">

									<!-- <tr> 
										<td width="115" height="30" align="center">이벤트마감일</td>
										<td width="479" height="30">
											&nbsp;&nbsp;
											<select name="char_year" value="굴림" style="font-size:12px;">
										<?
											for($a=2002;$a<2101;$a++) {
										?>
										<option value="<?=$a?>" <?if($M_Year==$a) {?>selected<?}?>><?=$a?></option>									
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
										<option value="<?=$bb?>" <?if($M_Month==$bb) {?>selected<?}?>><?=$bb?></option>	
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
										<option value="<?=$cc?>" <?if($M_Day==$cc) {?>selected<?}?>><?=$cc?></option>	
										<?
											}
										?>
										</select>일 (특별이벤트만 적용)
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr> -->
									<tr> 
										<td width="115" height="30" align="center">판매대기</td>
										<td width="479" height="30" align="left">
											&nbsp;&nbsp;
											<input type="radio" name="soldout" value="Y" <?if ($soldout=="Y") echo("checked")?>> 대기 
											<!-- <input type="radio" name="soldout" value="K" <?if ($soldout=="K") echo("checked")?>> 수정 -->
											<input type="radio" name="soldout" value="N" <?if ($soldout=="N") echo("checked")?>> 등록
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									

									
									
									<tr> 
										<td colspan="2" height="40" align="center"> 
											<input type="hidden" name="first" value="Y">
											<!-- <input type="button" value="재고관리" class="adminbttn" onClick="javascript:go_stock()"> -->
											<input type="button" value="수정" class="adminbttn" 
											onClick="javascript:go_modify()">
											<input type="button" value="목록" class="adminbttn" onClick="javascript:go_list('<?=$sel_theme?>')">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									
									<input type="hidden" name="sel_theme" value="<?=$sel_theme?>">
									<input type="hidden" name="keyfield" value="<?=$keyfield?>">
									<input type="hidden" name="key" value="<?echo($key)?>">
									<input type="hidden" name="chk_order" value="<?=$chk_order?>">
									<input type="hidden" name="sel_cate" value="<?=$sel_cate?>">
									<input type="hidden" name="page" value="<?echo($page)?>">
									<input type="hidden" name="sel_code1" value="<?=$sel_code1?>">  
									<input type="hidden" name="sel_code2" value="<?=$sel_code2?>">  
									<input type="hidden" name="sel_code3" value="<?=$sel_code3?>">  
									<input type="hidden" name="sel_code4" value="<?=$sel_code4?>">  
									<input type="hidden" name="sel_code" value="<?=$sel_code?>">  				
									<input type="hidden" name="old_code" value="<?=$code?>">  				
									</form>  
								</table>
								<br><br>
								
							</table><BR><BR>
							</td>
						</tr>
					</table> 
<? include "../inc/down_menu.php"; ?>
<!-- 글 수정 하기 레이어 실행 -->
<div id="edit" style="position:absolute; width:200px; height:80px; z-index:1; left: 420px; top: 280px; visibility: hidden; border: 1 solid black; background: white">

<table border="0" cellspacing="0" cellpadding="3" width="200">
	<tr bgcolor="#E0E0E0" onMouseOut="drag=0" onMouseOver="dragObj=edit; drag=1;move=0">
   		<td>[√글 수정하기]</td>
		<td align="right"><a href="#" onClick="MM_showHideLayers('edit','','hide')"><img src="./img/close.gif" width="12" height="11" alt="" border="0"></a></td>
	</tr>
	<form method="post" name="Edit">
	<tr>
		<td align="" colspan="2">
			비밀번호: <input type="password" name="PassWord" value="" size="11"  onKeypress="Key_Press_Edit()">  <input type="button" name="button" value="확 인" onClick="Edit_Ok()" style="background-color:white; BORDER: #dddddd 1px solid; WIDTH:50; HEIGHT: 20"> 
			<input type="hidden" name="Edit" value="Edit_ok"><!-- pass_check 구분 변수 -->
			<input type="hidden" name="No" value="<?=$No?>">
			<input type="hidden" name="page" value="<?=$page?>">
		</td>
   </tr>
    <tr>
		<td align="" colspan="2">
			<font color="#CE0005">&nbsp;&nbsp;* 해당 글 을 수정 합니다. <BR>
			   &nbsp;&nbsp;&nbsp; &nbsp;비밀번호를 입력해 주세요</font>
		</td>
   </tr>
	</form>
</table>
</div>


<!-- 글 삭제 하기 레이어 실행 -->
<div id="Del" style="position:absolute; width:200px; height:80px; z-index:1; left: 420px; top: 280px; visibility: hidden; border: 1 solid black; background: white"> 
	<table border=0 cellspacing=0 cellpadding=3 width=200>
		<tr bgcolor="#E0E0E0" onMouseOut="drag=0" onMouseOver="dragObj=Del; drag=1;move=0">
   			<td>[√글 삭제하기]</td>
		<td align="right"><div align="right"><a href="#" onClick="MM_showHideLayers('Del','','hide')"><img src="./img/close.gif" width="12" height="11" alt="" border="0"></a></div></td>
	</tr>
	<form method="post" name="Delete">
	<tr>
		<td align="" colspan="2">
			비밀번호: <input type="password" name="PassWord" value="" size="11"  onKeypress="Key_Press_Del()">  <input type="button" name="button" value="확인" onClick="Del_Ok()" style="background-color:white; BORDER: #dddddd 1px solid; WIDTH:50; HEIGHT: 20">
			<input type="hidden" name="Del_ok" value="ok"><!-- pass_check 구분 변수 -->
			<input type="hidden" name="No" value="<?=$No?>">
		</td>
   </tr>
   <tr>
		<td align="" colspan="2">
			<font color="#CE0005">&nbsp;&nbsp;* 해당 글 을 삭제 합니다. <BR>
			   &nbsp;&nbsp;&nbsp; &nbsp;비밀번호를 입력해 주세요</font>
		</td>
   </tr>
	</form>
	</table>
</div>