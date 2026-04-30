<?
#####################################################################

include "../common/dbconn.php";
include "../common/user_function.php";


if(!ereg("(^[0-9a-zA-Z]{4,}$)", $passwd) && $passwd!="") {
   error("INVALID_PASSWD");
   exit;
}

$jumin = $jumin1 ."-". $jumin2;
$zip = $zip1 ."-". $zip2;

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
	$query = $query . " etc1='$etc1',etc2='$etc2'";
	$query = $query . " WHERE id = '$id'";
$DB->get($query,$rs,$rn);
if($result) {
// 리스트 출력화면으로 이동한다
	$encoded_key = urlencode($key);
	echo("<meta http-equiv='Refresh' content='0; URL=member_event.php?id=$id'>");   
} else {
   	error("QUERY_ERROR");
	exit;
}


?>