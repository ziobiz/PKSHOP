<?
#####################추천상품추가####################################
include "../common/dbconn.php";
include "../common/user_function.php";

$theme = $_GET[theme];
$sel_goods = $_POST[sel_goods];
$sel_cate = $_POST[sel_cate];
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
$theme=$_REQUEST["theme"];
if($theme == "r") {
	$theme = "theme_r"; 
	$rank = "rank_r";
	$theme_str = "r";
}else if($theme == "f") {
	$theme = "theme_f"; 
	$rank = "rank_f";
	$theme_str = "f";
}else if($theme == "n") {
	$theme = "theme_n"; 
	$rank = "rank_n";
	$theme_str = "n";
}else if($theme == "s") {
	$theme = "theme_s"; 
	$rank = "rank_s";
	$theme_str = "s";
}else if($theme == "x") {
	$theme = "theme_x"; 
	$rank = "rank_x";
	$theme_str = "x";
}else if($theme == "y") {
	$theme = "theme_y"; 
	$rank = "rank_y";
	$theme_str = "y";
}else if($theme == "z") {
	$theme = "theme_z"; 
	$rank = "rank_z";
	$theme_str = "z";
}


$sel_goods = substr("$sel_goods",-11);
$DB->update($shop_goods,"$theme='$theme_str' WHERE code = '$sel_goods'");


if ($theme=="theme_n") $tmpphp = "pro_pri.php";
else if ($theme=="theme_r") $tmpphp = "pro_propose.php";
else if ($theme=="theme_f") $tmpphp = "pro_like.php";
else if ($theme=="theme_x") $tmpphp = "pro_x.php";
else if ($theme=="theme_y") $tmpphp = "pro_y.php";
else if ($theme=="theme_z") $tmpphp = "pro_z.php";
else if ($theme=="theme_s") $tmpphp = "pro_s.php";

else $tmpphp = "pro_new.php";

// 

echo "<meta http-equiv='Refresh' content='0; URL=$tmpphp?sel_cate=$sel_cate&sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3'>";

#####################################################################
?>
