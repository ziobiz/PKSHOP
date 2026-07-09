<?
#####################################################################

include "../common/user_function.php";
include "../common/dbconn.php";
include_once "../inc/admin_shell_lib.php";
$query = "SELECT passwd,name,jumin,sex,job,email,tel,handphone,zip,address,info,point,dis,dis1,company,recommend,comnum,etc1,etc2,cont,solar,admail,adsms,c_jisa from $member_table WHERE id='$id'";

$DB->get($query,$rs,$rn);
if(!$result) {
  	error("QUERY_ERROR");
  	exit;
}

$real_pass = $rs[0][0];
$name = $row[1];
$jumin = $row[2];
$sex = $row[3];
$job = $row[4];
$email = $row[5];
$tel = $row[6];
$handphone = $row[7];
$zipcorde = $row[8];
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
$cont = $row[19];
$solar = $row[20];
$admail = $row[21];
$adsms = $row[22];
//$recommend2 = $row[23];
//$c_c_id = $row[23];
$jisa = $row[23]; 

$info = stripslashes($info);
$jumin1 = substr($jumin,0,6);
$jumin2 = substr($jumin,-7);
$zip1 = substr($zipcorde,0,3);
$zip2 = substr($zipcorde,-3);

$jumin = explode("-",$jumin);
$Birth_year = $jumin[0];
$Birth_month = $jumin[1];
$Birth_day = $jumin[2];

$dis1_kk = $dis1;

$query_p = "SELECT sum(Point) as point_cur FROM $shop_point WHERE Cid='$id'";
$row_p = mysql_fetch_assoc($result_p = mysql_query($query_p));
$point_cur = $row_p[point_cur];  

#####################################################################
?>
<?php pkshop_admin_auto_shell_begin(); ?>
  <script language="javascript">
	<!--
	function go_modify() {      
		if(document.form.passwd.value != "") {
			if(document.form.passwd.value.length < 4) {
				alert('비밀번호는 최소 4자 이상 입력하세요!');
				document.form.newpasswd.focus();
				return;
			}
			if(!document.form.passwd2.value) {
				alert('새 비밀번호 확인를 입력하세요!');
				document.form.passwd2.focus();
				return;
			}
			if(document.form.passwd.value != document.form.passwd2.value) {
				alert('새 비밀번호와 새 비밀번호확인이 일치하지 않습니다.');
				document.form.passwd2.focus();
				return;
			}
		}
		document.form.action="member_modify_ok.php";
		document.form.submit();
	}
	function go_reset() {      
		document.form.passwd.value="";
		document.form.passwd2.value="";

		document.form.sex[0].checked=true;
		document.form.belt[0].selected=true;
		document.form.job[0].selected=true;
		document.form.email.value="";
		document.form.homepage.value="";
		document.form.tel.value="";
		document.form.handphone.value="";
		document.form.zipcode.value="";

		document.form.addrss.value="";	
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
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">ID</font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left">
										<font face="돋움" size="2">&nbsp; 
										<?=$id?></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font face="돋움" size="2">비밀번호</font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left">
										<font size="2" face="돋움"> 
										&nbsp; 
										<input type="text" maxlength=10 name="passwd" value="<?=$real_pass?>" size=10 class="adminbttn">
										</font><font face="돋움" size="2">4~10자 이내의 영문, 숫자</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">비밀번호 확인</font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left"><font size="2" face="돋움"> 
										&nbsp;
										<input type="password" maxlength=10 name="passwd2" size=10 class="adminbttn">
										비밀번호를 다시 한번 입력하십시오.</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">이름(본명)</font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left">
										<font size="2" face="돋움"> 
										&nbsp;
										<input name="name" size="20" value="<?=$name?>" class="adminbttn"></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>


								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">센터</font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left">
										<font size="2" face="돋움"> 
										&nbsp;
										<input name="center" size="20" value="<?=$jisa?>" class="adminbttn"></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								
								<!-- <tr> 
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
											<option value="<?=$i?>" <?if($Birth_year==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select>년&nbsp;

											<select name="Birth_month" class="adminbttn">
											<option value="">선택</option>
											<?for($i=1;$i<13;$i++){?>
											<option value="<?=$i?>" <?if($Birth_month==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select>월&nbsp;

											<select name="Birth_day" class="adminbttn">
											<option value="">선택</option>
											<?for($i=1;$i<32;$i++){?>
											<option value="<?=$i?>" <?if($Birth_day==$i){?>selected<?}?>><?=$i?></option>
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
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">성별</font></div>
									</td>
									<td width=479 height="30" colspan="3">
										<font size="2" face="돋움"> 
										&nbsp;
										<input type='radio' name='sex' style='border:0px;' value='M' <?if ($sex=='M') echo("checked");?>>남&nbsp;
										<input type='radio' name='sex' style='border:0px;' value='F' <?if ($sex=='F') echo("checked");?>>여
										</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr> -->
								<!-- <tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">직업</font></div>
									</td>
									<td width=479 height="30" colspan="3"><font size="2" face="돋움"> 
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
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">전자우편</font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left">
										<font size="2" face="돋움">&nbsp;
										<input maxlength=50 name="email" value="<?=$email?>" size="25" class="adminbttn">
										연락을 위해 필요합니다.</font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<!-- <tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">전화번호 </font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left">
										<font size="2" face="돋움"> 
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
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">휴대폰 번호</font></div>
									</td>
									<td width=479 height="30" colspan="3" align="left"><font size="2" face="돋움"> 
										&nbsp;
										<input maxlength=13 name="handphone" size="20" value="<?=$handphone?>" class="adminbttn"></font>
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
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">추천인</font></div>
									</td>
									<td width=479 height="30" colspan="3"><font size="2" face="돋움"> 
										&nbsp;
										<input name="recommend" size="20" value="<?=$recommend?>" class="adminbttn"></font>
									</td>
								</tr>
<!-- 								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr> -->
<!-- 																<tr>  -->
<!-- 									<td width=115 height="30">  -->
<!-- 										<div align="center"><font size="2" face="돋움">후원인</font></div> -->
<!-- 									</td> -->
<!-- 									<td width=479 height="30" colspan="3"><font size="2" face="돋움">  -->
										&nbsp;
<!-- 										<input maxlength=13 name="recommend2" size="20" value="<?=$recommend2?>" class="adminbttn"></font> -->
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<!-- <tr>
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">코인 </font></div>
									</td>
									<td width=479 height="30" colspan="3">
										<font size="2" face="돋움"> 
										&nbsp;<?=$point_cur?></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">코인주소</font></div>
									</td>
									<td width=479 height="30" colspan="3"><font size="2" face="돋움"> 
										&nbsp;
										<input name="company" size="30" value="<?=$company?>" class="adminbttn"></font>
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
										<input type="radio" name=dis value="0" class="adminbttn" <?if($dis=="0"){?>checked<?}?>>일반회원  <!-- <input type="radio" name=dis value="1" class="adminbttn" <?if($dis=="1"){?>checked<?}?>>정회원<input type="radio" name=dis value="2" class="adminbttn" <?if($dis=="2"){?>checked<?}?>>대기회원</font> -->
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr> 

<!-- 								<tr>  -->
<!-- 									<td width=115 height="30">  -->
<!-- 										<div align="center"><font size="2" face="돋움">회원승인 </font></div> -->
<!-- 									</td> -->
<!-- 									<td width=479 height="30" colspan="3" align="left"> -->
<!-- 										<font size="2" face="돋움">  -->
<!-- 										&nbsp; -->
<!-- 										<input type="radio" name=dis1 value="1" class="adminbttn" <?if($dis1=="1"){?>checked<?}?>>승인 <input type="radio" name=dis1 value="0" class="adminbttn" <?if($dis1=="0"){?>checked<?}?>>미승인</font> -->
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
										<div align="center"><font size="2" face="돋움">기타2</font></div>
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
					<input type="hidden" name="id" value="<?echo($id)?>">
					<input type="hidden" name="real_pass" value="<?echo($real_pass)?>">
					<input type="hidden" name="keyfield" value="<?echo($keyfield)?>">
					<input type="hidden" name="key" value="<?echo($key)?>">
					<input type="hidden" name="page" value="<?echo($page)?>">
					</form>
				</table> 
				<table width="600" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
					<tr><td height="30"></td></tr>
					<tr> 
						<td height="20" align="center"> 
							<input type="button" value="정보변경" class="adminbttn" onClick="javascript:go_modify()">
							<input type="button" value="뒤로가기" class="adminbttn" onClick="javascript:go_list()">
						</td>
					</tr>
				</table>
				<br><br>
<?
#디비관련 셋팅파일 불러 오기
include './db_config/mysql.php';
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function admin_memodel(No,Comm_No){
	go=confirm('\n정말로 데이터를 삭제 하시겠습니까?\n')
	if(go==true){
		url='erase.php?No='+No+'&Comm_No='+Comm_No;
		location=url;
	}else{return false;}
}  

function check_blank(fm,name,length){
	if(fm.value.substr(0,1)==" "){
		alert(name + " 입력하지 않으셨거나 첫 글자에 공백이 있습니다.\n\n" + name + " 정확히 입력하여 주십시오.");
		fm.focus();
		fm.select();
		return "wrong";
	}
	if(fm.value.length < length){
		alert(name + " " +length +"자 이상 입력하여 주십시오.");
		fm.focus();
		return "wrong";
	}
}

function check(fm){
	if(check_blank(fm.Point,'포인트를',1)=='wrong'){return false}
	if(check_blank(fm.Cont,'내역을',2)=='wrong'){return false}
	document.form2.submit();
}
//-->
</SCRIPT>

							<table width='700'  border='0' cellpadding='0' cellspacing='0' align="center">
								<tr><td>
							
							<table width='600' border='0' cellpadding='0' cellspacing='0'>
								
								<!-- <form name='form2' action='point_do.php' method='post'>
								
								<input type='hidden' name='Cid' value='<?=$id?>'>
								<input type='hidden' name='no' value='<?=$no?>'>
								<tr bgcolor='<?=$bg_back?>'>
									<td height='42' width="180">&nbsp;<B>코인</B> : <input type='text' name="Point"  size='15'></td>
									<td colspan="2"><B>내 역</B> : <input type='text' name="Cont" size='40'></td>
									<td><input type="button" value="입 력" onclick='return check(document.form2)'></td>
								</tr>
								</form>  -->

								<?
							
								$point_db_queiry=point_db_queiry($Point_Rs,$Point_tn);
								$Point_Rs=$point_db_queiry[0];
								$Point_tn=$point_db_queiry[1];

								if($Point_tn!=0) {
								while($point_query=mysql_fetch_array($Point_Rs)){
									$point_db_value=point_db_value ($No,$Cid,$Cont,$Point,$Point_Date,$Point1_Date);
									$No=$point_db_value[0];				$Cid=$point_db_value[1];
									$Cont=$point_db_value[2];			$Point=$point_db_value[3];		
									$Point_Date=$point_db_value[4];	$Point1_Date=$point_db_value[5];

								?>
								<tr bgcolor='<?=$bg_back?>'>
									<td height='22'>&nbsp;&nbsp;<?=$Point?> </td>

									<td colspan="3">
										<?=$Cont?>&nbsp;&nbsp; <font color="#8C8C8C"><?=$Point1_Date?></font> 
										<a href='#' onclick="return admin_memodel('<?=$No?>','<?=$Cid?>')"><b><font color="#BB0004" size="2">√</font></b></a>
									</td>
								</tr>
								<tr><td colspan="4" height="1" bgcolor="#D2DEE8"></td></tr>
								<?}}?>
								</table>
								</td></tr>
							</table>
							<BR><BR> 

<?php pkshop_admin_shell_end(); ?>
