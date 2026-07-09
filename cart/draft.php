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
<script type="text/javascript">
<!--
function image_t(kk){
	window.open('../../Adm/product/image.htm?Fname='+kk,'','scrollbars=yes,width=50,height=50,top=100,resizable=yes');
}
//-->
</script>

<script type="text/javascript">
<!--
function cont_t(kk){
	window.open('./draft_cont.php?No='+kk,'','scrollbars=yes,width=620,height=300,top=300,left=300,resizable=yes');
}

function cont_ok(kk){
	go=confirm('\n정말로 시안을 확정하시겠습니까?\n')
	if(go==true){
		url='draft_ok.php?No='+kk;
		window.open(url,'_self');
	}else{return false;}
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
				시안확인
			</div>
			<table class="cart_table">
				<tr>
					<th width="15%">주문번호/주문일</th>					
					<th width="33%">주문정보</th>
					<th width="11%">주문일</th>
					<th width="15%">시안</th>
					<th width="11%">상태</th>
					<th width="11%">수정/확정</th>
				</tr>
<?
if($valid_k_name!="" and $valid_k_ordernum1!="" and $valid_k_ordernum2!="" and $valid_k_ordernum3!=""){
$k_name=$valid_k_name;
$k_ordernum=$valid_k_ordernum1."-".$valid_k_ordernum2."-".$valid_k_ordernum3;
			
#####################################################################

$query = "SELECT ss.No,ss.title,ss.money,ss.point,ss.code1,ss.code2,ss.code3,ss.code4,ss.code,ss.c_type,ss.c_hangul,ss.c_english,ss.c_homepage,ss.c_up,ss.c_ju,ss.c_color,ss.c_company,ss.c_manual,ss.c_text,ss.c_option1,ss.c_option2,ss.c_option3,ss.c_option4,ss.c_option5,ss.c_option6,ss.c_option7,ss.c_amount,ss.c_form_n,ss.c_sample,ss.c_pro_n,ss.c_text_f,ss.c_text_b,ss.c_fname,ss.c_webhard,ss.c_talk,ss.c_hu_name,ss.c_hu_price,ss.detail,ss.fname1,ss.fname2,ss.a_detail,ss.c_status,ss.name,ss.signdate,so.ordernum,so.signdate,so.status FROM $shop_sell as ss,$shop_order as so WHERE ss.ordernum=so.ordernum and so.pay_name = '$k_name' and so.pay_mobile='$k_ordernum' and (ss.c_status='검토요청' or ss.c_status='수정요청' or ss.c_status='시안확정' or so.status='검토요청' or so.status='수정요청' or so.status='시안확정') order by No desc";





 $result= mysql_query($query,$DBconn);
 if (!$result) {
 	error("QUERY_ERROR");
 	exit;
 }
 
 $total_record = mysql_num_rows($result);


 if($total_record=="0"){
	 
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("You have no items in your order.");
	history.back();
//-->
</SCRIPT>
<?
exit;
///////} 이상해서 없앰 2017.05.18 ///////
 }
 ####################################################################

}else{
#####################################################################
include "../include/login_check.php";
$query = "SELECT ss.No,ss.title,ss.money,ss.point,ss.code1,ss.code2,ss.code3,ss.code4,ss.code,ss.c_type,ss.c_hangul,ss.c_english,ss.c_homepage,ss.c_up,ss.c_ju,ss.c_color,ss.c_company,ss.c_manual,ss.c_text,ss.c_option1,ss.c_option2,ss.c_option3,ss.c_option4,ss.c_option5,ss.c_option6,ss.c_option7,ss.c_amount,ss.c_form_n,ss.c_sample,ss.c_pro_n,ss.c_text_f,ss.c_text_b,ss.c_fname,ss.c_webhard,ss.c_talk,ss.c_hu_name,ss.c_hu_price,ss.detail,ss.fname1,ss.fname2,ss.a_detail,ss.c_status,ss.name,ss.signdate,so.ordernum,so.signdate,so.status FROM $shop_sell as ss,$shop_order as so WHERE ss.ordernum=so.ordernum and so.id='$valid_user' and (ss.c_status='검토요청' or ss.c_status='수정요청' or ss.c_status='시안확정' or so.status='검토요청' or so.status='수정요청' or so.status='시안확정') order by No desc";
$result = mysql_query($query,$DBconn);
if(!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_num_rows($result);
}


if ($page=="") $page=1;
$num_per_page = 10;
$page_per_block = 10;

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
$article_num = $total_record - $num_per_page*($page-1);
$ii=0;

for($i = $first; $i <= $last; $i++) { 

	
	$No = mysql_result($result,$i,0);				$title = mysql_result($result,$i,1);	
	$money = mysql_result($result,$i,2);			$point = mysql_result($result,$i,3);	
	$code1 = mysql_result($result,$i,4);			$code2 = mysql_result($result,$i,5);	
	$code3 = mysql_result($result,$i,6);			$code4 = mysql_result($result,$i,7);	
	$code = mysql_result($result,$i,8);				$c_type = mysql_result($result,$i,9);	
	$c_hangul = mysql_result($result,$i,10);		$c_english = mysql_result($result,$i,11);	
	$c_homepage = mysql_result($result,$i,12);		$c_up = mysql_result($result,$i,13);	
	$c_ju = mysql_result($result,$i,14);			$c_color = mysql_result($result,$i,15);	
	$c_company = mysql_result($result,$i,16);		$c_manual = mysql_result($result,$i,17);
	$c_text = mysql_result($result,$i,18);			$c_option1 = mysql_result($result,$i,19);	
	$c_option2 = mysql_result($result,$i,20);		$c_option3 = mysql_result($result,$i,21);	
	$c_option4 = mysql_result($result,$i,22);		$c_option5 = mysql_result($result,$i,23);	
	$c_option6 = mysql_result($result,$i,24);		$c_option7 = mysql_result($result,$i,25);	
	$c_amount = mysql_result($result,$i,26);		$c_form_n = mysql_result($result,$i,27);	
	$c_sample = mysql_result($result,$i,28);		$c_pro_n = mysql_result($result,$i,29);	
	$c_text_f = mysql_result($result,$i,30);		$c_text_b = mysql_result($result,$i,31);	
	$c_fname = mysql_result($result,$i,32);			$c_webhard = mysql_result($result,$i,33);	
	$c_talk = mysql_result($result,$i,34);			$c_hu_name = mysql_result($result,$i,35);
	$c_hu_price = mysql_result($result,$i,36);		$detail = mysql_result($result,$i,37);	
	$fname1 = mysql_result($result,$i,38);			$fname2 = mysql_result($result,$i,39);	
	$a_detail = mysql_result($result,$i,40);		$c_status = mysql_result($result,$i,41);	
	$name = mysql_result($result,$i,42);			$signdate = mysql_result($result,$i,43);	

	//주문정보
	$ordernum = mysql_result($result,$i,44);		$signdate1 = mysql_result($result,$i,45);
	$status = mysql_result($result,$i,46);
	
							
	$sum_money = $money * $c_amount;	
	$point = $point * $c_amount;
	$total_money = $total_money + $sum_money;		
	$title = stripslashes($title);
	$money =  number_format($money)."원";				
	$sum_money =  number_format($sum_money)."원";
	$c_company = str_replace( chr(13),"<br>",$c_company);
	$c_text_f = str_replace( chr(13),"<br>",$c_text_f);
	$c_text_b = str_replace( chr(13),"<br>",$c_text_b);
	$detail = str_replace( chr(13),"<br>",$detail);
	

	$str = split(",", $c_fname); 
	$c_fname_link="";
	for($im=0; $im < sizeof($str); $im++){ 
		$c_fname_link=$c_fname_link."[<a href='../shop_img/$str[$im]' target='_blank'>$str[$im]</a>]";
	} 
	

	$str1 = split(",", $c_sample); 
	$c_fname_link1="";
	for($im=0; $im < sizeof($str1); $im++){ 
		$c_fname_link1=$c_fname_link1."&nbsp;<img src='../shop_img/$str1[$im]' width='100'>";
	} 
 
	


	if($signdate>0){
		$signdate = date("Y.m.d H:i:s",$signdate);
	}else{
		$signdate = "00.00.00 00:00:00";
	}

	if($signdate1>0){
		$signdate1 = date("Y.m.d H:i:s",$signdate1);
	}else{
		$signdate1 = "00.00.00 00:00:00";
	}
	
	$kk_mode="c_code=$code&c_type=$c_type&c_hangul=$c_hangul&c_english=$c_english&c_homepage=$c_homepage&c_up=$c_up&c_ju=$c_ju&c_color=$c_color&c_manual=$c_manual&c_text=$c_text&c_option1=$c_option1&c_option2=$c_option2&c_option3=$c_option3&c_option4=$c_option4&c_option5=$c_option5&c_option6=$c_option6&c_option7=$c_option7&c_amount=$c_amount&c_form_n=$c_form_n&c_sample=$c_sample&c_pro_n=$c_pro_n&c_text_f=$c_text_f&c_text_b=$c_text_b&File_c_fname=$c_fname&c_webhard=$c_webhard&c_talk=$c_talk&c_hu_name=$c_hu_name&c_hu_price=$c_hu_price";
	

#####################################################################
?>
				<tr class="cart_table_line">
					<td><?=$ordernum?><p class="c_9"><?=$signdate1?></p></td>					
					<td class="align_right">
						<a href="../cart/sian_view.php?No=<?=$No?>" class="a_3"><?=$title?><p class="font_thin a_9"><?if($code1=="01"){?>
										<?if($c_option1!=""){?>&nbsp;/&nbsp;<?=$c_option1?><?}?>
										<?if($c_hangul!=""){?>&nbsp;/&nbsp;<?=$c_hangul?><?}?>
										<?if($c_english!=""){?>&nbsp;/&nbsp;<?=$c_english?><?}?>
										<?if($c_homepage!=""){?>&nbsp;/&nbsp;<?=$c_homepage?><?}?>
										<?if($c_up!=""){?>&nbsp;/&nbsp;<?=$c_up?><?}?>
										<?if($c_ju!=""){?>&nbsp;/&nbsp;<?=$c_ju?><?}?>
										<?if($c_color!=""){?>&nbsp;/&nbsp;<?=$c_color?><?}?>
										<?if($c_manual!=""){?>&nbsp;/&nbsp;<?=$c_manual?><?}?>
										<?if($c_text!=""){?>&nbsp;/&nbsp;<?=$c_text?><?}?>
										<?}else{?>

										<?if($c_option1!=""){?>&nbsp;/&nbsp;<?=$c_option1?><?}?>
										<?if($c_option2!=""){?>&nbsp;/&nbsp;<?=$c_option2?><?}?>
										<?if($c_option3!=""){?>&nbsp;/&nbsp;<?=$c_option3?><?}?>
										<?if($c_option4!=""){?>&nbsp;/&nbsp;<?=$c_option4?><?}?>
										<?if($c_option5!=""){?>&nbsp;/&nbsp;<?=$c_option5?><?}?>
										<?if($c_option6!=""){?>&nbsp;/&nbsp;<?=$c_option6?><?}?>
										<?if($c_option7!=""){?>&nbsp;/&nbsp;<?=$c_option7?><?}?>
										<?if($c_form_n!=""){?>&nbsp;/&nbsp;<?=$c_form_n?><?}?>
										<?if($c_pro_n!=""){?>&nbsp;/&nbsp;<?=$c_pro_n?><?}?>
										<?if($c_hu_name!=""){?>&nbsp;/&nbsp;<?=$c_hu_name?><?}?>
										<?}?></p></a>
					</td>
					<td><?=$signdate1?></td>
					<td class="cart_img">
						<?if($c_status!="시안확정"){?><a href="../cart/sian_view.php?No=<?=$No?>"><?}?>
						<?if($fname1!=""){?><img src="../shop_img/<?=$fname1?>" width="100"><?}?>
						<?if($fname2!=""){?><img src="../shop_img/<?=$fname2?>" width="100"><?}?>
					</td>
					<td class="c_redb"><?=$c_status?></td>
					<td>
						<?if($c_status=="검토요청"){?><input type="button" value="수정요청" class="btn_modify" onclick="location.href='sian_view.php?No=<?=$No?>';"><br/><?}?>
						<?if($c_status=="수정요청"){?><input type="button" value="수정요청" class="btn_modify" onclick="location.href='sian_view.php?No=<?=$No?>';"><br/><?}?>
						<?if($c_status!="시안확정"){?><input type="button" value="시안확정" class="btn_complete" onclick="location.href='sian_view.php?No=<?=$No?>';"><?}?>
						
					</td>
				</tr>
<?}?>
				<tr>
					<td colspan="7" class="cart_price" style="text-align:center;">
						<div class="sp5"></div>
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

							<a href="sian_view.php?<?=$mode?>&page=<?=$page_num?>" onMouseOver="status='이전페이지';return true;" onMouseOut="status=''">◀</a>

<?
 }
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
?>
 							<font color="#666666">&nbsp;<b>[<?=$direct_page?>]</b></font>
<?	
	} else {
?> 	
							&nbsp;<a href="sian_view.php?<?=$mode?>&page=<?=$direct_page?>" onMouseOver="status='go to page $direct_page';return true;" onMouseOut="status=''"><font color="#666666">[<?=$direct_page?>]</font></a>
 <?	
	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
?>
 
							&nbsp;<a href="sian_view.php?<?=$mode?>&page=<?=$page_num?>" onMouseOver="status='다음페이지';return true;" onMouseOut="status=''">▶</a>
 
 <?
 }
 ?>   
						<div class="sp5"></div>
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
