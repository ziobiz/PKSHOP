<? include "../include/top_session.php";
	include "../../Adm/common/dbconn.php";
?>
<?
//=========== 중복 결제 확인 삭제 =====================
//$result = session_unregister("connect_check");
unset($_SESSION["connect_check"]);
//=====================================================

include "cartfunc.php";
//echo $session_cart;
//exit;
if($buyselected=='Y'){
	//선택주문
	$session_cart=$session_cart_selected;
}else if($order_kk=="Y"){
	//바로주문
	$ss_dis=time();
	
	
	$numresults = mysql_query("select count(*) as soo from $shop_cart where cart_id='$valid_user'");
	$row_num = mysql_fetch_array($numresults);
	$total_su=$row_num[soo];	
	if ($total_su=='0'){
		mysql_query("insert into $shop_cart values ('','$valid_user','$session_cart')");	
	}else{

		if ($session_cart!="") {
			mysql_query("update $shop_cart set cart_cont='$session_cart' where cart_id='$valid_user' "); 	
		}
	}
	
}else{
	//전체주문
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Kona Summit Platform</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../include/reset.css">
  <link rel="stylesheet" href="../include/style.css">
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
  if ($session_cart=="") {
	popup_msg("장바구니에 선택하신 상품이 없습니다.");
	exit;
  }

#####################################################################

$query = "SELECT name,email,zip,address,tel,handphone,point from $member_table WHERE id='$valid_user'";
$result = mysql_query($query,$DBconn);
if(!$result) {
   error("QUERY_ERROR");
   exit;
}
$row = mysql_fetch_row($result);
$name = $row[0];
$email = $row[1];
$zip = $row[2];
$address = $row[3];
$tel = $row[4];
$handphone = $row[5];
$point = $row[6];
$kk_point=$point;

//$point =  number_format($point);

$query_p = "SELECT sum(Point) as point_cur FROM $shop_point WHERE Cid='$valid_user'";
$row_p = mysql_fetch_assoc($result_p = mysql_query($query_p));
$point_cur = $row_p[point_cur]; 
$kk_point=$point_cur;

if($kk_point==""){
	$kk_point=0;
}
#####################################################################
?>
<script type="text/javascript" src="../include/js/jquery-1.12.2.min.js"></script>
<script language="JavaScript">
<!--

function paygo() {
   if(!document.join.buyername.value) {
      alert('주문자 이를을 입력하세요.');
      document.join.buyername.focus();
      return;
   }
   if(!document.join.post.value) {
      alert('주문자 우편번호를 입력하세요.');
      document.join.post1.focus();
      return;
   }
   if(!document.join.addr1.value) {
      alert('주문자 주소를 입력하세요.');
      document.join.addr1.focus();
      return;
   }

   if(!document.join.htel.value) {
      alert('주문자 연락처를 입력하세요.');
      document.join.htel.focus();
      return;
   }
  
   if(!document.join.email.value) {
      alert('주문자 E-mail을 입력하세요.');
      document.join.email.focus();
      return;
   }

   if(!document.join.recvname.value) {
      alert('수신자 이름을 입력하세요.');
      document.join.recvname.focus();
      return;
   }
   
   if(!document.join.rhtel.value) {
      alert('배송지 연락처를 입력하세요.');
      document.join.rhtel.focus();
      return;
   }

   <?if($valid_user) {?>
	   if(document.join.usepoint.value!="") {		
		  if(parseInt(document.join.usepoint.value)>'<?=$kk_point?>'){
			 alert('사용하실코인이 보유코인을 초과하였습니다.');
			document.join.usepoint.focus();
			return;
		  }
	   }		
	   var kk_point = '<?=$kk_point?>';
	   if(document.join.usepoint.value!="") {		
		  if(parseInt(document.join.usepoint.value)>parseInt(document.join.total_coin1.value)){
			 alert('사용가능한 코인을 초과하였습니다.');
			document.join.usepoint.focus();
			return;
		  }
	   }
	<?}?>

	if(document.join.paymentkind[0].checked==true){
		if(document.join.in_name.value==""){
			alert('입금자명을 입력해주세요.');
			document.join.in_name.focus();
			return;
		}
	}

   document.join.submit();
}

function no_cart() {
	alert("품절된 상품이 있습니다. 확인후 구입해주세요.");
	return ;
}
//-->
</script>
<script language="javascript">
function go_recal1() {
	document.form.action='./cart_racal.php';
    document.form.submit();
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

			<div class="page_title">
				주문서작성
			</div>

			<table class="cart_table">
				<tr>
					<th width="20%">상품이미지</th>
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

	
	//echo "$money <br>";

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

	
	//전체합구하기
	$total_point=$total_point+$sum_point; //포인트합계
	$total_money=$total_money+$sum_money; //전체합계
	
	

#####################################################################
?>
				<tr class="cart_table_line">
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
}?>
<?
//기본값 이상이면 무조건 무료

if ($charge_price > $total_money) $charge=$charge;
else $charge=0;
//echo "$charge_price / $total_money / $charge";

if($code1=="10" || $code1=="01" || $freeshipping == "1"){
	$charge=0;
}
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

<form name="join" method="post" action="approval.php">

<script language="javascript">
<!--


function sync_data(obj){
		
		if( obj.checked ){
		document.join.recvname.value=document.join.buyername.value;
		document.join.rpost.value=document.join.post.value;
		document.join.raddr1.value=document.join.addr1.value;
		document.join.rtel1.selectedIndex=document.join.tel1.selectedIndex;
		document.join.rtel2.value=document.join.tel2.value;
		document.join.rtel3.value=document.join.tel3.value;
		document.join.rhtel1.selectedIndex=document.join.htel1.selectedIndex;
		document.join.rhtel2.value=document.join.htel2.value;
		document.join.rhtel3.value=document.join.htel3.value;
		}else{
		document.join.recvname.value="";
		document.join.rpost.value="";
		document.join.raddr1.value="";
		document.join.rtel1.selectedIndex=0;
		document.join.rtel2.value="";
		document.join.rtel3.value="";
		document.join.rhtel1.selectedIndex=0;
		document.join.rhtel2.value="";
		document.join.rhtel3.value="";
		}
	}
//-->
</script>
			<div class="order_table_title">
				주문하시는 분
			</div>

			<table class="order_table">
				<tr>
					<th width="18%">이 름</th>
					<td width="78%"><input type="text" name="buyername" value="<?=$name?>" class="input_name"></td>
				</tr>
				<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
				<script>
					function openDaumPostcode() {							
					new daum.Postcode({
						oncomplete: function(data) {
							// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

							// 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
							// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
							var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
							var extraRoadAddr = ''; // 도로명 조합형 주소 변수

							// 법정Kona Summit Platform이 있을 경우 추가한다. (법정리는 제외)
							// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
							if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
								extraRoadAddr += data.bname;
							}
							// 건물명이 있고, 공동주택일 경우 추가한다.
							if(data.buildingName !== '' && data.apartment === 'Y'){
							   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
							}
							// 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
							if(extraRoadAddr !== ''){
								extraRoadAddr = ' (' + extraRoadAddr + ')';
							}
							// 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
							if(fullRoadAddr !== ''){
								fullRoadAddr += extraRoadAddr;
							}

							// 우편번호와 주소 정보를 해당 필드에 넣는다.
							document.getElementById('zip').value = data.zonecode; //5자리 새우편번호 사용
							document.getElementById('address').value = fullRoadAddr;
							//document.getElementById('address').value = data.jibunAddress;

							
						}
					}).open();	
					}
				</script>
				<tr>
					<th>주 소</th>
					<td>
						<input type="text" name="post" value="<?=$zip?>" id="zip" class="input_addr"> <input type="button" value="Find Address" class="btn_addr" onclick="javascript:openDaumPostcode()"><br/><br/>
						<input type="text" name="addr1" value="<?=$address?>" id="address" class="input_addr01"><br>
						(상세한 주소까지 정확히 입력해 주세요.)
					</td>
				</tr>
				<tr>
					<th>핸드폰</th>
					<td><select name="htel1" class="input_tel">
							<option value="010" <?if($handphone1=="010"){?>selected<?}?>>010</option>
							<option value="011" <?if($handphone1=="011"){?>selected<?}?>>011</option>
							<option value="019" <?if($handphone1=="019"){?>selected<?}?>>019</option>
							<option value="018" <?if($handphone1=="018"){?>selected<?}?>>018</option>
							<option value="017" <?if($handphone1=="017"){?>selected<?}?>>017</option>
							<option value="016" <?if($handphone1=="016"){?>selected<?}?>>016</option>
						 </select>&nbsp;-&nbsp;<input type="text" name="htel2" value="<?=$handphone2?>" class="input_tel">&nbsp;-&nbsp;<input type="text" name="htel3" value="<?=$handphone3?>" class="input_tel"></td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td><select name="tel1" class="input_tel">
							<option value="02" <?if($tel1=="02"){?>selected<?}?>>02</option>
							<option value="031" <?if($tel1=="031"){?>selected<?}?>>031</option>
							<option value="032" <?if($tel1=="032"){?>selected<?}?>>032</option>
							<option value="033" <?if($tel1=="033"){?>selected<?}?>>033</option>
							<option value="041" <?if($tel1=="041"){?>selected<?}?>>041</option>
							<option value="042" <?if($tel1=="042"){?>selected<?}?>>042</option>
							<option value="043" <?if($tel1=="043"){?>selected<?}?>>043</option>
							<option value="044" <?if($tel1=="044"){?>selected<?}?>>044</option>
							<option value="051" <?if($tel1=="051"){?>selected<?}?>>051</option>
							<option value="052" <?if($tel1=="052"){?>selected<?}?>>052</option>
							<option value="053" <?if($tel1=="053"){?>selected<?}?>>053</option>
							<option value="054" <?if($tel1=="054"){?>selected<?}?>>054</option>
							<option value="055" <?if($tel1=="055"){?>selected<?}?>>055</option>
							<option value="061" <?if($tel1=="061"){?>selected<?}?>>061</option>
							<option value="062" <?if($tel1=="062"){?>selected<?}?>>062</option>
							<option value="063" <?if($tel1=="063"){?>selected<?}?>>063</option>
							<option value="064" <?if($tel1=="064"){?>selected<?}?>>064</option>
							<option value="070" <?if($tel1=="070"){?>selected<?}?>>070</option>
							<option value="080" <?if($tel1=="080"){?>selected<?}?>>080</option>
							<option value="0505" <?if($tel1=="0505"){?>selected<?}?>>0505</option>
						</select>&nbsp;-&nbsp;<input type="text" name="tel2" value="<?=$tel2?>" class="input_tel">&nbsp;-&nbsp;<input type="text" name="tel3" value="<?=$tel3?>" class="input_tel"></td>
				</tr>
				<tr>
					<th>E-Mail</th>
					<td><input type="text" name="email" value="<?=$email?>" class="input_email"></td>
				</tr>
				
			</table>

			<div class="sp20"></div>

			<div class="order_table_title">
				받으시는 분&nbsp;&nbsp;<input type="checkbox" class="checkbox" onClick="sync_data(this);"> <span class="font_thin font_12">주문자와 동일</span>
			</div>

			<table class="order_table">
				<tr>
					<th width="18%">이 름</th>
					<td width="78%"><input type="text" name="recvname" class="input_name"></td>
				</tr>
				<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
					<script>
						function openDaumPostcode1() {							
						new daum.Postcode({
							oncomplete: function(data) {
								// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

								// 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
								// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
								var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
								var extraRoadAddr = ''; // 도로명 조합형 주소 변수

								// 법정Kona Summit Platform이 있을 경우 추가한다. (법정리는 제외)
								// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
								if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
									extraRoadAddr += data.bname;
								}
								// 건물명이 있고, 공동주택일 경우 추가한다.
								if(data.buildingName !== '' && data.apartment === 'Y'){
								   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
								}
								// 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
								if(extraRoadAddr !== ''){
									extraRoadAddr = ' (' + extraRoadAddr + ')';
								}
								// 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
								if(fullRoadAddr !== ''){
									fullRoadAddr += extraRoadAddr;
								}

								// 우편번호와 주소 정보를 해당 필드에 넣는다.
								document.getElementById('czip').value = data.zonecode; //5자리 새우편번호 사용
								document.getElementById('caddr').value = fullRoadAddr;
								//document.getElementById('address').value = data.jibunAddress;

								
							}
						}).open();	
						}
					</script>
				<tr>
					<th>주 소</th>
					<td>
						<input type="text" name="rpost" id="czip" class="input_addr"> <input type="button" value="Find Address" class="btn_addr" onclick="javascript:openDaumPostcode1()"><br/><br/>
						<input type="text" name="raddr1" id="caddr" class="input_addr01"><br/>
						(상세한 주소까지 정확히 입력해 주세요.)
					</td>
				</tr>
				<tr>
					<th>핸드폰</th>
					<td><select name="rhtel1" class="input_tel">
							<option value="010">010</option>
							<option value="011">011</option>
							<option value="019">019</option>
							<option value="018">018</option>
							<option value="017">017</option>
							<option value="016">016</option>
						 </select>&nbsp;-&nbsp;<input type="text" name="rhtel2" class="input_tel">&nbsp;-&nbsp;<input type="text" name="rhtel3" class="input_tel"></td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td><select name="rtel1" class="input_tel">
							<option value="02">02</option>
							<option value="031">031</option>
							<option value="032">032</option>
							<option value="033">033</option>
							<option value="041">041</option>
							<option value="042">042</option>
							<option value="043">043</option>
							<option value="044">044</option>
							<option value="051">051</option>
							<option value="052">052</option>
							<option value="053">053</option>
							<option value="054">054</option>
							<option value="055">055</option>
							<option value="061">061</option>
							<option value="062">062</option>
							<option value="063">063</option>
							<option value="064">064</option>
							<option value="070">070</option>
							<option value="080">080</option>
							<option value="0505">>0505</option>
						</select>&nbsp;-&nbsp;<input type="text" name="rtel2" class="input_tel">&nbsp;-&nbsp;<input type="text" name="rtel3" class="input_tel"></td>
				</tr>
				<tr>
					<th class="align_top">전하실 말</th>
					<td>
						<textarea name="receive_etc" class="order_memo"></textarea>
					</td>
				</tr>
			</table>

			<div class="sp20"></div>
<script type="text/javascript">
<!--


function show_bank(mode){
	if(mode=="1"){
		document.getElementById("bank_table").style.display="";

	}else{
		document.getElementById("bank_table").style.display="none";	
	
	}
	document.getElementById('tax_choice').style.display='';
	document.getElementById('tax_explain').style.display='none';
	if (mode==2) { // 세금계산서 관련
	document.join.o_tax_type[0].checked='checked';
	show_tax('none');
	document.getElementById('tax_choice').style.display='none';
	document.getElementById('tax_explain').style.display='';
	document.getElementById('tax_explain').innerHTML='신용카드결제 후 영수증을 출력하셔서 세무자료로 이용하실 수 있습니다';
	}
}

//세금계산서정보
function show_tax(mode){
	document.getElementById("tax_table").style.display=mode;
}


//-->
</script>
			<div class="order_table_title">
				결제정보
			</div>

			<table class="order_table">
				<tr>
					<th width="18%">적립금 사용</th>
					<td width="78%"><input type="text" name="usepoint" class="input_tel" <?if($kk_point<1000){?>onfocus='this.blur()'<?}?>><span style="font-weight:bold;">원</span>
					<input type="hidden" name="kkpoint1" value="<?=$kk_point?>">
					&nbsp;&nbsp;* 내 사용가능 적립금 <span style="color:#f26c4f;"><?=number_format($kk_point)?>원</span>&nbsp;&nbsp;(<?=number_format($point_u_setting)?>원 부터 사용이 가능합니다.)
					</td>
				</tr>
				<tr>
					<th width="18%">결제수단</th>
					<td width="78%"><input type="radio" name="paymentkind" value="1" onclick="show_bank(1);" class="radio" checked>무통장입금&nbsp;&nbsp;<input type="radio" name="paymentkind" value="2" onclick="show_bank(2);" class="radio">신용카드&nbsp;&nbsp;<input type="radio" name="paymentkind" value="3" class="radio" onclick="show_bank(3);">실시간계좌이체&nbsp;&nbsp;<input type="radio" name="paymentkind" value="4" onclick="show_bank(4);" class="radio">에스크로 결제					
					</td>
				</tr>
				<tr id="bank_table">
					<th></th>
					<td>
						입금자명&nbsp;&nbsp;<input type="text" name="in_name" class="input_tel"><br/><br/>
						<select name="bank_kk" class="selet_bank">
							<?
							while(list($key1,$value1) = each($abank_setting)) {	
							?>
								<option value="<?=$abank_setting[$key1]?>"><?=$abank_setting[$key1]?></option>
							<?}?>
						</select>
					</td>
				</tr>

				<tr id="tax_table2">
					<th>세금계산서</th>
					<td>
						<div id="tax_choice">
						<input type="radio" name="o_tax_type" value="1" onclick="show_tax('none');" class="radio" <?if($cdis=="1" || $cdis==""){?>checked="checked"<?}?>>미발행&nbsp;&nbsp;<input type="radio" name="o_tax_type" value="2" onclick="show_tax('block');" class="radio" <?if($cdis=="0"){?>checked="checked"<?}?>>발행
						</div>
						<div id="tax_explain" style="display:none">sdfdsf</div>
					</td>
				</tr>
			</table>

			

			<div id="tax_table" style="display:<?if($cdis=='0'){?>block<?}else{?>none<?}?>;">
			<div class="sp20"></div>
			<div class="order_table_title">
				회사정보 입력
			</div>

			<table class="order_table">
				<tr>
					<th width="18%">회사명</th>
					
					<td width="32%"><input type="text" name="tcompany" value="<?=$company?>" class="input_name_tax"></td>
					<th width="18%">사업자등록번호</th>
					
					<td width="32%">
						<input type="text" name="tnumber" value="<?=$cnumber?>" class="input_name_tax">
					</td>

				</tr>
		
				<tr>
					<th>대표자명</th>
					
					<td><input type="text" name="tname" value="<?=$cname?>" class="input_name_tax"></td>
					<th>수신이메일</th>
				
					<td>
						<input type="text" name="temail" value="<?=$email?>" class="input_name_tax">
					</td>
				</tr>
		
				
				<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
				<script>
					function openDaumPostcode2() {							
					new daum.Postcode({
						oncomplete: function(data) {
							// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

							// 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
							// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
							var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
							var extraRoadAddr = ''; // 도로명 조합형 주소 변수

							// 법정Kona Summit Platform이 있을 경우 추가한다. (법정리는 제외)
							// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
							if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
								extraRoadAddr += data.bname;
							}
							// 건물명이 있고, 공동주택일 경우 추가한다.
							if(data.buildingName !== '' && data.apartment === 'Y'){
							   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
							}
							// 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
							if(extraRoadAddr !== ''){
								extraRoadAddr = ' (' + extraRoadAddr + ')';
							}
							// 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
							if(fullRoadAddr !== ''){
								fullRoadAddr += extraRoadAddr;
							}

							// 우편번호와 주소 정보를 해당 필드에 넣는다.
							document.getElementById('tzip').value = data.zonecode; //5자리 새우편번호 사용
							document.getElementById('taddr').value = fullRoadAddr;
							//document.getElementById('address').value = data.jibunAddress;

							
						}
					}).open();	
					}
				</script>
				<tr>
					<th>주소</th>			
					<td colspan="3">
						<input type="text" name="tzip" value="<?=$czip?>" id="tzip" class="input_addr"> <input type="button" value="Find Address" class="btn_addr" onclick="javascript:openDaumPostcode2()"><br/><br/>
						<input type="text" name="taddr" value="<?=$caddr?>" id="taddr" class="input_addr01"><br/>
					</td>
				</tr>
				<tr>		
					<th>업태</th>				
					<td>
						<input type="cup" name="tcup" value="<?=$cup?>" class="input_name_tax">
					</td>				
					<th>종목</th>				
					<td>
						<input type="text" name="tcjung" value="<?=$cjung?>" class="input_name_tax">
					</td>
				</tr>				
			</table>
			</div>

			<div class="sp20"></div>

			<div class="view_btn">
				<input type="button" value="취 소" class="cart_btn01" onclick="location.href='./cart.php'">&nbsp;
				<input type="button" value="주문하기" class="cart_btn03" onclick="paygo();">
			</div>
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
