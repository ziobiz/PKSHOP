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

	<div id="header">

		<div class="header_top">
			<div class="header_inner">
				<div class="header_top_box01">
				<a href="../cart/overview.php">My Shopping</a>
				<a href="../cart/cart.php">Shopping Cart</a>
				</div>
				<div class="header_top_box02">
					<?if($_SESSION['member_id']==""){ ?>
					<a href="../member/login.php">LOGIN or Membership （ログインと会員登録)</a>
					<!-- <a href="../member/agree.php">JOIN US</a> -->
					<?}else{?>
					<a href="../cart/overview.php">MY PAGE</a>
					<a href="../member/logout.php">LOG OUT</a>
						<?}?>
					
					<!-- 로그인 이후
					<a href="#">로그아웃</a>
					<a href="../member/modify.php">정보수정</a>
					-->
					<!-- <a href="../sub05/list.php?Sub_No=1">고객센터</a> -->
				</div>
			</div>
		</div>


		<div class="header_inner pc_hide" style="position:relative;">
			<div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);"><a href="../main/main.html"><img src="<?=htmlspecialchars(pkshop_site_setting('logo_mobile'), ENT_QUOTES, 'UTF-8')?>" class="m_logo" style="width:<?=intval(pkshop_site_setting('logo_mobile_width'))?>px;height:<?=intval(pkshop_site_setting('logo_mobile_height'))?>px;object-fit:contain;"></a></div>
			<div class="nav_btn"><img src="../images/nav_btn.png"></div>
		</div>


		<div class="header_inner">
			<div class="po-box">
				<div class="logo">
					<a href="../main/main.html"><img src="<?=htmlspecialchars(pkshop_site_setting('logo_pc'), ENT_QUOTES, 'UTF-8')?>" alt="로고" style="width:<?=intval(pkshop_site_setting('logo_pc_width'))?>px;height:<?=intval(pkshop_site_setting('logo_pc_height'))?>px;object-fit:contain;"></a>
				</div>
			<SCRIPT LANGUAGE="JavaScript">
			<!--
			function sgo2() {
				if(document.find2.word.value==""){
					alert("Enter the search word.");
					return;
				}
//				document.find2.stype.value = "1";
				document.find2.submit();
			}
			//-->
			</SCRIPT>
			<div class="Search-Area">
				<form name="find2" action="../sub04/list.php?type=4" method="post">
					<select class="header_select">
						<option selected value="제품명">Name</option>
					</select>
					
					<div class="header_input">
					<input type="text" name="word" style="border:none;">
					<a onclick="javascript:sgo2();" style="cursor:pointer;"><img src="../images/icon01.png"></a>
					</div>
				</form>
			</div>
				<div class="scroll-banner">
					<div class="swiper mySwiper01">
						<?
						
						$tops = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&Type=all3";
										
						$ch = curl_init();
						curl_setopt ($ch, CURLOPT_URL, $api_history);
						curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
						curl_setopt ($ch, CURLOPT_POST, 1);
						curl_setopt ($ch, CURLOPT_POSTFIELDS, $tops);
						curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
						curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
						$tops = curl_exec ($ch);
						curl_close ($ch);
						$tops = json_decode($tops,true);
						$count = count($tops);


				
						?>
					  <div class="swiper-wrapper">
						  <?foreach ($tops as $key => $value) {
							  if($value["imgl"] == "")continue;
								$code2	 = $value['code2'];
								$code3	 = $value['code3'];
								$code	 = $value['code'];
								$code4		= $value['code4'];	/*색상*/ 
							  ?>
							<!-- <div class="swiper-slide">  <a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&theme=f&type=<?=$type?>"><img style="width:100%;" src="//pentakleva.shop/upload/<?=$value["imgl"]?>"></a></div> -->
						  <?}?>
					  </div>
					  <div class="swiper-pagination"></div>
					</div>
				</div>
				<script>
				  var swiper = new Swiper(".mySwiper01", {
					direction: "vertical",
					slidesPerView: 1,
					spaceBetween: 30,
					mousewheel: true,
					autoplay: {
					  delay: 2500,
					  disableOnInteraction: false,
					},
				  });
				</script>
				<div class="sp35"></div>
			</div>
	</div>
<!--네비-->
<?
		
		$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&Type=cartegory";
		// echo $api_history;
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $api_history);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec ($ch);
		curl_close ($ch);
		// echo $result;
		// exit;
		
		$json_o = json_decode($result,true);

		$count = count($json_o);
									
		
									
?>
<div class="main_nav_bar">
<div class="content">
				<ul class="all_category">
					<li><a href="#">Category</a>
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
					<li><a href="../sub04/list.php?theme_str=r">Best </a></li>
					<li><a href="../sub04/list.php?theme_str=n">Recommended</a></li>
					<li><a href="../sub04/list.php?theme_str=f">Hot deal</a></li>
					<!-- <li><a href="#none">명품샵</a></li> -->
				</ul>
			</div>
		</div>
	</div>
<!--//네비-->
<div id="gnb" class="pc_hide">
	<div class="gnb_inner">
		<div class="click_logo_box">
			<div class="nav_logo"><img src="../images/logo2.png"></div>
			<div id="close"><img src="../images/gnb_close.png"></div>
		</div>

		
				<div class="header_top_box02">
					
				<?if($_SESSION['member_id']==""){ ?>
					<a href="../member/login.php">LOGIN or Membership<br>（ログインと会員登録)</a>
					<!-- <a href="../member/agree.php">JOIN US</a> -->
					<?}else{?>
					<a href="../cart/overview.php">MY PAGE</a>
					<a href="../member/logout.php">LOG OUT</a>
						<?}?>

				</div>

				
				<ul class="m_nav">
					<li><a href="../sub04/list.php?theme_str=r">Best</a></li>
					<li><a href="../sub04/list.php?theme_str=n">Recommended</a></li>
					<li><a href="../sub04/list.php?theme_str=f">Hot deal</a></li>
					<!-- <li><a href="../sub04/list.php?theme_str=n">추천제품</a></li>
					<li><a href="../sub04/list.php?theme_str=f">Hot deal제품</a></li> -->
				</ul>

				<ul class="m_dropdown">
<?
		for($i=0;$i<$count;$i++)
		{

?>
							<li><a href="../sub04/list.php?left_code=<?=$json_o[$i]['code']?>00000000"><?=$json_o[$i]['cate']?></a></li>
<?}?>


					<!-- <ul class="sub_dropdown">
						<li><a href="../sub05/list.php?Sub_No=1">- 공지사항</a></li>
						<li><a href="../sub05/list.php?Sub_No=2">- 질문과 답변</a></li>
						<li><a href="../sub05/list.php?Sub_No=3">- 이벤트</a></li>
					</ul> -->
				</ul>

				


	</div>
</div>
	<div class="clear"></div>
