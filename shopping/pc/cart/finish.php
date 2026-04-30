<? include "../include/top_session.php";
	include "../../Adm/common/dbconn.php";?>
<? 

$_SESSION['session_cart']="";
$session_cart="";

$session_cart_selected="";
//include "../include/login_check.php";
mysql_query("delete from $shop_cart  where cart_id='$valid_user' "); 


//echo "1 $connect_check_point";
?>

<?php
/**********************************************************************************************
*
* 파일명 : AGS_pay_result.php
* 작성일자 : 2016/10/11
*
* 소켓결제결과를 처리합니다.
*
* Copyright NICEPayments.Co.,Ltd. All rights reserved.
*
**********************************************************************************************/

//공통사용
$AuthTy 		= trim( $_POST["AuthTy"] );				//결제형태
$SubTy 			= trim( $_POST["SubTy"] );				//서브결제형태
$rStoreId 		= trim( $_POST["rStoreId"] );			//업체ID
$rAmt 			= trim( $_POST["rAmt"] );				//거래금액
$rOrdNo 		= trim( $_POST["rOrdNo"] );				//주문번호
$rProdNm 		= trim( $_POST["rProdNm"] );			//상품명
$rOrdNm			= trim( $_POST["rOrdNm"] );				//주문자명

//소켓통신결제(신용카드,핸드폰,일반가상계좌)시 사용
$rSuccYn 		= trim( $_POST["rSuccYn"] );			//성공여부
$rResMsg 		= trim( $_POST["rResMsg"] );			//실패사유
$rApprTm 		= trim( $_POST["rApprTm"] );			//승인시각

//신용카드공통
$rBusiCd 		= trim( $_POST["rBusiCd"] );			//전문코드
$rApprNo 		= trim( $_POST["rApprNo"] );			//승인번호
$rCardCd 		= trim( $_POST["rCardCd"] );			//카드사코드
$rDealNo 		= trim( $_POST["rDealNo"] );			//거래고유번호

//신용카드(안심,일반)
$rCardNm 		= trim( $_POST["rCardNm"] );			//카드사명
$rMembNo 		= trim( $_POST["rMembNo"] );			//가맹점번호
$rAquiCd 		= trim( $_POST["rAquiCd"] );			//매입사코드
$rAquiNm 		= trim( $_POST["rAquiNm"] );			//매입사명


//계좌이체
$ICHE_OUTBANKNAME	= trim( $_POST["ICHE_OUTBANKNAME"] );		//이체계좌은행명
$ICHE_OUTACCTNO 	= trim( $_POST["ICHE_OUTACCTNO"] );			//이체계좌번호
$ICHE_OUTBANKMASTER = trim( $_POST["ICHE_OUTBANKMASTER"] );		//이체계좌소유주
$ICHE_AMOUNT 		= trim( $_POST["ICHE_AMOUNT"] );			//이체금액

//핸드폰
$rHP_TID 		= trim( $_POST["rHP_TID"] );			//핸드폰결제TID
$rHP_DATE 		= trim( $_POST["rHP_DATE"] );			//핸드폰결제날짜
$rHP_HANDPHONE 	= trim( $_POST["rHP_HANDPHONE"] );		//핸드폰결제핸드폰번호
$rHP_COMPANY 	= trim( $_POST["rHP_COMPANY"] );		//핸드폰결제통신사명(SKT,KTF,LGT)

//ARS
$rARS_PHONE = trim( $_POST["rARS_PHONE"] );				//ARS결제전화번호

//가상계좌
$rVirNo 		= trim( $_POST["rVirNo"] );				//가상계좌번호 가상계좌추가
$VIRTUAL_CENTERCD = trim( $_POST["VIRTUAL_CENTERCD"] );	//가상계좌 입금은행코드

//에스크로
$ES_SENDNO	= trim( $_POST["ES_SENDNO"] );				//에스크로(전문번호)

//*******************************************************************************
//* MD5 결제 데이터 정상여부 확인
//* 결제전 AGS_HASHDATA 값과 결제 후 rAGS_HASHDATA의 일치 여부 확인
//* 형태 : 상점아이디(StoreId) + 주문번호(OrdNo) + 결제금액(Amt)
//*******************************************************************************

$AGS_HASHDATA	= trim( $_POST["AGS_HASHDATA"] );				
$rAGS_HASHDATA	= md5($rStoreId . $rOrdNo . (int)$rAmt);				

if($AGS_HASHDATA == $rAGS_HASHDATA){
	$errResMsg   = "";
}else{
	$errResMsg   = "결재금액 변조 발생. 확인 바람";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
HCBRS
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../include/css/reset.css" rel="stylesheet" type="text/css" media="all"/>
<link href="../include/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="../include/reset.css" rel="stylesheet" type="text/css" media="all"/>
<link href="../include/style.css" rel="stylesheet" type="text/css" media="all"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<meta property="og:type" content="website">
<meta property="og:title" content="CFWORLD MALL">
<meta property="og:description" content="명함, 전단지, 봉투, 스티커,리플렛,카달로그등 맞춤디자인">
<meta property="og:image" content="http://www.whyble.net/images/logo.png">
<meta property="og:url" content="http://www.whyble.net">
<meta name="description" content="명함, 전단지, 봉투, 스티커, 리플렛, 카달로그등 맞춤디자인, 고급명함, 배너, 도록, 로고"><meta name="keywords" content="명함,전단지,봉투,스티커,리플렛,카다로그,대전명함,대전명함제작,저렴한명함,대전카탈로그 "/>
<!-- Chrome, Safari, IE -->
<link rel="shortcut icon" href="../images/webicon2.png">
<!-- Firefox, Opera (Chrome and Safari say thanks but no thanks) -->
<link rel="icon" href="../images/webicon2.png">
<script language=javascript> // "지불처리중" 팝업창 닫기
<!--
var openwin = window.open("AGS_progress.php","popup","width=300,height=160");
openwin.close();
-->
</script>
<script language=javascript>
<!--
/***********************************************************************************
* ◈ 영수증 출력을 위한 자바스크립트
*		
*	영수증 출력은 [카드결제]시에만 사용하실 수 있습니다.
*  
*   ※당일 결제건에 한해서 영수증 출력이 가능합니다.
*     당일 이후에는 아래의 주소를 팝업(630X510)으로 띄워 내역 조회 후 출력하시기 바랍니다.
*	  ▷ 팝업용 결제내역조회 패이지 주소 : 
*	     	 http://www.allthegate.com/support/card_search.php
*		→ (반드시 스크롤바를 'yes' 상태로 하여 팝업을 띄우시기 바랍니다.) ←
*
***********************************************************************************/
function show_receipt() 
{
	if("<?=$rSuccYn?>"== "y" && "<?=$AuthTy?>"=="card")
	{
		var send_dt = appr_tm.value;
		
		url="http://www.allthegate.com/customer/receiptLast3.jsp"
		url=url+"?sRetailer_id="+sRetailer_id.value;
		url=url+"&approve="+approve.value;
		url=url+"&send_no="+send_no.value;
		url=url+"&send_dt="+send_dt.substring(0,8);
		
		window.open(url, "window","toolbar=no,location=no,directories=no,status=,menubar=no,scrollbars=no,resizable=no,width=420,height=700,top=0,left=150");
	}
	else
	{
		alert("해당하는 결제내역이 없습니다");
	}
}
-->
</script>
</head>

<body>
<div id="wrap">	

	<!-- 상단(Top) -->

	 
	  <? include "../include/top.php"; ?>

				
	<!-- 상단(Top) -->

	<!-- 컨텐츠 시작 -->
	<div id="content">
		
		<div class="content_inner" align="center">

			<div class="sp40"></div>

			<img src="images/confirm_icon01.png" alt="체크아이콘"/><br/>
			주문이 완료되었습니다!
			<p class="cm_s">
			이용해주셔서 감사합니다.
			</p>
			<?if($AuthTy=="card" || $AuthTy == "iche"){

			if($rSuccYn=="y"){
			$query="update $shop_order set";
			$query=$query." status='주문접수',approve='$rApprNo',send_no='$rBillNo',appr_tm='$rApprTm'";
			$query=$query." where ordernum='$rOrdNo'";

			$result = mysql_query($query,$DBconn);

				if(!$result) {
					error("QUERY_ERROR");
					exit;
				}
				
				if($connect_check_point!="ok"){
				### 포인트 적립 ##################################################################
				$query = "SELECT pointin,pointout,signdate FROM $shop_order WHERE id='$valid_user' and ordernum='$rApprNo'";
				$result = mysql_query($query,$DBconn);
					if(!$result) {
						error("QUERY_ERROR");
						exit;
					}
				$row = mysql_fetch_row($result);
				$pointin = $row[0]; //적립된 포인트
				$pointout = $row[1]; //쓰인 포인트
				$signdate = $row[2]; //주문날짜

				$Signdate_kk = date("Y-m-d h:i:s",$signdate); 
				$Cont = "코인사용 [주문번호:$ordernum 주문일:$Signdate_kk]";
				$query="insert into $shop_point values";
				$query=$query."(";
				$query=$query."''"; #no 값이 들어 간다...자동 증가.
				$query=$query.",'$valid_user'";
				$query=$query.",'$Cont'";
				$query=$query.",'-$pointout'";
				$query=$query.",now()";
				$query=$query.",'$signdate'";
				$query=$query.")";

				
				if($pointout>0) $result = mysql_query($query);
				### 포인트 적립 ##################################################################
				}

		?>
		<?					
			}else{
			$query="update $shop_order set";
			$query=$query." status='취소'";
			$query=$query." where ordernum='$rOrdNo'";

			$result = mysql_query($query,$DBconn);

				if(!$result) {
					error("QUERY_ERROR");
					exit;
				}
		?>
		<SCRIPT LANGUAGE="JavaScript">
		<!--
		 alert("'<?=$rResMsg?>' 결제승인이 실패 하였습니다.\n\n죄송합니다. 다시 주문해주세요.");
		 location="../main/main.php";
		//-->
		</SCRIPT>
		<?
			exit;
			}
		 ?>	
		 
		 <div class="order_num">
			<span style="font-weight:bold;">주문 번호 : <?=$rOrdNo?></span><br/>
			주문자명 : <?=$rOrdNm?>
		</div>

		<?}else{
		$query="update $shop_order set";
		$query=$query." status='주문접수'";
		$query=$query." where ordernum='$ordernum'";
		//echo "$query";
		$result = mysql_query($query,$DBconn);

		if(!$result) {
			error("QUERY_ERROR");
			exit;
		}

		/*
		if($connect_check_point!="ok"){
		### 포인트 적립 ##################################################################
		$query = "SELECT pointin,pointout,signdate FROM $shop_order WHERE id='$valid_user' and ordernum='$ordernum'";
		$result = mysql_query($query,$DBconn);
			if(!$result) {
				error("QUERY_ERROR");
				exit;
			}
		$row = mysql_fetch_row($result);
		$pointin = $row[0]; //적립된 포인트
		$pointout = $row[1]; //쓰인 포인트
		$signdate = $row[2]; //주문날짜

		$Signdate_kk = date("Y-m-d h:i:s",$signdate); 
		$Cont = "코인사용 [주문번호:$ordernum 주문일:$Signdate_kk]";
		$query="insert into $shop_point values";
		$query=$query."(";
		$query=$query."''"; #no 값이 들어 간다...자동 증가.
		$query=$query.",'$valid_user'";
		$query=$query.",'$Cont'";
		$query=$query.",'-$pointout'";
		$query=$query.",now()";
		$query=$query.",'$signdate'";
		$query=$query.")";

		//echo "$query";
		if($pointout>0) $result = mysql_query($query);
		### 포인트 적립 ##################################################################
		}
		*/

		?>	
		<div class="order_num">
			<span style="font-weight:bold;">주문 번호 :<?=$ordernum?></span><br/>
		</div>
		<?}?>
		</div>

		<div class="sp40"></div>

		
	
<?
//중복 실행 방지 
$connect_check_point="ok";
//session_register("connect_check_point");
$_SESSION['connect_check_point'] = $connect_check_point;
?>	
	<!-- 컨텐츠 종료 -->

</div>
	<!-- 하단(Copy) -->

	 
	  <? include "../include/bottom.html"; ?>	  
				
				
	<!-- 하단(Copy) -->

	


</div>
</body>
</html>
