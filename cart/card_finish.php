<? 
include "../include/get_balance.php";
// include "../include/login_check.php";


$_SESSION['session_cart']="";
$session_cart="";

$session_cart_selected="";
//include "../include/login_check.php";
curl_d($api_category,"&Type=cartDel&session_cart=$session_cart");
$merchantTransactionId=  $_GET["merchantTransactionId"];
$transactionId=  $_GET["transactionId"];

if($transactionId != "" && $merchantTransactionId != ""){
	$md5 = md5("5933757143C1DA395C1AECD1accId=2021121005433420956302&signType=MD5&transactionId=$transactionId");
	$body_data = array(
        "accId" => "2021121005433420956302",
        "signType" => "MD5",
        "sign" => $md5,
        "transactionId" => $transactionId,
 
      

    );
    
    
    $body = json_encode($body_data);
    // echo $body;
    $data = "accId=2021121005433420956302&signType=MD5&sign=$md5";
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, "https://acquirer-payment.pingpongx.com/v2/query");
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec ($ch);
	// echo $result;
    curl_close ($ch);
    $result = json_decode($result,true);
	if($result["status"] == "SUCCESS"){
		$relateTransactionId=$result["relateTransactionId"];
		curl_d($api_category,"&Type=orderUpdate&transactionId=$merchantTransactionId&kka=a");
		$text="Card payment has been approved.<br>Thank you.<br> <span style='font-weight:bold;'>Your Payment code : $relateTransactionId</span>";
		echo "OK";
	}else{
		$text ="I'm waiting for payment.<br>
		Card information may be incorrect or the address may not be accurate,<br> so it may not be approved. Please ask the manager.";
		echo "OK";
	}
	
}else{
    echo "OK";
	$text="The payment has been completed.<br>Thank you.";
}
?>