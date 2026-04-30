<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

include "../include/get_balance.php";
// print_r($_POST);exit;
$mbsReserved=explode("&&",$_POST["mbsReserved"]);
if($_SESSION["member_id"] == ""){
	if($mbsReserved[0] != ""){
		$_SESSION['member_id'] =$mbsReserved[0];
		$_SESSION['member_code'] =$mbsReserved[1];
	}
}

include "../include/login_check.php";
include "./KSPayWebHost.php";

$_SESSION['session_cart']="";
$session_cart="";

$session_cart_selected="";


if (function_exists("mb_http_input")) mb_http_input("utf-8");
if (function_exists("mb_http_output")) mb_http_output("utf-8");
$rcid       = $_POST['reCommConId'];
$rctype     = $_POST['reCommType'];
$rhash      = $_POST['reHash'];

  $authyn   = "";
  $trno     = "";
  $trddt		= "";
  $trdtm		= "";
  $amt      = "";
  $authno   = "";
  $msg1     = "";
  $msg2     = "";
  $ordno		= "";
  $isscd		= "";
  $aqucd		= "";
  $temp_v		= "";
  $result		= "";
  $halbu		= "";
  $cbtrno   = "";
  $cbauthno = "";
  $resultcd = "";

  //업체에서 추가하신 인자값을 받는 부분입니다
  $a = $_POST["a"];
  $b = $_POST["b"];
  $c = $_POST["c"];
  $d = $_POST["d"];
  $payamt      = $_POST["sndAmount"];
$ipg = new KSPayWebHost($rcid, null,$payamt);

  if ($ipg->kspay_send_msg("1"))
  {
	  $authyn   = $ipg->kspay_get_value("authyn");
	  $trno     = $ipg->kspay_get_value("trno"  );
	  $trddt    = $ipg->kspay_get_value("trddt" );
	  $trdtm    = $ipg->kspay_get_value("trdtm" );
	  $amt      = $ipg->kspay_get_value("amt"   );
	  $authno   = $ipg->kspay_get_value("authno");
	  $msg1     = $ipg->kspay_get_value("msg1"  );
	  $msg2     = $ipg->kspay_get_value("msg2"  );
	  $ordno    = $ipg->kspay_get_value("ordno" );
	  $isscd    = $ipg->kspay_get_value("isscd" );
	  $aqucd    = $ipg->kspay_get_value("aqucd" );
	  $temp_v   = "";
	  $result   = $ipg->kspay_get_value("result");
	  $halbu    = $ipg->kspay_get_value("halbu");
	  $cbtrno   = $ipg->kspay_get_value("cbtrno");
	  $cbauthno = $ipg->kspay_get_value("cbauthno");

	  if (!empty($msg1)) $msg1 = iconv("EUC-KR", "UTF-8", $msg1);
	  if (!empty($msg2)) $msg2 = iconv("EUC-KR", "UTF-8", $msg2);

	  if (!empty($authyn) && 1 == strlen($authyn))
	  {
		  if ($authyn == "O") {
	  // 정상승인
			  $resultcd = "0000";
	}
	else {
	  // 승인실패
			  $resultcd = trim($authno);
		  }
  }
  }





	$body ="tid=$tid&ediDate=$ediDate&mid=$mid&goodsAmt=$goodsAmt&charSet=utf-8&signData=$signData&encData=$encData";
	// echo $body;
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, "https://api.payster.co.kr/payment.do");
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=utf-8'));
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec ($ch);
	// echo $result;
	$json_o = json_decode($result,true);

	// print_r($json_o);exit;

    curl_close ($ch);
	$resultMsg =$json_o["resultMsg"];
	$resultCode =$json_o["resultCd"];
	// print_r($json_o);exit;


//include "../include/login_check.php";
curl_d($api_category,"&Type=cartDel&session_cart=$session_cart");
$merchantTransactionId=  $_GET["merchantTransactionId"];
$transactionId=  $_GET["transactionId"];
// echo $resultCode;

	// echo "ASd";exit;
	// $md5 = md5("5933757143C1DA395C1AECD1accId=2021121005433420956302&signType=MD5&transactionId=$transactionId");
	// $body_data = array(
    //     "accId" => "2021121005433420956302",
    //     "signType" => "MD5",
    //     "sign" => $md5,
    //     "transactionId" => $transactionId,



    // );


    // $body = json_encode($body_data);

    // $data = "5933757143C1DA395C1AECD1accId=2021121005433420956302&signType=MD5&sign=$md5";
    // $ch = curl_init();
    // curl_setopt ($ch, CURLOPT_URL, "https://acquirer-payment.pingpongx.com/v2/query");
    // curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
    // curl_setopt ($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
    // curl_setopt ($ch, CURLOPT_POSTFIELDS, $body);
    // curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
    // curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    // $result = curl_exec ($ch);

    // curl_close ($ch);

    // $result = json_decode($result,true);

	if( $resultCode == "3001"){
		$relateTransactionId=$result["relateTransactionId"];
		curl_d($api_category,"&Type=orderUpdate&ediDate=$ediDate&tid=$tid");
		// echo curl_d($api_category,"&Type=orderUpdate&ediDate=$ediDate&tid=$tid");
		// exit;
		// echo curl_d($api_category,"&Type=orderUpdate&transactionId=$merchantTransactionId");
		// exit;
		$img='<img src="images/confirm_icon01.png" alt="체크아이콘"/><br/>';
		$text="Card payment has been approved.<br>Thank you.<br> <span style='font-weight:bold;'>Your Payment code : $tid</span>";
	}else{
		$img='<img src="images/cart_delet.png" alt="체크아이콘"/><br/>';
		$text ="Card payment failed.<br> Please check the card information again.";
	}



if($_GET["kind"] == 2){
	$img='<img src="images/confirm_icon01.png" alt="체크아이콘"/><br/>';
	$text="The payment has been completed.<br>Thank you.";
}
$img='<img src="images/confirm_icon01.png" alt="체크아이콘"/><br/>';
	$text="Card payment has been approved.<br>Thank you.<br> <span style='font-weight:bold;'>Your Payment code : $_POST[reCommConId]</span>";
// echo "A";exit;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Chrome, Safari, IE -->
<link rel="shortcut icon" href="../images/webicon2.png">
<!-- Firefox, Opera (Chrome and Safari say thanks but no thanks) -->
<link rel="icon" href="../images/webicon2.png">

</head>

<body>
<div id="wrap">
`
	<!-- 상단(Top) -->


	  <? include "../include/top.php"; ?>


	<!-- 상단(Top) -->

	<!-- 컨텐츠 시작 -->
	<div id="content">

		<div class="content_inner" align="center">

			<div class="sp40"></div>

			<?=$img?>
			<?=nl2br($text)?>
			</p>
			<div class="sp40"></div>
			<div class="cart_btn_order" onclick="location.href='../main/main.html'">
				Go back to the main page.
			</div>


		<!-- <div class="order_num">
			<span style="font-weight:bold;">주문 번호 :<?=$ordernum?></span><br/>
		</div> -->

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
