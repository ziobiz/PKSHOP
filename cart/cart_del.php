<?
#####################################################################
include "../include/get_balance.php";
include "../../Adm/common/dbconn.php";
$session_cart = $_SESSION["session_cart"];
//환경설정 파일을 불러온다.
$del_num=$_GET["del_num"];
include "cartfunc.php";
if ($del_num=='a') {
	echo("<meta http-equiv='Refresh' content='0; URL=../main/main.php'>");   
}	
else {
	delCart($del_num);


	// $DB->get("select count(*) as soo from $shop_cart where cart_id='$valid_user'",$crts,$crtn);
	$crts = json_decode(curl_d($api_category,"&Type=cartCount"),true);
	$total_su=$crts[0]['soo'];

	if ($total_su=='0'){
		curl_d($api_category,"&Type=cartSave&session_cart=$session_cart");
	}else{
		curl_d($api_category,"&Type=cartUpdate&session_cart=$session_cart");
	}

	$_SESSION["session_cart"] = $session_cart;
	if ($session_cart=="") { 

		$session_cart_selected="";

		 
		 curl_d($api_category,"&Type=cartDel&session_cart=$session_cart");
		 
		echo("<meta http-equiv='Refresh' content='0; URL=../main/main.html'>"); 
	}

	else echo("<meta http-equiv='Refresh' content='0; URL=cart.php'>");   
}
#####################################################################
?>