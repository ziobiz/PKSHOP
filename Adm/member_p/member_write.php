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
<script language="javascript">
<!--

function open_winaddr(url){
	window.open(url,"window","width=320,height=280,toolbar=no,location=no,directorys=no,status=no,menubar=no,scrollbars=yes,resizable=no,left=100,top=100")
}

function go_modify() {      
	

		if(!document.form.name.value) {
		alert('이름을 입력하세요!');
		document.form.name.focus();
		return;
	}

	document.form.action="member_ok.php";
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
							<form name="form" method="post" enctype="multipart/form-data">
								<tr><td colspan=4 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=4 height=5></td></tr>
								<tr>
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">제품코드</font></div>
									</td>
									<td height="30" colspan="3">
										<font face="돋움" size="2">&nbsp; 
										<? include './product_board.php';?>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>								
								<tr> 
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">이름(본명)</font></div>
									</td>
									<td height="30" colspan="3">
										&nbsp;
										<input name="name" size=15 class="adminbttn">
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								
								<tr> 
									<td height=25 width=115> 
										<div align="center"><font size="2" face="돋움">생년월일</font></div>
									</td>
									<td height=25 width=479 colspan="3">
										<font size="2" face="돋움"> 
										&nbsp;
										<select name="Birth_year" class="adminbttn">
											<option value="" >선택</option>
											<? for($i=1930;$i<Date("Y")+1;$i++){?>
											<option value="<?=$i?>" <?if($Birth_year==$i || Date("Y")==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select>년&nbsp;

											<select name="Birth_month" class="adminbttn">
											<option value="">선택</option>
											<?for($i=1;$i<13;$i++){?>
											<option value="<?=$i?>" <?if($Birth_month==$i || Date("m")==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select>월&nbsp;

											<select name="Birth_day" class="adminbttn">
											<option value="">선택</option>
											<?for($i=1;$i<32;$i++){?>
											<option value="<?=$i?>" <?if($Birth_day==$i || Date("d")==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select>일&nbsp;&nbsp;&nbsp;
										  
														</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">성별</font></div>
									</td>
									<td height="30" colspan="3">
										<font size="2" face="돋움"> 
										&nbsp;
										<input type='radio' name='sex' style='border:0px;' value='M' <?if ($sex=='M' || $sex=='') echo("checked");?>>남&nbsp;
										<input type='radio' name='sex' style='border:0px;' value='F' <?if ($sex=='F') echo("checked");?>>여
										</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr> 
								
								<tr> 
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">전자우편</font></div>
									</td>
									<td height="30" colspan="3">
										<font size="2" face="돋움">&nbsp;
										<input maxlength=50 name="email" value="<?=$email?>" size="25" class="adminbttn">
										연락을 위해 필요합니다.</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">휴대폰 번호</font></div>
									</td>
									<td height="30" colspan="3"><font size="2" face="돋움"> 
										&nbsp;
										<input maxlength=13 name="handphone" size="20" value="<?=$handphone?>" class="adminbttn">
										 예) 000-0000-0000 </font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">주소</font></div>
									</td>
									<td height="30" colspan="3"><font size="2" face="돋움"> 
										&nbsp;
										<script src="http://dmaps.daum.net/map_js_init/postcode.js"></script>
												<script>
													function openDaumPostcode() {
													new daum.Postcode({
														oncomplete: function(data) {
														// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
														// 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
														document.getElementById('zipcorde').value = data.postcode1+'-'+data.postcode2;
														//document.getElementById('post2').value = data.postcode2;
														document.getElementById('address').value = data.address;

														//전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
														//아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
														//var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
														//document.getElementById('address1_id').value = addr;

														document.getElementById('address').focus();
														}
													}).open();
													}
												</script>

										<input maxlength=20 name="zipcorde" value="<?=$zipcorde?>" id="zipcorde" size=15 class="adminbttn">
										</font><font face="돋움" size="1">&nbsp;</font><font face="돋움" size="2"><span onclick="javascript:openDaumPostcode()" style="cursor:pointer;">(우편번호)</span>&nbsp; 
										
										</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr>
									<td width=105 height="30"> 
										
									</td>
									<td height="30" colspan="3">
										&nbsp;
										<input maxlength="50" name="address" value="<?=$address?>" id="address" size=60 class="adminbttn">              
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>	
								 <tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">메 모</font></div>
									</td>
									<td width=479 height="30" colspan="3">
										&nbsp;<textarea cols="70" rows="5" name="info"><?=$info?></textarea>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>	
								 <tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">파 일</font></div>
									</td>
									<td width=479 height="30" colspan="3">
										&nbsp;<input type='file' name='File' size='60'>
										<BR>
										<? if($mode=="edit" and $Fname!=""){ ?>
											<?=$Fname?> <input type='checkbox' name='F_del' value='0'>삭제	
										<?}?>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>	

								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">개인정보활용 </font></div>
									</td>
									<td width=479 height="30" colspan="3">
										<font size="2" face="돋움"> 
										&nbsp;
										<input type="radio" name=admail value="0" class="adminbttn" <?if($admail=="0" || $admail==""){?>checked<?}?>>동의안함 <input type="radio" name=admail value="1" class="adminbttn" <?if($admail=="1"){?>checked<?}?>>동의</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">이벤트정보 </font></div>
									</td>
									<td width=479 height="30" colspan="3">
										<font size="2" face="돋움"> 
										&nbsp;
										<input type="radio" name=adsms value="0" class="adminbttn" <?if($adsms=="0" || $adsms==""){?>checked<?}?>>받음 <input type="radio" name=adsms value="1" class="adminbttn" <?if($adsms=="1"){?>checked<?}?>>안받음</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								

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
							<input type="button" value="회원등록" class="adminbttn" onClick="javascript:go_modify()">
						</td>
					</tr>
				</table>
				<br>
				<br>



