<?include "../include/top_session.php";?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <title>Kona Summit Platform</title>
  <link rel="stylesheet" href="../include/reset.css">
  <link rel="stylesheet" href="../include/style.css">
  <?include "../../Adm/common/dbconn.php";?>


<SCRIPT LANGUAGE="JavaScript">
<!--
function go_save(code,amount,size,color) {
	url="./cart_do.php?code="+code+"&amount="+amount+"&size="+size+"&color="+color;
	window.open(url,"","width=50,height=50");
}
//-->
</SCRIPT>

<SCRIPT LANGUAGE="JavaScript">
<!--
function go_buy(code,amount,size,color) {
	location="./order.php?code="+code+"&amount="+amount+"&size="+size+"&color="+color;
	
}
//-->
</SCRIPT>
</head>

<body>
	<div class="wrap">

		<!-- 상단 (top) -->

		<? include "../include/top.php"; ?>

				
	<!-- 상단(Top) -->

	<div class="page_navi">
		<div class="pn_inner">
			<img src="../images/navi_icon.png">&nbsp;&nbsp;Home&nbsp;&nbsp;>&nbsp;&nbsp;
			상품검색
		</div>
	</div>

	<hr class="hr_gray"/>

	<div class="sp20"></div>



	<!-- 컨텐츠 시작 -->
	<div id="content">

		<!-- 컨텐츠 왼쪽 -->
		<div class="content_left">

			<div class="sub_menu">
				<div class="sub_menu_title">
					상품검색
				</div>
				<div class="sub_menu_cate">
					상품검색
				</div>
				<div class="sub_menu_text">
					
					
					<ul>
						
						<li class="li_line"></li>
								
					</ul>
				</div>
			</div>		
			<div class="main_cs">
				<div class="main_cs_title">
					CS CENTER
				</div>
				<div class="sp10"></div>
				<div class="main_cs_tel">
					02)875-0345
				</div>
				<div class="sp5"></div>
				<div class="main_cs_text">
					평일 오전 10시-오후 6시<br/>
					토요일, 일요일, 공휴일 휴무
				</div>
			</div>
			<div class="main_cs">
							<div class="main_cs_title">
					BANK INFO
				</div>
				<div class="sp10"></div>
				<div class="main_cs_bank">
					293-144193-01-019
				</div>
				<div class="sp10"></div>
				<div class="main_cs_text">
					기업은행<br/>
					예금주 : (주)코알플러스
				</div>
			</div>
		
		</div>
		<!-- 컨텐츠 왼쪽 종료 -->


		<!-- 컨텐츠 오른쪽 -->
		<div class="content_right">

			<!-- 왼쪽패딩 -->
			<div class="left_padding">				

				

				 <div class="range">
					<a href="./search.php?word=<?=$word?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$tmp_code3?>&type=<?=$type?>&title_cate3=<?=$cate3?>&p_num=<?=$p_num?>&query_dis=k_new" class="a_5">신상품순</a> | <a href="./search.php?word=<?=$word?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$tmp_code3?>&type=<?=$type?>&title_cate3=<?=$cate3?>&p_num=<?=$p_num?>&query_dis=k_price1" class="a_5">낮은가격순</a> | <a href="./search.php?word=<?=$word?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$tmp_code3?>&type=<?=$type?>&title_cate3=<?=$cate3?>&p_num=<?=$p_num?>&query_dis=k_price2" class="a_5">높은가격순</a>
				</div> 

				<div class="sp20"></div>

				<div class="product_list">
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

  $query = "SELECT code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4 ,opt_num,imgb1,imgb2 FROM $shop_goods where title like '%$word%' and soldout='N' $kk_query";

 }
 

$result= mysql_query($query,$DBconn);
  if (!$result) {
  	error("QUERY_ERROR");
  	exit;
  }
 ####################################################################
//echo "$query";
$total_record = mysql_num_rows($result);

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
   $code2 = mysql_result($result,$i,0);
  	$code3 = mysql_result($result,$i,1);
	$code = mysql_result($result,$i,2);
	$title = mysql_result($result,$i,3);	
	$pricec = mysql_result($result,$i,4);
	$prices = mysql_result($result,$i,5);
	$priced = mysql_result($result,$i,6);
	$company = mysql_result($result,$i,7);
	$new = mysql_result($result,$i,8);
	$soldout = mysql_result($result,$i,9);
	$best = mysql_result($result,$i,10);
	$cut = mysql_result($result,$i,11);
	$recommend = mysql_result($result,$i,12);
	$price_dis = mysql_result($result,$i,13);
	$size = mysql_result($result,$i,14);	/*사이즈*/
	$color = mysql_result($result,$i,15);	/*색상*/	
	$imgl = mysql_result($result,$i,16);	/*색상*/	
	$code4 = mysql_result($result,$i,17);	/*색상*/	
	$opt_num = mysql_result($result,$i,18);	/*색상*/	
	$imgb1 = mysql_result($result,$i,19);
	$imgb2 = mysql_result($result,$i,20);

	$asize = split(",",$size);				/*사이즈 분리*/			 $acolor = split(",",$color);					/*색상 분리*/

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
		$price_s = "<font class='sbest_text02'>".number_format($pricec)."원</font> ";	//가격표시변환
	}else{
		$price_s = "<font class='sbest_text02'>".number_format($priced)."원</font> "."<font style='text-decoration: line-through;'>(".number_format($pricec).")</font>"."원";	
	}

	### 이미지 파일 저장 디렉토리 ###
	$savedir = "//pentakleva.shop/upload/";

	$img_name =$imgb1;


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
					

						
						
						

						
						<!-- 상품 -->
						<div class="pl_box">
							<div class="pl_img">
								<a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&theme=f&type=<?=$type?>"><?if($imgl!=""){?><img src="<?=$imgl?>" border="0" align="absmiddle" width="200" height="200"><?}else{?><img src="<?=$savedir?><?=$imgb1?>" width="131" height="131" border="0" align="absmiddle" style="border:1px solid #dedede;"><?}?>
							</div>
							<div class="sp15"></div>
							<div class="pl_text">
								<a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&theme=f&type=<?=$type?>" class="a_3"><?=$title?></a>
							</div>
							<div class="sp5"></div>
							<div class="md_price">
								<a href="../sub04/view.php?left_code=<?=$code?>&code1=<?=$code1?>&code2=<?=$code2?>&code3=<?=$code3?>&code4=<?=$code4?>&type=<?=$type?>" class="c_red"><?=$price_s?></a>
							</div>
						</div>
						<!-- 상품종료 -->

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


				<div class="sp20"></div>
				<div style="text-align:center;">
				<?
	$total_block = ceil($total_page/$page_per_block);
	$block = ceil($page/$page_per_block);
	$first_page = ($block-1)*$page_per_block;
	$last_page = $block*$page_per_block;
	if($total_block <= $block) {
	$last_page = $total_page;
	}
	if($block > 1) {
		$my_page = $first_page;
		echo "<a href=\"$PHP_SELF?page=$my_page&word=$word\" onMouseOver=\"status='';return true;\" onMouseOut=\"status=''\" class='board01_'>[이전]</a>&nbsp;";
	}

	for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
		if($page == $direct_page) {
			echo "<b>[$direct_page]</b>&nbsp;";
		} else {
			echo "<a href=\"$PHP_SELF?page=$direct_page&word=$word\" onMouseOver=\"status='';return true;\" onMouseOut=\"status=''\" style=\"text-decoration:none;\" class='style5'>[$direct_page]&nbsp;</a>";
		}
	}

	if($block < $total_block) {
		$my_page = $last_page+1;
		echo "&nbsp;<a href=\"$PHP_SELF?page=$my_page&word=$word\" onMouseOver=\"status='';return true;\" onMouseOut=\"status=''\"  class='board01_'>[다음]</a>";
	}
	?>
	</div>
				<div class="sp30"></div>
			
			</div>
			<!-- 왼쪽패딩 종료 -->
		
		</div>
		<!-- 컨텐츠 오른쪽 종료 -->

		<div class="sp40"></div>

		
	


	</div>
	<!-- 컨텐츠 종료 -->


    
	<!-- 하단(Copy) -->

	 
	  <? include "../include/bottom.html"; ?>
				
				
	<!-- 하단(Copy) -->


</div>
</body>
</html>
