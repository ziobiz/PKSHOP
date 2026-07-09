<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );
$theme_str = $_GET["theme_str"];
$query_dis = $_GET["query_dis"];
$word = $_REQUEST["word"];
$type = $_REQUEST["type"];

?>
<!doctype html>
<html lang="en">
 <head>
 <?
	include "../include/get_balance.php";
/*
$query = "SELECT coin_price FROM $coin_goods order by no desc";
$result = mysql_query($query,$DBconn);
$value = mysql_fetch_row($result);
$exchange = $value[0];
*/

$left_code = $_GET['left_code'] ;
 if($left_code != "") {
	$code1 = substr($left_code, 0, 2);
	$code2 = substr($left_code, 2, 2);
	$code3 = substr($left_code, 4, 2);
	$code4 = substr($left_code, 6, 2);
	$left_code_tmp = $left_code;
}else{
	$code1 = $code1;
	$code2 = $code2;
	$code3 = $code3;
	$code4 = $code4;
}

$code1_cate_tmp = $code1;
$code2_cate_tmp = $code2;
$code3_cate_tmp = $code3;
$code4_cate_tmp = $code4;


if($theme_str==""){//정렬순서 관련



	if($code1!=""){
		$curl_d = json_decode(curl_d($api_category,"&Type=cate1&code1=$code1"),true);
		
		
	
		$tmp_cate1		= $curl_d[0]['cate'];
		$title_cate_1	= $tmp_cate1;	//대분류 이름기억
		$title_code_1	= $code1;
		
	}
	if($code2!=""){
		$curl_d = json_decode(curl_d($api_category,"&Type=cate2&code1=$code1&code2=$code2"),true);
		
		if(count($curl_d)>0){
			$tmp_cate2 = $curl_d[0]['cate'] ;
			$title_cate_2 = $tmp_cate2;	//중분류 이름기억
			$title_code_2 = $code2;
		}
		
		}
	
		if($code3!=""){
			$curl_d = json_decode(curl_d($api_category,"&Type=cate3&code1=$code1&code2=$code2&code3=$code3"),true);
			if(count($curl_d)>0){
				$tmp_cate3 = $curl_d[0]['cate'] ;
				$title_cate_3 = $tmp_cate3;	//중분류 이름기억
				$title_code_3 = $code3;
			}
		}
	
		if($code4!=""){
			$curl_d = json_decode(curl_d($api_category,"&Type=cate4&code1=$code1&code2=$code2&code3=$code3&code4=$code4"),true);
			if(count($curl_d)>0){
				$tmp_cate4 = $curl_d[0]['cate'];
				$title_cate_4 = $tmp_cate4;	//중분류 이름기억
				$title_code_4 = $code4;
			}
		}

}
if($theme_str == "r"){
	$Title="BEST";
}else if($theme_str == "n"){
	$Title="Recommended";
}else if($theme_str == "f"){
	$Title="HOT Deal";
}else{
	$Title="PRODUCTS";
}
#####################################################################
?>
 </head>
 <body>
	<div class="wrap">

		<!-- 상단 (top) -->

		<? include "../include/top.php"; ?>

		<!-- 상단 (top) 끝 -->

		<div class="sp50"></div>
		<div class="sub04_container">
			<!-- 카테고리 -->

			<? include "../include/category_pur.php"; ?>

			<!-- 카테고리 끝 -->

<script>
function urlgogo(){
value = document.getElementById("cars").value;
location.href=value;
}
</script>

			<!-- list -->

			<div class="sub_content">
				<div class="list_visual">
					<div class="bar"></div>
					<p class="list_visual_text"><?=$Title?></p>
				</div>

				<div class="sp15"></div>
				<div class="option_form">
				<form name="form" method="post">
					<select name="cars" onchange="urlgogo();" id="cars" class="selectbox">
						<option value="./list.php?left_code=<?=$left_code?>&query_dis=k_new&theme_str=<?=$theme_str?>&type=<?=$type?>&word=<?=$word?>" <?if($query_dis=="k_new"){?>selected<?}?>>Latest</option>
						<option value="./list.php?left_code=<?=$left_code?>&query_dis=k_price&theme_str=<?=$theme_str?>&type=<?=$type?>&word=<?=$word?>" <?if($query_dis=="k_price"){?>selected<?}?>>Low price</option>
						<option value="./list.php?left_code=<?=$left_code?>&query_dis=k_price2&theme_str=<?=$theme_str?>&type=<?=$type?>&word=<?=$word?>" <?if($query_dis=="k_price2"){?>selected<?}?>>High Price</option>
					</select>
					</form>
				</div>

				<div class="sp15"></div>
				<div class="products">
					<div class="product_content">
				<?

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

  if($type=="1") { //소분류 카테고리를 클릭했을때 소분류 상품만 보여주기 쿼리
    $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4,opt_num,imgb1,imgb2 FROM $shop_goods where code1 = '$code1' and code2 = '$code2' and soldout='N' $kk_query";
  } elseif($type=="5") {
    $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4,opt_num,imgb1,imgb2 FROM $shop_goods where company like '%$com_dis%' and soldout='N' $kk_query";
  } elseif($type=="2") {
    $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4,opt_num,imgb1,imgb2 FROM $shop_goods where code1 = '$code1' and code2 = '$code2_cate_tmp' and code3 = '$code3_cate_tmp' and soldout='N' $kk_query";
	//echo $query;
  } elseif($type=="3") {
    $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4,opt_num,imgb1,imgb2 FROM $shop_goods where code1 = '$code1' and code2 = '$code2_cate_tmp' and code3 = '$code3_cate_tmp' and code4 = '$code4_cate_tmp' and soldout='N' $kk_query";
  }else if($type=="4"){
  $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4 ,opt_num,imgb1,imgb2 FROM $shop_goods where title like '%$word%' and soldout='N' $kk_query";
  }else {
//    $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4,opt_num,imgb1,imgb2 FROM $shop_goods where code1 = '$code1' and soldout='N' $kk_query";

	//$query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4,opt_num,imgb1,imgb2 FROM $shop_goods where code1 = '$code1' and soldout='N' $kk_query";
  }

 }

 $data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&userid=".$_SESSION['member_id']."&Type=cate3&cate1=".$code1."&cate2=".$code2."&cate3=".$code3."&cate4=".$code4."&theme_str=$theme_str&query_dis=$query_dis&word=$word";
	
	
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
   $code2	= $json_o[$i]['code2'];
  	$code3	= $json_o[$i]['code3'];
	$code	= $json_o[$i]['code'];
	$title	= $json_o[$i]['title'];
	$pricec = $json_o[$i]['pricec'];
	$prices = $json_o[$i]['prices'];
	$priced = $json_o[$i]['priced'];
	$company = $json_o[$i]['company'];
	$new	= $json_o[$i]['new'];
	$soldout = $json_o[$i]['soldout'];
	$best	= $json_o[$i]['best'];
	$cut	= $json_o[$i]['cut'];
	$recommend = $json_o[$i]['recommend'];
	$price_dis = $json_o[$i]['price_dis'];
	$size	= $json_o[$i]['size'];	/*사이즈*/
	$color	= $json_o[$i]['color'];	/*색상*/
	$imgl	= $json_o[$i]['imgl'];	/*색상*/
	$code4  = $json_o[$i]['code4'];	/*색상*/
	$opt_num = $json_o[$i]['opt_num'];	/*색상*/
	$imgb1 = $json_o[$i]['imgb1'];
	$imgb2 = $json_o[$i]['imgb2'];
	$country = $json_o[$i]['country'];
	$onlypoint = $json_o[$i]['onlypoint'];
	if ($onlypoint == 1) {
		$onlyP = $onlyP + 1;
		$title=$title."<span style='color:#ff0000;'> [InT Only]</span>";
	}
	if($shop_country != $country){
		continue;
	}
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

		$price_s = "&nbsp;&nbsp;"."<font class='sbest_text02'>$ ".number_format($priced)." </font> <font style='text-decoration: line-through; font-size:13px; letter-spacing:-1px;'>($ ".number_format($pricec).") </font>";
	}
$price_s = "<font class='sbest_text02'>".number_format($pricec)."</font> ";	//가격표시변환
	### 이미지 파일 저장 디렉토리 ###
	$savedir = "//pentakleva.shop/upload/";

	$img_name = $savedir.$imgl;
	
	if ($_SESSION['valid_user'] == "") $price_s = "";

	$img_info = getImageSize($savedir.'/'.$imgl);//본이미지의 정보를 얻어옵니다
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
if ($cook_dis == "1" && $cook_dis1 == "승인") {
	$price_tmp = $priced;
} else	if ($cook_dis == "2" && $cook_dis1 == "승인") {
	$price_tmp = $pricec;
} else if ($cook_dis == "3" && $cook_dis1 == "승인") {
	$price_tmp = $prices;
} else {
	if ($priced > 0) {
		$price_tmp = $priced;
	} else {
		$price_tmp = $pricec;
	}
}

	if ($i>$first && ($i%4) == 0) {
#####################################################################
?>


<?
	}
?>
					<!-- 상품 -->
					<div class="product_box">
						<div class="item01">
							<a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&theme=f&type=<?=$type?>"><?if($imgl!=""){?><img src="<?=$img_name?>" ><?}else{?>&nbsp;<?}?></a>
						</div>
							<div class="sp20"></div>
							<p class="product_title"><a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&theme=f&type=<?=$type?>"><?=$title?></a></p>
							<?if($_SESSION["member_id"] != ""){?>
							<p class="best_price" style="font-weight:bold;font-size:16px;color:#c3070b">$ <?=$price_tmp?></p>
							<?}?>
					</div>


				<!-- 상품종료 -->


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
			<!-- 추천상품 종료 -->



					<div class="sp50"></div>
				<div class="sp20"></div>
				<div class="page_nav">
				<?
	$total_block = ceil($total_page/$page_per_block);
	$block = ceil($page/$page_per_block);
	$first_page = ($block-1)*$page_per_block;
	$last_page = $block*$page_per_block;
	if($total_block <= $block) {
	$last_page = $total_page;
	}

	//echo $total_block."";
	if($block > 1) {
		$my_page = $first_page;
		echo "<a href=\"$PHP_SELF?page=$my_page&code1=$code1&code2=$code2&code3=$code3&title_cate1=$title_cate1&title_cate2=$title_cate2&type=$type&kk_order=$kk_order&p_num=$p_num\" onMouseOver=\"status='';return true;\" onMouseOut=\"status=''\" class='board01_'>[이전]</a>&nbsp;";
	}

	for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
		if($page == $direct_page) {
			echo "<b>[$direct_page]</b>&nbsp;";
		} else {
			echo "<a href=\"$PHP_SELF?left_code=$left_code&page=$direct_page&code1=$code1&code2=$code2&code3=$code3&title_cate1=$title_cate1&title_cate2=$title_cate2&type=$type&kk_order=$kk_order&p_num=$p_num\" onMouseOver=\"status='';return true;\" onMouseOut=\"status=''\" style=\"text-decoration:none;\" class='style5'>[$direct_page]&nbsp;</a>";
		}
	}

	if($block < $total_block) {
		$my_page = $last_page+1;
		echo "&nbsp;<a href=\"$PHP_SELF?page=$my_page&code1=$code1&code2=$code2&code3=$code3&title_cate1=$title_cate1&title_cate2=$title_cate2&type=$type&kk_order=$kk_order&p_num=$p_num\" onMouseOver=\"status='';return true;\" onMouseOut=\"status=''\"  class='board01_'>[다음]</a>";
	}
	?>
	</div>
				</div>
			</div>
		</div>
	</div>

		<div class="sp50"></div>


		<!--  footer 시작 -->

		<? include "../include/bottom.php"; ?>

		<!--  footer 끝 -->

	</div>

</body>
</html>
