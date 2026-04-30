<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

#####################################################################
include "../include/top_session.php";
$session_cart = $_SESSION["session_cart"];
$del_num = $_GET["del_num"];

//환경설정 파일을 불러온다.
include "cartfunc.php";



if ($del_num=='a') {
	$session_cart=""; 
	echo("<meta http-equiv='Refresh' content='0; URL=../main/main.php'>");  
}	
else {

	delCart($del_num);

	// echo $session_cart;
	// exit;
	$crts = json_decode(curl_d($api_category,"&Type=cartCount"),true);
	
	$total_su=$crts[0]['soo'];
	// echo $total_su;
	// exit;


	if ($total_su=='0'){

		curl_d($api_category,"&Type=cartUpdate&session_cart=$session_cart");

		
	}else{
		


		curl_d($api_category,"&Type=cartDel&session_cart=$session_cart");
		$_SESSION["session_cart"]=$session_cart;
		
	}

	if ($session_cart=="") { 

		$session_cart_selected="";

		 
		 curl_d($api_category,"&Type=cartDel&session_cart=$session_cart");

		echo("<meta http-equiv='Refresh' content='0; URL=../main/main.html'>"); 
	}
	
	else echo("<meta http-equiv='Refresh' content='0; URL=cart_order.php'>");   
}
#####################################################################
?>