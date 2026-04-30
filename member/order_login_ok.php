<?
$id = strtolower($id);
include "../../Adm/common/user_function.php";
include "../../Adm/common/dbconn.php";

$k_ordernum=$k_ordernum1."-".$k_ordernum2."-".$k_ordernum3;

$query = "select ordernum,id,pay_name,kind,status,signdate,pay_tel,pointin,pointout,in_name,charge,char_num from $shop_order where pay_name = '$k_name' and pay_mobile='$k_ordernum' and status<>'주문대기' order by ordernum desc";

//echo $query;
//exit;
$result= mysql_query($query,$DBconn);
if (!$result) {
	error("QUERY_ERROR");
	exit;
}

$total_record = mysql_num_rows($result);

if($total_record=="0") {
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<script language='javascript'>alert('주문내역이 없습니다.');</script>";	
	echo "<script language=javascript>history.back();</script>";
	exit;
}else{
	// 세션 설정
	/*
	$valid_k_name = $k_name;
	session_register("valid_k_name");
	$valid_k_ordernum1 = $k_ordernum1;
	session_register("valid_k_ordernum1");
	$valid_k_ordernum2 = $k_ordernum2;
	session_register("valid_k_ordernum2");
	$valid_k_ordernum3 = $k_ordernum3;
	session_register("valid_k_ordernum3");
	*/

	SetCookie("valid_k_name",$k_name,0,"/","");
	SetCookie("valid_k_ordernum1",$k_ordernum1,0,"/","");
	SetCookie("valid_k_ordernum2",$k_ordernum2,0,"/","");
	SetCookie("valid_k_ordernum3",$k_ordernum3,0,"/","");
//	exit;
	echo "<meta http-equiv='Refresh' content='0; URL=../cart/overview.php'>";

}
#####################################################################
?>
