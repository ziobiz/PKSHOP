<?
#####################################################################
include "../common/user_function.php";
include "../common/dbconn.php";
 
if($PATH_TRANSLATED!='../Adm/login/login.html'){

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
<title>관리자 모드</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../image/style.css" type="text/css">

<head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>

<?
$encoded_key = urlencode($key);
$query = "SELECT no,id,name,jumin,sex,email,handphone,zip,address,info,signdate,Fname,admail,adsms from $member_table_p where id='$id' ";

if($key != ""){
	$query = $query." and $keyfield LIKE '%$key%' ";
}

$query = $query."ORDER BY signdate DESC";	
//echo "$query";
$DB->get($query,$rs,$rn);

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
$mode="keyfield=$keyfield&key=$encoded_key&sex=$sex&job=$job&dis=$dis&member_count=$member_count";

#####################################################################
?>

<script language="javascript">
<!--
function go_del() {
	ans = confirm('정말로 삭제하시겠습니까?');
	if (ans == true ) {
		document.form.action="member_del.php";
		document.form.submit();
	}	
}

function go_status(kk) {
	ans = confirm('정말로 변경하시겠습니까?');
	if (ans == true ) {
		document.form.action=kk;
		document.form.submit();
	}	
}

function go_search() {
	document.form.action="member.php?dis=<?=$dis?>";
	document.form.submit();
}

function go_mail(tmp_mail) {
	document.location = "mailing.php?to_name=" + tmp_mail;
}
//-->
</script>
				<table width="800" border="0" cellspacing="0" cellpadding="0" class="left_margin30">
				
					<tr><td height=30></td></tr>
					<tr><td>
							<table width="100%" border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>이벤트기록</b></td><td align="right">
									
									
									
									<form name=dform action="./member_dis_excel.php" method=post target="_blank">
										
										<? 
										$file_name=date("Y")."-".date("m")."-".date("d")." ".date("H")."-".date("i");
										$query_k="select title FROM $shop_goods where code='$id'";  
										$result_k= mysql_query($query_k,$DBconn);
										$row_k = mysql_fetch_row($result_k);	
										$title_k=$row_k[0];										
										?>

										<input type="hidden" name ="file_name" value="<?=$title_k?>(<?=$file_name?>)">
										<input type="hidden" name ="id" value="<?=$id?>">
										<input type="hidden" name ="member_count" value="<?=$member_count?>">
										<input type="button" value="이벤트등록" class="adminbttn" onClick="location.href='member_write.php?id=<?=$id?>'">&nbsp;&nbsp;
										<input type="submit" value="엑셀다운로드">
									</form></td>
								</tr>
							</table>
					</td></tr>
					<form name="form" method="post">
					<tr><td height=3></td></tr>
					<tr>
						<td>							 
								<table width="800" border="0" cellspacing="0" cellpadding="4">
									<tr> 
										
										<td height="20"> 
											
											
											
											&nbsp;&nbsp;
											<select name="keyfield">
											<option value="name" <?if ($keyfield=='name') echo("selected");?>>이름</option>
											<!-- <option value="company" <?if ($keyfield=='company') echo("selected");?>>회사명</option> -->
											<option value="address" <?if ($keyfield=='address') echo("selected");?>>주소</option>
											</select>
											<input type="text" name="key" value="<?=$key?>"size="16" maxlength="16" class="adminbttn">
											
											<input type="button"  value="검색" class="adminbttn" onClick="javascript:go_search()">
										</td>
									</tr>
									
								</table>
								<table width="800" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=7 height=3 bgcolor='#88B7DA'></td></tr>
									<tr align="center" bgcolor='#EBF0F4'> 
										<td width="50" height="30">번호</td>
										<td width="100" height="30">이름</td>
										<td width="170" height="30">핸드폰</td>
										<td width="150" height="30">이메일</td>
										<td width="90" height="30">가입일</td>
										<td width="40" height="30"> 
											 <input type="button" value="삭제" class="adminbttn" onClick="javascript:go_del('member_del.php?<?=$mode?>&page=<?=$page?>&id=<?=$id?>')"> 
										</td>
									</tr>
									<tr><td colspan=7 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr><td colspan=7 height=3></td></tr>
<?
#####################################################################

$ii=0;
for($i = $first; $i <= $last; $i++) { 
	$no =$rs[$i][0];
	$id =$rs[$i][1];
	$name =$rs[$i][2];
	$jumin =$rs[$i][3];
	$sex =$rs[$i][4];
	$email =$rs[$i][5];
	$handphone =$rs[$i][6];
	$zip =$rs[$i][7];
	$address =$rs[$i][8];
	$info =$rs[$i][9];
	$signdate =$rs[$i][10];
	$Fname =$rs[$i][11];

	$signdate = date("Y-m-d",$signdate);

	//no,id,name,jumin,sex,email,handphone,zip,address,info,signdate,Fname,admail,adsms
	
#####################################################################
?>
								<tr align="center"> 
									<td height="30"><?=$article_num?></td>
									<td height="30"><a href="member_modify.php?<?=$mode?>&page=<?=$page?>&no=<?=$no?>"><B><?=$name?></B>
										</a>
									</td>
									<td><?=$handphone?></td>
									<td height="30"><?=$email?>
										 </td>
									<td height="30"><?=$signdate?></td>
									<td height="30"> 
										<input type="checkbox" name="check<?=$ii?>" value="<?=$no?>">
									</td>
								</tr>
								
								<tr><td colspan=7 height=1 bgcolor='#D2DEE8'></td></tr>

<?
				
	
   $article_num--;
   $ii++;
        
}              
$chk_num = $last-$first+1;
?>
							</table>
						</td>
					</tr>
				</table> 
				<table width="800" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
					<tr> 
						<td height="20" align="center"><font color="#666666">
<?
#####################################################################
$total_block = ceil($total_page/$page_per_block);
$block = ceil($page/$page_per_block);
$first_page = ($block-1)*$page_per_block;
$last_page = $block*$page_per_block;
if($total_block <= $block) {
	$last_page = $total_page;
}

if($page!='1'){
	echo "<a href=\"member.php?$mode&page=1\" onMouseOver=\"status='';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">처음</a>&nbsp;";
}
 if ($page > 1) {
 	$page_num = $page - 1;
 	echo "<a href=\"member.php?$mode&page=$page_num\" onMouseOver=\"status='이전페이지';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">◀</font></a>&nbsp;";
 }
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
 		echo "<font color=\"#666666\">&nbsp;<b>$direct_page</b></font>&nbsp;";
 	} else {
 		echo "&nbsp;<a href=\"member.php?$mode&page=$direct_page\" onMouseOver=\"status='go to page $direct_page';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">$direct_page</font></a>&nbsp;";
 	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
 	echo "&nbsp;<a href=\"member.php?$mode&page=$page_num\" onMouseOver=\"status='다음페이지';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">▶</font></a>&nbsp;";
 }
if($page!=$total_page){
	echo "<a href=\"member.php?$mode&page=$total_page\" onMouseOver=\"status='';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">마지막</a>";
}
 ?>
							</font> 
						</td>
					</tr>
					<input type="hidden" name="chk_num" value="<?echo($chk_num)?>"> 
					<input type="hidden" name="id" value="<?echo($id)?>"> 
					</form>  
				</table>
				<br><br>
</body>
</html>