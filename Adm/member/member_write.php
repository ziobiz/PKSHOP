<?
#####################################################################
include "../common/user_function.php";
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_member.php";

#####################################################################
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
		alert('아이디를 입력하세요!');
		document.form.id.focus();
		return;
	}

	if(document.form.passwd.value.length < 4) {
		alert('비밀번호는 최소 4자 이상 입력하세요!');
		document.form.passwd.focus();
		return;
	}

	if(document.form.passwd.value != document.form.passwd2.value) {
		alert('비밀번호확인이 일치하지 않습니다.');
		document.form.passwd2.focus();
		return;
	}

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
 
				<table width="700" border="0" cellspacing="0" cellpadding="0">
					<tr><td height=30></td></tr>
					<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>회원관리</b></td>
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
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">ID</font></div>
									</td>
									<td height="30" colspan="3" align="left">
										<font face="돋움" size="2">&nbsp; 
										<input type="text" name="id" size=10 class="adminbttn"></font> <a href="javascript:idchk('/Adm/member/autozip/id_check.php');">[아이디 중복검색]</a>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=105 height="30"> 
										<div align="center"><font face="돋움" size="2">비밀번호</font></div>
									</td>
									<td height="30" colspan="3" align="left">
										<font size="2" face="돋움"> 
										&nbsp; 
										<input type="password" maxlength=10 name="passwd" size=10 class="adminbttn">
										</font><font face="돋움" size="2">4~10자 이내의 영문, 숫자</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">비밀번호 확인</font></div>
									</td>
									<td height="30" colspan="3" align="left"><font size="2" face="돋움"> 
										&nbsp;
										<input type="password" maxlength=10 name="passwd2" size=10 class="adminbttn">
										비밀번호를 다시 한번 입력하십시오.</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">이름(본명)</font></div>
									</td>
									<td height="30" colspan="3" align="left">
										&nbsp;
										<input name="name" size=15 class="adminbttn">
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<!-- <tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">회사명</font></div>
									</td>
									<td width=479 height="30" colspan="3"><font size="2" face="돋움"> 
										&nbsp;
										<input maxlength=13 name="company" size="20" value="<?=$company?>" class="adminbttn"></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">사업자번호</font></div>
									</td>
									<td width=479 height="30" colspan="3"><font size="2" face="돋움"> 
										&nbsp;
										<input maxlength=13 name="comnum" size="20" value="<?=$comnum?>" class="adminbttn"></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr> -->
								<!-- <tr> 
									<td height=25 width=115> 
										<div align="center"><font size="2" face="돋움">생년월일</font></div>
									</td>
									<td height=25 width=479 colspan="3" align="left">
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
										  <input type="radio" checked="checked" value="1" name="solar" class="adminbttn" <?if($solar=="1" || $solar==""){?>checked<?}?>/>
											<span class="board04">양력</span>
											<input type="radio" value="0" name="solar" class="adminbttn" <?if($solar=="0"){?>checked<?}?>/>
											<span class="board04">음력</span>
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
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr> -->
								<!-- <tr> 
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">직업</font></div>
									</td>
									<td height="30" colspan="3"><font size="2" face="돋움"> 
										&nbsp;
										<select size="1" id=txtCompany name="job"  class="adminbttn">
											<option selected>선택하세요.</option>
											<option value="0" <?if($job=="0" || $job==""){?>selected<?}?>>무직</option>     
											 <option value="1" <?if($job=="1"){?>selected<?}?>>학생</option>     
											 <option value="2" <?if($job=="2"){?>selected<?}?>>컴퓨터/인터넷</option> 
											 <option value="3" <?if($job=="3"){?>selected<?}?>>언론</option>     
											 <option value="4" <?if($job=="4"){?>selected<?}?>>공무원</option>     
											 <option value="5" <?if($job=="5"){?>selected<?}?>>군인</option>     
											 <option value="6" <?if($job=="6"){?>selected<?}?>>서비스업</option>     
											 <option value="7" <?if($job=="7"){?>selected<?}?>>교육</option>     
											 <option value="8" <?if($job=="8"){?>selected<?}?>>금융/증권/보험업</option>     
											 <option value="9" <?if($job=="9"){?>selected<?}?>>유통업</option>     
											 <option value="10" <?if($job=="10"){?>selected<?}?>>예술</option>     
											 <option value="11" <?if($job=="11"){?>selected<?}?>>의료</option>     
											 <option value="12" <?if($job=="12"){?>selected<?}?>>법률</option>     
											 <option value="13" <?if($job=="13"){?>selected<?}?>>건설업</option>     
											 <option value="14" <?if($job=="14"){?>selected<?}?>>제조업</option>     
											 <option value="15" <?if($job=="15"){?>selected<?}?>>부동산업</option>     
											 <option value="16" <?if($job=="16"){?>selected<?}?>>운송업</option>     
											 <option value="17" <?if($job=="17"){?>selected<?}?>>농/수/임/광산업</option>     
											 <option value="18" <?if($job=="18"){?>selected<?}?>>가사</option>     
											 <option value="19" <?if($job=="19"){?>selected<?}?>>기타</option>     
										</select>
										</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr> -->
								<tr> 
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">전자우편</font></div>
									</td>
									<td height="30" colspan="3" align="left">
										<font size="2" face="돋움">&nbsp;
										<input maxlength=50 name="email" value="<?=$email?>" size="25" class="adminbttn">
										연락을 위해 필요합니다.</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<!-- <tr> 
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">전화번호 </font></div>
									</td>
									<td height="30" colspan="3" align="left">
										<font size="2" face="돋움" align="left"> 
										&nbsp;
										<input maxlength=14 name="tel" size="20" value="<?=$tel?>"  class="adminbttn">
										&nbsp; </font><font face="돋움" size="2">예) 02-0000-0000 
										<br>
										&nbsp; 
										유/무선 관계없이 연락 가능한 전화번호</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr> -->
								<tr> 
									<td width=105 height="30"> 
										<div align="center"><font size="2" face="돋움">휴대폰 번호</font></div>
									</td>
									<td height="30" colspan="3" align="left"><font size="2" face="돋움"> 
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
									<td height="30" colspan="3" align="left"><font size="2" face="돋움"> 
										&nbsp;
										<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
										<script>
											function openDaumPostcode() {							
											new daum.Postcode({
												oncomplete: function(data) {
													// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

													// 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
													// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
													var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
													var extraRoadAddr = ''; // 도로명 조합형 주소 변수

													// 법정동명이 있을 경우 추가한다. (법정리는 제외)
													// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
													if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
														extraRoadAddr += data.bname;
													}
													// 건물명이 있고, 공동주택일 경우 추가한다.
													if(data.buildingName !== '' && data.apartment === 'Y'){
													   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
													}
													// 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
													if(extraRoadAddr !== ''){
														extraRoadAddr = ' (' + extraRoadAddr + ')';
													}
													// 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
													if(fullRoadAddr !== ''){
														fullRoadAddr += extraRoadAddr;
													}

													// 우편번호와 주소 정보를 해당 필드에 넣는다.
													document.getElementById('zipcorde').value = data.zonecode; //5자리 새우편번호 사용
													document.getElementById('address').value = fullRoadAddr;
													//document.getElementById('address').value = data.jibunAddress;

													
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
									<td height="30" colspan="3" align="left">
										&nbsp;
										<input maxlength="50" name="address" value="<?=$address?>" id="address" size=60 class="adminbttn">              
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>	
								<!-- <tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">자기 소개</font></div>
									</td>
									<td width=479 height="30" colspan="3">
										&nbsp;<textarea cols="70" rows="5" name="info"><?=$info?></textarea>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>	 -->							
		
								<!-- <tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">추천인</font></div>
									</td>
									<td width=479 height="30" colspan="3"><font size="2" face="돋움"> 
										&nbsp;
										<input maxlength=13 name="recommend" size="20" value="<?=$recommend?>" class="adminbttn"></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">후원인</font></div>
									</td>
									<td width=479 height="30" colspan="3"><font size="2" face="돋움"> 
										&nbsp;
										<input maxlength=13 name="recommend2" size="20" value="<?=$recommend2?>" class="adminbttn"></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr> -->
								<!--<tr>
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">코인 </font></div>
									</td>
									<td width=479 height="30" colspan="3">
										<font size="2" face="돋움"> 
										&nbsp;<?=$point_cur?></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr> -->

								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">회원구분 </font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left">
										<font size="2" face="돋움"> 
										&nbsp;
										<input type="radio" name=dis value="0" class="adminbttn" <?if($dis=="0" || $dis==""){?>checked<?}?>>일반회원  <!-- <input type="radio" name=dis value="1" class="adminbttn" <?if($dis=="1"){?>checked<?}?>>정회원<input type="radio" name=dis value="2" class="adminbttn" <?if($dis=="2"){?>checked<?}?>>대기회원 --></font>
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
							<input type="button" value="회원등록" class="adminbttn" onClick="javascript:go_modify()">
						</td>
					</tr>
				</table>
				<br>
				<br>



<? include "../inc/down_menu.php"; ?>