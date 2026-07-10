<?
#####################################################################
include "../common/user_function.php";
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_member.php";

#####################################################################


echo $data = date("Y-m-d");
?>
 
<script language="javascript">
<!--
function idchk(url){
	str=document.form.id.value
    
	if(!document.form.id.value) {
      alert('아이디를 입력하세요!');
      document.form.id.focus();
      return;
   }
   url = url + '?id=' + document.form.id.value;

   /*
	var isID = /^[a-z0-9_]{4,12}$/;
	if( !isID.test(str) ){
   	alert("아이디는 4~12자의 영문 소문자와 숫자만 사용할 수 있습니다.");
      document.join.id.focus();
      return;
   }
 	url = url + '?id=' + document.join.id.value;
	*/

	//alert (url);
	window.open(url,"","width=301,height=210,toolbar=no,location=no,directorys=no,status=no,menubar=no,scrollbars=no,resizable=no,left=100,top=100");
}

function open_winaddr(url){
	window.open(url,"window","width=320,height=280,toolbar=no,location=no,directorys=no,status=no,menubar=no,scrollbars=yes,resizable=no,left=100,top=100")
}

function go_modify() {      
	if(!document.form.id.value) {
		alert('센터이름을 입력하세요!');
		document.form.id.focus();
		return;
	}

	if(!document.form.charge.value) {
		alert('담당자를 입력하세요!');
		document.form.id.focus();
		return;
	}

	if(!document.form.tel.value) {
		alert('연락처를 입력하세요!');
		document.form.id.focus();
		return;
	}


	document.form.action="center_insert_ok.php";
	document.form.submit();
}

function go_list() {
	location="member.php?K_dis=<?=$K_dis?>";
}
function open_addr(url){
	window.open(url,"window","width=350,height=230,toolbar=no,location=no,directorys=no,status=no,menubar=no,scrollbars=yes,resizable=no,left=100,top=100")
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
								<tr><td colspan=4 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=4 height=5></td></tr>

								
								<tr>
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">등록일</font></div>
									</td>
									<td height="30" colspan="3" align="left">
										<font face="돋움" size="2">&nbsp; 
										<input type="text" name="date" size=10 class="adminbttn" value="<?=$data?>"></font> 
									</td>
								</tr>




								<tr>
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">센터이름</font></div>
									</td>
									<td height="30" colspan="3" align="left">
										<font face="돋움" size="2">&nbsp; 
										<input type="text" name="id" size=10 class="adminbttn"></font> <a href="javascript:idchk('/Adm/member/autozip/id_check.php');"></a>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>

								<tr>
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">담당자</font></div>
									</td>
									<td height="30" colspan="3" align="left">
										<font face="돋움" size="2">&nbsp; 
										<input type="text" name="charge" size=10 class="adminbttn"></font> <a href="javascript:idchk('/Adm/member/autozip/id_check.php');"></a>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>

								<tr>
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">연락처</font></div>
									</td>
									<td height="30" colspan="3" align="left">
										<font face="돋움" size="2">&nbsp; 
										<input type="text" name="tel" size=10 class="adminbttn"></font> <a href="javascript:idchk('/Adm/member/autozip/id_check.php');"></a>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								
								
								<input type="hidden" name="dis" value="0">

<!-- 								<tr>  -->
<!-- 									<td width=115 height="30">  -->
<!-- 										<div align="center"><font size="2" face="돋움">회원승인 </font></div> -->
<!-- 									</td> -->
<!-- 									<td width=479 height="30" colspan="3" align="left"> -->
<!-- 										<font size="2" face="돋움">  -->
<!-- 										&nbsp; -->
<!-- 										<input type="radio" name=dis1 value="1" class="adminbttn" <?if($dis1=="1" || $dis==""){?>checked<?}?>>승인 <input type="radio" name=dis1 value="0" class="adminbttn" <?if($dis1=="0"){?>checked<?}?>>미승인</font> -->
<!-- 									</td> -->
<!-- 								</tr> -->
<!-- 								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr> -->
								<!-- <tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">기타1 </font></div>
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
										<div align="center"><font size="2" face="돋움">기타2 </font></div>
									</td>
									<td width=479 height="30" colspan="3">
										<font size="2" face="돋움"> 
										&nbsp;
										<textarea rows="3" cols="50" name="etc2"><?=$etc2?></textarea>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr> -->

							</table>
						</td>
					</tr>
					<input type="hidden" name="keyfield" value="<?echo($keyfield)?>">
					<input type="hidden" name="key" value="<?echo($key)?>">
					<input type="hidden" name="page" value="<?echo($page)?>">
					</form>
				</table> 
				<table width="600" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
					<tr><td height="30"></td></tr>
					<tr> 
						<td height="20" align="center"> 
							<input type="button" value="센터등록" class="adminbttn" onClick="javascript:go_modify()">
						</td>
					</tr>
				</table>
				<br>
				<br>



<? include "../inc/down_menu.php"; ?>
