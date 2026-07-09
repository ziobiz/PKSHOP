<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );
$theme_str = isset($_GET['theme_str']) ? $_GET['theme_str'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$query_dis = isset($_GET['query_dis']) ? $_GET['query_dis'] : '';
include "../include/get_balance.php";
if (!PKSHOP_PUBLIC_PRICE) {
	include "../include/login_check.php";
}
include "../include/product_detail_helper.php";

// include "../include/top_session.php";

?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus  ">

<SCRIPT LANGUAGE="JavaScript">
<!--
function imgview(code) {
	window.open("./zoom.php?code="+code,"imgview","toolbar=no,resizable=no,status=no,width=648,height=505,scrollbars=no");
}

function no_cart() {
	alert("It's out of stock.");
	return ;
}

function go_cart(code,cate,color,size,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5) {

	var amount = document.p_form.qty.value;
	var opt1 = "", opt2 = "", opt3 = "", opt4 = "", opt5 = "";
	<?if ($option_n1 != ''){?>
	var opt1 = document.p_form.opt1.value;
	<?}?>
	<?if ($option_n2 != ''){?>
		var opt2 = document.p_form.opt2.value;
	<?}?>
	<?if ($option_n3 != ''){?>
		var opt3 = document.p_form.opt3.value;
	<?}?>
	<?if ($option_n4 != ''){?>
		var opt4 = document.p_form.opt4.value;
	<?}?>
	<?if ($option_n5 != ''){?>
		var opt5 = document.p_form.opt5.value;
	<?}?>
	var opt1 = opt1 || "";
	var opt2 = opt2 || "";
	var opt3 = opt3 || "";
	var opt4 = opt4 || "";
	var opt5 = opt5 || "";


	document.p_form.action="../cart/cart1.php?code=" + code + "&amount=" + amount+"&opt1="+opt1+"&opt2="+opt2+"&opt3="+opt3+"&opt4="+opt4+"&opt5="+opt5;
	document.p_form.submit();

}

function buy_go(code,cate,color,size,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5) {
	var valid_user = '<?= isset($valid_user) ? addslashes($valid_user) : "" ?>';
	if (!valid_user) {
		alert('Only members can complete a purchase. Please log in to continue.');
		location.href = '../member/login.php?from=buy';
		return false;
	}
	amount = document.p_form.qty.value;
	var opt1 = "", opt2 = "", opt3 = "", opt4 = "", opt5 = "";
	<?if ($option_n1 != ''){?>
	var opt1 = document.p_form.opt1.value;
	<?}?>
	<?if ($option_n2 != ''){?>
		var opt2 = document.p_form.opt2.value;
	<?}?>
	<?if ($option_n3 != ''){?>
		var opt3 = document.p_form.opt3.value;
	<?}?>
	<?if ($option_n4 != ''){?>
		var opt4 = document.p_form.opt4.value;
	<?}?>
	<?if ($option_n5 != ''){?>
		var opt5 = document.p_form.opt5.value;
	<?}?>
	var opt1 = opt1 || "";
	var opt2 = opt2 || "";
	var opt3 = opt3 || "";
	var opt4 = opt4 || "";
	var opt5 = opt5 || "";
	
	
	/*
	if (document.p_form.color.value == '')
	{
		alert("Please select a color.");
	}
	else if (document.p_form.size.value == '')
	{
		alert("Please select a size.");
	}
	else*/
	// {
		// alert("../cart/cart2.php?code=" + code + "&amount=" + amount+"&opt1="+opt1+"&opt2="+opt2+"&opt3="+opt3+"&opt4="+opt4+"&opt5="+opt5);
		// return false;
	document.p_form.action="../cart/cart2.php?code=" + code + "&amount=" + amount+"&opt1="+opt1+"&opt2="+opt2+"&opt3="+opt3+"&opt4="+opt4+"&opt5="+opt5;
	document.p_form.submit();
	// }
	
}


function go_save(code,cate,color,size,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5) { //
	amount = document.p_form.qty.value;
	size = document.p_form.size.value;
	color = document.p_form.color.value;
	option1 = document.p_form.option1.value;
	option2 = document.p_form.option2.value;
	option3 = document.p_form.option3.value;
	option4 = document.p_form.option4.value;
	option5 = document.p_form.option5.value;
	cprice1 = document.p_form.cprice1.value;

	size=encodeURIComponent(size);
	color=encodeURIComponent(color);
	option1=encodeURIComponent(option1);
	option2=encodeURIComponent(option2);
	option3=encodeURIComponent(option3);
	option4=encodeURIComponent(option4);
	option5=encodeURIComponent(option5);

var valid_user = '<?=$valid_user?>';//???

	url="./save_do.php?code=" + code + "&amount=" + amount + "&size=" + size + "&color=" + color + "&option1=" + option1 + "&option2=" + option2 + "&option3=" + option3 + "&option4=" + option4 + "&option5=" + option5 + "&cprice1=" + cprice1 + "&valid_user=" + valid_user;
	window.open(url,"","width=50,height=50");
}

//-->
</SCRIPT>
<?

$left_code	 = $_GET['left_code'];
$code		 = $_GET['code1'];

if($left_code != "") {
	$code1 = substr($left_code, 0, 2);
	$code2 = substr($left_code, 2, 2);
	$code3 = substr($left_code, 4, 2);
	$code4 = substr($left_code, 6, 2);
	$left_code_tmp = $left_code;
	$code=$left_code;
}else{
	$code1 = '01';
}

if($code != "") {
	$code1 = substr($code, 0, 2);
	$code2 = substr($code, 2, 2);
	$code3 = substr($code, 4, 2);
	$code4 = substr($code, 6, 2);
	$code=$code;
}

//접속접보
$signdate=time();
$ip=$REMOTE_ADDR;


// $sql = "id			='$code',									
// 		signdate	='$signdate',
// 		ip			='$ip'";
// $DB->insert($attendance, $sql);

//$result_ip = mysql_query($query_ip);

$code1_cate_tmp = $code1;
$code2_cate_tmp = $code2;
$code3_cate_tmp = $code3;
$code4_cate_tmp = $code4;
$title_cate_1 = '';
$title_cate_2 = '';
$title_cate_3 = '';
$title_cate_4 = '';

//echo "$code1 $code2 $code3 $code4,$theme_str";
if($theme_str==""){//정렬순서 관련

	if($code1!=""){
		$curl_d = json_decode(curl_d($api_category,"&Type=cate1&code1=$code1"),true);
		if (is_array($curl_d) && isset($curl_d[0]['cate'])) {
			$tmp_cate1		= $curl_d[0]['cate'];
			$title_cate_1	= $tmp_cate1;	//대분류 이름기억
			$title_code_1	= $code1;
		}
	}
	
	if($code2!=""){
	$curl_d = json_decode(curl_d($api_category,"&Type=cate2&code1=$code1&code2=$code2"),true);
	if(is_array($curl_d) && count($curl_d)>0){
		$tmp_cate2 = $curl_d[0]['cate'] ;
		$title_cate_2 = $tmp_cate2;	//중분류 이름기억
		$title_code_2 = $code2;
	}
	
	}

		if($code3!=""){
		$curl_d = json_decode(curl_d($api_category,"&Type=cate3&code1=$code1&code2=$code2&code3=$code3"),true);
		if(is_array($curl_d) && count($curl_d)>0){
			$tmp_cate3 = $curl_d[0]['cate'] ;
			$title_cate_3 = $tmp_cate3;	//중분류 이름기억
			$title_code_3 = $code3;
		}
	}

	if($code4!=""){
		$curl_d = json_decode(curl_d($api_category,"&Type=cate4&code1=$code1&code2=$code2&code3=$code3&code4=$code4"),true);
		if(is_array($curl_d) && count($curl_d)>0){
			$tmp_cate4 = $curl_d[0]['cate'];
			$title_cate_4 = $tmp_cate4;	//중분류 이름기억
			$title_code_4 = $code4;
		}
	}

}


$goods = json_decode(curl_d($api_history,"&Type=goodsView&code=".$code),true);
if (!is_array($goods) || !isset($goods[0]) || !is_array($goods[0])) {
	$goods = array(array());
}

#####################################################################
$pkshop_head_style = 'shop';
if (!empty($goods[0]['title'])) {
	$pkshop_page_title = $goods[0]['title'];
}
include "../include/pkshop_html_head.php";
?>
 </head>

 <body>

	 <div class="wrap">

		<!-- 상단 (top) -->

		<? include "../include/top.php"; ?>

		<!-- 상단 (top) 끝 -->

		<div class="sub04_container">
		<div class="sp50"></div>
			<!-- 카테고리 -->

			<? include "../include/category_pur.php"; ?>

			<!-- 카테고리 끝 -->



			<!-- view -->



					<?



	$query = "SELECT title,info,pricec,prices,priced,point,size,color,currnum,detail,company,feature,soldout,relation,price_dis,imgm,opt_num,opt_num_str,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,point_dis,color_opt,size_opt,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5,home,event_str,imgb1,imgb2,imgb3,imgb4,imgb5,coin,c_pv FROM $shop_goods WHERE code='$code'";
	
	// $DB->get($query, $goods,$goodn);
	
	

	if (!is_array($goods) || !isset($goods[0]) || !is_array($goods[0])) {
		$goods = array(array());
	}

	$row = $goods;
	$title		= $row[0]['title'];		/*상품명*/	
	$info		= $row[0]['info'];
	$pricec		= $row[0]['pricec'];		/*판매*/			
	$prices		= $row[0]['prices'];     /*입고*/
	$priced		= $row[0]['priced'];     /*할인*/
	$point		= $row[0]['point'];		/*상품 적립금*/		
	$size		= $row[0]['size'];		/*사이즈*/
	$color		= $row[0]['color'];		/*색상*/						
	$currnum	= $row[0]['currnum'];		/*현재수량*/
	$detail		= $row[0]['detail'];		/*상품정보*/					
	$company	= $row[0]['company'];		/*제조사*/
	$feature	= $row[0]['feature'];		 /*규격설명*/			
	$soldout	= $row[0]['soldout'];
	$relation	= $row[0]['relation'];			
	$price_dis	= $row[0]['price_dis'];			
	$imgm		= $row[0]['imgm'];
	$opt_num	= $row[0]['opt_num'];
	$opt_num_str= $row[0]['opt_num_str'];
	$option_t1	= $row[0]['option_t1'];
	$option_n1	= $row[0]['option_n1'];
	$option_p1	= $row[0]['option_p1'];
	$option_k1	= $row[0]['option_k1'];
	$option_t2	= $row[0]['option_t2'];
	$option_n2	= $row[0]['option_n2'];
	$option_p2	= $row[0]['option_p2'];
	$option_k2	= $row[0]['option_k2'];
	$option_t3	= $row[0]['option_t3'];
	$option_n3	= $row[0]['option_n3'];
	$option_p3	= $row[0]['option_p3'];
	$option_k3	= $row[0]['option_k3'];
	$option_t4	= $row[0]['option_t4'];
	$option_n4	= $row[0]['option_n4'];
	$option_p4	= $row[0]['option_p4'];
	$option_k4	= $row[0]['option_k4'];
	$option_t5	= $row[0]['option_t5'];
	$option_n5	= $row[0]['option_n5'];
	$option_p5	= $row[0]['option_p5'];
	$option_k5	= $row[0]['option_k5'];
	$point_dis	= $row[0]['point_dis'];
	$color_opt	= $row[0]['color_opt'];
	$size_opt	= $row[0]['size_opt'];
	$add_opt1	= $row[0]['add_opt1'];
	$add_opt2	= $row[0]['add_opt2'];
	$add_opt3	= $row[0]['add_opt3'];
	$add_opt4	= $row[0]['add_opt4'];
	$add_opt5	= $row[0]['add_opt5'];
	$home		= $row[0]['home'];
	$event_str	= $row[0]['event_str'];
	$imgb1		= $row[0]['imgb1'];
	$imgl		= $row[0]['imgl'];
	$imgm		= $row[0]['imgm'];
	$imgb2		= $row[0]['imgb2'];
	$imgb3		= $row[0]['imgb3'];
	$imgb4		= $row[0]['imgb4'];
	$imgb5		= $row[0]['imgb5'];

	$coin		= $row[0]['coin'];
	$c_pv		= $row[0]['c_pv'];
	$country = isset($row[0]['country']) ? $row[0]['country'] : '';

	if($title == ""){?>
		<script>
			alert("The product information cannot be checked.");
			history.back();
		</script>
	<?exit;}
	
	$event_str = preg_replace("/\r/", "", $event_str);
	$event_str = preg_replace("/(\>[ ]*)\n/", ">\n", $event_str);
	$event_str = preg_replace("/((font|span|a)\>[ ]*|[^\>])\n/i", "\\1<br />\n", $event_str);

	$pricec_code = $pricec;  //판매


	$prices_code = $prices;  //코인사용
	$priced_code = $priced;  //할인

	$detail = stripslashes($detail);
	$detail = pkshop_sanitize_product_detail_html($detail, array(
		'imgl'  => $imgl,
		'imgm'  => $imgm,
		'imgb1' => $imgb1,
		'imgb2' => $imgb2,
		'imgb3' => $imgb3,
		'imgb4' => $imgb4,
		'imgb5' => $imgb5,
	));
##############회&nbsp;원등급에 따른 가격계산###################################3
	if($cook_dis=="1" && $cook_dis1=="승인"){
		$price_tmp = $priced;
	}else	if($cook_dis=="2" && $cook_dis1=="승인"){
		$price_tmp = $pricec;
	}else if($cook_dis=="3" && $cook_dis1=="승인"){
		$price_tmp = $prices;
	}else{
		if($priced>0){
			$price_tmp = $priced;
		}else{
			$price_tmp = $pricec;
		}
	}

$price_tmp_kk = $price_tmp; //shop_view.htm용 — USD 숫자값 유지
$price_tmp_display = pkshop_format_display_price($price_tmp_kk);
#################################################

#################포인트 계산################################
if($point_dis=='pe'){
	$cpoint=number_format(floor($price_tmp*$point/100))."&nbsp;원";
	$cpoint1=floor($price_tmp*$point/100);
}else{
	$cpoint=number_format($point)."&nbsp;";
	$cpoint1=$point;
}
#################################################

	
	$asize = explode(",",$size);				/*사이즈 분리*/			 
	$acolor = explode(",",$color);				/*색상 분리*/
	$priced = number_format($priced);		/*가격표시변환*/

	$aopt_num = explode(",",$opt_num);


	$aoption_n1=explode("\r\n",$option_n1);		
	$aoption_p1=explode("\r\n",$option_p1);		
	$aoption_k1=explode("\r\n",$option_p1);
	$aoption_n2=explode("\r\n",$option_n2);	 	
	$aoption_p2=explode("\r\n",$option_p2);		
	$aoption_k2=explode("\r\n",$option_p2);
	$aoption_n3=explode("\r\n",$option_n3);		
	$aoption_p3=explode("\r\n",$option_p3);		
	$aoption_k3=explode("\r\n",$option_p3);
	$aoption_n4=explode("\r\n",$option_n4);		
	$aoption_p4=explode("\r\n",$option_p4);	 	
	$aoption_k4=explode("\r\n",$option_p4);
	$aoption_n5=explode("\r\n",$option_n5);		
	$aoption_p5=explode("\r\n",$option_p5);		
	$aoption_k5=explode("\r\n",$option_p5);
	$aaoption_n1=explode("\r\n",$option_n1);		
	$aaoption_p1=explode("\r\n",$option_p1);		
	$aaoption_k1=explode("\r\n",$option_p1);
	$aaoption_n2=explode("\r\n",$option_n2);	 	
	$aaoption_p2=explode("\r\n",$option_p2);		
	$aaoption_k2=explode("\r\n",$option_p2);
	$aaoption_n3=explode("\r\n",$option_n3);		
	$aaoption_p3=explode("\r\n",$option_p3);		
	$aaoption_k3=explode("\r\n",$option_p3);
	$aaoption_n4=explode("\r\n",$option_n4);		
	$aaoption_p4=explode("\r\n",$option_p4);	 	
	$aaoption_k4=explode("\r\n",$option_p4);
	$aaoption_n5=explode("\r\n",$option_n5);		
	$aaoption_p5=explode("\r\n",$option_p5);		
	$aaoption_k5=explode("\r\n",$option_p5);

	
	### 이미지 파일 저장 디렉토리 ###
	$savedir = "//pentakleva.shop/upload/";

	$img_name = $imgb1;

	$view_img = '';
	if ($imgl != '') {
		$view_img = $imgl;
	} elseif ($imgm != '') {
		$view_img = $imgm;
	} elseif ($imgb1 != '') {
		$view_img = $imgb1;
	} elseif ($imgb2 != '') {
		$view_img = $imgb2;
	} elseif ($imgb3 != '') {
		$view_img = $imgb3;
	}

	$thumb_images = array();
	foreach (array($imgl, $imgm, $imgb1, $imgb2, $imgb3) as $timg) {
		if ($timg != '' && !in_array($timg, $thumb_images)) {
			$thumb_images[] = $timg;
		}
	}

	$img_info = @getImageSize($savedir . (($view_img != '') ? $view_img : $imgb1));
	$img_width = isset($img_info[0]) ? $img_info[0] : 0;
	$img_height = isset($img_info[1]) ? $img_info[1] : 0;

	if($img_width > $img_height){
		$img_size = "width='274'";
	}else{
		$img_size = "height='238'";
	}

	


?>

<SCRIPT LANGUAGE="JavaScript">


function price_change(){
	var frm = document.p_form;
	var price = document.getElementById('pricec_code').value;
	var qty = document.getElementById('qty').value;
	var price2 = qty*price;

	$price_total = price2;
	price2 = price2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	document.getElementById('totalprice').innerHTML=price2+"&nbsp;LANX";
}

//-->
</SCRIPT>
<?if($option_t1!=""){?>
<SCRIPT LANGUAGE="JavaScript">
 
</SCRIPT>
<?}?>


			<div class="content2">
        <div class="sp30"><span class="car-span"><?=$title_cate_1?></span><?if($title_cate_2 != ""){?>> <?=$title_cate_2?><?}?> <?if($title_cate_3 != ""){?>> <?=$title_cate_3?><?}?> <?if($title_cate_4 != ""){?>> <?=$title_cate_4?><?}?></div>
				<p class="view_title"><?=$title?></p>
				<div class="view_line"></div>

				<div class="sp30"></div>
				<div class="view_content">
					<div class="view_img">
						<div class="thumbnail-m"><img src="//pentakleva.shop/upload/<?=$view_img?>" id="pr_img" style="max-height: 275px;"></div>
						
						<div class="thumbnail-s swiper viewThumbSwiper">
								<ul class="swiper-wrapper">
									<?foreach ($thumb_images as $timg) {?>
									<li class="swiper-slide" style="cursor:pointer;"><img src="//pentakleva.shop/upload/<?=$timg?>" alt="items"></li>
									<?}?>
								</ul>
							</div>

<?
	// if ($_SESSION['member_id'] == ""){ $pricec_code = "";
	
	// $priced_code = "";
	// $coin = "";
	// }
?>
					</div>
					<div class="view_imformation">
					<form name=p_form method=post>
						<input type="hidden" name="shop_bonus" id="shop_bonus" value="<?=$json_balance['shop_bonus']?>">
						<input type="hidden" name="cprice1" id="cprice1" value="<?=$cprice1?>">
						<input type="hidden" name="cprice" value="<?=$cprice?>">
						<input type="hidden" name="cpoint1" value="<?=$cpoint1?>">
						<input type="hidden" name="cpoint" value="<?=$cpoint1?>">
						<input type="hidden" name="pricec_code" id="pricec_code" value="<?=$pricec_code?>">
						<table class="view_table">
							
							<!-- <tr>
								<td class="option_td">My shopping point.</td>
								<td class=""><?=number_format($json_balance['total_SP'])?>Point</font>&nbsp;&nbsp;&nbsp;</td>
							</tr> -->
							<tr>
								<td class="option_td">Price</td>
								
								<td class=""><span id="priceText"><?=htmlspecialchars($price_tmp_display, ENT_QUOTES, 'UTF-8')?></span></font>&nbsp;&nbsp;&nbsp;</td>
							</tr>
							<?if(floor($price_tmp*($c_pv/100))> 0){?>
							<tr>
								<td class="option_td">RV</td>
								
								<td class=""><span id="pvText">RV <?=(floor($price_tmp*($c_pv/100)))?></span></font>&nbsp;&nbsp;&nbsp;</td>
							</tr>
							<?}?>

							<!-- <tr>
								<td class="option_td">현금결재</td>
								<td class=""><?=number_format($priced_code)?></font>&nbsp;&nbsp;&nbsp;</td> -->
							<!-- </tr> -->

							

							<? if($point>0){?>
							<tr>
								<td class="option_td">Point</td>
								<td class=""><?=$cpoint1?></td>
							</tr>
							<?}else{?>
								<input type="hidden" name="cpoint" value="<?=$cpoint?>" onFocus="this.blur();" style="border:0;">
							<?}?>
							<tr class="option_tr03">
								<td class="option_td">Quantity</td>
								<td>
								<select id="qty" name="qty" onchange="go_price3()">
							<?for($i=1; $i<=20; $i++){?>
							<option value=<?=$i?>><?=$i?></option>
							<?}?>
								</select>
									<?=$price_total?>
								</td>
							</tr>

							<?

							

								if ($color !=  '')
								{
							?>
							<tr class="option_tr03">
								<td class="option_td">Color</td>
								<td>
							<select id="color" name="color">
							<option value=''>Choice</option>	
							<?for($i=0; $i<count($acolor); $i++){
								if ($acolor[$i] == "") continue;
								?>
							<option value="<?=htmlspecialchars($acolor[$i], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($acolor[$i], ENT_QUOTES, 'UTF-8')?></option>									
							<?}?>
								</select>
									Color
								</td>
							</tr>
							<?
								}	
							?>
							<?if(count($asize) >0){?>
							<tr class="option_tr03">
								<td class="option_td">Size</td>
								<td>
							<select id="size" name="size">
							<!-- <option value=''>Choice</option>	 -->
							
							<?
							$kkk=0;
							for($i=0; $i<=count($asize)-1; $i++){
								if($asize[$i]=="")continue;
								?>
							
							<option value="<?=htmlspecialchars($asize[$i], ENT_QUOTES, 'UTF-8')?>"><?=htmlspecialchars($asize[$i], ENT_QUOTES, 'UTF-8')?></option>									
							<?$kkk++;}?>
								<?if($kkk==0){?>
									<option value="기본">basics</option>
								<?}?>
								</select>
									Size
								</td>
							</tr>
							<?}?>
							<?	

								if ($option_n1 != '')
								{
									
							?>

							<tr class="option_tr03">
								<td class="option_td"><?=$option_t1?></td>
								<td>
							<select id="opt1" name="opt1" onchange="go_price3()" style="padding:3%;border: 1px solid #c0c0c0;">
							<!-- <option value=''>선택</option>	 -->
							<?for($i=0; $i<=count($aoption_n1)-1; $i++){?>
							
							<option value="<?=$aoption_n1[$i]?>"><?=$aoption_n1[$i]?> (<?=pkshop_format_display_price($aaoption_k1[$i])?>) </option>									
							<?}?>
								</select>
								</td>
							</tr>

							<?
								}	
							?>
								<?	

							if ($option_n2 != '')
							{
								
							?>

							<tr class="option_tr03">
							<td class="option_td"><?=$option_t2?></td>
							<td>
							<select id="opt2" name="opt2"  onchange="go_price3()"  style="padding:3%;border: 1px solid #c0c0c0;">
							<!-- <option value=''>선택</option>	 -->
							<?for($i=0; $i<=count($aoption_n2)-1; $i++){?>

							<option value=<?=$aoption_n2[$i]?>><?=$aoption_n2[$i]?>  (<?=pkshop_format_display_price($aaoption_k2[$i])?>) </option>									
							<?}?>
							</select>
							</td>
							</tr>

							<?
							}	
							?>
								<?	

							if ($option_n3 != '')
							{
								
							?>

							<tr class="option_tr03">
							<td class="option_td"><?=$option_t3?></td>
							<td>
							<select id="opt3" name="opt3"  onchange="go_price3()"  style="padding:3%;border: 1px solid #c0c0c0;">
							<!-- <option value=''>선택</option>	 -->
							<?for($i=0; $i<=count($aoption_n3)-1; $i++){?>

							<option value=<?=$aoption_n3[$i]?>><?=$aoption_n3[$i]?>  (<?=pkshop_format_display_price($aaoption_k3[$i])?>) </option>									
							<?}?>
							</select>
							</td>
							</tr>

							<?
							}	
							?>
								<?	

							if ($option_n4 != '')
							{
								
							?>

							<tr class="option_tr03">
							<td class="option_td"><?=$option_t4?></td>
							<td>
							<select id="opt4" name="opt4"  onchange="go_price3()"  style="padding:3%;border: 1px solid #c0c0c0;">
							<!-- <option value=''>선택</option>	 -->
							<?for($i=0; $i<=count($aoption_n4)-1; $i++){?>

							<option value=<?=$aoption_n4[$i]?>><?=$aoption_n4[$i]?>  (<?=pkshop_format_display_price($aaoption_k4[$i])?>) </option>									
							<?}?>
							</select>
							</td>
							</tr>

							<?
							}	
							?>
								<?	

							if ($option_n5 != '')
							{
								
							?>

							<tr class="option_tr03">
							<td class="option_td"><?=$option_t5?></td>
							<td>
							<select id="opt5" name="opt5"  onchange="go_price3()"  style="padding:3%;border: 1px solid #c0c0c0;">
							<!-- <option value=''>선택</option>	 -->
							<?for($i=0; $i<=count($aoption_n5)-1; $i++){?>

							<option value=<?=$aoption_n5[$i]?>><?=$aoption_n5[$i]?>  (<?=pkshop_format_display_price($aaoption_k5[$i])?>) </option>									
							<?}?>
							</select>
							</td>
							</tr>

							<?
							}	
							?>




						</table>
						<div class="sp50"></div>

						<div class="sp30"></div>
						<div class="view_btn_sub01">
							<input type="button" value="Buy" class="sub04_btn00 sub04_btn02" onclick="javascript:buy_go('<?=$code?>','<?=$title_cate1?>')">
							<input type="button" value="Cart" class="sub04_btn00 sub04_btn03" onclick="javascript:go_cart('<?=$code?>','<?=$title_cate1?>');">
						</div>

						</form>
				</div>
			</div>

				<div class="sp30"></div>

				<div class="view_section">


					<div class="view_line_btn">
						<div class="view_line"></div>
						<input type="button" value="Product details" class="sub04_btn" onclick=""></input>
						<input type="button" value="Delivery information" class="sub04_btn" onclick=""></input>
					</div>


					<div class="sp50"></div>
					<div class="view_pg" style="text-align:center;">
					<?=$detail?>
					<?if (trim(strip_tags($detail)) == '') {?>
						<img src="../sub04/images/content.jpg">
					<?}?>
					</div>


					<div class="view_line_btn">
						<input type="button" value="Product details." class="sub04_btn"  onclick="">
						<input type="button" value="Delivery information." class="sub04_btn"  onclick="">
						<div class="view_line"></div>
					</div>

				</div>
			</div>



           <!-- view 끝 -->
		</div>

		<div class="sp50"></div>


		<!--  footer      -->

		<? include "../include/bottom.php"; ?>

		<!--  footer    -->
	</div>
	<?php include dirname(__FILE__) . '/../include/pkshop_currency_script.php'; ?>
	<script>

function go_price3() {
	var extractTextPattern = /(<([^>]+)>)/gi;
	var c_pv = <?=$c_pv?>;
	if(isNaN(c_pv)){
		c_pv =0;
	}
	var qty = $("#qty").val();
	var o1 =0;
	frm = document.p_form;
	// console.log(frm);
		<?if($price_tmp_kk>0){?>
			frm.cprice.value = '<?=number_format($price_tmp_kk)?>'+'&nbsp;';
			frm.cprice1.value = <?=$price_tmp_kk?>;
		<?}?>

		<?if($point>0){?>
			<?if($point_dis=='wo' || $point_dis==""){?>
				frm.cpoint.value = '<?=number_format($point)?>'+'&nbsp;';
				frm.cpoint1.value = <?=$point?>;
			<?}else if($point_dis=='pe'){?>
				<?if($price_tmp_kk!="" && $price_tmp_kk!="0"){
					$pricep=floor($price_tmp_kk*$point/100);
				}?>

				frm.cpoint.value = '<?=number_format($pricep)?>'+'&nbsp;';
				frm.cpoint1.value = '<?=$pricep?>';
			<?}?>
		<?}?>

	<?if($option_t1!=""){?>
	<?php foreach ($aaoption_n1 as $key1 => $value1) { ?>
	  
	
	if (frm.opt1[<?=$key1?>].selected == true) {
		// var a = frm.opt1[<?=$key1?>];
		
		// console.log(a);
		// if(a == '<option value="">선택</option>'){
		// 	alert("1");
		// }
		<?if($price_tmp!=""){?>
			o1_1 = <?=$aoption_p1[$key1]?>;
			o1=o1_1;
		<?}?>
		
			// alert(<?=$aoption_p1[$key1]?>);
		<?if($point!=""){?>
			<?if($point_dis=='wo' || $point_dis==""){?>
				var o3_1  = '<?=$aoption_k1[$key1]?>';
				o3=o3_1;
			<?}else if($point_dis=='pe'){?>
				<?
					$pricep1=floor($aoption_p1[$key1]*$aoption_k1[$key1]/100);
					$aoption_k1[$key1]=$pricep1;
				?>

				o3_1  = <?=$aoption_k1[$key1]?>;
				o3=o3_1;
			<?}?>
		<?}?>
	}
	<?php } ?>
	<?php } ?>

	<?if($option_t2!=""){?>
	<?php foreach ($aaoption_n2 as $key1 => $value1) { ?>
	if (frm.opt2[<?=$key1?>].selected == true) {
		
		<?if($price_tmp!=""){?>
			o1_2 = o1_1+<?=$aoption_p2[$key1]?>;
			o1=o1_2;
		<?}?>

		<?if($point!=""){?>
			<?if($point_dis=='wo' || $point_dis==""){?>
				o3_2 =o3_1+<?=$aoption_k2[$key1]?>;
				o3=o3_2;
			<?}else if($point_dis=='pe'){?>

				<?
					$pricep2=floor($aoption_p2[$key1]*$aoption_k2[$key1]/100);
					$aoption_k2[$key1]=$pricep2;
				?>
				o3_2 =o3_1+<?=$aoption_k2[$key1]?>;
				o3=o3_2;
			<?}?>
		<?}?>
	}
	<?php } ?>
	<?php } ?>
	
	<?if($option_t3!=""){?>
	<?php foreach ($aaoption_n3 as $key1 => $value1) { ?>
	if (frm.opt3[<?=$key1?>].selected == true) {
		<?if($price_tmp!=""){?>
			o1_3 = o1_2+<?=$aoption_p3[$key1]?>;
			o1=o1_3;
		<?}?>

		<?if($point!=""){?>
			<?if($point_dis=='wo' || $point_dis==""){?>
				o3_3 =o3_2+<?=$aoption_k3[$key1]?>;
				o3=o3_3;
			<?}else if($point_dis=='pe'){?>

				<?
					$pricep3=floor($aoption_p3[$key1]*$aoption_k3[$key1]/100);
					$aoption_k3[$key1]=$pricep3;
				?>
				o3_3 =o3_2+<?=$aoption_k3[$key1]?>;
				o3=o3_3;
			<?}?>

		<?}?>
	}
	<?php } ?>
	<?php } ?>

	<?if($option_t4!=""){?>
	<?php foreach ($aaoption_n4 as $key1 => $value1) { ?>
	if (frm.opt4[<?=$key1?>].selected == true) {
		<?if($price_tmp!=""){?>
			o1_4 = o1_3+<?=$aoption_p4[$key1]?>;
			o1=o1_4;
		<?}?>

		<?if($point!=""){?>
			<?if($point_dis=='wo' || $point_dis==""){?>
				o3_4 = o3_3+<?=$aoption_k4[$key1]?>;
				o3=o3_4;
			<?}else if($point_dis=='pe'){?>

				<?
					$pricep4=floor($aoption_p4[$key1]*$aoption_k4[$key1]/100);
					$aoption_k4[$key1]=$pricep4;
				?>
				o3_4 = o3_3+<?=$aoption_k4[$key1]?>;
				o3=o3_4;
			<?}?>

		<?}?>
	}
	<?php } ?>
	<?php } ?>

	
frm.cprice.value =(parseFloat(<?=$price_tmp_kk?>)+o1)*qty+'&nbsp;';
frm.cprice1.value = (parseFloat(<?=$price_tmp_kk?>)+o1)*qty;
var lineUsd = (parseFloat(<?=$price_tmp_kk?>)+o1)*qty;
$("#priceText").text(typeof pkshopFormatUsdPrice === 'function' ? pkshopFormatUsdPrice(lineUsd) : ('$ ' + lineUsd));
$("#pvText").text("RV " + Math.floor(lineUsd * (c_pv / 100)));
}
go_price3();

var viewThumbSwiper = new Swiper(".viewThumbSwiper", {
        slidesPerView: 3,
        spaceBetween: 15,
        loop: true,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
		autoplay: {
          delay: 2500,
          disableOnInteraction: false,
        },
      });
	  $(document).ready(function () {
	$(".viewThumbSwiper .swiper-slide").on("click", function () {
            var src = $(this).children().attr("src");
            
            $("#pr_img").attr("src",src);
        });
});
	</script>
