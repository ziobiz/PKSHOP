<? 
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";

$cate = $_GET["cate"];
$cate1 = $_REQUEST["cate1"];
$cate2 = $_REQUEST["cate2"];
$cate3 = $_REQUEST["cate3"];
$cate4 = $_REQUEST["cate4"];

$catenum1 = $_REQUEST["catenum1"];
$catenum2 = $_REQUEST["catenum2"];
$catenum3 = $_REQUEST["catenum3"];
$catenum4 = $_REQUEST["catenum4"];

$code1 = $_REQUEST["code1"];
$code2 = $_REQUEST["code2"];
$code3 = $_REQUEST["code3"];
$code4 = $_REQUEST["code4"];

$cateuid1 = $_REQUEST["cateuid1"];
$cateuid2 = $_REQUEST["cateuid2"];
$cateuid3 = $_REQUEST["cateuid3"];
$cateuid4 = $_REQUEST["cateuid4"];


	$query = "SELECT cate1,code1 FROM $shop_cate WHERE uid='$cateuid1'";
	$DB->get($query,$rs,$rn);

	$cate1 = $rs[0][0];
	$code1 = $rs[0][1];
	$cate1 = stripslashes($cate1);
	$cate1 = htmlspecialchars($cate1);


	$query = "SELECT cate2,code2 FROM $shop_cate WHERE uid='$cateuid2'";
	
	$DB->get($query,$rs,$rn);

	$cate2 = $rs[0][0];
	$code2 = $rs[0][1];
	$cate2 = stripslashes($cate2);
	$cate2 = htmlspecialchars($cate2);
	
	$query = "SELECT cate3,code3 FROM $shop_cate WHERE uid='$cateuid3'";
	$DB->get($query,$rs,$rn);

	$cate3 = $rs[0][0];
	$code3 = $rs[0][1];
	$cate3 = stripslashes($cate3);
	$cate3 = htmlspecialchars($cate3);

	$query = "SELECT cate4,code4 FROM $shop_cate WHERE uid='$cateuid4'";
	$DB->get($query,$rs,$rn);
	

	$cate4 = $rs[0][0];
	$code4 = $rs[0][1];
	$cate4 = stripslashes($cate4);
	$cate4 = htmlspecialchars($cate4);



?>
<script language="javascript">
<!--
//ie에서 배열.indexOf를 사용하기 위한
Array.prototype.indexOf = function(obj) {
    for (var i = 0, length = this.length; i < length; i++)
        if (this[i] == obj) return i;
    return -1;
};


function go_up(i) {
	eval('code = document.form.code' + i + '.value');
	if (code=="")	{
		alert('상품코드를 입력하십시요');
		return;
	}
	eval('cate = document.form.cate' + i + '.value');	
	if (cate=="")	{
		alert('상품명을 입력하십시요');
		return;
	}
	document.form.action = "category_post.php?cate=" + i;
   document.form.submit();
}
function go_modify(i) {
	eval('code = document.form.code' + i + '.value');
	if (code=="")	{
		alert('상품코드를 입력하십시요');
		return;
	}
	eval('cate = document.form.cate' + i + '.value');	
	if (cate=="")	{
		alert('상품명을 입력하십시요');
		return;
	}
	document.form.action = "category_modify.php?cate=" + i;
   document.form.submit();
}
function go_delete(i) {
	document.form.action = "category_delete.php?cate=" + i;
   document.form.submit();
}

function selectcate(i,uid) {
	if (i=="1") {
		document.form.cateuid2.value="";
		document.form.code2.value="";
		document.form.cate2.value="";
		document.form.cateuid3.value="";
		document.form.code3.value="";
		document.form.cate3.value="";
		document.form.cateuid4.value="";
		document.form.code4.value="";
		document.form.cate4.value="";
	}
	else if (i=="2")  {
		document.form.cateuid3.value="";
		document.form.code3.value="";
		document.form.cate3.value="";
		document.form.cateuid4.value="";
		document.form.code4.value="";
		document.form.cate4.value="";
	}
	else if (i=="3")  {
		document.form.cateuid4.value="";
		document.form.code4.value="";
		document.form.cate4.value="";
	}
	eval('document.form.cateuid'+ i +'.value="' + uid + '"');
	document.form.action = "category.php?cate=" + i;
   document.form.submit();
}
 function all_chk(i) {
 	var chk = document.forms.form;
 	var tmpchk = "catechk"+i;
 	for (var i=0; i<chk.length; i++) {
		tmpname = chk[i].name;
		aaa = tmpname.indexOf(tmpchk);
 		if (chk[i].type == "checkbox" && aaa > -1 && chk[i].checked == false) {
 			chk[i].checked = true;
 		} else {
 			chk[i].checked = false;
 		}
 	}
 }
//-->
</script>
<form name="form" method="post">
					<table width=1500 border=0 cellpadding=0 cellspacing=0>
						<tr><td height=30></td></tr>
						<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon1.gif" width=45 height=35 border=0></td>
									<td class='td14'>&nbsp;<b>분류등록/수정</b></td>
								</tr>
							</table>
						</td></tr>
						<tr><td height=3></td></tr>
						<tr>
							<td valign=top align="center">

<!-- 내용 시작 ---->
				<br>
				<table border="0" cellspacing="0" cellpadding="0">
				
					<tr>
						<td> 
							<table width="200" border='1' cellspacing='0' cellpadding='10' bordercolor='#88B7DA' bgcolor='#D2DEE8' align="left">
							 <tr>
								<td valign="top"> 
									<table width="250" border="0" cellspacing="0" cellpadding="0">
										<tr align="center"> 
											<td colspan="3" height="20"><b>1차 카테고리</b></td>
										</tr>
										<tr> 
											<td height="20" width="25" align="left">
												<a href="javascript:all_chk('1')" OnFocus="this.blur()"><B>all</B>
											</td>
											<td height="20" width="98"><b>카테고리 명</b></td>
											<td height="20" width="57"><b>우선순위</b></td>
											<td height="20" width="57"><b>숨김</b></td>
										</tr>
<?
#####################################################################
$query = "SELECT uid,cate1,code1,rank,show1 FROM $shop_cate WHERE code2='00' and code3='00' and code4='00' ORDER BY order_rank";
$DB->get($query,$rs,$rn);
for ($i=0;$i<$rn;$i++) {

	$ii=$i+1;
	$uid = $rs[$i][0];
	$cate = $rs[$i][1];
	$code = $rs[$i][2];
	$rank = $rs[$i][3];
	$show1 = $rs[$i][4];
	$cate_view = stripslashes($cate);
#####################################################################
?>
	
										<tr> 
											<td height="20" width="25" align="left"> 
												<input type="checkbox" name="catechk1<?=$ii?>" value="Y">
											</td>
											<td height="20" width="98">
												<a href="javascript:selectcate('1','<?=$uid?>')" onMouseOver="status='선택'; return true;" onMouseOut="status='';"><?=$cate_view?></a>
											</td>
											<td height="20" width="57" align="center"> 
												<select name="rank1<?=$ii?>" class="adminbttn">

<?			

#####################################################################
			for ($j=1;$j<=$rn;$j++) {			
			if ($ii==$j){ 
				$oselect = "selected";
			}else{
				$oselect = "";
			}
?>
												<option value="<?=$j?>" <?=$oselect?>><?=$j?></option>
<?                  
   }
?>
												</select>
											</td>
											<td height="20" width="25" align="left"> 
												<input type="checkbox" name="show1<?=$ii?>" <?=$show1==1 ? " checked " : ""?> value="1" >
											</td>
										</tr>
              
<?        
}
$rn++;
?>
										<input type="hidden" name="catenum1" value="<?=$rn?>">

									</table>
									<br><br><br>
<?
############1차 카테고리 추가시 자동 코드 생성 쿼리##################

$query = "SELECT code1 FROM $shop_cate ORDER BY code1 desc";

$DB->get($query,$rs,$rn);
$ncode1 = $rs[0][0];
if($ncode1 == "") {
	$ncode1 = "01";
}else {
	$ncode1 = $ncode1 + 1;
	if($ncode1 < 10) {
		$ncode1 = "0" . $ncode1;
	}
}
#####################################################################
?>			
									<table width="250" border="0" cellspacing="0" cellpadding="0">
										<tr> 
											<td width="58" height="20"><b>상품코드</b></td>
											<td width="122" height="20" align="center"><b>카테고리명</b></td>
										</tr>
										<tr> 
											<td width="58" height="20" align="center"> 
												<? if($code1 != "") {$imsi_1=$code1;
												     } else {$imsi_1=$ncode1;
												     }
												?>
												<input type="text" name="code1" value="<?=$imsi_1?>" size="4" maxlength="2" class="adminbttn">
											</td>
											<td width="122" height="20" align="center"> 
												<input type="text" name="cate1" value="<?=$cate1?>" size="16" maxlength="15" class="adminbttn">
											</td>
											<input type="hidden" name="cateuid1" value="<?=$cateuid1?>">
										</tr>
										<tr align="center"> 
											<td colspan="2" height="30">                        
												<input type="button" value="추가" class="adminbttn" onClick="javascript:go_up('1')">
												<input type="button" value="수정" class="adminbttn" onClick="javascript:go_modify('1')">
												<input type="button" value="순위변경" class="adminbttn orderBtn" valid.i='1' valid.num='<?=$rn?>'>
												<input type="button" value="숨김변경" class="adminbttn viewBtn" valid.i='1' valid.num='<?=$rn?>'>
											</td>
										</tr>
										</table>
										<table width="250" border="0" cellspacing="0" cellpadding="0">
											<tr align="center"> 
												<td  height="40"><b>선택된 카테고리</b> 
													<input type="button" value="삭제" class="adminbttn" onClick="javascript:go_delete('1')">
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
							<table width=20 border="0" cellspacing="0" cellpadding="10" align="left"><tr><td>&nbsp;</td></tr></table>
							<table width="200" border='1' cellspacing='0' cellpadding='10' bordercolor='#88B7DA' bgcolor='#D2DEE8' align="left">
								<tr> 
									<td valign="top"> 
										<table width="250" border="0" cellspacing="0" cellpadding="0">
											<tr align="center"> 
												<td colspan="3" height="20"><b>2차 카테고리</b></td>
											</tr>
											<tr> 
												<td height="20" width="25" align="left"><a href="javascript:all_chk('2')" OnFocus="this.blur()"><B>all</B></td>
												<td height="20" width="98"><b>카테고리 명</b></td>
												<td height="20" width="57"><b>우선순위</b></td>
												<td height="20" width="57"><b>숨김</b></td>
											</tr>
<?
#####################################################################

$query = "SELECT uid,cate2,code2,rank,show2 FROM $shop_cate WHERE code1='$code1' and code2!='00' and code3='00' and code4='00' ORDER BY order_rank";
$DB->get($query,$rs,$rn);

for ($i=0;$i<$rn;$i++) {
	$ii=$i+1;
	$uid =$rs[$i][0];
	$cate =$rs[$i][1];
	$code = $rs[$i][2];
	$rank = $rs[$i][3];
	$show2 = $rs[$i][4];
	$cate_view = stripslashes($cate);

#####################################################################
?>
											<tr> 
												<td height="20" width="25" align="left"> 
													<input type="checkbox" name="catechk2<?=$ii?>" value="Y">
												</td>
												<td height="20" width="98">
													<a href="javascript:selectcate('2','<?=$uid?>')" onMouseOver="status='선택'; return true;" onMouseOut="status='';"><?=$cate_view?></a>
												</td>
												<td height="20" width="57" align="center"> 
													<select name="rank2<?=$ii?>" class="adminbttn">
<?
#####################################################################

	for ($j=1;$j<=$rn;$j++) {			
			if ($ii==$j){
				$oselect = "selected";
			}else{
				$oselect = "";
			}
#####################################################################
?>
			
													<option value="<?=$j?>" <?=$oselect?>><?=$j?></option>
<?                      
   }
?>
													</select>
												</td>
												<td height="20" width="25" align="left"> 
												<input type="checkbox" name="show2<?=$ii?>" <?=$show2==1 ? " checked " : ""?>  value="1" >
											</td>
											</tr>
<?      
}
$rn++;
?>
											<input type="hidden" name="catenum2" value="<?=$rn?>">

										</table>
										<br><br><br>
<?
############2차 카테고리 추가시 자동 코드 생성 쿼리##################

$query = "SELECT code2 FROM $shop_cate where code1 = '$code1' ORDER BY code2 desc";
$DB->get($query,$rs,$rn);
$ncode2 = $rs[0][0];

if($ncode2 == "") {
	$ncode2 = "00";
}else {
	$ncode2 = $ncode2 + 1;
	if($ncode2 < 10) {
		$ncode2 = "0" . $ncode2;
	}
}
#####################################################################
?>
										<table width="250" border="0" cellspacing="0" cellpadding="0">
											<tr> 
												<td width="58" height="20"><b>상품코드</b></td>
												<td width="122" height="20" align="center"><b>카테고리명</b></td>
											</tr>
											<tr> 
												<td width="58" height="20" align="center">
													<? if($code2 != "") {$imsi_2=$code2;
												     }else {$imsi_2=$ncode2;
												     }
													?>
													<input type="text" name="code2" value="<?=$imsi_2?>" size="4" maxlength="2" class="adminbttn">
												</td>
												<td width="122" height="20" align="center"> 
													<input type="text" name="cate2" value="<?=$cate2?>" size="16" maxlength="15" class="adminbttn">
												</td>
												<input type="hidden" name="cateuid2" value="<?=$cateuid2?>">
											</tr>
											<tr align="center"> 
												<td colspan="2" height="30">                        
													<input type="button" value="추가" class="adminbttn" onClick="javascript:go_up('2')">
													<input type="button" value="수정" class="adminbttn" onClick="javascript:go_modify('2')">
													<input type="button" value="순위변경" class="adminbttn orderBtn" valid.i='2' valid.num='<?=$rn?>'>
													<input type="button" value="숨김변경" class="adminbttn viewBtn" valid.i='2' valid.num='<?=$rn?>'>
												</td>
											</tr>
										</table>
										<table width="250" border="0" cellspacing="0" cellpadding="0">
											<tr align="center"> 
												<td  height="40"><b>선택된 카테고리</b> 
													<input type="button" value="삭제" class="adminbttn" onClick="javascript:go_delete('2')">
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
<!-- 3차 -->						
							<table width=20 border="0" cellspacing="0" cellpadding="10" align="left"><tr><td>&nbsp;</td></tr></table>
							<table width="205" border='1' cellspacing='0' cellpadding='10' bordercolor='#88B7DA' bgcolor='#D2DEE8'  align="left">
								<tr> 
									<td valign="top"> 
										<table width="250" border="0" cellspacing="0" cellpadding="0">
											<tr align="center"> 
												<td colspan="3" height="20"><b>3차 카테고리</b></td>
											</tr>
											<tr> 
												<td height="20" width="25" align="left">
													<a href="javascript:all_chk('3')" OnFocus="this.blur()"><B>all</B>
												</td>
												<td height="20" width="98"><b>카테고리 명</b></td>
												<td height="20" width="57"><b>우선순위</b></td>
												<td height="20" width="57"><b>숨김</b></td>
											</tr>
<?
#####################################################################

$query = "SELECT uid,cate3,code3,rank,show3 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3!='00' and code4='00' ORDER BY order_rank";
$DB->get($query,$rs,$rn);

for ($i=0;$i<$rn;$i++) {
	$ii=$i+1;
	$uid  = $rs[$i][0];
	$cate = $rs[$i][1];
	$code = $rs[$i][2];
	$rank = $rs[$i][3];
	$show3 = $rs[$i][4];
	$cate_view = stripslashes($cate);

#####################################################################
?>
	
											<tr> 
												<td height="20" width="25" align="left"> 
													<input type="checkbox" name="catechk3<?=$ii?>" value="Y">
												</td>
												<td height="20" width="98">
													<a href="javascript:selectcate('3','<?=$uid?>')" onMouseOver="status='선택'; return true;" onMouseOut="status='';"><?=$cate_view?></a>
												</td>
												<td height="20" width="57" align="center"> 
													<select name="rank3<?=$ii?>" class="adminbttn">


<?	
#####################################################################
	for ($j=1;$j<=$rn;$j++) {			
			if ($ii==$j) {
				$oselect = "selected";
			} else { 
				$oselect = "";
			}
#####################################################################
?>
			
													<option value="<?=$j?>" <?=$oselect?>><?=$j?></option>
<?                       
 }
?>  
													</select>
												</td>
												<td height="20" width="25" align="left"> 
												<input type="checkbox" name="show3<?=$ii?>" <?=$show3==1 ? " checked " : ""?>  value="1" >
											</td>
											</tr>
<?       
}
$rn++;
?>
											<input type="hidden" name="catenum3" value="<?=$rn?>">


										</table>
										<br><br><br>
<?
############3차 카테고리 추가시 자동 코드 생성 쿼리##################

$query = "SELECT code3 FROM $shop_cate where code1 = '$code1' and code2 = '$code2' ORDER BY code3 desc";
$DB->get($query,$rs,$rn);

$ncode3 = $rs[0][0];

if($ncode3 == "") {
	$ncode3 = "00";
}else {
	$ncode3 = $ncode3 + 1;
	if($ncode3 < 10) {
		$ncode3 = "0" . $ncode3;
	}
}
?>
										<table width="250" border="0" cellspacing="0" cellpadding="0">
											<tr> 
												<td width="58" height="20"><b>상품코드</b></td>
												<td width="122" height="20" align="center"><b>카테고리명</b></td>
											</tr>
											<tr> 
												<td width="58" height="20" align="center"> 
													<? if($code3 != "") {$imsi_3=$code3;
												     } else {$imsi_3=$ncode3;
												     }
													?>
													<input type="text" name="code3" value="<?=$imsi_3?>" size="4" maxlength="2" class="adminbttn">
												</td>
												<td width="122" height="20" align="center"> 
													<input type="text" name="cate3" value="<?=$cate3?>" size="16" maxlength="15" 	class="adminbttn">
												</td>
												<input type="hidden" name="cateuid3" value="<?=$cateuid3?>">
											</tr>
											<tr align="center"> 
												<td colspan="2" height="30">                        
													<input type="button" value="추가" class="adminbttn" onClick="javascript:go_up('3')">
													<input type="button" value="수정" class="adminbttn" onClick="javascript:go_modify('3')">
													<input type="button" value="순위변경"  class="adminbttn orderBtn" valid.i='3' valid.num='<?=$rn?>'>
													<input type="button" value="숨김변경" class="adminbttn viewBtn" valid.i='3' valid.num='<?=$rn?>'>
												</td>
											</tr>
										</table>
										
										<table width="250" border="0" cellspacing="0" cellpadding="0">
											<tr align="center"> 
												<td  height="40"><b>선택된 카테고리</b> 
													<input type="button" value="삭제" class="adminbttn" onClick="javascript:go_delete('3')">
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
	<!-- 4차 -->						
							<table width=20 border="0" cellspacing="0" cellpadding="10" align="left"><tr><td>&nbsp;</td></tr></table>
							<table width="205" border='1' cellspacing='0' cellpadding='10' bordercolor='#88B7DA' bgcolor='#D2DEE8'  align="left">
								<tr> 
									<td valign="top"> 
										<table width="250" border="0" cellspacing="0" cellpadding="0">
											<tr align="center"> 
												<td colspan="3" height="20"><b>4차 카테고리</b></td>
											</tr>
											<tr> 
												<td height="20" width="25" align="left">
													<a href="javascript:all_chk('4')" OnFocus="this.blur()"><B>all</B>
												</td>
												<td height="20" width="98"><b>카테고리 명</b></td>
												<td height="20" width="57"><b>우선순위</b></td>
												<td height="20" width="57"><b>숨김</b></td>
											</tr>
<?
#####################################################################

$query = "SELECT uid,cate4,code4,rank,show4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4!='00' ORDER BY order_rank";
$DB->get($query,$rs,$rn);
for ($i=0;$i<$rn;$i++) {
	$ii=$i+1;
	$uid = $rs[$i][0];
	$cate = $rs[$i][1];
	$code = $rs[$i][2];
	$rank = $rs[$i][3];
	$show4 = $rs[$i][4];
	$cate_view = stripslashes($cate);

#####################################################################
?>
	
											<tr> 
												<td height="20" width="25" align="left"> 
													<input type="checkbox" name="catechk4<?=$ii?>" value="Y">
												</td>
												<td height="20" width="98">
													<a href="javascript:selectcate('4','<?=$uid?>')" onMouseOver="status='선택'; return true;" onMouseOut="status='';"><?=$cate_view?></a>
												</td>
												<td height="20" width="57" align="center"> 
													<select name="rank4<?=$ii?>" class="adminbttn">


<?	
#####################################################################
	for ($j=1;$j<=$rn;$j++) {			
			if ($ii==$j) {
				$oselect = "selected";
			} else { 
				$oselect = "";
			}
#####################################################################
?>
			
													<option value="<?=$j?>" <?=$oselect?>><?=$j?></option>
<?                       
 }
?>  
													</select>
												</td>
												<td height="20" width="25" align="left"> 
												<input type="checkbox" name="show4<?=$ii?>" <?=$show4==1 ? " checked " : ""?>  value="1" >
											</td>
											</tr>
<?       
}
$rn++;
?>
											<input type="hidden" name="catenum4" value="<?=$rn?>">


										</table>
										<br><br><br>
<?
############4차 카테고리 추가시 자동 코드 생성 쿼리##################

$query = "SELECT code4 FROM $shop_cate where code1 = '$code1' and code2 = '$code2' and code3 = '$code3' ORDER BY code4 desc";
$DB->get($query,$rs,$rn);
$ncode4 = $rs[0][0];

if($ncode4 == "") {
	$ncode4 = "00";
}else {
	$ncode4 = $ncode4 + 1;
	if($ncode4 < 10) {
		$ncode4 = "0" . $ncode4;
	}
}
?>
										<table width="250" border="0" cellspacing="0" cellpadding="0">
											<tr> 
												<td width="58" height="20"><b>상품코드</b></td>
												<td width="122" height="20" align="center"><b>카테고리명</b></td>
											</tr>
											<tr> 
												<td width="58" height="20" align="center"> 
													<? if($code4 != "") {
														$imsi_4=$code4;
												     } else {
														 $imsi_4=$ncode4;
												     }
													?>
													<input type="text" name="code4" value="<?=$imsi_4?>" size="4" maxlength="2" class="adminbttn">
												</td>
												<td width="122" height="20" align="center"> 
													<input type="text" name="cate4" value="<?=$cate4?>" size="16" maxlength="15" 	class="adminbttn">
												</td>
												<input type="hidden" name="cateuid4" value="<?=$cateuid4?>">
											</tr>
											<tr align="center"> 
												<td colspan="2" height="30">                        
													<input type="button" value="추가" class="adminbttn" onClick="javascript:go_up('4')">
													<input type="button" value="수정" class="adminbttn" onClick="javascript:go_modify('4')">
													<input type="button" value="순위변경"  class="adminbttn orderBtn" valid.i='4' valid.num='<?=$rn?>'>
													<input type="button" value="숨김변경" class="adminbttn viewBtn" valid.i='4' valid.num='<?=$rn?>'>
												</td>
											</tr>
										</table>
										
										<table width="250" border="0" cellspacing="0" cellpadding="0">
											<tr align="center"> 
												<td  height="40"><b>선택된 카테고리</b> 
													<input type="button" value="삭제" class="adminbttn" onClick="javascript:go_delete('4')">
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>


						</td>
					</tr>
					
				</table> 
				<br>
					<table border="0" cellspacing="0" cellpadding="0" class="left_margin30">
						<tr> 
							<td valign="top"> 
								<p><b> 이용방법</b><br><br></p>
								<table width="694" border="0" cellspacing="1" cellpadding="0" bgcolor="#88B7DA">
									<tr>
										<td bgcolor="#EBF0F4"> 
											<p><br>
											<b>&nbsp;카테고리 추가 </b>: 상품코드와 카테고리명을 입력한 후 추가버튼 클릭</p>
											<p>
											<b>&nbsp;카테고리 수정 </b>: 수정할 카테고리명을 클릭한 후 상품코드와 카테고리명을 수정하고 수정버튼 클릭 </p>
											<p>
											<b>&nbsp;카테고리 삭제 </b>: 삭제할 카테고리명 왼쪽의 박스에 체크한 후 삭제버튼 클릭 [ 모두 삭제시 all 버튼 클릭 ]<br><br></p>
										</td>
									</tr>
								</table>
								<br><br>
							</td>
						</tr>
					</table>
					<table border="0" cellspacing="0" cellpadding="0" class="left_margin30">
						<tr> 
							<td valign="top"> 
								<p><b> 이용 팁</b><br><br></p>
								<table width="694" border="0" cellspacing="1" cellpadding="20" bgcolor="#88B7DA">
									<tr> 
										<td bgcolor="#EBF0F4"> 
											<p><b><font color="#990000">우선 순위란?</font> </b>:
											사이트에서 소개될 카테고리명의 순서</p>
											<p><b><font color="#990000">효과적인 상품코드 이용</font> </b>: 
											1,2,3,4차 카테고리별로 각각 두자리의 코드를 입력하실 수 있습니다. 이는 어떤 상품을 코드만 보고도 파악할 수 있도록 한 시스템입니다. 카테고리를 3차 까지 사용한 경우 
											<font color="#990000">11</font><font color="#CC6633">22</font><font color="#339999">33</font><font color="#0000ff">44</font> (예) 의 코드가 발생하며 상품등록시 3자리의 코드를 추가 입력할 수 있도록 
											하여 ( 카테고리당 999개까지 등록 가능 )<font color="#990000">11</font><font color="#CC6633">22</font><font color="#339999">33</font><font color="#0000ff">44</font>001(예)과 같이 9자리의 코드를 사용하실 수 있습니다. 상품 코드 체계를 먼저 설정하시고 사용하시면 효과적으로 사용하실 수 있습니다. 이 체계를 사용하지 않으셔도 무방합니다.</p>
										</td>
									</tr>
								</table>
								<br><br>								
							</td>
						</tr>
					</table>
<!-- 내용 끝 -->
							</td>
						</tr>
						<tr><td height=40></td></tr>
						
					</table>
													</form>
<? include "../inc/down_menu.php"; ?>				
<script>
	
$(document).ready(function () {
	$(".viewBtn").on("click",function(){
		var i = $(this).attr("valid.i");
		var num = $(this).attr("valid.num");		
		document.form.action = "category_view.php?cate=" + i;
   		document.form.submit();
	});
	$(".orderBtn").on("click", function () {
		var i = $(this).attr("valid.i");

	var num = $(this).attr("valid.num");
	// alert(i);
		var tmp_total = new Array();
	temp = "";
	num = parseInt(num);
	// console.log(document.form);
	for (j=1;j<num-1;j++) {
		if(document.form["rank"+i+j] == undefined){
			continue;
		}
		var temp = document.form["rank"+i+j].value;
		

		// console.log(temp);
		if(temp == undefined || temp == ""){
			continue;
		}
		// alert(temp);
		// eval('temp = document.form.rank' + i + j + '.value');
		if (temp!="") {
			temp = temp.substring(0,2);
			if (tmp_total.indexOf(temp)>-1) {
				alert ("우선순위를 다시 선택하세요");
				return;
			}
			else {
				tmp_total.push(temp);			
			}
		}			
	}

	document.form.action = "category_order.php?cate=" + i;
   document.form.submit();
	});
// function go_order(i,num) {

// }
});
	
</script>