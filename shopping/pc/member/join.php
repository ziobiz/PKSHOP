<?include "../include/top_session.php";?>
<!doctype html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CFWORLD MALL</title>
<link rel="stylesheet" href="../include/reset.css">
<link rel="stylesheet" type="text/css" href="../include/style.css" media="screen and (min-width:1024px)"/>
<link rel="stylesheet" type="text/css" href="../include/responsive.css" media="screen and (max-width:1023px)"/>

 </head>
 <body>
	<div id="wrap">

	<!-- 상단(Top) -->

	 
	  <? include "../include/top.php"; ?>
<script language="javascript">
<!--
function idchk(url){
	str=document.form.id.value
    
	if(!document.form.id.value) {
      alert('아이디를 입력하세요!');
      document.form.id.focus();
      return;
   }

   
	var isID = /^[a-z0-9_]{4,12}$/;
	if( !isID.test(str) ){
   	alert("아이디는 4~12자의 영문 소문자와 숫자만 사용할 수 있습니다.");
      document.form.id.focus();
      return;
   }
 	url = url + '?id=' + document.form.id.value;
	

	//alert (url);
	window.open(url,"","width=301,height=210,toolbar=no,location=no,directorys=no,status=no,menubar=no,scrollbars=no,resizable=no,left=100,top=100");
}

function reidchk(url){
	str=document.form.recommend.value
    
	if(!document.form.recommend.value) {
      alert('추천인ID를 입력하세요!');
      document.form.recommend.focus();
      return;
   }

   

 	url = url + '?id=' + document.form.recommend.value;
	

	//alert (url);
	window.open(url,"","width=301,height=210,toolbar=no,location=no,directorys=no,status=no,menubar=no,scrollbars=no,resizable=no,left=100,top=100");
}


 

function go_modify() {      
	var id2 = document.getElementById('id');
	var name2 = document.getElementById('name');
	if(!document.form.id.value) {
		alert('아이디를 입력하세요!');
		document.form.id.focus();
		return;
	}
	var special_pattern = /[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i;
		if(special_pattern.test(id2.value) == true ){
			alert('아이디에 특수문자혹은 공백을 사용할 수 없습니다.');
			 return false;
		}

		if(special_pattern.test(name2.value) == true ){
			alert('이름에 특수문자혹은 공백을 사용할 수 없습니다.');
			 return false;
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


	if(!document.form.email.value) {
		alert('이메일을 입력하세요!');
		document.form.email.focus();
		return;
	}
	/*
	if(!document.form.s_center.value) {
		alert('센터명을 선택하세요!');
		document.form.s_center.focus();
		return;
	}*/

	if(!document.form.handphone1.value) {
		alert('휴대폰을 입력하세요!');
		document.form.handphone1.focus();
		return;
	}

	if(!document.form.handphone2.value) {
		alert('휴대폰을 입력하세요!');
		document.form.handphone2.focus();
		return;
	}

	if(!document.form.handphone3.value) {
		alert('휴대폰을 입력하세요!');
		document.form.handphone3.focus();
		return;
	}

	if(!document.form.zipcorde.value) {
		alert('우편번호를 입력하세요!');
		document.form.zipcorde.focus();
		return;
	}

	if(!document.form.address.value) {
		alert('주소을 입력하세요!');
		document.form.address.focus();
		return;
	}
//	if(document.form.recommend.value !="ok"){
//		alert("추천인 확인을 진행해주세요");
//		return;
//	}


	document.form.action="member_ok.php";
	document.form.submit();
}
//-->

function reid_check(){
		window.name='문자인증확인';
		window.open("", "Window","top=500,left=500,width=500, height=100,status=yes,scrollbars=no, resizable=yes,menubar=no");
		document.form.action = "reid_check.php";
		document.form.target = "_blank";
		document.form.submit();
}
</script> 
				
	<!-- 상단(Top) -->

	<!-- 컨텐츠 시작 -->
	<div id="content">
		
		<!-- 컨텐츠 이너 시작 -->
		<div class="content_inner">

			<div class="sp90"></div>

			<!-- ㅌ타이틀 -->
			<div class="member_title">
				<span class="c_orange">MEMBERS</span> 회원가입
			</div>

			<div class="sp10"></div>
			<div class="member_title01">
			HCBRS에서 다양한 서비스와 혜택을 만나보세요.
			</div>
			<!-- 타이틀종료 -->

			<div class="sp35"></div>

			<form name="form" method="post">
			<div class="join_inner">
				<table class="join_table">
					<tr>
						<td colspan="2" class="join_title">사이트 이용정보<p class="title_s">정보를 입력하시면 회원가입이 완료됩니다.</p></td>
					</tr>
					<tr>
						<td height="5px"></td>
					</tr>

					<tr>
						<th>아이디</th>
						<td>
							<input type="text" name="id" id="id" value="<?=$id?>" class="join_name"> <input type="button" value="중복확인" class="btn_id_check"onclick="idchk('../../Adm/member/autozip/id_check.php');">
							<p class="join_text">영문, 숫자만 입력가능, 최소 4자 이상 입력하세요.</p>
						</td>
					</tr>

					<tr>
						<th>추천인아이디</th>
						<td>
							<input type="text" name="c_c_id" id="c_c_id" class="join_name"> 
							<p class="join_text">영문, 숫자만 입력가능, 최소 4자 이상 입력하세요.</p>
						</td>
					</tr>
					<tr>
						<th>비밀번호</th>
						<td><input type="password" name="passwd" class="join_input"><p class="join_text">6~12자 이내 영문, 숫자 조합만 가능합니다.</p></td>
					</tr>
					<tr>
						<th>비밀번호 확인</th>
						<td><input type="password" name="passwd2" class="join_input"></td>
					</tr>
					<tr>
						<td height="10px"></td>
					</tr>
					<tr>
						<td colspan="2" class="join_title">개인정보 입력</td>
					</tr>
					<tr>
						<td height="5px"></td>
					</tr>
					<tr>
						<th>이 름</th>
						<td><input type="text" name="name" id="name" value="<?=$name?>" class="join_input"></td>
					</tr>
					<tr>
						<th>이메일</th>
						<td><input type="text" name="email" value="<?=$email?>" class="join_input"></td>
					</tr>

<!-- 					<tr> -->
<!-- 						<th>이메일<br>수신동의</th> -->
<!-- 						<td><input type="radio" name="admail" value="0" checked>수신동의&nbsp;&nbsp;&nbsp;<input type="radio" name="admail" value="1">수신하지않음<br/> -->
<!-- 							<p class="join_text">메일링서비스를 통해 각종 이벤트및 정보를 우선적으로 받아보실 수 있습니다.<br/> -->
<!-- 							회원가입 및 주문 관련 메일은 수신동의와 상관없이 모든 회원에게 발송됩니다.</p></td> -->
<!-- 					</tr> -->
<?	
	
	$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc";
		
	
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, "http://globalsummit.cafe24.com/work/api/api_center.php");
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec ($ch);
	curl_close ($ch);

	$json_center = json_decode($result, true);
?>
<!--
					<tr>
					<th>센터명</th>
					<td>
						<select name="s_center" class="join_tel">
						<option value="">센터 선택..</option>
				<?
					for($i=0;$i<count($json_center);$i++)
					{
						$name= $json_center[$i]['name'];

						if ($name != "")
						{
				?>
			<option value='<?=$name?>'> <?=$name?></option>
				<?
						}
					}	
				?>
							</select>
						</td>
					</tr>

-->
					<tr>
						<th>휴대폰번호</th>
						<td>
							<select name="handphone1" class="join_tel">
								<option value="010">010</option>
								<option value="011">011</option>
								<option value="019">019</option>
								<option value="018">018</option>
								<option value="017">017</option>
								<option value="016">016</option>
							</select>
							<input type="text" name="handphone2" value="<?=$handphone2?>" class="join_tel">&nbsp;-&nbsp;<input type="text" name="handphone3" value="<?=$handphone3?>" class="join_tel"></td>
					</tr>

<!-- 					<tr> -->
<!-- 						<th>SCFWORLD<br/>수신동의</th> -->
<!-- 						<td><input type="radio"  name="adsCFWORLD" value="0" checked>수신동의&nbsp;&nbsp;&nbsp;<input type="radio" name="adsCFWORLD" value="1">수신하지않음<br/> -->
<!-- 							<p class="join_text">SCFWORLD 수신동의 하시면 SCFWORLD를 통해 각종 이벤트및 정보를 우선적으로 받아보실 수 있습니다.<br/> -->
<!-- 							회원가입 및 주문 관련 SCFWORLD는 수신동의와 상관없이 모든 회원에게 발송됩니다.</p></td> -->
<!-- 					</tr> -->
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

									// 법정LANX MALL이 있을 경우 추가한다. (법정리는 제외)
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
					
					<tr>
						<th rowspan="3">주 소</th>
						<td>
							<input type="text" name="zipcorde" value="<?=$zipcorde?>" id="zipcorde" class="join_addr"> <input type="button" value="Find Address" class="btn_id_check" onclick="javascript:openDaumPostcode();">
						</td>
					</tr>
					<tr>
						<td><input type="text" name="address" value="<?=$address?>" id="address" class="join_input"></td>
					</tr>
					<tr>
						<td><input type="text" name="address1" value="<?=$address1?>" class="join_input"></td>
					</tr>
					
<!-- 					<tr> -->
<!-- 						<th>후원자</th> -->
<!-- 						<td><input type="text" name="recommend2" value="<?=$recommend2?>" class="join_input"></td> -->
<!-- 					</tr> -->
				</table>
			</div>

			<div class="sp30"></div>

			<div class="write_btn_box">
				<input type="button" value="회원가입" class="cart_btn04" onClick="javascript:go_modify();">&nbsp;
				<input type="button" value="취 소" class="cart_btn01" onclick="location.href='./agree.php'">
			</div>
			</form>
			
		</div>
		<!-- 컨텐츠_이너 종료 -->

			
	</div>
	<!-- 컨텐츠 종료 -->


	<!-- 하단(Copy) -->

	 <div class="sp50"></div>
	  <? include "../include/bottom.php"; ?>	  
				
				
	<!-- 하단(Copy) -->

	


</div>
</body>
</html>
