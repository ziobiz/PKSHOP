<meta charset="utf-8">
<?
#####################################################################

include "../common/dbconn.php";
include "../common/user_function.php";

$Cid=$_POST['cid'];
$Point=$_POST['point'];
$shop_key=$_POST['shop_key'];


$Cid=trim($Cid);
$Point=trim($Point);
$signdate = time();

if($shop_key=="459sdfwodlfjsx342255" && $Cid!="" && $Point!=""){

	$query="INSERT INTO $shop_point";
	$query=$query."(";
	$query=$query."Cid,Cont,Point,Wdate,Signdate";
	$query=$query.")";
	$query=$query."VALUES";
	$query=$query."(";
	$query=$query."'$Cid','','$Point','','$signdate'";
	$query=$query.")";

	$DB->get($query,$rs,$rn);
	if($result) {
	// 리스트 출력화면으로 이동한다
		echo"1";
	} else {
		echo"2";
	}
}else{
	echo"0";
}


?>
