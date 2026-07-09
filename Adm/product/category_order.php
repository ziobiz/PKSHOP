<?
#####################################################################
include "../common/dbconn.php";
	include "../common/user_function.php";
#####################################################################
$cate = $_GET["cate"];
$cate1 = $_POST["cate1"];
$cate2 = $_POST["cate2"];
$cate3 = $_POST["cate3"];
$cate4 = $_POST["cate4"];

$catenum1 = $_POST["catenum1"];
$catenum2 = $_POST["catenum2"];
$catenum3 = $_POST["catenum3"];
$catenum4 = $_POST["catenum4"];

$code1 = $_POST["code1"];
$code2 = $_POST["code2"];
$code3 = $_POST["code3"];
$code4 = $_POST["code4"];
$cateuid1 = $_POST["cateuid1"];
$cateuid2 = $_POST["cateuid2"];
$cateuid3 = $_POST["cateuid3"];
$cateuid4 = $_POST["cateuid4"];



if ($cate=='1'){
	$query = "SELECT uid FROM $shop_cate WHERE code2='00' and code3='00' and code4='00' ORDER BY order_rank";
}else if ($cate=='2'){
	$query = "SELECT uid FROM $shop_cate WHERE code1='$code1' and code2!='00' and code3='00' and code4='00' ORDER BY order_rank";
}else if ($cate=='3'){
	$query = "SELECT uid FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3!='00' and code4='00' ORDER BY order_rank";
}else if ($cate=='4'){
	$query = "SELECT uid FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4!='00' ORDER BY order_rank";
}	


$DB->get($query,$rs,$rn);

for ($i=0; $i<$rn; $i++){
	$ii=$i+1;
	$uid =$rs[$i][0];	
	$tmprank = "rank" . $cate . $ii;
	$rank = $_POST[$tmprank];
	$query2 = "rank='$rank', order_rank=$rank WHERE uid = '$uid'";	
	$DB->update($shop_cate,$query2);
	
}



$tmp="cateuid1=$cateuid1&cateuid2=$cateuid2&cateuid3=$cateuid3&cateuid4=$cateuid4";

echo "<meta http-equiv='Refresh' content='0; URL=category.php?$tmp'>";
?>
