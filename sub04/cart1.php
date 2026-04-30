<? include "../include/get_balance.php";?>
<? include "../../Adm/common/dbconn.php";?>
<? //include "../include/login_check.php"; ?>
<? //include "../include/dis_check.php"; ?>

<?


if ($session_cart=="") {
	$query_cart = "select cart_cont from $shop_cart where cart_id = '$valid_user'";
	$result_cart = mysql_query($query_cart,$DBconn);
	if (!$result_cart) {
		echo "QUERY_ERROR1 ";
		exit;
	}
	$row_cart = mysql_fetch_row($result_cart);
	$session_cart= $row_cart[0];
}

include "cartfunc.php";
//session_register("session_cart");
$_SESSION["session_cart"] =  $session_cart;



$ss_dis=time();
if($code!="" && $amount!="") {
	$val=array($code,$amount,$size,$color,$back,$option1,$option2,$option3,$option4,$option5);
	addCart($val);
	
	$numresults = mysql_query("select count(*) as soo from $shop_cart where cart_id='$valid_user'");
	$row_num = mysql_fetch_array($numresults);
	$total_su=$row_num[soo];

	if ($total_su=='0'){
		mysql_query("insert into $shop_cart values ('','$valid_user','$session_cart')");	
	}else{
		mysql_query("update $shop_cart set cart_cont='$session_cart' where cart_id='$valid_user' ");
	}

}

echo "<meta http-equiv='refresh' content='0;url=cart.php'>"; 
?>
