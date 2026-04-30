<? include "../include/get_balance.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Kona Summit Platform</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../include/css/reset.css" rel="stylesheet" type="text/css" media="all"/>
<link href="../include/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<meta property="og:type" content="website">
<meta property="og:title" content="Kona Summit Platform">
<meta property="og:description" content="명함, 전단지, 봉투, 스티커,리플렛,카달로그등 맞춤디자인">
<meta property="og:image" content="http://www.whyble.net/images/logo.png">
<meta property="og:url" content="http://www.whyble.net">
<meta name="description" content="명함, 전단지, 봉투, 스티커, 리플렛, 카달로그등 맞춤디자인, 고급명함, 배너, 도록, 로고"><meta name="keywords" content="명함,전단지,봉투,스티커,리플렛,카다로그,대전명함,대전명함제작,저렴한명함,대전카탈로그 "/>
<!-- Chrome, Safari, IE -->
<link rel="shortcut icon" href="../images/webicon2.png">
<!-- Firefox, Opera (Chrome and Safari say thanks but no thanks) -->
<link rel="icon" href="../images/webicon2.png">
<?

if($left_code != "") {
	$code1 = substr($left_code, 0, 2);
	$code2 = substr($left_code, 2, 2);
	$code3 = substr($left_code, 4, 2);
	$code4 = substr($left_code, 6, 2);
	$left_code_tmp = $left_code;
}else{
	$code1 = '10';
}

$code1_cate_tmp = $code1;
$code2_cate_tmp = $code2;
$code3_cate_tmp = $code3;
$code4_cate_tmp = $code4;

//echo "$code1 $code2 $code3 $code4,$theme_str";
if($theme_str==""){//정렬순서 관련

	if($code1!=""){
	$query_title1 = "SELECT cate1 FROM $shop_cate WHERE code1='$code1'";
	$result_title1 = mysql_query($query_title1,$DBconn);
	if(!$result_title1) {
	   error("QUERY_ERROR");
	   exit;
	}
		$tmp_cate1 = mysql_result($result_title1,$i,0);
		$title_cate_1 = $tmp_cate1;	//대분류 이름기억
		$title_code_1 = $code1;
	}

	if($code2!=""){
	$query_title2 = "SELECT cate2 FROM $shop_cate WHERE code1='$code1' and code2='$code2'";

	$result_title2 = mysql_query($query_title2,$DBconn);
	if(!$result_title2) {
	   error("QUERY_ERROR");
	   exit;
	}
		$tmp_cate2 = mysql_result($result_title2,$i,0);
		$title_cate_2 = $tmp_cate2;	//중분류 이름기억
		$title_code_2 = $code2;
	}

	if($code3!=""){
	$query_title3 = "SELECT cate3 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3'";

	$result_title3 = mysql_query($query_title3,$DBconn);
	if(!$result_title3) {
	   error("QUERY_ERROR");
	   exit;
	}
		$tmp_cate3 = mysql_result($result_title3,$i,0);
		$title_cate_3 = $tmp_cate3;	//중분류 이름기억
		$title_code_3 = $code3;
	}

	if($code4!=""){
	$query_title4 = "SELECT cate4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='$code4'";

	$result_title4 = mysql_query($query_title4,$DBconn);
	if(!$result_title4) {
	   error("QUERY_ERROR");
	   exit;
	}
	
	$total_record_cnt = mysql_num_rows($result_title4);

	if($total_record_cnt > 0){
		$tmp_cate4 = mysql_result($result_title4,$i,0);
		$title_cate_4 = $tmp_cate4;	//중분류 이름기억
		$title_code_4 = $code4;
	}
	
	}

}

#####################################################################
?>
<script type="text/javascript">
<!--
function go_cart() {

	document.p_form.action="../cart/order_do.php";
	document.p_form.submit();

}
//-->
</script>
</head>

<body>
<div id="wrap">	

	<!-- 상단(Top) -->

	 
	  <? include "../include/top.php"; ?>

				
	<!-- 상단(Top) -->

	<!-- 컨텐츠 시작 -->
	<div id="content">
		
		<div class="content_inner">

			<div class="sp40"></div>

			 <? include "../include/mypage_menu.php"; ?>

			<div class="sp30"></div>

			<div class="page_title">
				개인결제
			</div>

			<!-- 개인결제 시작-->
			<div class="portfolio_inner">
<?

// 정렬 방식
$kk_query="ORDER BY signdate desc";

#####################################################################

$query = "SELECT No,code1,code2,code3,code4,code,title,info1,info2,info3,c_su,c_du,c_jaks,c_jaes,c_in,c_term,img1,img2,img3,img4,img5,img6,img7,imgb,logo_type,logoimg1,logoimg2,logoimg3,logoimg4,logoimg5,logoimg6,manual,s_text1,s_price1,s_img1,s_text2,s_price2,s_img2,s_text3,s_price3,s_img3,lineimg,option_t1,option_n1,option_p1,option_t2,option_n2,option_p2,option_t3,option_n3,option_p3,option_t4,option_n4,option_p4,option_t5,option_n5,option_p5,option_t6,option_n6,option_p6,option_t7,option_n7,option_p7,amount_t,amount_s,amount_d,etc_t1,etc_s1,etc_t2,etc_s2,etc_t3,etc_s3,hu_dis,point,discount,form_n1,form_t1,form_p1,form_d1,form_n2,form_t2,form_p2,form_d2,form_n3,form_t3,form_p3,form_d3,form_n4,form_t4,form_p4,form_d4,form_n5,form_t5,form_p5,form_d5,sample,pro_n1,pro_t1,pro_p1,pro_d1,pro_n2,pro_t2,pro_p2,pro_d2,pro_n3,pro_t3,pro_p3,pro_d3,pro_n4,pro_t4,pro_p4,pro_d4,pro_n5,pro_t5,pro_p5,pro_d5,signdate,soldout,order1,order2,order3,order4,theme_g,rank_g,t_id FROM $shop_goods where code1 = '$code1' $kk_query";
 
//echo "$query";
$result= mysql_query($query,$DBconn);
  if (!$result) {
  	error("QUERY_ERROR");
  	exit;
  }
 ####################################################################

$total_record = mysql_num_rows($result);
//echo "$query <br> $total_record";
$num_per_page = 12;
$page_per_block = 10;
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

} else {
$ii=0;
$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
$No = mysql_result($result,$i,0);			$code1 = mysql_result($result,$i,1);		
$code2 = mysql_result($result,$i,2);		$code3 = mysql_result($result,$i,3);	 
$code4 = mysql_result($result,$i,4);		$code = mysql_result($result,$i,5);		
$title = mysql_result($result,$i,6);		$info1 = mysql_result($result,$i,7);
$info2 = mysql_result($result,$i,8);		$info3 = mysql_result($result,$i,9);		
$c_su = mysql_result($result,$i,10);		$c_du = mysql_result($result,$i,11);
$c_jaks = mysql_result($result,$i,12);		$c_jaes = mysql_result($result,$i,13);		
$c_in = mysql_result($result,$i,14);		$c_term = mysql_result($result,$i,15);
$img1 = mysql_result($result,$i,16);		$img2 = mysql_result($result,$i,17);		
$img3 = mysql_result($result,$i,18);		$img4 = mysql_result($result,$i,19);	
$img5 = mysql_result($result,$i,20);		$img6 = mysql_result($result,$i,21);		
$img7 = mysql_result($result,$i,22);		$imgb = mysql_result($result,$i,23);	
$logo_type = mysql_result($result,$i,24);	$logoimg1 = mysql_result($result,$i,25);	
$logoimg2 = mysql_result($result,$i,26);	$logoimg3 = mysql_result($result,$i,27);	
$logoimg4 = mysql_result($result,$i,28);	$logoimg5 = mysql_result($result,$i,29);	
$logoimg6 = mysql_result($result,$i,30);	$manual = mysql_result($result,$i,31);			
$s_text1 = mysql_result($result,$i,32);		$s_price1 = mysql_result($result,$i,33);	
$s_img1 = mysql_result($result,$i,34);		$s_text2 = mysql_result($result,$i,35);		
$s_price2 = mysql_result($result,$i,36);	$s_img2 = mysql_result($result,$i,37);		
$s_text3 = mysql_result($result,$i,38);		$s_price3 = mysql_result($result,$i,39);		
$s_img3 = mysql_result($result,$i,40);		$lineimg = mysql_result($result,$i,41);	
$option_t1 = mysql_result($result,$i,42);	$option_n1 = mysql_result($result,$i,43);		
$option_p1 = mysql_result($result,$i,44);	$option_t2 = mysql_result($result,$i,45);	
$option_n2 = mysql_result($result,$i,46);	$option_p2 = mysql_result($result,$i,47);		
$option_t3 = mysql_result($result,$i,48);	$option_n3 = mysql_result($result,$i,49);	
$option_p3 = mysql_result($result,$i,50);	$option_t4 = mysql_result($result,$i,51);		
$option_n4 = mysql_result($result,$i,52);	$option_p4 = mysql_result($result,$i,53);	
$option_t5 = mysql_result($result,$i,54);	$option_n5 = mysql_result($result,$i,55);		
$option_p5 = mysql_result($result,$i,56);	$option_t6 = mysql_result($result,$i,57);	
$option_n6 = mysql_result($result,$i,58);	$option_p6 = mysql_result($result,$i,59);		
$option_t7 = mysql_result($result,$i,60);	$option_n7 = mysql_result($result,$i,61);	
$option_p7 = mysql_result($result,$i,62);	$amount_t = mysql_result($result,$i,63);		
$amount_s = mysql_result($result,$i,64);	$amount_d = mysql_result($result,$i,65);	
$etc_t1 = mysql_result($result,$i,66);		$etc_s1 = mysql_result($result,$i,67);			
$etc_t2 = mysql_result($result,$i,68);		$etc_s2 = mysql_result($result,$i,69);		
$etc_t3 = mysql_result($result,$i,70);		$etc_s3 = mysql_result($result,$i,71);			
$hu_dis = mysql_result($result,$i,72);		$point = mysql_result($result,$i,73);		
$discount = mysql_result($result,$i,74);	$form_n1 = mysql_result($result,$i,75);		
$form_t1 = mysql_result($result,$i,76);		$form_p1 = mysql_result($result,$i,77);	
$form_d1 = mysql_result($result,$i,78);		$form_n2 = mysql_result($result,$i,79);		
$form_t2 = mysql_result($result,$i,80);		$form_p2 = mysql_result($result,$i,81);	
$form_d2 = mysql_result($result,$i,82);		$form_n3 = mysql_result($result,$i,83);		
$form_t3 = mysql_result($result,$i,84);		$form_p3 = mysql_result($result,$i,85);	
$form_d3 = mysql_result($result,$i,86);		$form_n4 = mysql_result($result,$i,87);		
$form_t4 = mysql_result($result,$i,88);		$form_p4 = mysql_result($result,$i,89);	
$form_d4 = mysql_result($result,$i,90);		$form_n5 = mysql_result($result,$i,91);		
$form_t5 = mysql_result($result,$i,92);		$form_p5 = mysql_result($result,$i,93);	
$form_d5 = mysql_result($result,$i,94);		$sample = mysql_result($result,$i,95);			
$pro_n1 = mysql_result($result,$i,96);		$pro_t1 = mysql_result($result,$i,97);		
$pro_p1 = mysql_result($result,$i,98);		$pro_d1 = mysql_result($result,$i,99);		
$pro_n2 = mysql_result($result,$i,100);		$pro_t2 = mysql_result($result,$i,101);	
$pro_p2 = mysql_result($result,$i,102);		$pro_d2 = mysql_result($result,$i,103);		
$pro_n3 = mysql_result($result,$i,104);		$pro_t3 = mysql_result($result,$i,105);	
$pro_p3 = mysql_result($result,$i,106);		$pro_d3 = mysql_result($result,$i,107);		
$pro_n4 = mysql_result($result,$i,108);		$pro_t4 = mysql_result($result,$i,109);	
$pro_p4 = mysql_result($result,$i,110);		$pro_d4 = mysql_result($result,$i,111);		
$pro_n5 = mysql_result($result,$i,112);		$pro_t5 = mysql_result($result,$i,113);	
$pro_p5 = mysql_result($result,$i,114);		$pro_d5 = mysql_result($result,$i,115);		
$signdate = mysql_result($result,$i,116);	$soldout = mysql_result($result,$i,117);	
$order1 = mysql_result($result,$i,118);		$order2 = mysql_result($result,$i,119);		
$order3 = mysql_result($result,$i,120);		$order4 = mysql_result($result,$i,121);	
$theme_g = mysql_result($result,$i,122);	$rank_g = mysql_result($result,$i,123);		
$t_id = mysql_result($result,$i,124);

	

### 이미지 파일 저장 디렉토리 ###
$savedir = "../shop_img/";


### 카테고리명 #######################
if ($code2=="00") {
	$query2 = "SELECT cate1 FROM $shop_cate WHERE code1='$code1' and code2='00' and code3='00' and code4='00'";	
}
else if ($code3=="00") {
	$query2 = "SELECT cate2 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='00' and code4='00'";	
}
else if ($code4=="00") {
	$query2 = "SELECT cate3 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='00'";
}
else {
	$query2 = "SELECT cate4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='$code4'";
}
$result2 = mysql_query($query2,$DBconn);
if(!$result2) {
error("QUERY_ERROR");
exit;
}	
$row = mysql_fetch_row($result2);
$cate_name = $row[0];
$cate_name = stripslashes($cate_name);

$title = trim($title);
$title = stripslashes($title);
$info1 = stripslashes($info1);
$info2 = stripslashes($info2);
$info3 = stripslashes($info3);

$aoption_n1=split("\r\n",$option_n1);		$aoption_p1=split("\r\n",$option_p1);
$atheme_g=split("/",$theme_g);

	
?>
				<!--결제_box  -->
				<a href="view.php"><div class="pay_box">
					<center>
						<div class="pay_img">
							<a href="cart_do.php?c_option1=<?=$option_n1?>&c_code=<?=$code?>&c_amount=1"><img src="images/pay.jpg" onmouseover="this.src='images/pay_on.jpg';" onmouseout="this.src='images/pay.jpg';" alt="개인결제이미지"/></a>
						</div>
						<div class="sp20"></div>
						<div class="pay_name">
							<a href="cart_do.php?c_option1=<?=$option_n1?>&c_code=<?=$code?>&c_amount=1"><span class="c_orangen"><?=$title?></span></a>
						</div>
						<div class="sp5"></div>
						<div class="pay_price">
							<a href="cart_do.php?c_option1=<?=$option_n1?>&c_code=<?=$code?>&c_amount=1"><?=number_format($option_p1)?>원</a>
						</div>
					</center>
				</div></a>
				<!-- 결제_box 종료 -->

<?
	$article_num--;
	$ii++;
	}
}
 ?>  				


			
			</div>
			<!--portfolio 종료 -->

			<br>
			<table width="1000" border="0" cellspacing="0" cellpadding="4" class="left_margin30" align="center">
					<tr> 
						<td height="20" align="center"><font color="#666666">
 <?
#####################################################################

 $total_block = ceil($total_page/$page_per_block);
 $block = ceil($page/$page_per_block);
 $first_page = ($block-1)*$page_per_block;
 $last_page = $block*$page_per_block;
 if($total_block <= $block) {
 	$last_page = $total_page;
 }
 
 $mode="keyfield=$keyfield&key=$encoded_key&sel_kind=$sel_kind&sel_status=$sel_status";
 
  if ($page > 1) {
 	$page_num = $page - 1;
?>

							<a href="pay.php?<?=$mode?>&page=<?=$page_num?>" onMouseOver="status='이전페이지';return true;" onMouseOut="status=''">◀</a>

<?
 }
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
?>
 							<font color="#666666">&nbsp;<b>[<?=$direct_page?>]</b></font>
<?	
	} else {
?> 	
							&nbsp;<a href="pay.php?<?=$mode?>&page=<?=$direct_page?>" onMouseOver="status='go to page $direct_page';return true;" onMouseOut="status=''"><font color="#666666">[<?=$direct_page?>]</font></a>
 <?	
	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
?>
 
							&nbsp;<a href="pay.php?<?=$mode?>&page=<?=$page_num?>" onMouseOver="status='다음페이지';return true;" onMouseOut="status=''">▶</a>
 
 <?
 }
 ?>          
          
							</font>
						</td>
					</tr>
				</table>

		</div>

			
			
	</div>
	<!-- 컨텐츠 종료 -->


	<!-- 하단(Copy) -->

	 
	  <? include "../include/bottom.html"; ?>	  
				
				
	<!-- 하단(Copy) -->

	


</div>
</body>
</html>
