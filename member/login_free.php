<? include "../include/get_balance.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>



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

			<!-- ㅌ타이틀 -->
			<div class="member_title">
				로그인
			</div>
			<div class="member_title01">
			</div>
			<!-- 타이틀종료 -->

			<div class="sp35"></div>

			<hr class="hr_gray"/>

			<div class="sp35"></div>

			<!-- 로그인시작 -->
			<div class="login_inner">
				<div class="sp50"></div>
				
				<!-- 회원 로그인 -->
				<script language="JavaScript">
				<!--
				function login022() { //v3.0
					if(!document.relogin22.id.value){
						alert('아이디를 입력하세요!');
						document.relogin22.id.focus();
						return;
					}
					if(!document.relogin22.passwd.value){
						alert('비밀번호를 입력하세요!');
						document.relogin22.passwd.focus();
						return;
					}
					document.relogin22.submit();
				}
				function EnterCheck011(i) {
					if(event.keyCode ==13 && i==1) 
					{ 
						document.relogin22.passwd.focus(); 
					}
					if(event.keyCode ==13 && i==2) 
					{ 
						document.relogin22.submit();
					} 
				} 
				// -->
				</script>
				<form name="relogin22" action="./login_ok_free.php" method="post">
				<div class="login_box">
					<div class="login_box_title">
						회원 로그인
					</div>
					<div class="login_title_s">
						로그인 후 이용하시면 더욱 다양한 서비스를 즐기실 수 있습니다.
					</div>

					<div class="sp20"></div>

					<table class="login_table">
						<tr>
							<td width="80%">
							<table class="login_table_in">
								<tr>								
									<th width="30%">아이디</th>
									<td width="68%"><input type="text" name="id" class="input_login" OnKeyDown="EnterCheck011(1);"></td>
						
								</tr>
								<tr>
									<td colspan="2" height="10px"></td>
								</tr>
								<tr>								
									<th width="30%">비밀번호</th>
									<td width="68%"><input type="password" name="passwd" class="input_login" OnKeyDown="EnterCheck011(2);"></td>
						
								</tr>
							</table>
							</td>

							<td width="20%"><input type="button" value="로그인" class="btn_login" onclick="javascript:login022();"></td>
						</tr>
						
				
					</table>
				</div>
				</form>
				<!-- 회원로그인 종료 -->

				<!-- 비회원 로그인 -->
				<script language="JavaScript">
				<!--
				function login03() { //v3.0
					if(!document.relogin3.k_name.value){
						alert('성함을 입력하세요!');
						document.relogin3.k_name.focus();
						return;
					}
					
					if(!document.relogin3.k_ordernum2.value){
						alert('휴대폰번호를 입력하세요!');
						document.relogin3.k_ordernum2.focus();
						return;
					}

					if(!document.relogin3.k_ordernum2.value){
						alert('휴대폰번호를 입력하세요!');
						document.relogin3.k_ordernum2.focus();
						return;
					}
					document.relogin3.submit();
				}
				function EnterCheck02(i) {
					if(event.keyCode ==13 && i==1) 
					{ 
						document.relogin3.k_ordernum2.focus(); 
					}
					if(event.keyCode ==13 && i==2) 
					{ 
						document.relogin3.k_ordernum3.focus(); 
					}
					if(event.keyCode ==13 && i==3) 
					{ 
						document.relogin3.submit();
					}
				} 
				// -->
				</script>
				<form name="relogin3" action="./order_login_ok.php" method="post">
				<div class="login_box01">
					<div class="login_box_title">
						비회원 로그인
					</div>
					<div class="login_title_s">
						비회원 주문조회는 주문하신 성함과 휴대폰번호를 입력하시면 주문/배송을<br/>확인하실 수 있습니다.
					</div>

					<div class="sp20"></div>
					
					<table class="login_table">
						<tr>
							<th width="20%">성 함</th>
							<td width="57%"><input type="text" name="k_name" class="input_login" OnKeyDown="EnterCheck02(1);"></td>
							<td width="3%" rowspan="3"></td>
							<td width="20%" rowspan="3"><input type="button" value="주문조회" class="btn_login01" onclick="javascript:login03();"></td>
						</tr>
						<tr>
							<td colspan="2" height="10px"></td>
						</tr>
						<tr>
							<th width="10%">휴대폰</th>
							<td width="50%"><select name="k_ordernum1" class="input_login_tel">
							<option value="010" <?if($handphone1=="010"){?>selected<?}?>>010</option>
							<option value="011" <?if($handphone1=="011"){?>selected<?}?>>011</option>
							<option value="019" <?if($handphone1=="019"){?>selected<?}?>>019</option>
							<option value="018" <?if($handphone1=="018"){?>selected<?}?>>018</option>
							<option value="017" <?if($handphone1=="017"){?>selected<?}?>>017</option>
							<option value="016" <?if($handphone1=="016"){?>selected<?}?>>016</option>
						 </select> - <input type="text" name="k_ordernum2" class="input_login_tel" OnKeyDown="EnterCheck02(2);"> - <input type="text" name="k_ordernum3" class="input_login_tel" OnKeyDown="EnterCheck02(3);"></td>
							<td width="2%"></td>
						</tr>
					</table>
				</div>
				</form>
				<!-- 비회원로그인 종료 -->

				<div class="sp50"></div>
			</div>
			<!-- 로그인 종료 -->

			<div class="sp30"></div>

			<hr class="hr_gray"/>

			<div class="sp30"></div>

			<div class="login_btn_box">
				<div class="login_left">
					<table class="find_id_table">
						<tr>
							<td width="55%">아이디/비밀번호를 잊으셨나요?<br/>정보를 입력하시면 찾아드립니다!</td>
							<td width="45%"><a href="find.php"><img src="images/btn_findid.png" alt="아이디찾기"/></a></td>
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

	<div class="sp90"></div>


	<!-- 하단(Copy) -->

	 
	  <? include "../include/bottom.php"; ?>	  
				
				
	<!-- 하단(Copy) -->

	


</div>
</body>
</html>
