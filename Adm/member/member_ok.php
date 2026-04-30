<meta charset="utf-8">
<?
#####################################################################

include "../common/dbconn.php";
include "../common/user_function.php";

if(ereg("([^[:space:]]+)", $email) && (!ereg("(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)", $email))  ) {
   error("INVALID_EMAIL");   
   exit;
}

if(!ereg("(^[0-9a-zA-Z]{4,}$)", $passwd) && $passwd!="") {
   error("INVALID_PASSWD");
   exit;
}
$handphone = $handphone1."-".$handphone2."-".$handphone3;
$jumin = $Birth_year ."-". $Birth_month ."-". $Birth_day;

//$oldpass=trim($oldpass);
$passwd=trim($passwd);
$passwd2=trim($passwd2);
$signdate = time();
$address = $address.$address1;

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
	$query="INSERT INTO $member";
	$query=$query."(";
	$query=$query."id,passwd,name,jumin,solar,sex,job,email";
	$query=$query.",tel,handphone,zip,address,info,signdate,point,dis,dis1,company,recommend,comnum,etc1,etc2";
	$query=$query.")";
	$query=$query."VALUES";
	$query=$query."(";
	$query=$query."'$id','$passwd','$name','$jumin','$solar','$sex','$job','$email','$tel'";
	$query=$query.",'$handphone','$zipcorde','$address','$info','$signdate','$point','$dis','$dis1','$company','$recommend','$comnum','$etc1','$etc2'";
	$query=$query.")";

$DB->get($query,$rs,$rn);
if($result) {
// 리스트 출력화면으로 이동한다
	$encoded_key = urlencode($key);
	echo("<meta http-equiv='Refresh' content='0; URL=member.php?keyfield=$keyfield&key=$encoded_key&page=$page&K_dis=$dis'>");   
} else {
   	error("QUERY_ERROR");
	exit;
}


?>
