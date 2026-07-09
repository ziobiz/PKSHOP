<?
include "../common/dbconn.php";
include "../common/user_function.php";

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

$tmp_code = "code".$cate;
$tmp_code=$$tmp_code;
if($tmp_code=="") {
   popup_msg("상품코드를 입력하십시오.");
   exit;
}
$tmp_cate = "cate".$cate;
$tmp_cate=$$tmp_cate;
if($tmp_cate=="") {
   popup_msg("상품명을 입력하십시오.");
   exit;
}




if ($cate=='1') {
	$cate2="";
	$cate3="";
	$cate4="";
	$code2="00";
	$code3="00";
	$code4="00";
	$rank=$catenum1;
	$uid=$cateuid1;
}	
else if ($cate=='2') {
	$cate3="";
	$cate4="";
	$code3="00";
	$code4="00";
	$rank=$catenum2;
	$uid=$cateuid2;
}	
else if ($cate=='3') {
	$cate4="";
	$code4="00";
	$rank=$catenum3;
	$uid=$cateuid3;
}	
else if ($cate=='4') {
	$rank=$catenum4;
	$uid=$cateuid4;
}

$cate1 = addslashes($cate1);
$cate2 = addslashes($cate2);
$cate3 = addslashes($cate3);
$cate4 = addslashes($cate4);


$query = "cate1='$cate1',cate2='$cate2',cate3='$cate3',cate4='$cate4' WHERE uid = '$uid'";
$DB->update($shop_cate,$query);
$cate1 = stripslashes($cate1);
$cate2 = stripslashes($cate2);
$cate3 = stripslashes($cate3);
$cate4 = stripslashes($cate4);

$tmp="cateuid1=$cateuid1&cateuid2=$cateuid2&cateuid3=$cateuid3&cateuid4=$cateuid4";


echo "<meta http-equiv='Refresh' content='0; URL=category.php?$tmp'>";
?>
