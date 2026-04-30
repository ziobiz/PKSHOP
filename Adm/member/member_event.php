<?
#####################################################################

include "../common/user_function.php";
include "../common/dbconn.php";



$query = "SELECT passwd,name,jumin,sex,job,email,tel,handphone,zip,address,info,point,dis,dis1,company,recommend,comnum,etc1,etc2 from $member_table WHERE id='$id'";
$DB->get($query,$rs,$rn);
if(!$result) {
  	error("QUERY_ERROR");
  	exit;
}

$real_pass = $rs[0][0];
$name = $row[1];
$jumin = $row[2];
$jumin=split("-",$jumin);
$sex = $row[3];
$job = $row[4];
$email = $row[5];
$tel = $row[6];
$handphone = $row[7];
$zip = $row[8];
$zip=split("-",$zip);
$address = $row[9];
$info = $row[10];
$point = $row[11];
$dis = $row[12];
$dis1 = $row[13];
$company = $row[14];
$recommend = $row[15];
$comnum = $row[16];
$etc1 = $row[17];
$etc2 = $row[18];

$info = stripslashes($info);
$jumin1 = $jumin[0];
$jumin2 = $jumin[1];
$zip1 = $zip[0];
$zip2 = $zip[1];

#####################################################################
?>
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
<title>웹주인 관리자 모드</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../image/style.css" type="text/css">

<head>
 
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
  <script language="javascript">
	<!--
	function go_modify() {      

		document.form.action="member_event_ok.php";
		document.form.submit();
	}
	function go_reset() {      
		document.form.passwd.value="";
		document.form.passwd2.value="";
		document.form.jumin1.value="";
		document.form.jumin2.value="";
		document.form.sex[0].checked=true;
		document.form.belt[0].selected=true;
		document.form.job[0].selected=true;
		document.form.email.value="";
		document.form.homepage.value="";
		document.form.tel.value="";
		document.form.handphone.value="";
		document.form.zip1.value="";
		document.form.zip2.value="";
		document.form.address.value="";	
	}

	function go_list() {
		document.form.action="member.php";
		document.form.submit();
	}
	function open_addr(url){
		window.open(url,"window","width=466,height=230,toolbar=no,location=no,directorys=no,status=no,menubar=no,scrollbars=yes,resizable=no,left=100,top=100")
	}

	//-->
	</script> 
 
				<table width="700" border="0" cellspacing="0" cellpadding="0">
					<tr><td height=30></td></tr>
					<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>내역관리</b></td>
								</tr>
							</table>
					</td></tr>
					<tr><td height=3></td></tr>
					<tr>
						<td>
							
							<table width="600" border='0' cellspacing='0' cellpadding='0'>
							<form name="form" method="post">
								<tr><td colspan=4 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=4 height=5></td></tr>
								<tr>
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">ID</font></div>
									</td>
									<td width=479 height="30" colspan="3">
										<font face="돋움" size="2">&nbsp; 
										<?=$id?></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								
						
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">이름(본명)</font></div>
									</td>
									<td width=479 height="30" colspan="3">
										&nbsp;<?=$name?>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">회사명</font></div>
									</td>
									<td width=479 height="30" colspan="3"><font size="2" face="돋움"> 
										&nbsp;
										<?=$company?></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">사업자번호</font></div>
									</td>
									<td width=479 height="30" colspan="3"><font size="2" face="돋움"> 
										&nbsp;
										<?=$comnum?></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">이벤트내역 </font></div>
									</td>
									<td width=479 height="30" colspan="3">
										<font size="2" face="돋움"> 
										&nbsp;
										<textarea rows="3" cols="50" name="etc1"><?=$etc1?></textarea>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">미수내역 </font></div>
									</td>
									<td width=479 height="30" colspan="3">
										<font size="2" face="돋움"> 
										&nbsp;
										<textarea rows="3" cols="50" name="etc2"><?=$etc2?></textarea>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
							</table>
						</td>
					</tr>
					<input type="hidden" name="id" value="<?echo($id)?>">
					
					</form>
				</table> 
				<table width="600" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
					<tr><td height="30"></td></tr>
					<tr> 
						<td height="20" align="center"> 
							<input type="button" value="정보변경" class="adminbttn" onClick="javascript:go_modify()">
							<input type="button" value="닫  기" class="adminbttn" onClick="javascript:window.close()">
						</td>
					</tr>
				</table>
				<br><br>
				