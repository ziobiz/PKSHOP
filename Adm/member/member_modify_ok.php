<meta charset="utf-8">
<?
#####################################################################

include "../common/dbconn.php";
include "../common/user_function.php";

//if(ereg("([^[:space:]]+)", $email) && (!ereg("(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)", $email))  ) {
//   error("INVALID_EMAIL");   
//   exit;
//}

if(!ereg("(^[0-9a-zA-Z]{4,}$)", $passwd) && $passwd!="") {
   error("INVALID_PASSWD");
   exit;
}

$jumin = $Birth_year ."-". $Birth_month ."-". $Birth_day;
//$handphone = $handphone1."-".$handphone2."-".$handphone3;
$handphone = $_REQUEST["handphone"];
$address=$address." ".$address;
//$oldpass=trim($oldpass);
$passwd=trim($passwd);
$passwd2=trim($passwd2);


if($passwd!="") {
	if(!ereg("([a-z0-9]{3,}$)", $passwd)) {
		echo "<script language=javascript> alert('비밀번호는 4자이상이어야 합니다.'); </script>";
		echo "<script language=javascript> history.go(-1); </script>";
		exit;
	}
	if($passwd!=$passwd2) {
		echo "<script language=javascript> alert('비밀번호가 동일하지 않습니다.'); </script>";
		echo "<script language=javascript> history.go(-1); </script>";
		exit;
	}
	$query = "SELECT '$passwd'";
	$DB->get($query,$rs,$rn);
	
	$newpasswd = $rs[0][0];

	
} else {
	$newpasswd = $real_pass;
}


//데이터베이스에 입력값을 삽입한다
	$query = "UPDATE $member SET";
	$query = $query . " passwd='$newpasswd',name='$name',jumin='$jumin',solar='$solar',sex='$sex',job='$job',email='$email',c_jisa='$center'";
	$query = $query . ",tel='$tel',handphone='$handphone',zip='$zipcorde',address='$address',info='$info',point='$point',dis='$dis',dis1='$dis1',company='$company',recommend='$recommend',comnum='$comnum',etc1='$etc1',etc2='$etc2',cont='$cont',admail='$admail',adsms='$adsms'";
	$query = $query . " WHERE id = '$id'";
$DB->get($query,$rs,$rn);
if($result) {

/*
//미승인 -> 승인시 메일 발송
if($dis1_kk=="미승인" && $dis1=="승인"){
	$stran_callback = "***-****-****";
	$stran_phone = "$handphone";
	$stran_msg = "*************************************************";
	$guest_no = "*****";
	$guest_key = "******************";

	if(isset($stran_phone) && $stran_phone != "") {

	  $xml_file = "http://sms.direct.co.kr/link/".
				  "send.php?stran_phone=".$stran_phone.
				  "&stran_callback=".$stran_callback.
				  "&stran_date=".urlencode($stran_date).
				  "&stran_msg=".urlencode($stran_msg).
				  "&guest_no=".$guest_no.
				  "&guest_key=".$guest_key;

	  $dom = domxml_open_file($xml_file);
	  $root = $dom->document_element();
	  $nodes = $root->child_nodes();
	  $ret = $nodes[count($nodes)-1]->get_content();
		
	}
}
*/
// 리스트 출력화면으로 이동한다
	$encoded_key = urlencode($key);
	echo("<meta http-equiv='Refresh' content='0; URL=member.php?keyfield=$keyfield&key=$encoded_key&page=$page'>");   
} else {
   	error("QUERY_ERROR");
	exit;
}


?>
