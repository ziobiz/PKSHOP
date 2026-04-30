<?
include "../common/dbconn.php";
include "../common/user_function.php";
$soldout=$_POST[soldout];
if($_POST[sel_code1] !="" || $_POST[sel_code2] !="" || $_POST[sel_code3] !="" || $_POST[sel_code4] !=""){
$sel_code1 = $_POST[sel_code1];
$sel_code2 = $_POST[sel_code2];
$sel_code3 = $_POST[sel_code3];
$sel_code4 = $_POST[sel_code4];
}else{
$sel_code1 = $_GET[sel_code1];
$sel_code2 = $_GET[sel_code2];
$sel_code3 = $_GET[sel_code3];
$sel_code4 = $_GET[sel_code4];
}
if($_POST[keyfield] !="" || $_POST['key'] !="" || $_POST[page] !=""){
$keyfield = $_POST['keyfield'];
$key = $_POST['key'];
$page =$_POST[page];
}else{
$keyfield = $_GET['keyfield'];
$key = $_GET['key'];
$page =$_GET[page];
}
for ($i = 0; $i < $chk_num; $i++){
 		$tmpchk = "check" . $i;
 		$sel_check = $_POST[$tmpchk];
 		if ($sel_check != "") {
		

 			$query="UPDATE $shop_goods SET";
			$query=$query." soldout='N' where No='$sel_check'";
			//echo "$query";
			//exit;

			$DB->get($query,$rs,$rn);
 			if(!$result) {
 				error("QUERY_ERROR");
 				exit;
 			}
 		}
	}
if ($buy_chk=='Y') {
	$tmp_url = "pro_buy.php?page=$page";
}
else {
	$tmp_url = "products.php?sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&chk_order=Y&sel_cate=$sel_cate";
}
echo "<meta http-equiv='Refresh' content='0; URL=$tmp_url'>";
?>