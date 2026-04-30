<?
include $_SERVER["DOCUMENT_ROOT"]."/include/com.php";
$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&user_id=".$_SESSION['member_id'];
// echo $api_center;
$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $api_center);
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt ($ch, CURLOPT_POST, 1);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec ($ch);
// echo $result;
$center = json_decode($result,true);
$user_id=$_GET['invitation'];

?>


<!doctype html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pentakleva</title>
<link rel="stylesheet" href="../include/reset.css">
<link rel="stylesheet" type="text/css" href="../include/style.css" media="screen and (min-width:1024px)"/>
<link rel="stylesheet" type="text/css" href="../include/responsive.css" media="screen and (max-width:1023px)"/>
<script type="text/javascript" src="../lib/common.js?234231"></script>
 </head>
 <body>
	<div id="wrap">

	<!-- 상단(Top) -->
	 
<? 
	include "../include/top.php"; 
?>
<script>
function signup_ok()
{
	var frm = document.join_form;
	var numbering = /[0-9]{4}/;
	//var regType1 = /^[A-Za-z0-9+]*$/;
	

	function checkMail(str)
	{
		var pattern = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i
		return pattern.test(str);
	}

	

	if (frm.name1.value == "")
	{
		alert("<?=$join_alert1?>");
		frm.name1.focus();
	}
	else if (frm.m_contury.value == "")
	{
		alert("<?=$join_alert3?>");
		frm.m_contury.focus();
	}
	else if (frm.tel_1.value == "" )
	{
		alert("<?=$join_alert4?>");
		frm.tel_1.focus();
	}
	else if (frm.tel_2.value == "" )
	{
		alert("<?=$join_alert4?>");
		frm.tel_2.focus();
	}
	else if (frm.tel_3.value == "" )
	{
		alert("<?=$join_alert4?>");
		frm.tel_3.focus();
	}
	else if (frm.email.value == "")
	{
		alert("<?=$join_alert7?>");
		frm.email.focus();
	}	else if (checkMail(frm.email.value) == false){
		alert("<?=$join_alert23?>");
	}
	else if (frm.s_username.value == "" || frm.s_username.value.length < 4)
	{
		alert("<?=$join_alert8?>");
		frm.s_username.focus();
	}
	// else if (frm.email_code.value == "")
	// {
	// 	alert("<?=$join_alert9?>");
	// 	frm.email_code.focus();
	// }


	else if (frm.passwd.value == "")
	{
		alert("<?=$join_alert10?>");
		frm.passwd.focus();
	}
	else if (frm.passwd.value.length < 8)
	{
		alert("<?=$join_alert11?>");
		frm.passwd.value = "";
		// frm.fin_passwd.value = "";
		frm.passwd.focus();
	}
	else if (frm.fin_passwd.value == "")
	{
		alert("<?=$join_alert13?>");
		frm.fin_passwd.focus();
	}
	else if (frm.passwd.value != frm.fin_passwd.value)
	{
		frm.fin_passwd.value = "";
		alert("<?=$join_alert14?>");
		frm.fin_passwd.focus();
	}
	else if (frm.pin.value == "")
	{
		alert("<?=$join_alert15?>");
		frm.pin.focus();
	}
	else if (!numbering.test(frm.pin.value) || frm.pin.value.length < 4)
	{
		frm.pin.value = "";
		alert("<?=$join_alert16?>");
		frm.pin.focus();
	}
	else if (frm.conf_pin.value == "")
	{
		alert("<?=$join_alert17?>");
		frm.conf_pin.focus();
	}
	else if (frm.pin.value != frm.conf_pin.value)
	{
		frm.conf_pin.value = "";
		alert("<?=$join_alert18?>");
		frm.conf_pin.focus();
	}
	else if (frm.C_ZIP.value =="")
	{
		alert("Please enter your address.");
		frm.C_ZIP.focus();
	}
	
	else if (frm.C_ADDR.value =="")
	{
		alert("Please enter your address.");
		frm.C_ADDR.focus();
	}
	
	else if (frm.C_ADDR2.value =="")
	{
		alert("Please enter your address.");
		frm.C_ADDR2.focus();
	}
	
	else if (frm.c_username.value =="")
	{
		alert("<?=$join_alert19?>");
		frm.c_username.focus();
	}
	
	else if (frm.h_username.value =="")
	{
		alert("Please enter Sponser");
		frm.h_username.focus();
	}
	
	else if (frm.confirm_cid.value == "")
	{
		alert("<?=$join_alert20?>");
		frm.c_username.focus();
		return false;
	}
	
	
	else if (frm.userid_confrom.value == "n")
	{
		alert("<?=$join_alert21?>");
		frm.s_username.focus();
		return false;
	}
	else 
	{
		$.ajax({
			type: "POST",
			url: "./joinform_insert.php",
			data: $("#form").serialize(),
			dataType: "json",
			success: function (response) {
				if(response.result == "1"){
					alert(response.msg);
					location.href="/member/login.php"
					return false;
				}else{
					alert(response.msg);
					return false;
				}
			}
		});
		// frm.submit();
	}
}




function load_sms()
{
	var frm = document.join_form;
	var email = frm.email.value;

	
	if (frm.email.value == "" )
	{
		alert("<?=$join_alert22?>");
	}else if (checkMail(frm.email.value) == false){
		alert("<?=$join_alert23?>");
	}
	else
	{
		var url ="send_email.php?email="+email;
		sms_load(url);
	}
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
				<span class="c_orange">MEMBERS</span> Sign up
			</div>

			<div class="sp10"></div>
			<div class="member_title01">
			Meet a variety of services and benefits at Pentakleva.
			</div>
			<!-- 타이틀종료 -->

			<div class="sp35"></div>

			<form action="joinform_insert.php" method="post" name="join_form" id ="form">
			<input type="hidden" name="userid_confrom" value="n" >
		<input type="hidden" name="phone_code" value="n" >
		<input type="hidden" name="cidflag"		value="n" >
		<input type="hidden" name="confirm_cid" value="" >
		<input type="hidden" name="confirm_hid" value="" >
		<input type="hidden" name="hidflag" value="n">
			<div class="join_inner" style="width:700px;">
				<table class="join_table">
					<tr>
						<td colspan="2" class="join_title">Site usage information.<div class="sp5"></div><p class="title_s">
                                                 If you enter the information, Sign Up will be completed.</p></td>
					</tr>
					<tr>
						<td height="5px"></td>
					</tr>


					<tr>
						<th width=32%>Name</th>
						<td>
							<input type="text" name="name1" name1="name1" value="<?=$name1?>" class="join_name"></p>
						</td>
					</tr>
					<tr>
						<th>Country</th>
						<td>
							<select class="join_name" name="m_contury" id="m_contury" style="width:69%;">
								<option value="82">Korea (+82)</option>
								<option value="1">USA (+1)</option>
								<option value="86">China (+86)</option>
								<option value="81">JAPAN (+81)</option>
								<option value="62">Indonesia (+62)</option>
								<option value="65">Singapore (+65)</option>
								<option value="84">Vietnam (+84)</option>
								<option value="91">India  (+91)</option>
								<option value="63">Philippines (+63)</option>
								<option value="66">Thailand (+66)</option>
								<option value="886">Taiwan (+886)</option>
								<option value="60">Malaysia  (+60)</option>
								<option value="855">Cambodia (+855)</option>
								<option value="52">Mexico (+52)</option>
								<option value="51">Peru (+51)</option>
								<option value="55">Brazil (+55)</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>Cell Phone</th>
						<td>
							<input type="number"style="width:17%;" class="join_name numberic" name="tel_1" id="tel1" maxlength='3'>
							<input type="number"style="width:23%;" class="join_name numberic mr-5p ml-5p" name="tel_2" id="tel2"  maxlength='4'>
							<input type="number"style="width:23%;" class="join_name numberic" name="tel_3" id="tel3" maxlength='4'>
						</td>
					</tr>
					<tr>
						<th>ID</th>
						<td>
						<input type="text" class="join_name" id="userid" name="s_username" onfocusout="check_id(this.vlaue)"  maxlength="20" >
						</td>
					</tr>
					
					<!--
					<tr>
						<th>추천아이디</th>
						<td>
							<input type="text" name="c_c_id" id="c_c_id" class="join_name"> 
							<p class="join_text">영문, 숫자만 입력가능, 최소 4자 이상 입력하세요.</p>
						</td>
					</tr>
					-->

					<tr>
						<th>Password</th>
						<td>
						<input type="Password" class="join_name" name="passwd">
						</td>
					</tr>
					<tr>
						<th>Verify Password</th>
						<td>
						<input type="Password" class="join_name" name="fin_passwd">
						</td>
					</tr>
					 <tr>
						<th>Pin Number</th>
						<td>
						<input type="Password" class="join_name numberic" maxlength="4" name="pin">
						</td>
					</tr>
					<tr>
						<th>Verify Pin</th>
						<td>
						<input type="Password" class="join_name numberic" maxlength="4" name="conf_pin">
						</td>
					</tr>
					<tr>
						<th>ZIP Code</th>
						<td>
						<input type="text" class="join_name" name="C_ZIP" id="C_ZIP">
						</td>
					</tr>
					<tr>
						<th>Address</th>
						<td>
						<input type="text" class="join_name" name="C_ADDR" id="C_ADDR">
						</td>
					</tr>
					<tr>
						<th>Detail Add</th>
						<td>
						<input type="text" class="join_name" name="C_ADDR2" id="C_ADDR2">
						</td>
					</tr>
<!--
					<tr>
						<th>Recommender</th>
						<td>
						<input type="text" class="join_name" name="c_username" id="c_username" onfocusout="check_spon('c')" value="<?=$user_id?>">
						</td>
					</tr>
					<tr>
						<th>R. Confirm</th>
						<td>
						<input type="text" class="join_name" name="sponsearchc"  readonly value="">	
						</td>
					</tr>
					<tr>
						<th>Sponsor ID</th>
						<td>
						<input type="text" class="join_name" name="h_username" id="h_username" onfocusout="check_spon2('h')" value="<?=$user_id?>">
						</td>
					</tr>
					<tr>
						<th>S. Confirm</th>
						<td>
						<input type="text" class="join_name" name="sponsearchch"  readonly value="">	
						</td>
					</tr> 
-->
					<tr>
						<th>E-mail</th>
						<td>
						<input type="text" class="join_name " name="email" id="email" style="float:left;">
						</td>
					</tr>
					
					<tr>
						<td height="5px"></td>
					</tr>
					
				</table>
			</div>

			<div class="sp30"></div>

			<div class="write_btn_box">
				<input type="button" value="Sign up" class="cart_btn04" onClick="signup_ok();">&nbsp;
				<input type="button" value="Cancle" class="cart_btn01" onclick="location.href='./agree.php'">
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

<script>
function iframeclick() {
document.getElementById("cap").contentWindow.document.body.onclick = function() {
        document.getElementById("cap").contentWindow.location.reload();
    }
}

$(document).ready(function () {
	var us="<?=$user_id?>";
	if(us != ""){
		check_spon('c');
	}
	// console.log($("#cap").find("img"));
	$("#cap").contents().find("img").css('cursor', 'pointer');
	$("#cap").on("click", function () {
		alert("1");
	});
    $(".requestE").off("click").on("click",function(e){
        e.preventDefault();
        var frm = document.join_form;

        if ($("#email").val() == "" || $("#email").val() == undefined)
        {
			$("#email").focus();
            alert("<?=$join_alert24?>");
            return false;
        }
        
        emailSend();
    });
	$(".requestS").off("click").on("click",function(e){
        e.preventDefault();

        smsSend();
    });
	var emailSend = function(){
        var email = $("#email").val();
		
			$.ajax({
			type: "POST",
			url: "./send_emailAws.php",
			data: {"email":email},
			dataType: "html",
			success: function (response) {
				if(response==0){
					alert("<?=$join_alert25?>");
					return false;
				}else if(response==1){
					alert("<?=$join_alert26?>");
					// location.href="./login.php"
					return false;
				}else if(response==22){
					alert("<?=$join_alert27?>");
					// location.href="./login.php"
					return false;
				}else if(response==999){
					alert("<?=$join_alert28?>");
					// location.href="./login.php"
					return false;
				}else{
					alert("<?=$join_alert28?>");
					return false;
				}
			}
		});
	}
    var smsSend = function(){
        var tel_1 = $("#tel1").val();
		var tel_2 = $("#tel2").val();
		var tel_3 = $("#tel3").val();

		if(tel_1 == "" || tel_1 == undefined){
			alert("Enter your phone number.");
			$("#tel1").focus();
			return false;
		}
		if(tel_2 == "" || tel_2 == undefined){
			alert("Enter your phone number.");
			$("#tel2").focus();
			return false;
		}
		if(tel_3 == "" || tel_3 == undefined){
			alert("Enter your phone number.");
			$("#tel3").focus();
			return false;
		}
		var m_contury = $("#m_contury").val();
			$.ajax({
			type: "POST",
			url: "./send_sms.php",
			data: {"tel_1":tel_1,"tel_2":tel_2,"tel_3":tel_3,"m_contury":m_contury},
			dataType: "html",
			success: function (response) {
				if(response==0){
					alert("<?=$join_alert29?>");
					return false;
				}else if(response==1){
					alert("<?=$join_alert30?>");
					// location.href="./login.php"
					return false;
				}else if(response==22){
					alert("<?=$join_alert31?>");
					// location.href="./login.php"
					return false;
				}
			}
		});
	}

});
$(document).ready(function () {
	$('#userid').keyup(function() {
// 		re = /[~!@\#$%^&*\()\-=+_']/gi; 

// 출처: https://nicebury.tistory.com/113 [나이스버리]
			var inputVal = $(this).val();
			$(this).val((inputVal.replace(/[~!@\#$%^&*\()\-=+_']/gi,'').replace(/^[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]*$/,'')));
	});
});
</script>

 <script type="text/javascript">
    $("#cap").on("load", function() {
      let head = $("iframe").contents().find("head");
      let css = '<link rel="stylesheet" href="./css/cap.css">';
      $(head).append(css);
    });
  </script>
</body>
</html>
