<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include_once "../inc/admin_shell_lib.php";
include "../common/user_function.php";
include "../inc/set_com.php";
########## 데이터베이스에 연결한다. #################################
if ($sel_cate=="") {
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

#####################################################################
?>
<?php pkshop_admin_auto_shell_begin(); ?>
<script language="javascript">
<!--
function go_del() {
	document.form.action="products_del.php";
	document.form.submit();
}

function go_modify(code) {
	document.form.action="pro_buylist.php?code=" + code;
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

				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0" class="left_margin30">
					<form name="form" method="post">
					<tr><td height=30></td></tr>
					<tr><td height=3></td></tr>
						<tr>
							<td>								
								<table width="800" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=8 height=3 bgcolor='#88B7DA'></td></tr>
									<tr align="center" bgcolor='#EBF0F4'> 
										<td width="47" height="26">번호</td>
										<td width="75" height="26">상품코드</td>
										<td width="322" height="26">상품명</td>
										<td width="73" height="26">판매가격</td>
										<td width="68" height="26">현재수량</td>
										<td width="68" height="26">상품홍보</td>
										<td width="62" height="26">재고관리</td>
										<td width="67" height="26">
											<a href="javascript:all_chk();" OnFocus="this.blur()"><B>all</B></a> 
											<input type="button" value="삭제" class="adminbttn" onClick="javascript:go_del()">
										</td>
									</tr>
									<tr><td colspan=8 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr><td colspan=8 height=3></td></tr>
<?
#####################################################################

$query = "SELECT code,title,currnum,pricec,theme FROM $shop_goods WHERE currnum<=warnnum ORDER BY signdate DESC";
$DB->get($query,$rs,$rn);
$total_record =$rn;

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
$ii=0;

for($i = $first; $i <= $last; $i++) { 
	$code =$rs[$i][0];
	$title =$rs[$i][1];
	$currnum =$rs[$i][2];
	$pricec =$rs[$i][3];
	$theme =$rs[$i][4];
	$title = stripslashes($title);
	$pricec = number_format($pricec);
	$currnum = number_format($currnum);
	if ($theme=="r") $theme="추천상품";
	else if ($theme=="f") $theme="인기상품";
	else if ($theme=="d") $theme="가격파괴상품";
	else $theme="일반상품";

#####################################################################
?>
									<tr align="center"> 
										<td width="47" height="26">&nbsp;<?=$article_num?></td>
										<td width="75" height="26">&nbsp;<?=$code?></td>
               							<td width="322" height="26">
											<a href="pro_info.php?page=<?=$page?>&code=<?=$code?>&sel_theme=b"><?=$title?>
										</td>
										<td width="73" height="26">&nbsp;<?=$pricec?></td>
										<td width="68" height="26">&nbsp;<?=$currnum?></td>
										<td width="68" height="26">&nbsp;<?=$theme?></td>
										<td width="62" height="26"> 
											<input type="button" value="수정" class="adminbttn" onClick="javascript:go_modify('<?=$code?>')">
										</td> 
										<td width="67" height="26"> 
											<input type="checkbox"  name="check<?=$ii?>" value="<?=$code?>">
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
					<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
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
  if ($page > 1) {
 	$page_num = $page - 1;
 
 ####################################################################
 ?>
								<a href="pro_buy.php?page=<?=$page_num?>" onMouseOver="status='이전페이지';return true;" onMouseOut="status=''">
								<font color="#666666">◀</font></a>

 <?
 }
 
 ####################################################################
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
?>
 								<font color="#666666">&nbsp;<b><?=$direct_page?></b></font>
<?	
	} else {
?>
 								&nbsp;<a href="pro_buy.php?page=<?=$direct_page?>" onMouseOver="status='go to page <?=$direct_page?>';return true;" onMouseOut="status=''">
								<font color="#666666"><?=$direct_page?></font></a>
<?
 	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
?>
								&nbsp;<a href="pro_buy.php?page=<?=$page_num?>" onMouseOver="status='다음페이지';return true;" onMouseOut="status=''">
								<font color="#666666">▶</font></a>
 
 <?
 }
 ?>
								</font>
							</td>
						</tr>
					</table>
					<br><br>
					<input type="hidden" name="buy_chk" value="Y">      
					<input type="hidden" name="chk_num" value="<?=$chk_num?>">      
					</form>
<?php pkshop_admin_shell_end(); ?>
