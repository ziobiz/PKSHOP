<?
include "../common/dbconn.php";
include "../common/user_function.php";

$cate = $_GET[cate];
$cate1 = $_POST[cate1];
$cate2 = $_POST[cate2];
$cate3 = $_POST[cate3];
$cate4 = $_POST[cate4];

$catenum1 = $_POST[catenum1];
$catenum2 = $_POST[catenum2];
$catenum3 = $_POST[catenum3];
$catenum4 = $_POST[catenum4];

$code1 = $_POST[code1];
$code2 = $_POST[code2];
$code3 = $_POST[code3];
$code4 = $_POST[code4];
$cateuid1 = $_POST[cateuid1];
$cateuid2 = $_POST[cateuid2];
$cateuid3 = $_POST[cateuid3];
$cateuid4 = $_POST[cateuid4];

if ($cate=='1'){
	$query = "SELECT code1,code2,code3,code4 FROM $shop_cate WHERE code1!='00' and code2='00' and code3='00' and code4='00' ORDER BY order_rank";
}else if ($cate=='2'){
	$query = "SELECT code1,code2,code3,code4 FROM $shop_cate WHERE code1='$code1' and code2!='00' and code3='00' and code4='00' ORDER BY order_rank";
}else if ($cate=='3') {
	$query = "SELECT code1,code2,code3,code4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3!='00' and code4='00' ORDER BY order_rank";
}else if ($cate=='4') {
	$query = "SELECT code1,code2,code3,code4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4!='00' ORDER BY order_rank";
}	

$DB->get($query,$rs,$rn);
$total_record =$rn;

for ($i=0;$i<$total_record=$rn;$i++) {
	$ii=$i+1;
	$code1 =$rs[$i][0];
	$code2 =$rs[$i][1];
	$code3 =$rs[$i][2];
	$code4 =$rs[$i][3];
	$tmpchk = "catechk" . $cate . $ii;
	$cate_chk = $_POST[$tmpchk];
	if ($cate_chk=="Y"){
		if ($cate=='1'){
			$query2 = " code1 = '$code1'";
			$code1="";
			$code2="";
			$code3="";
			$code4="";
			$cate1="";
			$cate2="";
			$cate3="";
			$cate4="";
		}	
		else if ($cate=='2'){
			$query2 = " code1 = '$code1' and code2 = '$code2'";
			$code2="";
			$code3="";
			$code4="";
			$cate2="";
			$cate3="";
			$cate4="";
		}	
		else if ($cate=='3'){
			$query2 = " code1 = '$code1' and code2 = '$code2' and code3 = '$code3'";
			$code3="";
			$code4="";
			$cate3="";
			$cate4="";
		}
		else if ($cate=='4'){
			$query2 = " code1 = '$code1' and code2 = '$code2' and code3 = '$code3' and code4 = '$code4'";
			$code4="";
			$cate4="";
		}	
		$DB->delete($shop_cate,$query2);
		// $result2 = mysql_query($query2,$DBconn);
		// if(!$result2){
  		// 	error("QUERY_ERROR");
  		// 	exit;
		// }
	}	
}


$tmp="cateuid1=$cateuid1&cateuid2=$cateuid2&cateuid3=$cateuid3&cateuid4=$cateuid4";

echo "<meta http-equiv='Refresh' content='0; URL=category.php?$tmp'>";
?>
