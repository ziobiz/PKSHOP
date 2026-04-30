<? include "../include/get_balance.php"; 

include "cartfunc.php";
$tot=totCount();
$session_cart = $_SESSION['session_cart'];
$idx = htmlspecialchars(addslashes($_GET["idx"]));


for($i=0;$i<$tot;$i++) {
	
	
	$tmp_qty = "qty" . $i;
	$tmp_qty = $_POST[$tmp_qty];
	
	$tmp_size = "size" . $i;
	$tmp_size = $_POST[$tmp_size];
	$tmp_color = "color" . $i;
	$tmp_color = $_POST[$tmp_color];
	$tmp_option1 = "option1" . $i;
	$tmp_option1 = trim($_POST[$tmp_option1]);
	$tmp_option2 = "option2" . $i;
	$tmp_option2 = $_POST[$tmp_option2];
	$tmp_option3 = "option3" . $i;
	$tmp_option3 = $_POST[$tmp_option3];
	$tmp_option4 = "option4" . $i;
	$tmp_option4 = $_POST[$tmp_option4];
	$tmp_option5 = "option5" . $i;
	$tmp_option5 = $_POST[$tmp_option5];


	modifyCart($i,$tmp_qty,$tmp_size,$tmp_color,$kdsf,$tmp_option1,$tmp_option2,$tmp_option3,$tmp_option4,$tmp_option5);
}


	if ($total_su=='0'){
		curl_d($api_category,"&Type=cartSave&session_cart=$session_cart");
	}else{
		curl_d($api_category,"&Type=cartUpdate&session_cart=$session_cart");
	}

	if ($session_cart=="") { 
		echo("<meta http-equiv='Refresh' content='0; URL=../main/main.html'>"); 
	}else{
		echo("<meta http-equiv='Refresh' content='0; URL=cart.php'>");   
	}
#####################################################################
?>