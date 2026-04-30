<? 
####################################################################

session_start();
include "../include/get_balance.php";
$ordnum = $_REQUEST["ordnum"];
curl_d($api_category,"&Type=sellCom&ordnum=$ordnum");




echo("<meta http-equiv='Refresh' content='0; URL=./overview.php?kk_name=$kk_name&kk_num=$kk_num'>");

#####################################################################
?>