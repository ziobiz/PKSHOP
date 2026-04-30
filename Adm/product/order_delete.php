<?
#####################################################################
include "../common/dbconn.php";
include "../common/user_function.php";
include "../inc/set_com.php";
// print_r($_POST);
// exit;
$chk_num = $_POST["chk_num"];
for ($i = 0; $i < $chk_num; $i++){
 	$tmpchk = "check2" . $i;
 	$sel_check = $_POST[$tmpchk];
	//  echo $sel_check;exit;
 	if ($sel_check != ""){
 		$query = "ordernum = '$sel_check'";
		 $DB->delete($shop_order,$query);
 		// $DB->get($query,$rs,$rn);
 		
		

 		$query = "ordernum = '$sel_check'";
		 $DB->delete($shop_sell,$query);
 		// $DB->get($query,$rs,$rn);
 		
 	}
}

$encoded_key = urlencode($key);
echo "<meta http-equiv='Refresh' content='0; URL=pro_order.php?page=$page&keyfield=$keyfield&key=$encoded_key'>";

#####################################################################
?>