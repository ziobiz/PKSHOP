<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

########################추천상품 삭제################################
include "../common/dbconn.php";
include "../common/user_function.php";
include "../inc/set_com.php";
$theme= $_GET["theme"];

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
$sel_num= $_POST["sel_num"];
for ($i = 0; $i <= $sel_num; $i++) {
 	$tmpchk = "check" . $i;
 	$sel_check = $_POST[$tmpchk];
 	if ($sel_check != "") {
 		$query = "UPDATE $shop_goods SET $theme='',$rank='99999' WHERE code = '$sel_check'";
		$DB->update($shop_goods,"$theme='',$rank='99999' WHERE code = '$sel_check'");
 		
 	}
}
// 


if ($theme=="theme_n") $tmpphp = "pro_new.php";
else if ($theme=="theme_r") $tmpphp = "pro_propose.php";
else if ($theme=="theme_f") $tmpphp = "pro_like.php";
else if ($theme=="theme_x") $tmpphp = "pro_x.php";
else if ($theme=="theme_y") $tmpphp = "pro_y.php";
else if ($theme=="theme_z") $tmpphp = "pro_z.php";
else if ($theme=="theme_s") $tmpphp = "pro_s.php";

echo "<meta http-equiv='Refresh' content='0; URL=$tmpphp?sel_cate=$sel_cate&sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3'>";

#####################################################################
?>