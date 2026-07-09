<?include "../include/top_session.php";?>
<!doctype html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pentakleva</title>
<link rel="stylesheet" href="../include/reset.css">
<link rel="stylesheet" type="text/css" href="../include/style.css" media="screen and (min-width:1024px)"/>
<link rel="stylesheet" type="text/css" href="../include/responsive.css" media="screen and (max-width:1023px)"/>

 </head>
 <body>
	<div id="wrap">

	<!-- 상단(Top) -->

	 
	  <? include "../include/top.php"; ?>

				
	<!-- 상단(Top) -->

	<!-- 컨텐츠 시작 -->
	<div id="content">
		
		<!-- 컨텐츠 이너 시작 -->
		<div class="content_inner">

			<div class="sp90"></div>

			<!-- 타이틀 -->
			<div class="member_title">
				아이디/비밀번호 찾기
			</div>

			<div class="sp10"></div>
			<div class="member_title01">
			Pentakleva에서 다양한 서비스와 혜택을 만나보세요.
			</div>
			<!-- 타이틀종료 -->

			<div class="sp35"></div>

			<hr class="hr_gray"/>

			<div class="sp35"></div>

			<!-- 로그인시작 -->
			<div class="login_inner">
				<div class="sp50"></div>
				
				<!-- 아이디찾기 -->

				<form name="relogin" method="post">
				<div class="login_box">
					<div class="login_box_title">
						아이디 찾기
					</div>
					<div class="login_title_s">
						가입시 입력하신 이름과 이메일을 입력하시면 아이디를 알려드립니다.
					</div>

					<div class="sp20"></div>

					<table class="login_table">
						<tr>
							<th width="20%">이름</th>
							<td width="57%"><input type="text" name="name" class="input_login"></td>
							<td width="3%" rowspan="3"></td>
							<td width="20%" rowspan="3"><input type="button" value="찾 기" class="btn_login" onclick="find_id()"></td>
						</tr>
						<tr>
							<td colspan="2" height="10px"></td>
						</tr>
						<tr>
							<th width="10%">전화번호</th>
							<td width="50%"><input type="text"name="email" class="input_login" OnKeyDown="EnterCheck01(2);"></td>
							<td width="2%"></td>
						</tr>
					</table>
				</div>
				</form>
				<!-- 아이디찾기 종료 -->

				<!-- 비밀번호찾기 -->
				
				<form name="relogin02" method="post">
				<div class="login_box01">
					<div class="login_box_title">
						비밀번호 찾기
					</div>
					<div class="login_title_s">
						가입하신 아이디, 이름, 이메일을 입력하시면 비밀번호를 이메일로 전송해드립니다.
					</div>

					<div class="sp20"></div>
					
					<table class="login_table">
						<tr>
							<th width="20%">아이디</th>
							<td width="57%"><input type="text" name="id" class="input_login"></td>
							<td width="3%" rowspan="3"></td>
							<td width="20%" rowspan="5" style="vertical-align:top;"><input type="button" value="찾 기" class="btn_login01" onclick="find_pass()"></td>
						</tr>
						<tr>
							<td colspan="2" height="10px"></td>
						</tr>
						<tr>
							<th width="10%">이 름</th>
							<td width="50%"><input type="text" name="name" class="input_login"></td>
							<td width="2%"></td>
						</tr>
						<tr>
							<td colspan="2" height="10px"></td>
						</tr>
						<tr>
							<th width="10%">전화번호</th>
							<td width="50%"><input type="text" name="email" class="input_login"></td>
							<td width="2%"></td>
						</tr>
					</table>
				</div>
				</form>
				<!-- 비밀번호찾기 종료 -->

			
			</div>
			<!-- 로그인 종료 -->

			<div class="sp30"></div>

			<hr class="hr_gray"/>

			<div class="sp30"></div>

			<div class="login_btn_box">
				<div class="login_left">
					<table class="find_id_table">
						<tr>
							<td width="55%">Pentakleva 회원이신가요?<br/>로그인하시고 다양한 혜택을 받아보세요!</td>
							<td width="45%"><a href="login.php"><img src="images/btn_gologin.png" alt="아이디찾기"/></a></td>
						</tr>
					</table>
				</div>
				<div class="login_right">
					<table class="find_id_table">
						<tr>
							<td width="55%">회원이 아니신가요? 회원가입을 하시면<br/>다양한 혜택을 받으실 수 있습니다.</td>
							<td width="45%"><a href="agree.php"><img src="images/btn_join.png" alt="회원가입"/></a></td>
						</tr>
					</table>
				</div>
			</div>

		
		</div>
		<!-- 컨텐츠_이너 종료 -->

			
	</div>
	<!-- 컨텐츠 종료 -->




	<!-- 하단(Copy) -->

	  <div class="sp50"></div>
	  <? include "../include/bottom.php"; ?>	  	  
				
				
	<!-- 하단(Copy) -->

	


</div>

<script>
function find_id(){
	var frm = document.relogin;
	if(!frm.name.value){
		alert("Please enter your name.");
		frm.name.focus();
		return false;
	}
	if(!frm.email.value){
		alert("Please enter your phone number.");
		frm.email.focus();
		return false;
	}
	frm.action="./search_do.php";
	frm.submit();
	return false;
}
function find_pass(){
	var frm = document.relogin02;
	if(!frm.id.value){
		alert("Please enter your ID.");
		frm.id.focus();
		return false;
	}
	if(!frm.name.value){
		alert("Please enter your name.");
		frm.name.focus();
		return false;
	}
	if(!frm.email.value){
		alert("Please enter your phone number.");
		frm.email.focus();
		return false;
	}
	frm.action="./search_pass_do.php";
	frm.submit();
	return false;
}
</script>
</body>
</html>
