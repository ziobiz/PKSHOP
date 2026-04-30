<?

// error_reporting( E_ALL );
//   ini_set( "display_errors", 1 );

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
	$tmp_code=$_POST[$tmp_code];


	if($tmp_code==""){
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
	$cateuid1=$new_uid;
	$cateuid2="";
	$cateuid3="";
	$cateuid4="";
}	

else if ($cate=='2') {
	$cate3="";
	$cate4="";
	$code3="00";
	$code4="00";
	$rank=$catenum2;
	$cateuid2=$new_uid;
	$cateuid3="";
	$cateuid4="";
}	

else if ($cate=='3') {
	$cate4="";
	$code4="00";
	$rank=$catenum3;
	$cateuid3=$new_uid;
	$cateuid4="";
}

else if ($cate=='4') {
	$rank=$catenum4;
	$cateuid4=$new_uid;
}

// include "../common/dbconn.php";
####### 동일한 코드가 있는지 조회 ########
// echo "SELECT uid FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='$code4'";
// $result = mysql_query("SELECT uid FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='$code4'",$DBconn);
$DB->get("SELECT uid FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='$code4'",$rs,$rn);
// echo "ASd'";
// exit;
if($rs[0][0]) {
	
	popup_msg("이미 동일한 코드가 존재 합니다. 다른 코드를 입력하십시오.");
	exit;
}   


// $result = mysql_query("SELECT max(uid) FROM $shop_cate",$DBconn);
$DB->get("SELECT max(uid) FROM $shop_cate",$rs,$rn);
// if (!$result) {
// 	error("QUERY_ERROR");
// 	exit;
// }

if($rs[0][0]) {
	$new_uid = $rs[0][0] + 1;
} else {
	$new_uid = 1;
}   


$cate1 = addslashes($cate1);
$cate2 = addslashes($cate2);
$cate3 = addslashes($cate3);
$cate4 = addslashes($cate4);
// echo "ASd";exit;
$query = "uid='$new_uid',cate1='$cate1',cate2='$cate2',cate3='$cate3',cate4='$cate4',code1='$code1',code2='$code2',code3='$code3',code4='$code4',rank='$rank',order_rank='$rank'";
$DB->insert($shop_cate,$query);
// $DB->get($query,$rs,$rn);


$tmp="cateuid1=$cateuid1&cateuid2=$cateuid2&cateuid3=$cateuid3&cateuid4=$cateuid4";


echo "<meta http-equiv='Refresh' content='0; URL=category.php?$tmp'>";
?>
