<?
#####################################################################

include "../common/user_function.php";
include "../common/dbconn.php";
?>

<? 
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
<title>웹주인 관리자 모드</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../image/style.css" type="text/css">

<script language="javascript">
<!--
function go_search() {
	document.form.action="member_log.php";
	document.form.submit();
}
//-->
</script>

<head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor='#FFFFFF' scroll="yes">


<?
$encoded_key = urlencode($key);
$query = "SELECT id,wdate from $member_table_log where id='$id' ";

if($Year!="" && $Month!="" && $Day!="" && $Year_1!="" && $Month_1!="" && $Day_1!=""){

	$wdate1=mktime(00,00,00,$Month,$Day,$Year); 
	$wdate2=mktime(23,29,29,$Month_1,$Day_1,$Year_1); 
	$query = $query."and (wdate>=$wdate1 and wdate<=$wdate2) ";

}

$query = $query."ORDER BY wdate DESC";	

$DB->get($query,$rs,$rn);

$first = 0;
$last = $total_record-1;   
$kk_cnt=$total_record;
$mode="keyfield=$keyfield&key=$encoded_key&sex=$sex&job=$job&dis=$dis";

#####################################################################
?>



				<table width="500" border="0" cellspacing="0" cellpadding="0" class="left_margin30">
				<form name="form" method="post">
				<input type="hidden" name="id" value="<?=$id?>">
					<tr><td height=30></td></tr>
					<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>접속 통계</b></td>
								</tr>
							</table>
					</td></tr>
					<tr><td height=3></td></tr>
					<tr>
						<td>							 
								<table width="500" border="0" cellspacing="0" cellpadding="4">
									<tr> 										
										<td height="20"> 
											<select name="Year">
											<?for($i=date("Y");$i<=date("Y")+2;$i++){?>
											<option value="<?=$i?>" <?if($i==$Year){?>selected<?}?>><?=$i?>
											<?}?>
										</select>년
										<select name="Month">
											<?for($i=1;$i<=12;$i++){?>
											<option value="<?=$i?>" <?if($i==$Month || $i==date("m")){?>selected<?}?>><?=$i?>
											<?}?>
										</select>월
										<select name="Day">
											<?for($i=1;$i<=31;$i++){?>
											<option value="<?=$i?>" <?if($i==$Day || $i==date("d")){?>selected<?}?>><?=$i?>
											<?}?>
										</select>일부터 ~ 
										<select name="Year_1">
											<?for($i=date("Y");$i<=date("Y")+2;$i++){?>
											<option value="<?=$i?>" <?if($i==$Year_1){?>selected<?}?>><?=$i?>
											<?}?>
										</select>년
										<select name="Month_1">
											<?for($i=1;$i<=12;$i++){?>
											<option value="<?=$i?>" <?if($i==$Month_1 || $i==date("m")){?>selected<?}?>><?=$i?>
											<?}?>
										</select>월
										<select name="Day_1">
											<?for($i=1;$i<=31;$i++){?>
											<option value="<?=$i?>" <?if($i==$Day_1 || $i==date("d")){?>selected<?}?>><?=$i?>
											<?}?>
										</select>일까지
											
										<input type="button"  value="검색" class="adminbttn" onClick="javascript:go_search()">
										</td>
									</tr>
									<tr>
										<td align="right"><B>총접속수 : <?=$total_record?></B></td>
									</tr>
								</table>
								<table width="500" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=3 height=3 bgcolor='#88B7DA'></td></tr>
									<tr align="center" bgcolor='#EBF0F4'> 
										<td width="100" height="30" align="center">번호</td>
										<td width="100" height="30" align="center">아이디</td>
										<td width="300" height="30" align="center">접속일</td>
									</tr>
									<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr><td colspan=3 height=3></td></tr>
<?
#####################################################################

$ii=0;
for($i = $first; $i <= $last; $i++) { 
	$id =$rs[$i][0];
	$wdate =$rs[$i][1];
	$wdate = date("Y년 m월 d일 H시 i분 s초",$wdate);

	
#####################################################################
?>
								<tr align="center">
									<td height="30" align="center"><?=$kk_cnt?></td>
									<td height="30" align="center"><?=$id?></td>
									<td height="30" align="center"><?=$wdate?></td>								
								</tr>
								<tr><td colspan=3 height=1 bgcolor='#D2DEE8'></td></tr>

<?
   $article_num--;
   $ii++;
   $kk_cnt--;
        
}              
$chk_num = $last-$first+1;
?>
							</table>
						</td>
					</tr>
				</table> 

				<br><br>

<!-- 전체 테이블 end -->
</body>
</html>