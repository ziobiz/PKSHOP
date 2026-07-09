<?

########## 입력값에 대한 타당성 검사를 수행한다. ###########
include "../common/dbconn.php";
include_once "../inc/admin_shell_lib.php";
include "../common/user_function.php";
########## 데이터베이스에 연결한다. ###########
include "../inc/set_com.php";

if ($sel_cate==""){
	$sel_code1="";
	$sel_code2="";
	$sel_code3="";
	$sel_code4="";
}else if ($sel_cate=="1") {
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
<?php pkshop_admin_auto_shell_begin(); ?>
<script language="javascript">
//ie에서 배열.indexOf를 사용하기 위한
Array.prototype.indexOf = function(obj) {
    for (var i = 0, length = this.length; i < length; i++)
        if (this[i] == obj) return i;
    return -1;
};

function go_select(i) {
	document.form.sel_cate.value=i;
	document.form.action="pro_like.php";
	document.form.submit();
}

function go_del() {
	document.form.action="pro_theme_del.php?theme=f";
	document.form.submit();
}

function go_rank(num) {
	var tmp_total = new Array();
	temp = "";
	num = parseInt(num);
	for (i=1;i<num;i++) {
		eval('temp = document.form.rank'+i+'.value');
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
	document.form.action="pro_theme_rank.php?theme=f&rank_num="+num;
	document.form.submit();
}

function go_add() {
	temp = document.form.sel_goods.value;
	theme=temp.substring(0,1);

	document.form.action="pro_theme_add.php?theme=f";
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

//-->
</script>


				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0">
					<form name="form" method="post">
					<tr><td height=30></td></tr>
					<tr><td height=3></td></tr>
						<tr> 
							<td> 								
								<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="4">
									<tr> 
										<td height="20">
											<b>HOT상품 추가</b> : 
											<select name="sel_code1" class="adminbttn" OnChange="go_select('1');">
											<option selected>1 차 카테고리</option>
<?
#####################################################################

$query = "SELECT cate1,code1 FROM $shop_cate WHERE code1<>'00' and code2='00' and code3='00' and code4='00' ORDER BY rank";
$DB->get($query,$rs,$rn);

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
											&nbsp;&nbsp; 
											<select name="sel_code2" class="adminbttn" OnChange="go_select('2');">
											<option selected>2 차 카테고리</option>
<?
#####################################################################

$query = "SELECT cate2,code2 FROM $shop_cate WHERE code1='$sel_code1' and code2!='00' and code3='00'  and code4='00' ORDER BY rank";
$DB->get($query,$rs,$rn);
$total_record =$rn;

for ($i=0;$i<$total_record=$rn;$i++) {
	$cate =$rs[$i][0];
	$g_code =$rs[$i][1];
	$cate = stripslashes($cate);
	$cate = htmlspecialchars($cate);

	if ($sel_code2==$g_code) $oselect = "selected";
	else $oselect = "";

#####################################################################
?>
											<option value="<?=$g_code?>" <?=$oselect?>><?=$cate?></option>

<?          
}
?>
											</select>
											&nbsp;&nbsp; 
											<select name="sel_code3" class="adminbttn" OnChange="go_select('3');">
											<option selected>3 차 카테고리</option>
<?
#####################################################################

$query = "SELECT cate3,code3 FROM $shop_cate WHERE code1='$sel_code1' and code2='$sel_code2' and code3!='00' and code4='00' ORDER BY rank";
$DB->get($query,$rs,$rn);
$total_record =$rn;

for ($i=0;$i<$total_record=$rn;$i++) {
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
											&nbsp;&nbsp; &nbsp;&nbsp; 
											<select name="sel_code4" class="adminbttn" OnChange="go_select('4');">
											<option selected>4 차 카테고리</option>
<?
#####################################################################

$query = "SELECT cate4,code4 FROM $shop_cate WHERE code1='$sel_code1' and code2='$sel_code2' and code3='$sel_code3' and code4!='00' ORDER BY rank";
$DB->get($query,$rs,$rn);
$total_record =$rn;

for ($i=0;$i<$total_record=$rn;$i++) {
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
										&nbsp;&nbsp; 
										<select name="sel_goods" class="adminbttn">
										<option selected>상품명</option>
<?
$query = "SELECT code,title,theme_f FROM $shop_goods WHERE (code1='$sel_code1' or code2='$sel_code2' or code3='$sel_code3' or code4='$sel_code4') and soldout<>'Y' ORDER BY signdate DESC";
$DB->get($query,$rs,$rn);

for ($i=0;$i<$total_record=$rn;$i++) {
	$g_code =$rs[$i][0];
	$title =$rs[$i][1];
	$theme_f =$rs[$i][2];
	$title = stripslashes($title);
	$title = htmlspecialchars($title);
?>
										<option value="<?=$theme_f.$g_code?>" <?=$oselect?>><?=$title?></option>
									
<?           
}
?>
										</select>
                  
										&nbsp;&nbsp;
											<input type="button" value="추가" class="adminbttn" onClick="javascript:go_add()">                  
										</td>
									</tr>
								</table>
								<table width="800" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=7 height=3 bgcolor='#88B7DA'></td></tr>
									<tr align="center" bgcolor='#EBF0F4'> 
										<td width="51" height="25">번호</td>
										<td width="97" height="25">상품코드</td>
										<td width="332" height="25">상품명</td>
										<td width="89" height="25">판매가격</td>
										<td width="80" height="25">현재수량</td>
										<td width="81" height="25">우선순위</td>
										<td width="54" height="25">
											<a href="javascript:all_chk();" OnFocus="this.blur()">
											<B>all</B></a>
										</td>
									</tr>
									<tr><td colspan=7 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr><td colspan=7 height=3></td></tr>
<?
#####################################################################

$query = "SELECT code,code1,code2,code3,title,currnum,pricec,rank_f,code4,order4,No FROM $shop_goods WHERE theme_f='f' ORDER BY rank_f asc,signdate DESC";

$DB->get($query,$rs,$rn);
$total_record =$rn;
$article_num=1;
$curr_i=1;
$ii=0;

for($i = 0; $i < $total_record; $i++) { 
	$code =$rs[$i][0];
	$code1 =$rs[$i][1];
	$code2 =$rs[$i][2];
	$code3 =$rs[$i][3];
	$title =$rs[$i][4];
	$currnum =$rs[$i][5];
	$pricec =$rs[$i][6];
	$rank =$rs[$i][7];
	$code4 =$rs[$i][8];
	$order4 =$rs[$i][9];
	$No =$rs[$i][10];
	$title = stripslashes($title);
	if ($rank=="9") $rank="";
	
	$query2 = "SELECT cate4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='$code4'";
	$DB->get($query2,$rs2,$rn2);

	$cate_name = $rs2[0][0];
	$cate_name = stripslashes($cate_name);
	$ii=$i+1;
#####################################################################
?>
									<tr align="center"> 
										<td width="51" height="26">&nbsp;<?=$article_num?></td>
										<td width="97" height="26">&nbsp;<?=$code?></td>
										<td width="332" height="26">
											<a href="pro_info.php?sel_theme=f&code=<?=$code?>&No=<?=$No?>"><?=$title?></a>
										</td>
										<td width="89" height="26">&nbsp;<?=$pricec?></td>
										<td width="80" height="26">&nbsp;<?=$currnum?></td>
										<td width="81" height="26"> 
											<select name="rank<?=$ii?>" class="adminbttn">
 
<?			

#####################################################################
			for ($j=1;$j<=$total_record;$j++) {			
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
										<input type="hidden" name="code<?=$ii?>" value="<?=$code?>">
										</td>
										<td height="26"> 
											<input type="checkbox" name="check<?=$ii?>" value="<?=$code?>">
										</td>
									</tr>
									<tr><td colspan=9 height=1 bgcolor='#D2DEE8'></td></tr>
    
<?
   $article_num=$article_num+1;      
   $curr_i++;
}
?>
								</table>
							</td>
						</tr>
					</table>
					<input type="hidden" name="sel_theme"> 
					<input type="hidden" name="sel_num" value="<?=$total_record?>">
					<input type="hidden" name="sel_cate" value="<?=$sel_cate?>">
					</form>  
					<BR><BR>
					<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
						<tr> 
							<td height="20" align="center"> <b>선택한 상품을</b> 
								<input type="button" value="목록에서  제외" class="adminbttn" onClick="javascript:go_del()">
								&nbsp;&nbsp;&nbsp;
								<input type="button" value="우선순위변경" class="adminbttn" onClick="javascript:go_rank('<?=$i?>')">
								
							</td>
						</tr>
					</table>
					<br><br>
<?php pkshop_admin_shell_end(); ?>
