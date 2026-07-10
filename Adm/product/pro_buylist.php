<?

########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_product.php";

include "../common/user_function.php";

########## 데이터베이스에 연결한다. #################################
if($first_chk!="Y") {
	
	$query = "SELECT title,theme,pricec,prices,priced,point,currnum,warnnum FROM $shop_goods WHERE code='$code'";
	$DB->get($query,$rs,$rn);
	
	
	

	$title = $rs[0][0];                             	$theme = $row[1];
	$pricec = $row[2];							$prices = $row[3];
	$priced = $row[4];							$point = $row[5];
	$currnum = $row[6];						$warnnum = $row[7];
	$postnum1 = $currnum;
	
}
	$title = stripslashes($title);
//	$title = htmlspecialchars($title);

$plus = intval($plus);

if ($plus_chk=="p") {
	$postnum1 = $postnum1 + $plus;
}else if ($plus_chk=="m") {
	$postnum1 = $postnum1 - $plus;
}

$postnum2 = $postnum1 - $currnum;

#####################################################################
?>
<script language="javascript">
<!--
function go_plus() {
	document.form.plus_chk.value="p";
	document.form.action="pro_buylist.php";
	document.form.submit();
}
function go_minus() {
	document.form.plus_chk.value="m";
	document.form.action="pro_buylist.php";
	document.form.submit();
}
function go_modify() {
	document.form.action="pro_buylist_ok.php";
	document.form.submit();
}
function go_list() {	
	document.form.action="pro_buy.php";
	document.form.submit();
}
//-->
</script>

				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr><td height=30></td></tr>
					<tr><td height=3></td></tr>
					<tr>
						<td>							
							<table class="pg-table pg-table-form" width="100%" border='0' cellspacing='0' cellpadding='0'>
								<form name="form" method="post">
									<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
									<tr><td colspan=2 height=5></td></tr>
									<tr> 
										<td width="115" height="30" align="center">상품명</td>
										<td width="479" height="30">
											&nbsp;&nbsp; <?=$title?>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										
										<td width="115" height="30" align="center">상품홍보</td>
										<?
										#############################
										if ($theme=="g"){$chk1="checked";
										}else if($theme=="r"){$chk2="checked";
										}else if($theme=="f"){$chk3="checked";
										}else if($theme=="d"){$chk4="checked";
										}else{$chk6="";
										}
										#############################
										?>
										<td width="479" height="30">
											&nbsp;&nbsp; 
											<input type="radio" name="theme" value="g" <?=$chk1?>>일반상품 
											&nbsp;&nbsp; 
											<input type="radio" name="theme" value="r" <?=$chk2?>>추천상품 
											&nbsp;&nbsp; 
											<input type="radio" name="theme" value="f" <?=$chk3?>>인기상품
											<!-- &nbsp;&nbsp; 
											<input type="radio" name="theme" value="d" <?=$chk4?>>할인상품 -->
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										<td width="115" height="30" align="center">소비자 가격</td>
										<td width="479" height="30">&nbsp;&nbsp; 
											<input type="text" name="pricec" value="<?=$pricec?>" size="16" maxlength="16" class="adminbttn">
											원
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										<td width="115" height="30" align="center">판매가격</td>
										<td width="479" height="30">
											&nbsp;&nbsp; 
											<input type="text" name="prices" value="<?=$prices?>" size="16" maxlength="16" class="adminbttn">
											원
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										<td width="115" height="30" align="center">할인가격</td>
										<td width="479" height="30">
											&nbsp;&nbsp; 
											<input type="text" name="priced" value="<?=$priced?>" size="16" maxlength="16" class="adminbttn">
											원
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										<td width="115" height="30" align="center">마일리지</td>
										<td width="479" height="30">
											&nbsp;&nbsp; 
											<input type="text" name="point" value="<?=$point?>" size="16" maxlength="16" class="adminbttn">
											포인트
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										<td width="115" height="30" align="center">변경전 재고량</td>
										<td width="479" height="30">
											&nbsp;&nbsp; <?=$currnum?> 개
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										<td width="115" height="30" align="center">변경후 재고량</td>
										<td width="479" height="30">
											&nbsp;&nbsp; <?=$postnum1?> 개
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										<td width="115" height="30" align="center">재고경고수량</td>
										<td width="479" height="30">
											&nbsp;&nbsp; 
											<input type="text" name="warnnum" value="<?=$warnnum?>" size="16" maxlength="16" class="adminbttn">개 <font color="#003366">* 재고가 경고수량으로 떨어지면 관리자가 파악 가능</font>
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										<td width="115" height="30" align="center">재고량 가감</td>
										<td width="479" height="30">
											&nbsp;&nbsp; 
											<input type="text" name="plus" size="16" maxlength="16" class="adminbttn">개 
											<input type="button" value=" + " class="adminbttn" onClick="javascript:go_plus()">
											<input type="button" value=" - " class="adminbttn" onClick="javascript:go_minus()">
										</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr> 
										<td colspan="2" height="40" align="center"> 
											<input type="button" value="수정" class="adminbttn" onClick="javascript:go_modify()">
											<input type="button" value="목록" class="adminbttn" onClick="javascript:go_list()">
										</td>
									</tr>
									<input type="hidden" name="currnum" value="<?=$currnum?>">
									<input type="hidden" name="code" value="<?=$code?>">
									<input type="hidden" name="first_chk" value="Y">
									<input type="hidden" name="page" value="<?=$page?>">
									<input type="hidden" name="postnum1" value="<?=$postnum1?>">
									<input type="hidden" name="postnum2" value="<?=$postnum2?>">
									<input type="hidden" name="plus_chk" value="">
									</form>  
								</table>
								<br><br>
							</td>
						</tr>
					</table>
<? include "../inc/down_menu.php"; ?>
