<?
	include "../include/get_balance.php";
	require_once dirname(__FILE__) . "/../include/site_settings_lib.php";
	$agree_terms_body = pkshop_agree_terms_text();
	$agree_privacy_body = pkshop_agree_privacy_text();
?>
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
<script type="text/javascript">
<!--
function go_join() {      

	if(document.form1.agree1.checked != true){
		alert("Sign up is possible only if you agree to the terms and conditions.   (進行のためには会員約款と個人情報管理に利用に関する同意をしていただきます。)");
		document.form1.agree1.focus();
        return;
	}

	if(document.form1.agree2.checked != true){
		alert("Sign up is possible only if you agree to the personal information handling policy. (進行のためには会員約款と個人情報管理に利用に関する同意をしていただきます。)");
		document.form1.agree2.focus();
        return;
	}
   
	document.form1.action="join.php";
	document.form1.submit();
}

//-->
</script>
				
	<!-- 상단(Top) -->

	<!-- 컨텐츠 시작 -->
	<div id="content">
		
		<!-- 컨텐츠 이너 시작 -->
		<div class="content_inner">

			<div class="sp90"></div>

			<!-- ㅌ타이틀 -->
			<div class="member_title">
				<span class="c_orange">MEMBERS</span> Sign up
			</div>

			<div class="sp10"></div>
			<div class="member_title01">
			Meet Pentakleva various services and benefits.
			</div>
			<!-- 타이틀종료 -->

			<div class="sp35"></div>

			<hr class="hr_gray"/>

			<div class="sp35"></div>

			<!-- 회원약관시작 -->
			<form name='form1' method='post'>
			<div class="agree_inner">
				<div class="agree_title">
					利用規約 / 返金ポリシー
				</div>
				<textarea class="agree_box"><?php echo htmlspecialchars($agree_terms_body, ENT_QUOTES, "UTF-8"); ?></textarea>
				<div class="sp10"></div>
				<div class="agree_check">
					<input type="checkbox" name="agree1" id="agree1" class="checkbox"> <span style="color:#c3070b"> <B><label for="agree1">Accept the terms and conditions <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(規約の同意)</label></B></span>
				</div>
			</div>
			<!-- 회원약관 종료 -->

			<!-- 개인정보 -->
			<div class="agree_inner">
				<div class="agree_title">
						プライバシーポリシー
				</div>
				<textarea class="agree_box"><?php echo htmlspecialchars($agree_privacy_body, ENT_QUOTES, "UTF-8"); ?></textarea>
				<div class="sp10"></div>
				<div class="agree_check">
					<input type="checkbox" name="agree2" id="agree2" class="checkbox"><span style="color:#c3070b"> <B><label for="agree2">Accept the personal information processing policy<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(個人情報管理及び利用に関する同意)</label></B></span> 
				</div>
			</div>
			<!-- 개인정보 종료 -->

			<div class="sp30"></div>

			<hr class="hr_gray"/>

			<div class="sp30"></div>

			<div class="write_btn_box">
				<input type="button" value="SING UP / 参加" class="cart_btn04" onclick="javascript:go_join()">
				<input type="button" value="BACK / 戻る" class="cart_btn01" onclick="location.href='../main/main.html'">
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
