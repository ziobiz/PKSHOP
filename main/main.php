<?
exit;
	include "../include/com.php";
?>
<link rel="shortcut icon" type="image/x-icon" href="images/pentakleva.ico">
<!doctype html>
<html lang="kr">
 <body>
 <div id="wrap">

	<!-- 상단(Top) -->
	<? include "main_top.php"; ?>
	<!-- 상단(Top) -->

	<div class="sp25"></div>
	<!-- 내용 -->
	<div class="content">

		<div>
		<div class="visual_slide">
			<div class="swiper-container">
				<div class="swiper-wrapper">
				  <div class="swiper-slide"><img src="../images/se1.jpg"></div>
				  <div class="swiper-slide"><img src="../images/se1.jpg"></div>
				  <div class="swiper-slide"><img src="../images/se1.jpg"></div>
				</div>
			</div>
		</div>
		<!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper('.swiper-container', {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>

		<div class="sp40"></div>

		<div class="product">
			<div class="product_titlebox">
				<p class="product_title">BEST PRODUCTS</p>
				<div class="conter_bar"></div>
			</div>

			<div	class="product_inner">
							<div>
<?
/*
// 정렬 방식
if($query_dis==""){
	if($type=='1'){
		$kk_query="ORDER BY order2";
	}else if($type=='2'){
		$kk_query="ORDER BY order3";
	}else if($type=='3'){
		$kk_query="ORDER BY order4";
	}else{
		$kk_query="ORDER BY order1,signdate desc";
	}
}else{
	if($query_dis=="k_new"){
		$kk_query="ORDER BY signdate desc";
	}else if($query_dis=="k_price1"){
		$kk_query="ORDER BY pricec ";
	}else if($query_dis=="k_price2"){
		$kk_query="ORDER BY pricec desc";
	}else if($query_dis=="k_ga1"){
		$kk_query="ORDER BY title";
	}else if($query_dis=="k_ga2"){
		$kk_query="ORDER BY title desc";
	}else{
		$kk_query="ORDER BY signdate desc";
	}
}

if($theme_str!=""){
	if($theme_str == "n") $theme_tmp = "where theme_n='n'";
	if($theme_str == "r") $theme_tmp = "where theme_r='r'";
	if($theme_str == "f") $theme_tmp = "where theme_f='f'";
	if($theme_str == "x") $theme_tmp = "where theme_x='x'";
	if($theme_str == "y") $theme_tmp = "where theme_y='y'";
	if($theme_str == "z") $theme_tmp = "where theme_z='z'";
	if($theme_str == "s") $theme_tmp = "where theme_s='s'";

    $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4 ,opt_num,imgb1,imgb2 FROM $shop_goods $theme_tmp $kk_query";
	

	
}else{


#####################################################################

  $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4 ,opt_num,imgb1,imgb2 FROM $shop_goods where theme_r = 'r' and soldout='N' $kk_query";

 }
 */


 $data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&Type=best";
										
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $api_history);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec ($ch);
		curl_close ($ch);
		
		
		
		$json_o = json_decode($result,true);

		$count = count($json_o);

		$total_record = $count;

		

$num_per_page = 40;
$page_per_block = 12;
if ($page=="") $page=1;
if ($keyfield=="") $key="";
if(!$total_record) {
	$first = 1;
	$last = 0;
} else {
	$first = $num_per_page*($page-1);
	$last = $num_per_page*$page;
	$IsNext = $total_record - $last;
	if($IsNext > 0) {
		$last -= 1;
	} else {
		$last = $total_record - 1;
	}
}
$total_page = ceil($total_record/$num_per_page);
 if($total_record == 0) {
?>
<?
 } else {
 ?>

<?
$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
    $code2 = $json_o[$i]['code2'];
  	$code3 = $json_o[$i]['code3'];
	$code = $json_o[$i]['code'];
	$title = $json_o[$i]['title'];
	$pricec = $json_o[$i]['pricec'];
	$prices = $json_o[$i]['prices'];
	$priced = $json_o[$i]['priced'];
	$company = $json_o[$i]['company'];
	$new = $json_o[$i]['new'];
	$soldout = $json_o[$i]['soldout'];
	$best = $json_o[$i]['best'];
	$cut = $json_o[$i]['cut'];
	$recommend = $json_o[$i]['recommend'];
	$price_dis = $json_o[$i]['price_dis'];
	$size = $json_o[$i]['size'];	/*사이즈*/
	$color = $json_o[$i]['color'];	/*색상*/
	$imgl = $json_o[$i]['imgl'];	/*색상*/
	$code4 = $json_o[$i]['code4'];	/*색상*/
	$opt_num = $json_o[$i]['opt_num'];	/*색상*/
	$imgb1 = $json_o[$i]['imgb1'];
	$imgb2 = $json_o[$i]['imgb2'];
	
	

	$asize = explode(",",$size);				/*사이즈 분리*/			 
	$acolor = explode(",",$color);					/*색상 분리*/
	

	//echo $pricec."222"; 


	if($size!=""){
		 $size=$asize[0];
	}
	if($color!=""){
		$color=$acolor[0];
	}

		$pricec_code = $pricec;
		$prices_code = $prices;
		$priced_code = $priced;
		
	
		
	if($priced=="0"){
	//	$price_s = "<font class='sbest_text02'>".number_format($pricec)."</font> ";	//가격표시변환
	}else{
	//	$price_s = "<font class='sbest_text02'>".number_format($priced)."</font> "."<font style='text-decoration: line-through;'>(".number_format($pricec).")</font>"."";
	}
$price_s = "<font style=''>(".number_format($pricec).")</font>"."";


	if ($_SESSION['valid_user'] == "") $price_s = "";
	### 이미지 파일 저장 디렉토리 ###
	$savedir = "../shop_img/";

	$img_name = $savedir.$imgb1;


	$img_info = getImageSize($savedir.'/'.$imgb1);//원본이미지의 정보를 얻어옵니다
	$img_width = $img_info[0];
	$img_height = $img_info[1];

	if($img_width > $img_height){
		$img_size = "width='242'";
	}else{
		$img_size = "height='200'";
	}



$price_code = $prices;
	$prices_code = $prices1;
	$priced_code = $priced;

if($opt_num!=""){
	$opt_num_arr = explode(",",$opt_num);
	$kk_amount = $opt_num_arr[0];
}else{
	$kk_amount = '1';
}
	if ($i>$first && ($i%4) == 0) {
#####################################################################
?>


<?
	}
?>


					<div class="best_box01">
						<div class="best_img">
							<a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&theme=f&type=<?=$type?>"><?if($imgl!=""){?><img src="<?=$imgl?>" border="0" align="absmiddle" ><?}else{?><img src="<?=$savedir?><?=$imgb1?>"  border="0" align="absmiddle" ><?}?>
						</div>
						<p class="best_text" style="padding-bottom:5px;"><a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&theme=f&type=<?=$type?>" class="a_3"><?=$title?></a></p>
						<p class="best_price"><a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&type=<?=$type?>" class="c_red"><?=$price_s?></a></p>
					</div>


						<?if(($i+1)%4!=0){?><?}?>



 <?
if($i==$last){
	if(($last+1)%4=="1"){
		echo "";
	}else if(($last+1)%4=="2"){
		echo "";
	}else if(($last+1)%4=="3"){
		echo "";
	}
		echo "";
	}
}
?>
<?
  $article_num--;
  }
 ?>
			</div>

			</div>
		</div>


	</div>

		<div class="new">
			<div class="sp40"></div>
			<p class="new_title">NEW ARRIVAL PRODUCTS</p>
			<div class="conter_bar"></div>
			<div class="new_inner">
<!-- 				<a class="new_arrow01" href="#"><img src="../main/images/arrow_left.png"></a> -->
				<div class="new_box">
	<?

/*
// 정렬 방식
if($query_dis==""){
	if($type=='1'){
		$kk_query="ORDER BY order2";
	}else if($type=='2'){
		$kk_query="ORDER BY order3";
	}else if($type=='3'){
		$kk_query="ORDER BY order4";
	}else{
		$kk_query="ORDER BY order1,signdate desc";
	}
}else{
	if($query_dis=="k_new"){
		$kk_query="ORDER BY signdate desc";
	}else if($query_dis=="k_price1"){
		$kk_query="ORDER BY pricec ";
	}else if($query_dis=="k_price2"){
		$kk_query="ORDER BY pricec desc";
	}else if($query_dis=="k_ga1"){
		$kk_query="ORDER BY title";
	}else if($query_dis=="k_ga2"){
		$kk_query="ORDER BY title desc";
	}else{
		$kk_query="ORDER BY signdate desc";
	}
}

if($theme_str!=""){
	if($theme_str == "n") $theme_tmp = "where theme_n='n'";
	if($theme_str == "r") $theme_tmp = "where theme_r='r'";
	if($theme_str == "f") $theme_tmp = "where theme_f='f'";
	if($theme_str == "x") $theme_tmp = "where theme_x='x'";
	if($theme_str == "y") $theme_tmp = "where theme_y='y'";
	if($theme_str == "z") $theme_tmp = "where theme_z='z'";
	if($theme_str == "s") $theme_tmp = "where theme_s='s'";

    $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4 ,opt_num,imgb1,imgb2 FROM $shop_goods $theme_tmp $kk_query";

}else{


#####################################################################

  $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4 ,opt_num,imgb1,imgb2 FROM $shop_goods where theme_r = 'r' and soldout='N' ORDER BY signdate desc limit 4 ";

 }

 echo $query;

*/


$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&Type=new";
										
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

		$total_record = $count;


$num_per_page = 40;
$page_per_block = 12;
if ($page=="") $page=1;
if ($keyfield=="") $key="";
if(!$total_record) {
	$first = 1;
	$last = 0;
} else {
	$first = $num_per_page*($page-1);
	$last = $num_per_page*$page;
	$IsNext = $total_record - $last;
	if($IsNext > 0) {
		$last -= 1;
	} else {
		$last = $total_record - 1;
	}
}
$total_page = ceil($total_record/$num_per_page);
 if($total_record == 0) {
?>
<?
 } else {
 ?>

<?
$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
	

   $code2 = $json_o[$i]['code2'];
  	$code3 = $json_o[$i]['code3'];
	$code = $json_o[$i]['code'];
	$title = $json_o[$i]['title'];
	$pricec = $json_o[$i]['pricec'];
	$prices = $json_o[$i]['prices'];
	$priced = $json_o[$i]['priced'];
	$company = $json_o[$i]['company'];
	$new = $json_o[$i]['new'];
	$soldout = $json_o[$i]['soldout'];
	$best = $json_o[$i]['best'];
	$cut = $json_o[$i]['cut'];
	$recommend = $json_o[$i]['recommend'];
	$price_dis = $json_o[$i]['price_dis'];
	$size = $json_o[$i]['size'];	/*사이즈*/
	$color = $json_o[$i]['color'];	/*색상*/
	$imgl = $json_o[$i]['imgl'];	/*색상*/
	$code4 = $json_o[$i]['code4'];	/*색상*/
	$opt_num = $json_o[$i]['opt_num'];	/*색상*/
	$imgb1 = $json_o[$i]['imgb1'];
	$imgb2 = $json_o[$i]['imgb2'];

	$asize = explode(",",$size);				/*사이즈 분리*/			 
	$acolor = explode(",",$color);					/*색상 분리*/

	if($size!=""){
		 $size=$asize[0];
	}
	if($color!=""){
		$color=$acolor[0];
	}

		$pricec_code = $pricec;
		$prices_code = $prices;
		$priced_code = $priced;

	if($priced=="0"){
//		$price_s = "<font class='sbest_text02'>".number_format($pricec)."원</font> ";	//가격표시변환
	}else{
if($priced=="0"){
//		$price_s = "<font class='sbest_text02'>".number_format($pricec)."</font>";	//가격표시변환
	}else{
//		$price_s = "<font class='sbest_text02'>".number_format($priced)."</font> "."<font style='text-decoration: line-through;'>(".number_format($pricec).")</font>"."";
	}
}
$price_s = "<font class='sbest_text02'>".number_format($pricec)."원</font> ";
	### 이미지 파일 저장 디렉토리 ###
	$savedir = "../shop_img/";

	$img_name = $savedir.$imgb1;
	if ($_SESSION['valid_user'] == "") $price_s = "";

	$img_info = getImageSize($savedir.'/'.$imgb1);//원본이미지의 정보를 얻어옵니다
	$img_width = $img_info[0];
	$img_height = $img_info[1];

	if($img_width > $img_height){
		$img_size = "width='242'";
	}else{
		$img_size = "height='200'";
	}



$price_code = $prices;
	$prices_code = $prices1;
	$priced_code = $priced;

if($opt_num!=""){
	$opt_num_arr = explode(",",$opt_num);
	$kk_amount = $opt_num_arr[0];
}else{
	$kk_amount = '1';
}


	if ($i>$first && ($i%4) == 0) {
#####################################################################
?>


<?
	}
?>
		<div class="new_product01">
						<div class="sp15"></div>
						<div class="new_img">
							<a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&theme=f&type=<?=$type?>"><?if($imgl!=""){?><img src="<?=$imgl?>" border="0" align="absmiddle" width="200" height="174"><?}else{?><img src="<?=$savedir?><?=$imgb1?>" width="200" height="174" border="0" align="absmiddle" style="border:1px solid #dedede;"><?}?>
						</div>
						<div class="new_textbar"></div>
						<p class="new_text01">PRODUCT</p>
						<div class="sp15"></div>
						<p class="new_text02"><a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&theme=f&type=<?=$type?>" class="a_3"><?=$title?></a></p>
						<div class="sp20"></div>
						<a class="new_btn"href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&type=<?=$type?>" class="c_red">go</a>
						<div class="sp25"></div>
					</div>




						<?if(($i+1)%4!=0){?><?}?>



 <?
if($i==$last){
	if(($last+1)%4=="1"){
		echo "";
	}else if(($last+1)%4=="2"){
		echo "";
	}else if(($last+1)%4=="3"){
		echo "";
	}
		echo "";
	}
}
?>
<?
  $article_num--;
  }
 ?>

				</div>
<!-- 				<a class="new_arrow02" href="#"><img src="../main/images/arrow_right.png"></a> -->
			</div>
		</div>

	<div class="content">
		<div class="sp40"></div>

		<div	class="product">
			<div class="product_titlebox">
				<p class="product_title">All PRODUCTS</p>
				<div class="conter_bar"></div>
<!-- 				<div class="product_btn_box"> -->
<!-- 					<a class="product_btn" href="#">◀</a> -->
<!-- 					<a class="product_btn" href="#">▶</a> -->
<!-- 				</div> -->
				<div class="all_btn">
	<?
		//1차분류

	$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&Type=all1";
										
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $api_history);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec ($ch);
	curl_close ($ch);
	
	$json_o = json_decode($result,true);
	
	

	$count = count($json_o);
	$total_record_tt = $count;
	
	for ($i = 0;$i<$total_record_tt ; $i++)
	{	

		$menu_code1 = $json_o[$i]['code'];
		$menu_title1 = $json_o[$i]['cate'];
		$menu_code123=$menu_code1;
		
		$menu_code123;
		$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&Type=all2&code1=".$menu_code123;


		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $api_history);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec ($ch);
		curl_close ($ch);

		


		if ($result != '')
		{
		$json_o = json_decode($result,true);
		
		$count = count($json_o);

		for ($j = 0;$j<$count ; $j++)
		{		
			
			?>


				<a href="../sub04/list.php?left_code=<?=$json_o[$j]['code2']?>&type=1"><?=$json_o[$j]['cate2']?></a>


					

		<?
			}
		}
	}
	?>

				</div>
			</div>

			<div	class="product_inner">
				<div>
<?

/*
// 정렬 방식
if($query_dis==""){
	if($type=='1'){
		$kk_query="ORDER BY order2";
	}else if($type=='2'){
		$kk_query="ORDER BY order3";
	}else if($type=='3'){
		$kk_query="ORDER BY order4";
	}else{
		$kk_query="ORDER BY order1,signdate desc";
	}
}else{
	if($query_dis=="k_new"){
		$kk_query="ORDER BY signdate desc";
	}else if($query_dis=="k_price1"){
		$kk_query="ORDER BY pricec ";
	}else if($query_dis=="k_price2"){
		$kk_query="ORDER BY pricec desc";
	}else if($query_dis=="k_ga1"){
		$kk_query="ORDER BY title";
	}else if($query_dis=="k_ga2"){
		$kk_query="ORDER BY title desc";
	}else{
		$kk_query="ORDER BY signdate desc";
	}
}

if($theme_str!=""){
	if($theme_str == "n") $theme_tmp = "where theme_n='n'";
	if($theme_str == "r") $theme_tmp = "where theme_r='r'";
	if($theme_str == "f") $theme_tmp = "where theme_f='f'";
	if($theme_str == "x") $theme_tmp = "where theme_x='x'";
	if($theme_str == "y") $theme_tmp = "where theme_y='y'";
	if($theme_str == "z") $theme_tmp = "where theme_z='z'";
	if($theme_str == "s") $theme_tmp = "where theme_s='s'";

    $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4 ,opt_num,imgb1,imgb2 FROM $shop_goods $theme_tmp $kk_query";

}else{


#####################################################################

  $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4 ,opt_num,imgb1,imgb2 FROM $shop_goods where soldout='N' $kk_query";

 }
 */

	$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&Type=all3";
										
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

	
$total_record = $count;

$num_per_page = 40;
$page_per_block = 12;
if ($page=="") $page=1;
if ($keyfield=="") $key="";
if(!$total_record) {
	$first = 1;
	$last = 0;
} else {
	$first = $num_per_page*($page-1);
	$last = $num_per_page*$page;
	$IsNext = $total_record - $last;
	if($IsNext > 0) {
		$last -= 1;
	} else {
		$last = $total_record - 1;
	}
}
$total_page = ceil($total_record/$num_per_page);
 if($total_record == 0) {
?>
<?
 } else {
 ?>

<?
$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $code2	 = $json_o[$i]['code2'];
  	$code3	 = $json_o[$i]['code3'];
	$code	 = $json_o[$i]['code'];
	$title	 = $json_o[$i]['title'];
	$pricec  = $json_o[$i]['pricec'];
	$prices  = $json_o[$i]['prices'];
	$priced  = $json_o[$i]['priced'];
	$company = $json_o[$i]['company'];
	$new	 = $json_o[$i]['new'];
	$soldout = $json_o[$i]['soldout'];
	$best	 = $json_o[$i]['best'];
	$cut	 = $json_o[$i]['cut'];
	$recommend  = $json_o[$i]['recommend'];
	$price_dis  = $json_o[$i]['price_dis'];
	$size		= $json_o[$i]['size'];		/*사이즈*/
	$color		= $json_o[$i]['color']; 	/*색상*/
	$imgl		= $json_o[$i]['imgl'];	/*색상*/
	$code4		= $json_o[$i]['code4'];	/*색상*/
	$opt_num	= $json_o[$i]['opt_num'];	/*색상*/
	$imgb1		= $json_o[$i]['imgb1'];
	$imgb2		= $json_o[$i]['imgb2'];

	$asize = explode(",",$size);				/*사이즈 분리*/			
	$acolor = explode(",",$color);					/*색상 분리*/

	if($size!=""){
		 $size=$asize[0];
	}
	if($color!=""){
		$color=$acolor[0];
	}

		$pricec_code = $pricec;
		$prices_code = $prices;
		$priced_code = $priced;

	if($priced=="0"){
		$price_s = "<font class='sbest_text02'>".number_format($pricec)."</font> ";	//가격표시변환
	}else{
if($priced=="0"){
		$price_s = "<font class='sbest_text02'>".number_format($pricec)."</font> ";	//가격표시변환
	}else{
		$price_s = "<font class='sbest_text02'>".number_format($priced)."</font> "."<font style='text-decoration: line-through;'>(".number_format($pricec).")</font>"."";
	}
	}
$price_s = "<font class='sbest_text02'>".number_format($pricec)."</font> ";	//가격표시변환
	### 이미지 파일 저장 디렉토리 ###
	$savedir = "../shop_img/";

	$img_name = $savedir.$imgb1;

	if ($_SESSION['valid_user'] == "") $price_s = "";
	$img_info = getImageSize($savedir.'/'.$imgb1);//원본이미지의 정보를 얻어옵니다
	$img_width = $img_info[0];
	$img_height = $img_info[1];

	if($img_width > $img_height){
		$img_size = "width='200'";
	}else{
		$img_size = "height='174'";
	}



$price_code = $prices;
	$prices_code = $prices1;
	$priced_code = $priced;

if($opt_num!=""){
	$opt_num_arr = explode(",",$opt_num);
	$kk_amount = $opt_num_arr[0];
}else{
	$kk_amount = '1';
}


	if ($i>$first && ($i%4) == 0) {
#####################################################################
?>


<?
	}
?>
				<div	class="all_box01">
						<div class="all_img">
							<a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&theme=f&type=<?=$type?>"><?if($imgl!=""){?><img src="<?=$imgl?>" border="0" align="absmiddle" width="200" height="174"><?}else{?><img src="<?=$savedir?><?=$imgb1?>" width="200" height="174" border="0" align="absmiddle"><?}?>
						</div>
						<p class="all_text" style="padding-bottom:5px;"><a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&theme=f&type=<?=$type?>" class="a_3"><?=$title?></a></p>
						<p class="all_price"><a href="./view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&type=<?=$type?>" class="c_red"><?=$price_s?></a></p>
					</div>



						<?if(($i+1)%4!=0){?><?}?>



 <?
if($i==$last){
	if(($last+1)%4=="1"){
		echo "";
	}else if(($last+1)%4=="2"){
		echo "";
	}else if(($last+1)%4=="3"){
		echo "";
	}
		echo "";
	}
}
?>
<?
  $article_num--;
  }
 ?>

				<div class="sp40"></div>


			</div>
</div>
		</div>

	</div>
	<!-- 내용 -->

	<div class="sp50"></div>

 </div>
 	<!-- 하단(footer) -->
	<? include "../include/bottom.php"; ?>
	<!-- 하단(footer) -->
 </body>
</html>
