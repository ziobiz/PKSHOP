<?	
//   error_reporting( E_ALL );
//   ini_set( "display_errors", 1 );

include "../include/top_session.php";
	include "../include/login_check.php";
	// print_r($_SESSION);
	// exit;
	
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
	
	
	// echo curl_d($api_category,"&Type=cartCont");
	// exit;

if ($session_cart=="") {
	

	$all1s = json_decode(curl_d($api_category,"&Type=cartCont"),true);


	$session_cart= $all1s[0]['cart_cont'];
	


}

include "cartfunc.php";
//session_register("session_cart");

$_SESSION["session_cart"] =  $session_cart;




$code = $_GET['code'] ;
$amount = $_GET['amount'] ;


$ss_dis=time();



if($code!="" && $amount!="") {
	$val=array($code,$amount,$size,$color,$back,$option1,$option2,$option3,$option4,$option5);
	// print_r($val);
	
	addCart($val);
	$all1s = json_decode(curl_d($api_category,"&Type=cartCount"),true);

	$total_su=$all1s[0]['soo'];
	



	if ($total_su=='0'){

		// $sql = "cart_id		='$valid_user',									
		// 		cart_cont		='$session_cart'";
		// $DB->insert($shop_cart, $sql);	
		curl_d($api_category,"&Type=cartSave&session_cart=$session_cart");
	}else{
		
		

		if ($_SESSION["session_cart"]!="") {

			// $sql = "cart_cont='$session_cart' where cart_id='".$_SESSION['member_id']."'";

			// $DB->update($shop_cart, $sql);
			curl_d($api_category,"&Type=cartUpdate&session_cart=$session_cart");
		}
	}

}

echo "<meta http-equiv='refresh' content='0;url=cart.php'>"; 
?>
