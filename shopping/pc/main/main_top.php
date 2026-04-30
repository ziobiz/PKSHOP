<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
<script type="text/javascript" src="../include/swiper.min.js"></script>
<script>
	$(function(){
		$('.dropdown').hide();
		$('.all_category li').hover(function(){
			$('ul', this).slideDown('fast');
		}, function(){
			$('ul', this).slideUp('fast');
		});
	});
</script>
<script>
	$(document).ready(function(){
		$(".nav_btn").click(function(){
			$("#gnb").animate({"left":"0px"},500);
		});	
		$("#close").click(function(){
			$("#gnb").animate({"left":"-150%"},500);
		});
	});
</script>
<script>
	$(function(){
		$('.dropdown').hide();
		$('.all_category li').hover(function(){
			$('ul', this).slideDown('fast');
		}, function(){
			$('ul', this).slideUp('fast');
		});
	});
</script>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
HCBRS
<link rel="stylesheet" href="../include/reset.css">
<link rel="stylesheet" type="text/css" href="../include/style_main.css" media="screen and (min-width:1024px)"/>
<link rel="stylesheet" type="text/css" href="../include/responsive.css" media="screen and (max-width:1023px)"/>
<link rel="stylesheet" href="../include/swiper.min.css">

 </head>
	<div id="header">

		<div class="header_top">
			<div class="header_inner">
<!-- 				<div class="header_top_box01"> -->
<!-- 					<a href="#">즐겨찾기</a> -->
<!-- 					<a href="#">바로가기</a> -->
<!-- 				</div> -->
				<div class="header_top_box02">
					<?if($_SESSION[valid_user]==""){ ?>
					<a href="../member/login.php">LOGIN</a>
					<a href="../member/agree.php">JOIN US</a>
					<?}else{?>
					<a href="../cart/overview.php">MY PAGE</a>
					<a href="../member/logout.php">LOG OUT</a>
						<?}?>
					
					<!-- 로그인 이후
					<a href="#">로그아웃</a>
					<a href="../member/modify.php">정보수정</a>
					-->
					<a href="../sub05/list.php?Sub_No=1">고객센터</a>
				</div>
			</div>
		</div>


		<div class="header_inner pc_hide" style="position:relative;">
			<div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);"><a href="../main/main.html"><img src="../images/logo_2.png" class="m_logo"></a></div>
			<div class="nav_btn"><img src="../images/nav_btn.png"></div>
		</div>


		<div class="header_inner">
			<div>
				<div class="sp35"></div>

				<div class="logo">
					<a href="../main/main.html"><img src="../images/logo_2.png" alt="로고"></a>
				</div>
			<SCRIPT LANGUAGE="JavaScript">
			<!--
			function sgo2() {
				if(document.find2.word.value==""){
					alert("검색단어를 입력하세요.");
					return;
				}
//				document.find2.stype.value = "1";
				document.find2.submit();
			}
			//-->
			</SCRIPT>
			<form name="find2" action="../sub04/list.php?type=4" method="post">
				<select class="header_select">
					<option selected value="제품명">제품명</option>
				</select>
				
				<div class="header_input">
				<input type="text" name="word" style="border:none;">
				<a onclick="javascript:sgo2();" style="cursor:pointer;"><img src="../images/icon01.png"></a>
				</div>
			</form>
				<div class="header_btn">
					<div class="header_btn_box01" onclick="location.href='../sub05/list.php?Sub_No=1';">
						<img class="header_btn_img" src="../images/icon02.png">
						<p class="header_btn_text01"><span>NOTICE</span><br>
						공지사항</p>
					</div>
					<div class="header_btn_box02" onclick="location.href='../cart/cart.php';">
						<img class="header_btn_img" src="../images/icon03.png">
						<p class="header_btn_text02"><span>MY CART</span><br>
						items</p>
					</div>
				</div>

				<div class="sp35"></div>
			</div>
	</div>
<!--네비-->
<?
		
		$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&Type=cartegory";
										
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $api_history);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec ($ch);
		curl_close ($ch);
		
		//echo $result;
		
		$json_o = json_decode($result,true);

		$count = count($json_o);
									
		
									
?>
<div class="main_nav_bar">
<div class="content">
				<ul class="all_category">
					<li><a href="#">전체카테고리</a>
						<ul class="dropdown">
<?


		for($i=0;$i<$count;$i++)
		{

?>
		<li><a href="../sub04/list.php?left_code=<?=$json_o[$i]['code']?>00000000"><?=$json_o[$i]['cate']?></a></li>
<?
		}
?>
						</ul>
					</li>
				</ul>

				<ul class="nav">
					<li><a href="../sub04/list.php?theme_str=r">BEST제품</a></li>
					<li><a href="../sub04/list.php?theme_str=n">추천제품</a></li>
					<li><a href="../sub04/list.php?theme_str=f">HOT제품</a></li>
					<li><a href="http://k-prestige.co.kr" target="_blank">명품샵</a></li>
				</ul>
			</div>
		</div>
	</div>
<!--//네비-->
<div id="gnb" class="pc_hide">
	<div class="gnb_inner">
		<div class="click_logo_box">
			<div class="nav_logo"><img src="../images/logo_2.png"></div>
			<div id="close"><img src="../images/gnb_close.png"></div>
		</div>

		
				<div class="header_top_box02">
					
					<a href="../cart/overview.php">MY PAGE</a>
		<a href="https://GP.app/web/logok3.php?uid=<?=base64_encode($valid_user)?>">돌아가기</a>

				</div>

				
				<ul class="m_nav">
					<li><a href="../sub04/list.php?theme_str=r">BEST제품</a></li>
					<!-- <li><a href="../sub04/list.php?theme_str=n">추천제품</a></li>
					<li><a href="../sub04/list.php?theme_str=f">HOT제품</a></li> -->
				</ul>

				<ul class="m_dropdown">
<?
		for($i=0;$i<$count;$i++)
		{

?>
							<li><a href="../sub04/list.php?left_code=<?=$json_o[$i]['code']?>00000000"><?=$json_o[$i]['cate']?></a></li>
<?}?>


					<ul class="sub_dropdown">
						<li><a href="../sub05/list.php?Sub_No=1">- 공지사항</a></li>
						<li><a href="../sub05/list.php?Sub_No=2">- 질문과 답변</a></li>
						<li><a href="../sub05/list.php?Sub_No=3">- 이벤트</a></li>
					</ul>
				</ul>

				


	</div>
</div>
	<div class="clear"></div>
