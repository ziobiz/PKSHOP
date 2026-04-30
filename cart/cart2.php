<?	
//   error_reporting( E_ALL );
//   ini_set( "display_errors", 1 );

include "../include/com.php";
	include "../include/login_check.php"; 
	//include "../lib/basic_class.php";

$session_cart = $_SESSION["session_cart"];
if ($session_cart=="") {
	
	// echo "ASd";
	// echo curl_d($api_category,"&Type=cartCont");
	// exit;
	$crts = json_decode(curl_d($api_category,"&Type=cartCont"),true);
	
	$session_cart= $crts[0]['cart_cont'];
}
// print_r($_REQUEST);exit;
//$session_cart=""; 
include "cartfunc.php";
//session_register("session_url");

$_SESSION['session_url'] = "$session_cart";
$_SESSION['session_cart'] = "$session_cart";

$code  = $_GET['code'];
$amount= $_GET['amount'];
$size =    htmlspecialchars(addslashes($_REQUEST["size"]));
$color =   htmlspecialchars(addslashes($_REQUEST["color"]));
$back =    htmlspecialchars(addslashes($_REQUEST["back"]));
$option1 = htmlspecialchars(addslashes($_REQUEST["opt1"]));
$option2 = htmlspecialchars(addslashes($_REQUEST["opt2"]));
$option3 = htmlspecialchars(addslashes($_REQUEST["opt3"]));
$option4 = htmlspecialchars(addslashes($_REQUEST["opt4"]));
$option5 = htmlspecialchars(addslashes($_REQUEST["opt5"]));
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
$ss_dis=time();
if($code!="" && $amount!="") {

	$val=array($code,$amount,$size,$color,$back,$option1,$option2,$option3,$option4,$option5);
	
	addCart($val);

}

//echo $session_cart;
//exit;
//if (!$session_cart) {
//	popup_msg("장바구니에 선택하신 상품이 없습니다.");
//	exit;
//}

	echo "<meta http-equiv='refresh' content='0;url=cart_order.php?order_kk=Y&code=$code'>"; 
?>