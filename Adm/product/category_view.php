<?
include "../common/dbconn.php";
include "../common/user_function.php";

$cate = $_GET["cate"];
$cate1 = $_POST["cate1"];
$cate2 = $_POST["cate2"];
$cate3 = $_POST["cate3"];
$cate4 = $_POST["cate4"];
$show1 = $_POST["show1"];
$show2 = $_POST["show2"];
$show3 = $_POST["show3"];
$show4 = $_POST["show4"];




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

// $tmp_code = "code".$cate;
// $tmp_code=$$tmp_code;
// if($tmp_code=="") {
//    popup_msg("상품코드를 입력하십시오.");
//    exit;
// }
// $tmp_cate = "cate".$cate;
// $tmp_cate=$$tmp_cate;
// if($tmp_cate=="") {
//    popup_msg("상품명을 입력하십시오.");
//    exit;
// }




if ($cate=='1'){
	$query = "SELECT uid FROM $shop_cate WHERE code2='00' and code3='00' and code4='00' ORDER BY order_rank";
}else if ($cate=='2'){
	$query = "SELECT uid FROM $shop_cate WHERE code1='$code1' and code2!='00' and code3='00' and code4='00' ORDER BY order_rank";
}else if ($cate=='3'){
	$query = "SELECT uid FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3!='00' and code4='00' ORDER BY order_rank";
}else if ($cate=='4'){
	$query = "SELECT uid FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code3!='00' ORDER BY order_rank";
}	
$DB->get($query,$rs,$rn);
$total_record = $rn;
for ($i=0;$i<$total_record=$rn;$i++){
	$ii=$i+1;
	$uid =$rs[$i][0];	
	$tmprank = "show" . $cate . $ii;
	$show = $_POST[$tmprank];

	if ($cate=='1'){
		$query2 = "show1='$show' WHERE uid = '$uid'";	
		$DB->update($shop_cate,$query2);
	}else if ($cate=='2'){
		$query2 = "show2='$show' WHERE uid = '$uid'";	
		$DB->update($shop_cate,$query2);
	}else if ($cate=='3'){
		$query2 = "show3='$show' WHERE uid = '$uid'";	
		$DB->update($shop_cate,$query2);
	}else if ($cate=='4'){
		$query2 = "show4='$show' WHERE uid = '$uid'";	
		$DB->update($shop_cate,$query2);
	}	
	
	// echo $query2;
	// echo "<br>";
	

}
// exit;


$tmp="cateuid1=$cateuid1&cateuid2=$cateuid2&cateuid3=$cateuid3&cateuid4=$cateuid4";

echo "<meta http-equiv='Refresh' content='0; URL=category.php?$tmp'>";
?>
