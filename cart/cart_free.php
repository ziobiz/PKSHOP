<? include "../include/get_balance.php";

?>
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
<script language='javascript'> 
<? 
	$freeshipping = $_COOKIE['freeshipping'];

?>
<!--
function select_all(){ 
	for(var i=0; i<document.form.chk_num.value; i++){ 
		
		if(document.form.elements[ "check" + i ].checked==true){
			document.form.elements[ "check" + i ].checked=false;
		}else{
			document.form.elements[ "check" + i ].checked=true;
		}
	} 
}

function go_del() {
	go=confirm('\n정말로 데이터를 삭제 하시겠습니까?\n')
	if(go==true){
		document.form.action="cart_del.php";
		document.form.submit();
	}else{return false;}
}

function go_order() {
	
	var total=document.form.chk_num.value;
	var check_ok=0;
	for(var i=0; i<total; i++){ 
		
		if(document.form.elements[ "check" + i ].checked==true){
			check_ok=check_ok+1;
		}else{
			check_ok=check_ok+0;
		}
	} 

	//alert(check_ok);

	if(check_ok>0){
		document.form.action="cart_order.php";
		document.form.submit();
	}else{
		alert("주문하실 상품을 선택하세요.");
		return;
	}
}

function on_print(){
	window.open("print.php","print","width=630,height=600,scrollbars=yes");
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

			<form method="post" name="form">
			<div class="page_title">
				장바구니
			</div>

			<table class="cart_table">
				<tr>
					<th width="5%"><input type="button" value="전체" onclick="select_all()" class="checkbox"></th>
					<th width="15%">상품이미지</th>
					<th width="50%">주문정보</th>
					<th width="10%">가격/인원</th>
					<th width="10%">적립금</th>
					<th width="10%">소계</th>
				</tr>
<?
#####################################################################
$c_ip=$_SERVER["REMOTE_ADDR"];
$query = "SELECT No,c_time,c_ip,c_code,c_type,c_hangul,c_english,c_homepage,c_up,c_ju,c_color,c_company,c_manual,c_text,c_option1,c_option2,c_option3,c_option4,c_option5,c_option6,c_option7,c_amount,c_form_n,c_sample,c_pro_n,c_text_f,c_text_b,c_fname,c_webhard,c_talk,c_hu_name,c_hu_price FROM $shop_cart WHERE c_ip='$c_ip' order by c_time desc";


$result = mysql_query($query,$DBconn);
if(!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_num_rows($result);

if($total_record=="0"){
?>

				<tr>
					<td colspan="6" height="100" align="center"><br><br>장바구니에 선택하신 상품이 없습니다.</td>
				</tr>
				<tr>
					<td colspan="6" class="t_in_line"></td>
				</tr>
<?
}else{
$charge=0; //배송비
$total_point=0; //포인트합계
$total_money=0; //전체합계
$total_settle=0; //배송비포함 합계
$ii=0;
for ($i=0;$i<$total_record;$i++) {
	
	$No = mysql_result($result,$i,0);			$c_time = mysql_result($result,$i,1);
	$c_ip = mysql_result($result,$i,2);			$c_code = mysql_result($result,$i,3);
	$c_type = mysql_result($result,$i,4);		$c_hangul = mysql_result($result,$i,5);
	$c_english = mysql_result($result,$i,6);	$c_homepage = mysql_result($result,$i,7);
	$c_up = mysql_result($result,$i,8);			$c_ju = mysql_result($result,$i,9);
	$c_color = mysql_result($result,$i,10);		$c_company = mysql_result($result,$i,11);
	$c_manual = mysql_result($result,$i,12);	$c_text = mysql_result($result,$i,13);
	$c_option1 = mysql_result($result,$i,14);	$c_option2 = mysql_result($result,$i,15);
	$c_option3 = mysql_result($result,$i,16);	$c_option4 = mysql_result($result,$i,17);
	$c_option5 = mysql_result($result,$i,18);	$c_option6 = mysql_result($result,$i,19);
	$c_option7 = mysql_result($result,$i,20);	$c_amount = mysql_result($result,$i,21);
	$c_form_n = mysql_result($result,$i,22);	$c_sample = mysql_result($result,$i,23);
	$c_pro_n = mysql_result($result,$i,24);		$c_text_f = mysql_result($result,$i,25);
	$c_text_b = mysql_result($result,$i,26);	$c_fname = mysql_result($result,$i,27);

	//echo "$c_amount";
	//exit;

	
	$c_webhard = mysql_result($result,$i,28);	$c_talk = mysql_result($result,$i,29);		
	$c_hu_name = mysql_result($result,$i,30);	$c_hu_price = mysql_result($result,$i,31);

	### 상품정보가져오기 ########################################################################
	$query_product = "SELECT No,code1,code2,code3,code4,code,title,info1,info2,info3,c_su,c_du,c_jaks,c_jaes,c_in,c_term,img1,img2,img3,img4,img5,img6,img7,imgb,logo_type,logoimg1,logoimg2,logoimg3,logoimg4,logoimg5,logoimg6,manual,s_text1,s_price1,s_img1,s_text2,s_price2,s_img2,s_text3,s_price3,s_img3,lineimg,option_t1,option_n1,option_p1,option_t2,option_n2,option_p2,option_t3,option_n3,option_p3,option_t4,option_n4,option_p4,option_t5,option_n5,option_p5,option_t6,option_n6,option_p6,option_t7,option_n7,option_p7,amount_t,amount_s,amount_d,etc_t1,etc_s1,etc_t2,etc_s2,etc_t3,etc_s3,hu_dis,point,discount,form_n1,form_t1,form_p1,form_d1,form_n2,form_t2,form_p2,form_d2,form_n3,form_t3,form_p3,form_d3,form_n4,form_t4,form_p4,form_d4,form_n5,form_t5,form_p5,form_d5,sample,pro_n1,pro_t1,pro_p1,pro_d1,pro_n2,pro_t2,pro_p2,pro_d2,pro_n3,pro_t3,pro_p3,pro_d3,pro_n4,pro_t4,pro_p4,pro_d4,pro_n5,pro_t5,pro_p5,pro_d5,signdate,soldout,order1,order2,order3,order4,theme_g,rank_g,t_id,form_n6,form_t6,form_p6,form_d6 FROM $shop_goods WHERE code='$c_code'";

	$result_product = mysql_query($query_product,$DBconn);
	if(!$result_product) {
	   error("QUERY_ERROR");
	   exit;
	}

	$row_product = mysql_fetch_row($result_product);
		
	$code1 = $row_product[1];		$code2 = $row_product[2];
	$title = $row_product[6];		$img1 = $row_product[16];	
	$logoimg6 = $row_product[30];	$manual = $row_product[31];			
	$s_text1 = $row_product[32];	$s_price1 = $row_product[33];	
	$s_img1 = $row_product[34];		$s_text2 = $row_product[35];		
	$s_price2 = $row_product[36];	$s_img2 = $row_product[37];		
	$s_text3 = $row_product[38];	$s_price3 = $row_product[39];
	$option_t1 = $row_product[42];	$option_n1 = $row_product[43];		
	$option_p1 = $row_product[44];	$option_t2 = $row_product[45];	
	$option_n2 = $row_product[46];	$option_p2 = $row_product[47];		
	$option_t3 = $row_product[48];	$option_n3 = $row_product[49];	
	$option_p3 = $row_product[50];	$option_t4 = $row_product[51];		
	$option_n4 = $row_product[52];	$option_p4 = $row_product[53];	
	$option_t5 = $row_product[54];	$option_n5 = $row_product[55];		
	$option_p5 = $row_product[56];	$option_t6 = $row_product[57];	
	$option_n6 = $row_product[58];	$option_p6 = $row_product[59];		
	$option_t7 = $row_product[60];	$option_n7 = $row_product[61];	
	$option_p7 = $row_product[62];	$point = $row_product[73];	
	$discount = $row_product[74];		$form_n1 = $row_product[75];		
	$form_t1 = $row_product[76];		$form_p1 = $row_product[77];	
	$form_d1 = $row_product[78];		$form_n2 = $row_product[79];		
	$form_t2 = $row_product[80];		$form_p2 = $row_product[81];	
	$form_d2 = $row_product[82];		$form_n3 = $row_product[83];		
	$form_t3 = $row_product[84];		$form_p3 = $row_product[85];	
	$form_d3 = $row_product[86];		$form_n4 = $row_product[87];		
	$form_t4 = $row_product[88];		$form_p4 = $row_product[89];	
	$form_d4 = $row_product[90];		$form_n5 = $row_product[91];		
	$form_t5 = $row_product[92];		$form_p5 = $row_product[93];	
	$form_d5 = $row_product[94];		$sample = $row_product[95];			
	$pro_n1 = $row_product[96];			$pro_t1 = $row_product[97];		
	$pro_p1 = $row_product[98];			$pro_d1 = $row_product[99];		
	$pro_n2 = $row_product[100];		$pro_t2 = $row_product[101];	
	$pro_p2 = $row_product[102];		$pro_d2 = $row_product[103];		
	$pro_n3 = $row_product[104];		$pro_t3 = $row_product[105];	
	$pro_p3 = $row_product[106];		$pro_d3 = $row_product[107];		
	$pro_n4 = $row_product[108];		$pro_t4 = $row_product[109];	
	$pro_p4 = $row_product[110];		$pro_d4 = $row_product[111];		
	$pro_n5 = $row_product[112];		$pro_t5 = $row_product[113];	
	$pro_p5 = $row_product[114];		$pro_d5 = $row_product[115];
	$form_n6 = $row_product[125];		$form_t6 = $row_product[126];		
	$form_p6 = $row_product[127];		$form_d6 = $row_product[128];
	


	$title = trim($title);
	$title = stripslashes($title);

	### 이미지 파일 저장 디렉토리 ###
	$savedir = "../shop_img/";



	$aoption_n1=split("\r\n",$option_n1);		
	$aoption_n2=split(",",$option_n2);			
	$aoption_n3=split(",",$option_n3);			
	$aoption_n4=split(",",$option_n4);			
	$aoption_n5=split(",",$option_n5);			
	$aoption_n6=split(",",$option_n6);			
	$aoption_n7=split(",",$option_n7);			

	$aoption_p1=split("\r\n",$option_p1);
	$aoption_p2=split("/",$option_p2);
	$aoption_p3=split("/",$option_p3);
	$aoption_p4=split("/",$option_p4);
	$aoption_p5=split("/",$option_p5);
	$aoption_p6=split("/",$option_p6);
	$aoption_p7=split("/",$option_p7);

	$aaoption_n1=split("\r\n",$option_n1);	
	$aaaoption_n1=split("\r\n",$option_n1);	
	$aaoption_n2=split(",",$option_n2);			
	$aaoption_n3=split(",",$option_n3);			
	$aaoption_n4=split(",",$option_n4);			
	$aaoption_n5=split(",",$option_n5);			
	$aaoption_n6=split(",",$option_n6);			
	$aaoption_n7=split(",",$option_n7);	

	$aaoption_p1=split("\r\n",$option_p1);
	$aaoption_p2=split("/",$option_p2);
	$aaoption_p3=split("/",$option_p3);
	$aaoption_p4=split("/",$option_p4);
	$aaoption_p5=split("/",$option_p5);
	$aaoption_p6=split("/",$option_p6);
	$aaoption_p7=split("/",$option_p7);

	$aamount_s=split("\r\n",$amount_s);
	$aaamount_s=split("\r\n",$amount_s);
	$atheme_g=split(",",$theme_g);

	//다중차열 구분
	$price_dis=split("/",$option_p7);
	//echo $price_dis[0];
	######################################################################################################
	
	$money=0; //기본옵션합계	
	$j_money=0; //주문형식가격
	$o_money=0; //제작옵션가격
	$c_money=0; //후가공가격
	$m_money=0; //메뉴얼가격
	$h_money=0; //현판제작가격
	$option_money=0; //옵션합계
	$sum_money_imsi=0; //합계(옵선뺀거)
	$sum_money=0; //합계(옵션더한거)
	$sum_point=0; //각각포인트
	$charge_im=0;  //임시배송비
	
	

	
	if($code1=="09" && $code2=="03"){ 

		if($c_option1!=""){
			$c_size=split("X",$c_option1);
			$x_size=$c_size[0];
			$y_size=$c_size[1];
		}

		if($x_size>180 || $y_size>500){
		?>
			<script type="text/javascript">
			<!--
				alert("제작 가능한 사이즈가 아닙니다.\n\n전화 문의주세요.");
			//-->
			</script>
		<?
		exit;
		}

		//90이하
		if($x_size<=90 && $y_size<=100){
			$money=$money+6600;
		}

		if($x_size<=90 && ($y_size>100 && $y_size<=200)){
			$money=$money+13200;
		}

		if($x_size<=90 && ($y_size>200 && $y_size<=300)){
			$money=$money+19800;
		}

		if($x_size<=90 && ($y_size>300 && $y_size<=400)){
			$money=$money+26400;
		}

		if($x_size<=90 && ($y_size>400 && $y_size<=500)){
			$money=$money+33000;
		}

		//91~100
		if(($x_size>90 && $x_size<=100) && $y_size<=100){
			$money=$money+12100;
		}

		if(($x_size>90 && $x_size<=100) && ($y_size>100 && $y_size<=200)){
			$money=$money+18700;
		}

		if(($x_size>90 && $x_size<=100) && ($y_size>200 && $y_size<=300)){
			$money=$money+25300;
		}

		if(($x_size>90 && $x_size<=100) && ($y_size>300 && $y_size<=400)){
			$money=$money+31900;
		}

		if(($x_size>90 && $x_size<=100) && ($y_size>400 && $y_size<=500)){
			$money=$money+38500;
		}

		//101~110
		if(($x_size>100 && $x_size<=110) && $y_size<=100){
			$money=$money+17600;
		}

		if(($x_size>100 && $x_size<=110) && ($y_size>100 && $y_size<=200)){
			$money=$money+24200;
		}

		if(($x_size>100 && $x_size<=110) && ($y_size>200 && $y_size<=300)){
			$money=$money+30800;
		}

		if(($x_size>100 && $x_size<=110) && ($y_size>300 && $y_size<=400)){
			$money=$money+37400;
		}

		if(($x_size>100 && $x_size<=110) && ($y_size>400 && $y_size<=500)){
			$money=$money+44000;
		}

		//111~120
		if(($x_size>111 && $x_size<=120) && $y_size<=100){
			$money=$money+23100;
		}

		if(($x_size>111 && $x_size<=120) && ($y_size>100 && $y_size<=200)){
			$money=$money+29700;
		}

		if(($x_size>111 && $x_size<=120) && ($y_size>200 && $y_size<=300)){
			$money=$money+36300;
		}

		if(($x_size>111 && $x_size<=120) && ($y_size>300 && $y_size<=400)){
			$money=$money+42900;
		}

		if(($x_size>111 && $x_size<=120) && ($y_size>400 && $y_size<=500)){
			$money=$money+49500;
		}

		//121~130
		if(($x_size>121 && $x_size<=130) && $y_size<=100){
			$money=$money+28600;
		}

		if(($x_size>121 && $x_size<=130) && ($y_size>100 && $y_size<=200)){
			$money=$money+35200;
		}

		if(($x_size>121 && $x_size<=130) && ($y_size>200 && $y_size<=300)){
			$money=$money+41800;
		}

		if(($x_size>121 && $x_size<=130) && ($y_size>300 && $y_size<=400)){
			$money=$money+48400;
		}

		if(($x_size>121 && $x_size<=130) && ($y_size>400 && $y_size<=500)){
			$money=$money+55000;
		}

		//131~140
		if(($x_size>131 && $x_size<=140) && $y_size<=100){
			$money=$money+34100;
		}

		if(($x_size>131 && $x_size<=140) && ($y_size>100 && $y_size<=200)){
			$money=$money+40700;
		}

		if(($x_size>121 && $x_size<=140) && ($y_size>200 && $y_size<=300)){
			$money=$money+47300;
		}

		if(($x_size>131 && $x_size<=140) && ($y_size>300 && $y_size<=400)){
			$money=$money+53900;
		}

		if(($x_size>131 && $x_size<=140) && ($y_size>400 && $y_size<=500)){
			$money=$money+60500;
		}

		//141~150
		if(($x_size>141 && $x_size<=150) && $y_size<=100){
			$money=$money+34100+5500;
		}

		if(($x_size>141 && $x_size<=150) && ($y_size>100 && $y_size<=200)){
			$money=$money+40700+5500;
		}

		if(($x_size>141 && $x_size<=150) && ($y_size>200 && $y_size<=300)){
			$money=$money+47300+5500;
		}

		if(($x_size>141 && $x_size<=150) && ($y_size>300 && $y_size<=400)){
			$money=$money+53900+5500;
		}

		if(($x_size>141 && $x_size<=150) && ($y_size>400 && $y_size<=500)){
			$money=$money+60500+5500;
		}

		//151~160
		if(($x_size>151 && $x_size<=160) && $y_size<=100){
			$money=$money+34100+5500+5500;
		}

		if(($x_size>151 && $x_size<=160) && ($y_size>100 && $y_size<=200)){
			$money=$money+40700+5500+5500;
		}

		if(($x_size>151 && $x_size<=160) && ($y_size>200 && $y_size<=300)){
			$money=$money+47300+5500+5500;
		}

		if(($x_size>151 && $x_size<=160) && ($y_size>300 && $y_size<=400)){
			$money=$money+53900+5500+5500;
		}

		if(($x_size>151 && $x_size<=160) && ($y_size>400 && $y_size<=500)){
			$money=$money+60500+5500+5500;
		}

		//161~170
		if(($x_size>161 && $x_size<=170) && $y_size<=100){
			$money=$money+34100+5500+5500+5500;
		}

		if(($x_size>161 && $x_size<=170) && ($y_size>100 && $y_size<=200)){
			$money=$money+40700+5500+5500+5500;
		}

		if(($x_size>161 && $x_size<=170) && ($y_size>200 && $y_size<=300)){
			$money=$money+47300+5500+5500+5500;
		}

		if(($x_size>161 && $x_size<=170) && ($y_size>300 && $y_size<=400)){
			$money=$money+53900+5500+5500+5500;
		}

		if(($x_size>161 && $x_size<=170) && ($y_size>400 && $y_size<=500)){
			$money=$money+60500+5500+5500+5500;
		}

		//171~180
		if(($x_size>171 && $x_size<=180) && $y_size<=100){
			$money=$money+34100+5500+5500+5500+5500;
		}

		if(($x_size>171 && $x_size<=180) && ($y_size>100 && $y_size<=200)){
			$money=$money+40700+5500+5500+5500+5500;
		}

		if(($x_size>171 && $x_size<=180) && ($y_size>200 && $y_size<=300)){
			$money=$money+47300+5500+5500+5500+5500;
		}

		if(($x_size>171 && $x_size<=180) && ($y_size>300 && $y_size<=400)){
			$money=$money+53900+5500+5500+5500+5500;
		}

		if(($x_size>171 && $x_size<=180) && ($y_size>400 && $y_size<=500)){
			$money=$money+60500+5500+5500+5500+5500;
		}


	}else{

		if($code1=="10"){
			$money=$aoption_p1[0];
		}else{
		//1차열 가격
		if($c_option1!="" && $price_dis[0]==""){
			while(list($key1,$value1) = each($aaoption_n1)) {		
				if ($c_option1 == $aaoption_n1[$key1]) {
					$money=$money+$aaoption_p1[$key1];

					//옵션 2~7까지
					for($m=2;$m<8;$m++){
						$sel_option_tmp="option_n".$m; //옵션명변수
						$sel_option_tmp1="price_dis".$m;	// / 구분변수
						$sel_option_tmp2="price_dis".$m.$m;	// , 구분변수
						$sel_option_tmp3="c_option".$m;		// c_option 변수
						$sel_option_tmp4="option_p".$m;  // 옵션가격 변수
						$sel_option=$$sel_option_tmp;
						$sel_option1=$$sel_option_tmp1;
						$sel_option2=$$sel_option_tmp2;
						$sel_option3=$$sel_option_tmp3;
						$sel_option4=$$sel_option_tmp4;						
						
						//echo "$sel_option<br>$sel_option3<br>";
						if($sel_option!=""){
							
							$sel_option1=split("/",$sel_option4); //옵션가격 / 구분
							$sel_option2=split(",", $sel_option1[$key1]); //옵션가격 ,구분
							
							$str2 = split(",", $sel_option); //옵션선택
							$kk2=sizeof($str2);	
							//echo "$kk2<br>";
							
							for($i2=0; $i2 < $kk2; $i2++){				
								if ($str2[$i2] == $sel_option3) {	
									//echo "$sel_option3<br>";
									//echo "$sel_option1[$key1]<br>";
									//echo "$sel_option2[$i2]<br>";
									$money=$money+$sel_option2[$i2];	//옵션가격 더하기
								}

				
							}
						}
					}
					//옵션 2~7까지

				}		
			}
		}
		

		//다중차열 가격	
		if($option_n1!="" && $price_dis[0]!=""){
			if($option_n1!=""){
				$str1 = split("\r\n", $option_n1); 
				$kk1=sizeof($str1);	
				$kkc1=$kk1;
			}else{
				$kkc1=1;
			}
			if($option_n2!=""){
				$str2 = split(",", $option_n2); 
				$kk2=sizeof($str2);	
				$kkc2=$kk2;
			}else{
				$kkc2=1;
			}

			if($option_n3!=""){
				$str3 = split(",", $option_n3); 
				$kk3=sizeof($str3);	
				$kkc3=$kk3;
			}else{
				$kkc3=1;
			}

			if($option_n4!=""){
				$str4 = split(",", $option_n4); 
				$kk4=sizeof($str4);	
				$kkc4=$kk4;
			}else{
				$kkc4=1;
			}

			if($option_n5!=""){
				$str5 = split(",", $option_n5); 
				$kk5=sizeof($str5);	
				$kkc5=$kk5;
			}else{
				$kkc5=1;
			}

			if($option_n6!=""){
				$str6 = split(",", $option_n6); 
				$kk6=sizeof($str6);	
				$kkc6=$kk6;
			}else{
				$kkc6=1;
			}

			
			
			$price_dis=split("/",$option_p7);
			$ii=0;
			
			//$c_option1_k=split("(",$c_option1);
			//$c_option1_kk=$c_option1_k[0];
			//echo "$c_option1_kk";

			while(list($key1,$value) = each($aaoption_n1)) {	
				if($value != "") {	
				
				if ($c_option1 == $aaoption_n1[$key1]) {
			
					$price_t=split(",", $price_dis[$ii]);
					$colspan=0;
					for($i2=0; $i2 < $kkc2; $i2++){
						for($i3=0; $i3 < $kkc3; $i3++){												
							for($i4=0; $i4 < $kkc4; $i4++){
								for($i5=0; $i5 < $kkc5; $i5++){
									for($i6=0; $i6 < $kkc6; $i6++){
									
									$sel_check=$price_t[$colspan];
									$kk=$i2+$i3+$i4+$i5+$i6;							
													
									
										
																		
										if ($c_option2 == $aaoption_n2[$i2] && $c_option3 == $aaoption_n3[$i3] && $c_option4 == $aaoption_n4[$i4] && $c_option5 == $aaoption_n5[$i5] && $c_option6 == $aaoption_n6[$i6]){	
										
											$money=$money+$sel_check;
										}
																	
									
									$colspan++;										
									}
								}
							}
						}
					}
				}
				}
				$ii++;
			}
		}

		}
		
	}

	
	

	//할인가격
	if($discount!="" && $discount>0){
		$money=$money-($money*($discount/100));
	}
	//echo "$money / ";

	//주문형식가격
	if($c_form_n==$form_n1){
		$j_money=$j_money+$form_p1;
	}
	if($c_form_n==$form_n2){
		$j_money=$j_money+$form_p2;
	}
	if($c_form_n==$form_n3){
		$j_money=$j_money+$form_p3;
	}
	if($c_form_n==$form_n4){
		$j_money=$j_money+$form_p4;
	}
	if($c_form_n==$form_n5){
		$j_money=$j_money+$form_p5;
	}
	if($c_form_n==$form_n6){
		$j_money=$j_money+$form_p6;
	}
	//echo "$j_money";


	//제작옵션가격
	$c_str = split(",", $c_pro_n); 
	for($im=0; $im < sizeof($c_str); $im++){ 
		if($pro_n1!="" && $c_str[$im]==$pro_n1){
			$o_money=$o_money+$pro_p1;
		}
		if($pro_n2!="" && $c_str[$im]==$pro_n2){
			$o_money=$o_money+$pro_p2;
		}
		if($pro_n3!="" && $c_str[$im]==$pro_n3){
			$o_money=$o_money+$pro_p3;
		}
		if($pro_n4!="" && $c_str[$im]==$pro_n4){
			$o_money=$o_money+$pro_p4;
		}
		if($pro_n5!="" && $c_str[$im]==$pro_n5){
			$o_money=$o_money+$pro_p5;
		}		
	} 
	//echo "$o_money";

	if($code1=="09" && $code2=="03"){ 

		$c_money=$c_money+$c_hu_price*$c_amount;
	}else{

		//후가공가격	
		if($c_option1<200){
			$saii=1;
		}else{
			$saii=($c_option1/200);
			//echo "후가공 $saii";
			//echo "$c_money+(($c_hu_price)*$saii)*$c_amount";
		}
		$c_money=$c_money+(($c_hu_price)*$saii)*$c_amount;

		
	}
	
	//echo "$c_money";

	//메뉴얼북 가격
	$m_money=$m_money+$c_manual; //메뉴얼가격
	//echo "$m_money";

	//현판제작 가격
	if($c_text==$s_text1){
		$h_money=$h_money+$s_price1;
	}
	if($c_text==$s_text2){
		$h_money=$h_money+$s_price2;
	}
	if($c_text==$s_text3){
		$h_money=$h_money+$s_price3;
	}	
	//echo "$h_money";

	//옵션합계
	$option_money = $option_money+$j_money+$o_money+$c_money+$m_money+$h_money;	

	//합계
	$sum_money_imsi = $sum_money_imsi+($money * $c_amount);


	//전체합계		
	$sum_money=$sum_money+$sum_money_imsi+$j_money+$o_money+$c_money+$m_money+$h_money;



	#### 배송비 설정 ################################################################
	$query_charge = "SELECT bank,charge_dis,charge_price,charge_place,charge_d1,charge_p1,charge_d2,charge_p2,charge_d3,charge_p3,charge_d4,charge_p4,charge_d5,charge_p5,charge_d6,charge_p6,charge_d7,charge_p7,charge_d8,charge_p8,charge_d9,charge_p9,point_dis,point_d,point_c,point_u FROM $admin_setting WHERE No='1'";

	$result_charge = mysql_query($query_charge,$DBconn);
	if(!$result_charge) {
		error("QUERY_ERROR");
		exit;
	}
	$row_charge = mysql_fetch_row($result_charge);
	$bank = $row_charge[0];
	$charge_dis = $row_charge[1];
	$charge_price = $row_charge[2];
	$charge_place = $row_charge[3];
	$charge_d1 = $row_charge[4];
	$charge_p1 = $row_charge[5];
	$charge_d2 = $row_charge[6];
	$charge_p2 = $row_charge[7];
	$charge_d3 = $row_charge[8];
	$charge_p3 = $row_charge[9];
	$charge_d4 = $row_charge[10];
	$charge_p4 = $row_charge[11];
	$charge_d5 = $row_charge[12];
	$charge_p5 = $row_charge[13];
	$charge_d6 = $row_charge[14];
	$charge_p6 = $row_charge[15];
	$charge_d7 = $row_charge[16];
	$charge_p7 = $row_charge[17];
	$charge_d8 = $row_charge[18];
	$charge_p8 = $row_charge[19];
	$charge_d9 = $row_charge[20];
	$charge_p9 = $row_charge[21];
	$point_dis = $row_charge[22];
	$point_d = $row_charge[23];
	$point_c = $row_charge[24];
	$point_u = $row_charge[25];

	if($charge_dis=="Y"){
		$charge_im=$charge_im+0;
	}else{
		if($charge_d1==$code1){
			$charge_im=$charge_im+$charge_p1;
		}else if($charge_d2==$code1){
			$charge_im=$charge_im+$charge_p2;
		}else if($charge_d3==$code1){
			$charge_im=$charge_im+$charge_p3;
		}else if($charge_d4==$code1){
			$charge_im=$charge_im+$charge_p4;
		}else if($charge_d5==$code1){
			$charge_im=$charge_im+$charge_p5;
		}else if($charge_d6==$code1){
			$charge_im=$charge_im+$charge_p6;
		}else if($charge_d7==$code1){
			$charge_im=$charge_im+$charge_p7;
		}else if($charge_d8==$code1){
			$charge_im=$charge_im+$charge_p8;
		}else if($charge_d9==$code1){
			$charge_im=$charge_im+$charge_p9;
		}else{
			$charge_im=$charge_im+$charge_p1;
		}
	}
	if($charge>$charge_im){
		$charge=$charge;
	}else{
		$charge=$charge_im;
	}
	//echo "$code1/ $charge_im / $charge";

	//적립금 계산
	if($point!="" && $point>0){
		$sum_point=$sum_point+($sum_money*($point/100));
	
	}
	//echo "$sum_point<br>";
	//echo "sdfds $sum_money<br>";

	
	//전체합구하기
	$total_point=$total_point+$sum_point; //포인트합계
	$total_money=$total_money+$sum_money; //전체합계
	
	

#####################################################################
?>
				<tr class="cart_table_line">
					<td>
						<input type="checkbox" name="check<?=$i?>" value="<?=$No?>" class="input_writer_sc">
						<input type="hidden" name="cart_check<?=$i?>" value="<?=$No?>">
					</td>
					<td class="cart_img"><?if($code1=="10"){?><img src="../images/whyble_imsi.jpg"><?}else{?><img src="../shop_img/<?=$img1?>" width="100" height="86"><?}?></td>
					<td class="align_right">
						<a href="#" class="a_3"><?=$title?>
						<p class="font_thin a_9">
						<?if($c_option1!=""){?>[<?=$c_option1?>]&nbsp;<?}?>
						<?if($c_option2!=""){?>[<?=$c_option2?>]&nbsp;<?}?>
						<?if($c_option3!=""){?>[<?=$c_option3?>]&nbsp;<?}?>
						<?if($c_option4!=""){?>[<?=$c_option4?>]&nbsp;<?}?>
						<?if($c_option5!=""){?>[<?=$c_option5?>]&nbsp;<?}?>
						<?if($c_option6!=""){?>[<?=$c_option6?>]&nbsp;<?}?>
						<?if($c_option7!=""){?>[<?=$c_option7?>]&nbsp;<?}?>

						<?if($c_form_n!=""){?>[<?=$c_form_n?>]&nbsp;<?}?>
						<?if($c_pro_n!=""){?>[<?=$c_pro_n?>]&nbsp;<?}?>
						<?if($c_hu_name!=""){?>[<?=$c_hu_name?>]&nbsp;<?}?>

						<?if($m_money>0){?>[메뉴얼북]&nbsp;<?}?>
						<?if($c_text!=""){?>[<?=$c_text?>]<?}?>
						</p>
						</a>
					</td>
					<td><?=number_format($money)?>원 / <?=$c_amount?>명<br/>옵션가격 : <?=number_format($option_money)?></td>
					<td class="c_sky"><?=number_format($sum_point)?>원</td>
					<td class="c_red"><?=number_format($sum_money)?>원</td>
				</tr>

<?
$ii++;
}
}

?>
<?
//기본값 이상이면 무조건 무료
if($code1=="10" || $code1=="01" || $freeshipping == "1"){
	$charge=0;
}else{
	if ($charge_price > $total_money) $charge=$charge;
	else $charge=0;
}
//echo "$charge_price / $total_money / $charge";

$total_settle = $total_money + $charge;

?>	
				
				<tr>
					<td colspan="6" class="cart_price">
						<div class="sp5"></div>
						총계 가격 <span class="c_red font_22"><?=number_format($total_settle)?></span>원&nbsp;&nbsp;&nbsp;(배송비 <?if($charge>0){?><?=number_format($charge)?>원<?}else{?>무료<?}?> 포함)
						<div class="sp5"></div>
					</td>
				</tr>
			</table>

			<div class="sp20"></div>

			<div class="view_btn_cart1">
				<input type="button" value="선택삭제" class="cart_btn03" onClick="javascript:go_del();">&nbsp;
				<input type="button" value="쇼핑계속하기" class="cart_btn01" onclick="location.href='../main/main.php'">&nbsp;
				<input type="button" value="견적서프린트" class="cart_btn02" onclick="on_print();">
			</div>

			<div class="view_btn_cart2">
				
				<input type="button" value="주문하기" class="cart_btn03" onClick="javascript:go_order();">
			</div>

			<input type="hidden" name="chk_num" value="<?=$total_record?>"> 
			</form>

		</div>		
		
			
	</div>
	<!-- 컨텐츠 종료 -->


	<!-- 하단(Copy) -->

	 
	  <? include "../include/bottom.html"; ?>	  
				
				
	<!-- 하단(Copy) -->

	


</div>
</body>
</html>
