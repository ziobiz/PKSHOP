<? 
include "../include/get_balance.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Kona Summit Platform</title>
<meta http-equiv="X-UA-Compatible" content="IE=EDGE">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../include/css/reset.css" rel="stylesheet" type="text/css" media="all"/>
<link href="../include/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<meta property="og:type" content="website">
<meta property="og:title" content="SISSHOP">
<meta property="og:description" content="명함, 전단지, 봉투, 스티커,리플렛,카달로그등 맞춤디자인">
<meta property="og:image" content="http://www.whyble.net/images/logo.png">
<meta property="og:url" content="http://www.whyble.net">
<meta name="description" content="명함, 전단지, 봉투, 스티커, 리플렛, 카달로그등 맞춤디자인, 고급명함, 배너, 도록, 로고"><meta name="keywords" content="명함,전단지,봉투,스티커,리플렛,카다로그,대전명함,대전명함제작,저렴한명함,대전카탈로그 "/>
<!-- Chrome, Safari, IE -->
<link rel="shortcut icon" href="../images/webicon2.png">
<!-- Firefox, Opera (Chrome and Safari say thanks but no thanks) -->
<link rel="icon" href="../images/webicon2.png">
<?
if($kkpoint1<$usepoint){
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	alert("사용적립금이 보유적립금보다 많습니다. 다시 입력 부탁 드립니다.");
	history.back();
	//-->
	</SCRIPT>
<?
exit;
}
?>

<script type="text/javascript">
<!--
function on_card(){
	var order_form = document.order_form;
	
	order_form.action = "finish.php";	
	order_form.submit();	
}
//-->
</script>

<script language=javascript src="http://www.allthegate.com/plugin/AGSWallet_New.js"></script>   
<script language=javascript>
<!--
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 올더게이트 플러그인 설치를 확인합니다.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


function Pay(form){
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MakePayMessage() 가 호출되면 올더게이트 플러그인이 화면에 나타나며 Hidden 필드
	// 에 리턴값들이 채워지게 됩니다.
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// 입력된 데이타의 유효성을 검사합니다.
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		if(Check_Common(form) == true){

			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// 올더게이트 플러그인 설치가 올바르게 되었는지 확인합니다.
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			if(document.AGSPay == null || document.AGSPay.object == null){
				alert("플러그인 설치 후 다시 시도 하십시오.");
			}else{
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// 올더게이트 플러그인 설정값을 동적으로 적용하기 JavaScript 코드를 사용하고 있습니다.
				// 상점설정에 맞게 JavaScript 코드를 수정하여 사용하십시오.
				//
				// [1] 일반/무이자 결제여부
				// [2] 일반결제시 할부개월수
				// [3] 무이자결제시 할부개월수 설정
				// [4] 인증여부
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [1] 일반/무이자 결제여부를 설정합니다.
				//
				// 할부판매의 경우 구매자가 이자수수료를 부담하는 것이 기본입니다. 그러나,
				// 상점과 올더게이트간의 별도 계약을 통해서 할부이자를 상점측에서 부담할 수 있습니다.
				// 이경우 구매자는 무이자 할부거래가 가능합니다.
				//
				// 예제)
				// 	(1) 일반결제로 사용할 경우
				// 	form.DeviId.value = "9000400001";
				//
				// 	(2) 무이자결제로 사용할 경우
				// 	form.DeviId.value = "9000400002";
				//
				// 	(3) 만약 결제 금액이 100,000원 미만일 경우 일반할부로 100,000원 이상일 경우 무이자할부로 사용할 경우
				// 	if(parseInt(form.Amt.value) < 100000)
				//		form.DeviId.value = "9000400001";
				// 	else
				//		form.DeviId.value = "9000400002";
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				form.DeviId.value = "9000400001";
				
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [2] 일반 할부기간을 설정합니다.
				// 
				// 일반 할부기간은 2 ~ 12개월까지 가능합니다.
				// 0:일시불, 2:2개월, 3:3개월, ... , 12:12개월
				// 
				// 예제)
				// 	(1) 할부기간을 일시불만 가능하도록 사용할 경우
				// 	form.QuotaInf.value = "0";
				//
				// 	(2) 할부기간을 일시불 ~ 12개월까지 사용할 경우
				//		form.QuotaInf.value = "0:3:4:5:6:7:8:9:10:11:12";
				//
				// 	(3) 결제금액이 일정범위안에 있을 경우에만 할부가 가능하게 할 경우
				// 	if((parseInt(form.Amt.value) >= 100000) || (parseInt(form.Amt.value) <= 200000))
				// 		form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
				// 	else
				// 		form.QuotaInf.value = "0";
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				//결제금액이 5만원 미만건을 할부결제로 요청할경우 결제실패
				if(parseInt(form.Amt.value) < 50000)
					form.QuotaInf.value = "0";
				else
					form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
				
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [3] 무이자 할부기간을 설정합니다.
				// (일반결제인 경우에는 본 설정은 적용되지 않습니다.)
				// 
				// 무이자 할부기간은 2 ~ 12개월까지 가능하며, 
				// 올더게이트에서 제한한 할부 개월수까지만 설정해야 합니다.
				// 
				// 100:BC
				// 200:국민
				// 201:NH 
				// 300:외환
				// 310:하나SK
				// 400:삼성
				// 500:신한
				// 800:현대
				// 900:롯데
				// 
				// 예제)
				// 	(1) 모든 할부거래를 무이자로 하고 싶을때에는 ALL로 설정
				// 	form.NointInf.value = "ALL";
				//
				// 	(2) 국민카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
				// 	form.NointInf.value = "200-2:3:4:5:6";
				//
				// 	(3) 외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
				// 	form.NointInf.value = "300-2:3:4:5:6";
				//
				// 	(4) 국민,외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
				// 	form.NointInf.value = "200-2:3:4:5:6,300-2:3:4:5:6";
				//	
				//	(5) 무이자 할부기간 설정을 하지 않을 경우에는 NONE로 설정
				//	form.NointInf.value = "NONE";
				//
				//	(6) 전카드사 특정개월수만 무이자를 하고 싶은경우(2:3:6개월)
				//	form.NointInf.value = "100-2:3:6,200-2:3:6,201-2:3:6,300-2:3:6,310-2:3:6,400-2:3:6,500-2:3:6,800-2:3:6,900-2:3:6";
				//
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				if(form.DeviId.value == "9000400002")
					form.NointInf.value = "ALL";
				   
			MakePayMessage(form);

			}
		}

}

function Enable_Flag(form){
        form.Flag.value = "enable"
}

function Disable_Flag(form){
        form.Flag.value = "disable"
}

function Check_Common(form){
	if(form.StoreId.value == ""){
		alert("상점아이디를 입력하십시오.");
		return false;
	}
	else if(form.StoreNm.value == ""){
		alert("상점명을 입력하십시오.");
		return false;
	}
	else if(form.OrdNo.value == ""){
		alert("주문번호를 입력하십시오.");
		return false;
	}
	else if(form.ProdNm.value == ""){
		alert("상품명을 입력하십시오.");
		return false;
	}
	else if(form.Amt.value == ""){
		alert("금액을 입력하십시오.");
		return false;
	}
	else if(form.MallUrl.value == ""){
		alert("상점URL을 입력하십시오.");
		return false;
	}
	return true;
}

function Display(form){
	if(form.Job.value == "onlycard" || form.TempJob.value == "onlycard"){
		document.all.card_hp.style.display= "";
		document.all.card.style.display= "";
		document.all.hp.style.display= "none";
		document.all.virtual.style.display= "none";
	}else if(form.Job.value == "onlyhp" || form.TempJob.value == "onlyhp"){
		document.all.card_hp.style.display= "";
		document.all.card.style.display= "none";
		document.all.hp.style.display= "";
		document.all.virtual.style.display= "none";
	}else if(form.Job.value == "onlyvirtual" || form.TempJob.value == "onlyvirtual" ){
		document.all.card_hp.style.display= "none";
		document.all.card.style.display= "";
		document.all.hp.style.display= "none";
		document.all.virtual.style.display= "";
	}else if(form.Job.value == "onlyiche" || form.TempJob.value == "onlyiche"  ){
		document.all.card_hp.style.display= "none";
		document.all.card.style.display= "none";
		document.all.hp.style.display= "none";
		document.all.virtual.style.display= "none";
	}else{
		document.all.card_hp.style.display= "";
		document.all.card.style.display= "";
		document.all.hp.style.display= "";
		document.all.virtual.style.display= "";
	}
}
-->
</script>
</head>

<body onload="javascript:Enable_Flag(frmAGS_pay);">
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
				주문서확인
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
	$title = $row_product[6];				$img1 = $row_product[16];	
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
<!-- 이메일 내용-->
<?
$surl = "http://www.whyble.net";
$mail_cont1[$i]="<tr>
	<td class=table_in></td>
	<td class=table_in><img src=$surl/shop_img/$img1 width=100 height=86></td>
	<td class=table_in style=text-align:left;><span style=font-weight:bold;>$title</span><br>";
	if($c_option1!=""){
		$mail_cont1[$i]=$mail_cont1[$i]."[$c_option1]&nbsp;";
	}
	if($c_option2!=""){
		$mail_cont1[$i]=$mail_cont1[$i]."[$c_option2]&nbsp;";
	}
	if($c_option3!=""){
		$mail_cont1[$i]=$mail_cont1[$i]."[$c_option3]&nbsp;";
	}
	if($c_option4!=""){
		$mail_cont1[$i]=$mail_cont1[$i]."[$c_option4]&nbsp;";
	}
	if($c_option5!=""){
		$mail_cont1[$i]=$mail_cont1[$i]."[$c_option5]&nbsp;";
	}
	if($c_option6!=""){
		$mail_cont1[$i]=$mail_cont1[$i]."[$c_option6]&nbsp;";
	}
	if($c_option7!=""){
		$mail_cont1[$i]=$mail_cont1[$i]."[$c_option7]&nbsp;";
	}

	if($c_form_n!=""){
		$mail_cont1[$i]=$mail_cont1[$i]."[$c_form_n]&nbsp;";
	}
	if($c_pro_n!=""){
		$mail_cont1[$i]=$mail_cont1[$i]."[$c_pro_n]&nbsp;";
	}
	if($c_hu_name!=""){
		$mail_cont1[$i]=$mail_cont1[$i]."[$c_hu_name]&nbsp;";
	}

	if($m_money>0){
		$mail_cont1[$i]=$mail_cont1[$i]."[메뉴얼북]&nbsp;";
	}
	if($c_text!=""){
		$mail_cont1[$i]=$mail_cont1[$i]."[$c_text]";
	}
	
$mail_cont1[$i]=$mail_cont1[$i]."</td>
	<td class=table_in>".number_format($money)."원 / $c_amount명<br>옵션가격 : ".number_format($option_money)."</td>
	<td class=table_in>".number_format($sum_point)."원</td>
	<td class=table_in><span style=color:#f26c4f;>".number_format($sum_money)."</span></td>
</tr>
<tr>
	<td colspan=6 class=t_in_line></td>
</tr>";

$mail_cont_tmp[$i]=$mail_cont1[$i];

$mail_cont=$mail_cont.$mail_cont_tmp[$i];

  ?>
<!-- 이메일내용 끝 -->
		
<?
$ii++;
}?>

<?
//기본값 이상이면 무조건 무료
if ($charge_price > $total_money) $charge=$charge;
else $charge=0;

if($code1=="10" || $code1=="01" || $freeshipping == "1"){
	$charge=0;
}

//echo "$charge_price / $total_money / $charge";
$charge_num=$charge;

$total_settle = $total_money + $charge;
if($usepoint==""){
	$usepoint=0;
}
$total_settle_num=$total_settle-$usepoint;
?>	

				
				<tr>
					<td colspan="5" class="cart_price">
						<div class="sp5"></div>
						총계 가격 <span class="c_red font_22"><?=number_format($total_settle)?></span>원&nbsp;&nbsp;&nbsp;(배송비 <?if($charge>0){?><?=number_format($charge)?>원<?}else{?>무료<?}?> 포함)
						<div class="sp5"></div>
					</td>
				</tr>
			</table>

			<div class="sp30"></div>
<!-- 이메일 상단 하단 -->
<? 
$mail_cont_title="
<table>
	<tr>
		<td colspan=6 class=t_line></td>
	</tr>
	<tr>
		<td class=t_title_check></td>
		<td class=t_title_img>상품이미지</td>
		<td class=t_title_info>주문정보</td>
		<td class=t_title_price>가격/인원</td>
		<td class=t_title_point>적립금</td>
		<td class=t_title_total>소계</td>
	</tr>
	<tr>
		<td colspan=6 class=t_line></td>
	</tr>
";


$mail_cont_end="
			<tr>
					<td colspan=6 class=t_line></td>
				</tr>
				<tr>
					<td colspan=6 class=t_total_price style=text-align:right;>총계 <span style=font:bold 20px 'nanum'; color:#f26c4f;>".number_format($total_settle)."</span>원&nbsp;&nbsp;&nbsp;(배송비 ".number_format($charge)."원 포함)</td>
				</tr>
				<tr>
					<td colspan=6 class=t_line></td>
				</tr>
				<tr>
					<td colspan=6 style=height:20px;></td>
				</tr>
			</table>";
$mail_cont=$mail_cont_title.$mail_cont.$mail_cont_end;


?>

<!-- 테이블END -->


<!-- ############ 데이터베이스 입력 ######################################################## -->
<?
//중복 주문삭제
if($connect_check!="ok"){
#####################################################################

// 새로운 주문번호를 생성한다
$result = mysql_query("SELECT max(ordernum) FROM $shop_order",$DBconn);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$row = mysql_fetch_row($result);
if($row[0]) {
	$new_num = $row[0] + 1;
} else {
	$new_num = 10000001;
}

#####################################################################

#####################################################################
if(session_is_registered("valid_user")) {
	$cook_id = $valid_user;				
}
else {
	$cook_id = "g".$new_num;
}

$new_num = $new_num;			//주문번호
$cook_id = $cook_id;			//아이디
$pay_name = $buyername;			//주문자 이름
$pay_zip = $post;				//주문자 우편번호
$pay_addr = $addr1;				//주문자 주소
$pay_tel = $tel1."-".$tel2."-".$tel3;				//주문자 연락처

$htel2=trim($htel2);
$htel3=trim($htel3);

$pay_mobile = $htel1."-".$htel2."-".$htel3;
$pay_email = $email;			//주문자 이메일

$receive_name = $recvname;		//수신자 이름
$receive_zip = $rpost;		//배송지 우편번호
$receive_addr = $raddr1;		//배송지 주소
$receive_tel = $rtel1."-".$rtel2."-".$rtel3;			//수신자 연락처
$receive_mobile = $rhtel1."-".$rhtel2."-".$rhtel3;
$receive_etc = addslashes($receive_etc); //특이사항


$kind = $paymentkind;			//결재종류 무통장:1 , 신용카드:2 , 실시간계좌이체:3, 에스크로 결제:4



//총 적립되는 금액
if($valid_user==""){
	$total_point=0;
}else{
	if($code1=="10"){
		$total_point=0;
	}else{
		$total_point = $total_point;
	}
}

$point = $usepoint;				//쓰이는 적립금 금액

$charge=$charge_num;

$signdate = time();				//주문일자

//주문 데이터베이스에 입력값을 삽입한다.

				$query1="INSERT INTO $shop_order";
				$query1=$query1."(";
				$query1=$query1." ordernum,id,pay_name,pay_tel,pay_mobile,pay_zip,pay_addr,pay_email,receive_name,receive_tel,receive_mobile,receive_zip,receive_addr,receive_email,receive_etc,kind,bank,pointin,pointout,in_name,charge,char_name,char_num,signdate,m_price,p_status,p_name,p_signdate,p_detail,status,c_name,c_signdate,c_detail,approve,transaction,send_no,appr_tm";
				$query1=$query1.")";
				$query1=$query1."VALUES";
				$query1=$query1."(";
				$query1=$query1."'$new_num','$cook_id','$pay_name','$pay_tel','$pay_mobile','$pay_zip','$pay_addr','$pay_email','$receive_name','$receive_tel','$receive_mobile','$receive_zip','$receive_addr','$receive_email','$receive_etc','$kind','$bank_kk','$total_point','$usepoint','$in_name','$charge','$char_name','$char_num','$signdate','$m_price','$p_status','$p_name','$p_signdate','$p_detail','주문대기','$c_name','$c_signdate','$c_detail','$approve','$transaction','$send_no','$appr_tm'";
				$query1=$query1.")";

$result1 = mysql_query($query1,$DBconn);



if(!$result1) {
   error("QUERY_ERROR");
   exit;
}


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
	//echo "$i<br>";
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

	$c_text_f = addslashes($c_text_f);
	$c_text_b = addslashes($c_text_b);
	//echo "$c_code<br>";
	### 상품정보가져오기 ########################################################################
	$query_product = "SELECT No,code1,code2,code3,code4,code,title,info1,info2,info3,c_su,c_du,c_jaks,c_jaes,c_in,c_term,img1,img2,img3,img4,img5,img6,img7,imgb,logo_type,logoimg1,logoimg2,logoimg3,logoimg4,logoimg5,logoimg6,manual,s_text1,s_price1,s_img1,s_text2,s_price2,s_img2,s_text3,s_price3,s_img3,lineimg,option_t1,option_n1,option_p1,option_t2,option_n2,option_p2,option_t3,option_n3,option_p3,option_t4,option_n4,option_p4,option_t5,option_n5,option_p5,option_t6,option_n6,option_p6,option_t7,option_n7,option_p7,amount_t,amount_s,amount_d,etc_t1,etc_s1,etc_t2,etc_s2,etc_t3,etc_s3,hu_dis,point,discount,form_n1,form_t1,form_p1,form_d1,form_n2,form_t2,form_p2,form_d2,form_n3,form_t3,form_p3,form_d3,form_n4,form_t4,form_p4,form_d4,form_n5,form_t5,form_p5,form_d5,sample,pro_n1,pro_t1,pro_p1,pro_d1,pro_n2,pro_t2,pro_p2,pro_d2,pro_n3,pro_t3,pro_p3,pro_d3,pro_n4,pro_t4,pro_p4,pro_d4,pro_n5,pro_t5,pro_p5,pro_d5,signdate,soldout,order1,order2,order3,order4,theme_g,rank_g,t_id,form_n6,form_t6,form_p6,form_d6 FROM $shop_goods WHERE code='$c_code'";

	$result_product = mysql_query($query_product,$DBconn);
	if(!$result_product) {
	   error("QUERY_ERROR");
	   exit;
	}

	$row_product = mysql_fetch_row($result_product);
		
	$code1 = $row_product[1];	$code2 = $row_product[2];
	$title = $row_product[6];				$img1 = $row_product[16];	
	$logoimg6 = $row_product[30];		$manual = $row_product[31];			
	$s_text1 = $row_product[32];		$s_price1 = $row_product[33];	
	$s_img1 = $row_product[34];			$s_text2 = $row_product[35];		
	$s_price2 = $row_product[36];		$s_img2 = $row_product[37];		
	$s_text3 = $row_product[38];		$s_price3 = $row_product[39];
	$option_t1 = $row_product[42];		$option_n1 = $row_product[43];		
	$option_p1 = $row_product[44];		$option_t2 = $row_product[45];	
	$option_n2 = $row_product[46];		$option_p2 = $row_product[47];		
	$option_t3 = $row_product[48];		$option_n3 = $row_product[49];	
	$option_p3 = $row_product[50];		$option_t4 = $row_product[51];		
	$option_n4 = $row_product[52];		$option_p4 = $row_product[53];	
	$option_t5 = $row_product[54];		$option_n5 = $row_product[55];		
	$option_p5 = $row_product[56];		$option_t6 = $row_product[57];	
	$option_n6 = $row_product[58];		$option_p6 = $row_product[59];		
	$option_t7 = $row_product[60];		$option_n7 = $row_product[61];	
	$option_p7 = $row_product[62];		$point = $row_product[73];	
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

	//후가공가격	
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

	if($code1=="10" || $code1=="01"){
		$charge=0;
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


//데이터베이스에 입력값을 삽입한다.

	$query_sell="INSERT INTO $shop_sell ";
	$query_sell=$query_sell."(";
	$query_sell=$query_sell."No,ordernum,title,money,point,code1,code2,code3,code4,code,c_type,c_hangul,c_english,c_homepage,c_up,c_ju,c_color,c_company,c_manual,c_text,c_option1,c_option2,c_option3,c_option4,c_option5,c_option6,c_option7,c_amount,c_form_n,c_sample,c_pro_n,c_text_f,c_text_b,c_fname,c_webhard,c_talk,c_hu_name,c_hu_price,detail,fname1,fname2,a_detail,c_status,name,signdate";
	$query_sell=$query_sell.")";
	$query_sell=$query_sell."VALUES";
	$query_sell=$query_sell."(";
	$query_sell=$query_sell."'','$new_num','$title','$sum_money','$sum_point','$code1','$code2','$code3','$code4','$c_code','$c_type','$c_hangul','$c_english','$c_homepage','$c_up','$c_ju','$c_color','$c_company','$c_manual','$c_text','$c_option1','$c_option2','$c_option3','$c_option4','$c_option5','$c_option6','$c_option7','$c_amount','$c_form_n','$c_sample','$c_pro_n','$c_text_f','$c_text_b','$c_fname','$c_webhard','$c_talk','$c_hu_name','$c_hu_price','$detail','$fname1','$fname2','$a_detail','$c_status','','$signdate'";
	$query_sell=$query_sell.")";

	$result_sell = mysql_query($query_sell,$DBconn);
   $title_11111=$title_11111.$title;
	if (!$result_sell) {
   		error("QUERY_ERROR");
   		exit;
	}

$ii++;
}


#### 세금계산서 입력 ##########################################################

if($o_tax_type=="2"){
	$tsigndate = time();
	$tdis=5;
	if($valid_user==""){
		$tid="비회원";
	}else{
		$tid=$valid_user;
	}

	//데이터베이스에 입력값을 삽입한다
	$query="INSERT INTO $m_tax";
	$query=$query."(";
	$query=$query."No,tid,tname,tnumber,tordernum,tcompany,temail,tzip,taddr,tcup,tcjung,tkind,tprice,tcharge,tdis,tsigndate";
	$query=$query.")";
	$query=$query."VALUES";
	$query=$query."(";
	$query=$query."'','$tid','$tname','$tnumber','$new_num','$tcompany','$temail','$tzip','$taddr','$tcup','$tcjung','$kind','$total_money','$charge_num','$tdis','$tsigndate'";
	$query=$query.")";
	

	$result = mysql_query($query,$DBconn);
	if(!$result) {
		error("QUERY_ERROR");
			exit;
	} 

	$Rs=mysql_fetch_array(mysql_query("select max(No) as No from $m_tax")); 
	$T_No = $Rs[No];

}

### 메일관련 함수 ###################################
include "../include/shtml.htm"; //고객에게 보낼 내용
include "../include/shtml1.htm"; //관리자에게 보낼 내용

//$r_mail = "deholic@nate.com"; //반송용
$r_mail="whyble@whyble.net"; //테스트메일

$rname="SISSHOP";
$rname_tmp = '=?utf-8?B?'.$rname_en=base64_encode( $rname ).'?=';

$smail=$pay_email;
$hh="From: $rname_tmp<$r_mail>\nContent-type: text/html;charset=utf-8";
$stitle="$pay_name 님의 주문이 접수 되었습니다. "; 
$stitle = '=?utf-8?B?'.base64_encode( $stitle ).'?=';


//mail($smail,$stitle,$shtml,$hh);

//$smail1="deholic@nate.com";
$smail1="whyble@whyble.net"; //테스트메일

$hh1="From: $rname_tmp<$r_mail>\nContent-type: text/html;charset=utf-8"; 
$stitle1="$pay_name 님의 주문이 접수되었습니다.";
$stitle1 = '=?utf-8?B?'.base64_encode( $stitle1 ).'?=';
$shtml = '=?utf-8?B?'.base64_encode( $shtml ).'?=';

//mail($smail1,$stitle1,$shtml,$hh1); 

### 상품명 자르기 #############################################
$Title=$title_11111;
If(strlen($Title)>80){
	$klen=80-1;
	while(ord($Title[$klen]) & 0x80) {$klen--;}
	$Title=substr($Title,0,80-((80+$klen+1)%2))."...";
}else{
	$Title=$Title;
}

}
?>	

<?if($paymentkind=="1"){?>
	<form name="frmTofinish" method="post" action="overview.php">
		<!-- 고객 -->
		<input type="hidden" name="smail" value="<?=$smail?>">
		<input type="hidden" name="stitle" value="<?=$stitle?>">
		<input type="hidden" name="shtml" value="<?=$shtml?>">
		<input type="hidden" name="hh" value="<?=$hh?>">
		<!-- 관리자 -->
		<input type="hidden" name="smail1" value="<?=$smail1?>">
		<input type="hidden" name="stitle1" value="<?=$stitle1?>">
		<input type="hidden" name="shtml1" value="<?=$shtml1?>">
		<input type="hidden" name="hh1" value="<?=$hh1?>">
		<input type="hidden" name="order_num" value="<?=$new_num?>">
		<input type="hidden" name="usepoint" value="<?=$usepoint?>">
		<input type="hidden" name="signdate" value="<?=$signdate?>">
		<input type="hidden" name="paymentkind" value="<?=$paymentkind?>">
		<input type="hidden" name="o_tax_type" value="<?=$o_tax_type?>">
		<input type="hidden" name="T_No" value="<?=$T_No?>">

         <!-- 결제정보END -->

		<div class="view_btn">
			<input type="button" value="주문내역" class="cart_btn03" onclick="location.href='./overview.php'">
		</div>
		<div class="sp20"></div>

	<?
	
	//중복 주문처리
	if($connect_check!="ok"){
	//주문상태변경
	$query_order="update $shop_order set ";
	$query_order=$query_order."status='접수대기' ";
	$query_order=$query_order."where ordernum='$new_num'";
	
	$result_order = mysql_query($query_order,$DBconn);

	if(!$result_order) {
		error("QUERY_ERROR");
		exit;
	}
	
	//포인트 삭제
	if($valid_user!=""){
		$Signdate_kk = date("Y-m-d h:i:s",$signdate); 
		$Cont = "제품구매 포인트[주문번호:$new_num 주문일:$Signdate_kk]";
		$query="insert into $shop_point values";
		$query=$query."(";
		$query=$query."''"; #no 값이 들어 간다...자동 증가.
		$query=$query.",'$valid_user'";
		$query=$query.",'$Cont'";
		$query=$query.",'-$usepoint'";
		$query=$query.",'$signdate'";
		$query=$query.",'$signdate'";
		$query=$query.")";

		if($usepoint>0) $result = mysql_query($query);
	}
	

	//세금계산서상태변경
	if($o_tax_type=="2" && $T_No!=""){			
		$query_t="update $m_tax set ";
		$query_t=$query_t."tdis='0' ";
		$query_t=$query_t."where No='$T_No'";

		$result_t = mysql_query($query_t,$DBconn);

		if(!$result_t) {
			error("QUERY_ERROR");
			exit;
		}
	}

	//mail($smail,$stitle,$shtml,$hh);
	//mail($smail1,$stitle1,$shtml1,$hh1); 
	

	##### 문자발송 ##############################################################

		/*
		$query="SELECT pay_name,pay_mobile,receive_mobile";
		$query=$query." FROM ";
		$query=$query." $shop_order WHERE ordernum='$new_num'";
		$result = mysql_query($query,$DBconn);		
			
			if(!$result) {
			error("QUERY_ERROR");
			exit;
			}
			$row = mysql_fetch_row($result);
			
			$pay_name = $row[0];		
			$pay_mobile = $row[1];		
			$receive_mobile = $row[2];

			$receive_mobile = str_replace(",", "", $receive_mobile);
			$receive_mobile = str_replace(".", "", $receive_mobile);
			$receive_mobile = str_replace(" ", "", $receive_mobile);
			$receive_mobile = str_replace("-", "", $receive_mobile);

		include "../class.http.php";
		include "../class.EmmaSMS.php";


		$sms_id = "whyble";
		$sms_passwd = "w030519@";
		$sms_type = "L";
		$sms_to = $receive_mobile;
		$sms_from = "1577-5063";
		$sms_date = 0;
		$sms_msg = $pay_name."님 주문해 주셔서 감사합니다. 주문번호는 ".$order_num." 입니다.
	
		-SISSHOP-";

		$sms = new EmmaSMS();
		$sms->login($sms_id, $sms_passwd);
		$ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date, $sms_type);
		*/

	######################################################################################
	//주문완료 후 삭제
	$c_ip=$_SERVER["REMOTE_ADDR"]; 

	$query = "DELETE from $shop_cart where c_ip='$c_ip'";
		$result = mysql_query($query,$DBconn);
		if(!$result) {
			error("QUERY_ERROR");
			exit;
		}
	}
	?>
	</form>
<?}else if($paymentkind=="2"){ //신용카드?>

<?
//*******************************************************************************
// MD5 결제 데이터 암호화 처리
// 형태 : 상점아이디(StoreId) + 주문번호(OrdNo) + 결제금액(Amt)
//*******************************************************************************


////////주문번호 생성////////////////
$StoreId 	= "whyble";
$OrdNo 		= $new_num;
$amt 		= $total_settle_num;

//$StoreId 	= "aegis"; ////테스트 아이디////
//$OrdNo 		= $Order_Num;
$ProdNm = "whyble";   ///상품명

$rpost2=$rpost."/".$raddr1; ///받는분 주소


$rhtel00 = $rhtel1."-".$rhtel2."-".$rhtel3;  ///받는분 핸드폰 번호
$htel00 = $htel1."-".$htel2."-".$htel3; ////주문자 핸드폰 번호



$AGS_HASHDATA = md5($StoreId . $OrdNo . $amt); 

/////

?>
<form name=frmAGS_pay method=post action="AGS_pay_ing.php">
<!-- 				2) 본 페이지에서는 올더게이트 플러그인을 다운로드하여 설치하도록 되어 있습니다. 다운로드후에  <font color=#006C6C>보안경고창이 뜨면 확인 버튼("예")을 선택하여</font> 플러그인을 설치해 주십시오. 만약 설치에 실패하였을 경우 수동으로 <a href="http://www.allthegate.com/plugin/AGSPayPluginV10.exe"><font color=#006C6C>다운로드</font></a>하여 설치해 주십시오.<br> -->
<input type=hidden name=Job value="onlycard"> 
<!--상점아이디를 실거래 전환후에는 발급받은 아이디로 바꾸시기 바랍니다.-->
<input type=hidden style=width:100px name=StoreId maxlength=20 value=<?=$StoreId?>>
<input type=hidden style=width:100px name=OrdNo maxlength=40 value=<?=$OrdNo?>>
<input type=hidden style=width:100px name=Amt maxlength=12 value=<?=$amt?>>
<input type=hidden style=width:300px name=StoreNm value="SISSHOP">
<input type=hidden style=width:300px name=ProdNm maxlength=300 value=<?=$Title?>>
<!-- 주의) 상점홈페이지주소를 반드시 입력해 주십시오. -->
<!-- (미입력시 특정 카드사 신용카드 결제 및 가상계좌 결제가 이뤄지지 않을 수 있습니다.) -->
<input type=hidden style=width:300px name=MallUrl value="http://whyble.net/">
<input type=hidden style=width:300px name=UserEmail maxlength=50 value=<?=$email?>>
<!-- 결제창 좌측상단에 상점의 로고이미지(85 * 38)를 표시할 수 있습니다. -->
<!-- 잘못된 값을 입력하거나 미입력시 이지스올더게이트의 로고가 표시됩니다. -->
<input type=hidden style=width:400px name=ags_logoimg_url maxlength=200 value="http://www.arthub.co.kr/images/top_logo.jpg">

<input type=hidden style=width:300px name=SubjectData value="SISSHOP;판매상품;계산금액;">
<!-- [신용카드, 핸드폰] 결제와 [현금영수증자동발행]을 사용하시는 경우에 반드시 입력해 주시기 바랍니다. -->
<input type=hidden style=width:100px name=UserId maxlength=20 value=<?=$cook_id?>>
<input type=hidden style=width:100px name=OrdNm maxlength=40 value=<?=$buyername?>>
<input type=hidden style=width:100px name=OrdPhone maxlength=21 value=<?=$htel00?>>
<input type=hidden style=width:300px name=OrdAddr maxlength=100 value=<?=$rpost2?>>
<input type=hidden style=width:100px name=RcpNm maxlength=40 value=<?=$recvname?>>
<input type=hidden style=width:100px name=RcpPhone maxlength=21 value=<?=$rhtel00?>>
<input type=hidden style=width:300px name=DlvAddr maxlength=100 value=<?=$rpost2?>>

<input type=hidden style=width:300px name=Remark maxlength=350 value="오후에 배송요망">

<input type=hidden style=width:300px name=CardSelect value="">
<!-- 결제창에 특정카드만 표기기능입니다. 
		  사용방법 예)  BC, 국민을 사용하고자 하는 경우 ☞ 100:200
						국민 만 사용하고자 하는 경우 ☞ 200
	 모두 사용하고자 할 때에는 아무 값도 입력하지 않습니다.
	 카드사별 코드는 매뉴얼에서 확인해 주시기 바랍니다. -->
			
<!-- 스크립트 및 플러그인에서 값을 설정하는 Hidden 필드  !!수정을 하시거나 삭제하지 마십시오-->
<!-- 적립금 사용포인트 넘겨주기  -->
<input type=hidden name=usepoint value=<?=$usepoint?>>
<input type=hidden name=Signdate_kk2 value=<?=$Signdate_kk?>>
<input type=hidden name=paymentkind value=<?=$paymentkind?>>
<!-- 각 결제 공통 사용 변수 -->
<input type=hidden name=Flag value="">				<!-- 스크립트결제사용구분플래그 -->
<input type=hidden name=AuthTy value="">			<!-- 결제형태 -->
<input type=hidden name=SubTy value="">				<!-- 서브결제형태 -->
<input type=hidden name=AGS_HASHDATA value="<?=$AGS_HASHDATA?>">	<!-- 암호화 HASHDATA -->

<!-- 신용카드 결제 사용 변수 -->
<input type=hidden name=DeviId value="">			<!-- (신용카드공통)		단말기아이디 -->
<input type=hidden name=QuotaInf value="0">			<!-- (신용카드공통)		일반할부개월설정변수 -->
<input type=hidden name=NointInf value="NONE">		<!-- (신용카드공통)		무이자할부개월설정변수 -->
<input type=hidden name=AuthYn value="">			<!-- (신용카드공통)		인증여부 -->
<input type=hidden name=Instmt value="">			<!-- (신용카드공통)		할부개월수 -->
<input type=hidden name=partial_mm value="">		<!-- (ISP사용)			일반할부기간 -->
<input type=hidden name=noIntMonth value="">		<!-- (ISP사용)			무이자할부기간 -->
<input type=hidden name=KVP_RESERVED1 value="">		<!-- (ISP사용)			RESERVED1 -->
<input type=hidden name=KVP_RESERVED2 value="">		<!-- (ISP사용)			RESERVED2 -->
<input type=hidden name=KVP_RESERVED3 value="">		<!-- (ISP사용)			RESERVED3 -->
<input type=hidden name=KVP_CURRENCY value="">		<!-- (ISP사용)			통화코드 -->
<input type=hidden name=KVP_CARDCODE value="">		<!-- (ISP사용)			카드사코드 -->
<input type=hidden name=KVP_SESSIONKEY value="">	<!-- (ISP사용)			암호화코드 -->
<input type=hidden name=KVP_ENCDATA value="">		<!-- (ISP사용)			암호화코드 -->
<input type=hidden name=KVP_CONAME value="">		<!-- (ISP사용)			카드명 -->
<input type=hidden name=KVP_NOINT value="">			<!-- (ISP사용)			무이자/일반여부(무이자=1, 일반=0) -->
<input type=hidden name=KVP_QUOTA value="">			<!-- (ISP사용)			할부개월 -->
<input type=hidden name=CardNo value="">			<!-- (안심클릭,일반사용)	카드번호 -->
<input type=hidden name=MPI_CAVV value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
<input type=hidden name=MPI_ECI value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
<input type=hidden name=MPI_MD64 value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
<input type=hidden name=ExpMon value="">			<!-- (일반사용)			유효기간(월) -->
<input type=hidden name=ExpYear value="">			<!-- (일반사용)			유효기간(년) -->
<input type=hidden name=Passwd value="">			<!-- (일반사용)			비밀번호 -->
<input type=hidden name=SocId value="">				<!-- (일반사용)			주민등록번호/사업자등록번호 -->

<!-- 계좌이체 결제 사용 변수 -->
<input type=hidden name=ICHE_OUTBANKNAME value="">	<!-- 이체계좌은행명 -->
<input type=hidden name=ICHE_OUTACCTNO value="">	<!-- 이체계좌예금주주민번호 -->
<input type=hidden name=ICHE_OUTBANKMASTER value=""><!-- 이체계좌예금주 -->
<input type=hidden name=ICHE_AMOUNT value="">		<!-- 이체금액 -->

<!-- 핸드폰 결제 사용 변수 -->
<input type=hidden name=HP_SERVERINFO value="">		<!-- 서버정보 -->
<input type=hidden name=HP_HANDPHONE value="">		<!-- 핸드폰번호 -->
<input type=hidden name=HP_COMPANY value="">		<!-- 통신사명(SKT,KTF,LGT) -->
<input type=hidden name=HP_IDEN value="">			<!-- 인증시사용 -->
<input type=hidden name=HP_IPADDR value="">			<!-- 아이피정보 -->

<!-- ARS 결제 사용 변수 -->
<input type=hidden name=ARS_PHONE value="">			<!-- ARS번호 -->
<input type=hidden name=ARS_NAME value="">			<!-- 전화가입자명 -->

<!-- 가상계좌 결제 사용 변수 -->
<input type=hidden name=ZuminCode value="">			<!-- 가상계좌입금자주민번호 -->
<input type=hidden name=VIRTUAL_CENTERCD value="">	<!-- 가상계좌은행코드 -->
<input type=hidden name=VIRTUAL_NO value="">		<!-- 가상계좌번호 -->

<input type=hidden name=mTId value="">	

<!-- 에스크로 결제 사용 변수 -->
<input type=hidden name=ES_SENDNO value="">			<!-- 에스크로전문번호 -->

<!-- 계좌이체(소켓) 결제 사용 변수 -->
<input type=hidden name=ICHE_SOCKETYN value="">		<!-- 계좌이체(소켓) 사용 여부 -->
<input type=hidden name=ICHE_POSMTID value="">		<!-- 계좌이체(소켓) 이용기관주문번호 -->
<input type=hidden name=ICHE_FNBCMTID value="">		<!-- 계좌이체(소켓) FNBC거래번호 -->
<input type=hidden name=ICHE_APTRTS value="">		<!-- 계좌이체(소켓) 이체 시각 -->
<input type=hidden name=ICHE_REMARK1 value="">		<!-- 계좌이체(소켓) 기타사항1 -->
<input type=hidden name=ICHE_REMARK2 value="">		<!-- 계좌이체(소켓) 기타사항2 -->
<input type=hidden name=ICHE_ECWYN value="">		<!-- 계좌이체(소켓) 에스크로여부 -->
<input type=hidden name=ICHE_ECWID value="">		<!-- 계좌이체(소켓) 에스크로ID -->
<input type=hidden name=ICHE_ECWAMT1 value="">		<!-- 계좌이체(소켓) 에스크로결제금액1 -->
<input type=hidden name=ICHE_ECWAMT2 value="">		<!-- 계좌이체(소켓) 에스크로결제금액2 -->
<input type=hidden name=ICHE_CASHYN value="">		<!-- 계좌이체(소켓) 현금영수증발행여부 -->
<input type=hidden name=ICHE_CASHGUBUN_CD value="">	<!-- 계좌이체(소켓) 현금영수증구분 -->
<input type=hidden name=ICHE_CASHID_NO value="">	<!-- 계좌이체(소켓) 현금영수증신분확인번호 -->

<!-- 텔래뱅킹-계좌이체(소켓) 결제 사용 변수 -->
<input type=hidden name=ICHEARS_SOCKETYN value="">	<!-- 텔레뱅킹계좌이체(소켓) 사용 여부 -->
<input type=hidden name=ICHEARS_ADMNO value="">		<!-- 텔레뱅킹계좌이체 승인번호 -->
<input type=hidden name=ICHEARS_POSMTID value="">	<!-- 텔레뱅킹계좌이체 이용기관주문번호 -->
<input type=hidden name=ICHEARS_CENTERCD value="">	<!-- 텔레뱅킹계좌이체 은행코드 -->
<input type=hidden name=ICHEARS_HPNO value="">		<!-- 텔레뱅킹계좌이체 휴대폰번호 -->
<!-- 스크립트 및 플러그인에서 값을 설정하는 Hidden 필드  !!수정을 하시거나 삭제하지 마십시오-->

		<div class="view_btn">
			<input type="button" value="결재하기" class="cart_btn03" onclick="javascript:Pay(frmAGS_pay);">
		</div>
		<div class="sp20"></div>

	</form>
<?}else if($paymentkind=="3"){ //계좌이체?>
	<form name="order_form" method="post">				
		
		<!-- 고객 -->
		<input type="hidden" name="smail" value="<?=$smail?>">
		<input type="hidden" name="stitle" value="<?=$stitle?>">
		<input type="hidden" name="shtml" value="<?=$shtml?>">
		<input type="hidden" name="hh" value="<?=$hh?>">
		<!-- 관리자 -->
		<input type="hidden" name="smail1" value="<?=$smail1?>">
		<input type="hidden" name="stitle1" value="<?=$stitle1?>">
		<input type="hidden" name="shtml1" value="<?=$shtml1?>">
		<input type="hidden" name="hh1" value="<?=$hh1?>">
		<input type="hidden" name="order_num" value="<?=$new_num?>">
		<input type="hidden" name="usepoint" value="<?=$usepoint?>">
		<input type="hidden" name="signdate" value="<?=$signdate?>">
		<input type="hidden" name="paymentkind" value="<?=$paymentkind?>">
		<input type="hidden" name="o_tax_type" value="<?=$o_tax_type?>">
		<input type="hidden" name="T_No" value="<?=$T_No?>">

		<div class="view_btn">
			<input type="button" value="결재하기" class="cart_btn03" onclick="on_card();">
		</div>
		<div class="sp20"></div>

	</form>
<?}else{?>
	<form name="order_form" method="post">				
		
		<!-- 고객 -->
		<input type="hidden" name="smail" value="<?=$smail?>">
		<input type="hidden" name="stitle" value="<?=$stitle?>">
		<input type="hidden" name="shtml" value="<?=$shtml?>">
		<input type="hidden" name="hh" value="<?=$hh?>">
		<!-- 관리자 -->
		<input type="hidden" name="smail1" value="<?=$smail1?>">
		<input type="hidden" name="stitle1" value="<?=$stitle1?>">
		<input type="hidden" name="shtml1" value="<?=$shtml1?>">
		<input type="hidden" name="hh1" value="<?=$hh1?>">
		<input type="hidden" name="order_num" value="<?=$new_num?>">
		<input type="hidden" name="usepoint" value="<?=$usepoint?>">
		<input type="hidden" name="signdate" value="<?=$signdate?>">
		<input type="hidden" name="paymentkind" value="<?=$paymentkind?>">
		<input type="hidden" name="o_tax_type" value="<?=$o_tax_type?>">
		<input type="hidden" name="T_No" value="<?=$T_No?>">

		<div class="view_btn">
			<input type="button" value="결재하기" class="cart_btn03" onclick="on_card();">
		</div>
		<div class="sp20"></div>

	</form>
<?}?>

<?
//중복 실행 방지 
$connect_check="ok";
session_register("connect_check");
?>

			<div class="order_table_title">
				주문하시는 분
			</div>

			<table class="order_table">
				<tr>
					<th width="18%">이 름</th>
					<td width="78%"><?=$buyername?></td>
				</tr>
				<tr>
					<th>주 소</th>
					<td><?=$post?>&nbsp;&nbsp;<br/>
					<?=$addr1?>
					</td>
				</tr>
				<tr>
					<th>핸드폰</th>
					<td><?=$htel1?>&nbsp;-&nbsp;<?=$htel2?>&nbsp;-&nbsp;<?=$htel3?></td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td><?=$tel1?>&nbsp;-&nbsp;<?=$tel2?>&nbsp;-&nbsp;<?=$tel3?></td>
				</tr>
				<tr>
					<th>E-Mail</th>
					<td><?=$email?></td>
				</tr>
				
			</table>

			<div class="sp30"></div>

			<div class="order_table_title">
				받으시는 분&nbsp;&nbsp;
			</div>

			<table class="order_table">
				<tr>
					<th width="18%">이 름</th>
					<td width="78%"><?=$recvname?></td>
				</tr>
				<tr>
					<th>주 소</th>
					<td>
						<?=$rpost?>&nbsp;&nbsp;<br/>
						<?=$raddr1?>
					</td>
				</tr>
				<tr>
					<th>핸드폰</th>
					<td><?=$rhtel1?>&nbsp;-&nbsp;<?=$rhtel2?>&nbsp;-&nbsp;<?=$rhtel3?></td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td><?=$rtel1?>&nbsp;-&nbsp;<?=$rtel2?>&nbsp;-&nbsp;<?=$rtel3?></td>
				</tr>
				
				<tr>
					<th class="align_top">전하실 말</th>
					<td><?=$receive_etc?>			
					</td>
				</tr>
			</table>

			<div class="sp30"></div>

			<div class="order_table_title">
				결제정보
			</div>

			<table class="order_table">
				<?if($usepoint>0){?>
				<tr>
					<th width="18%">적립금 사용</th>
					<td width="78%"><?=$usepoint?></td>
				</tr>
				<?}?>
				<tr>
					<th width="18%">결제수단</th>
					<td width="78%"><?if($paymentkind=="1"){?>
						무통장입금
						<?}else if($paymentkind=="2"){?>
						신용카드
						<?}else if($paymentkind=="3"){?>
						실시간계좌이체
						<?}else{?>
						에스크로 결제
						<?}?></td>
				</tr>

				<?if($paymentkind=="1"){?>
				<tr>
					<th></th>
					<td><span class="font_b">입금자명</span>&nbsp;&nbsp;<?=$in_name?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span class="font_b">입금계좌</span>&nbsp;&nbsp;
						<?=$bank_kk?>					
					</td>
				</tr>	
				<?}?>
			
				<tr>
					<th>세금계산서</th>
					<td>
						<?if($paymentkind=="2"){?>
						신용카드결제 후 영수증을 출력하셔서 세무자료로 이용하실 수 있습니다
						<?}else{?>
							<?if($o_tax_type=="1"){?>
							미발행
							<?}else{?>
							발행
							<?}?>
						<?}?>					
					</td>
				</tr>					
			</table>

			<div class="sp20"></div>
			
			<?if($o_tax_type=="2"){?>
			<div class="order_table_title">
				회사정보 입력
			</div>

			<table class="order_table">
				<tr>
					<th width="18%">회사명</th>
					
					<td width="32%"><?=$tcompany?></td>
					<th width="18%">사업자등록번호</th>
					
					<td width="32%">
						<?=$tnumber?>
					</td>

				</tr>
		
				<tr>
					<th>대표자명</th>					
					<td><?=$tname?></td>
					<th>수신이메일</th>				
					<td>
						<?=$temail?>
					</td>
				</tr>				
				<tr>
					<th>주소</th>			
					<td colspan="3">
						<?=$tzip?><br/><br/>
						<?=$taddr?><br/>
					</td>
				</tr>
				<tr>		
					<th>업태</th>				
					<td>
						<?=$tcup?>
					</td>				
					<th>종목</th>				
					<td>
						<?=$tcjung?>
					</td>
				</tr>				
			</table>
			
			<div class="sp20"></div>
			<?}?>

			

		</div>			
			
	</div>
	<!-- 컨텐츠 종료 -->


	<!-- 하단(Copy) -->

	 
	  <? include "../include/bottom.html"; ?>	  
				
				
	<!-- 하단(Copy) -->

	


</div>
</body>
<script type="text/javascript" src="https://www.allthegate.com/plugin/jquery-1.11.1.js"></script>
<script type="text/javascript" src="https://www.allthegate.com/payment/webPay/js/ATGClient_new.js"></script>

</html>


