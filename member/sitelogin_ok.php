<?
#####################################################################
session_start();
include "../../Adm/common/user_function.php";
include "../../Adm/common/dbconn.php";

$id=trim($globaltop_id);
$passwd=trim($passwd);

$query = "select passwd,name,dis,handphone from $member_table where id = '$id'";


$result = mysql_query($query,$DBconn);
 if (!$result) {
	 echo "QUERY_ERROR1 ";
	 exit;
 }
 
$row = mysql_fetch_row($result);
$DB_pw = $row[0];
$name = $row[1];
$dis = $row[2];
$handphone = $row[3];
$freeshipping = $row[4];

$handphone=split("-",$handphone);
$handphone3=$handphone[2];


if($name=="") {
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<script language='javascript'>alert('없는 아이디입니다.');</script>";	
	echo "<script language=javascript>history.back();</script>";
	exit;
}

SetCookie("cook_dis",$dis,0,"/","/");
SetCookie("valid_k_name","",time()-3600,"/","");
SetCookie("valid_k_ordernum1","",time()-3600,"/","");
SetCookie("valid_k_ordernum2","",time()-3600,"/","");
SetCookie("valid_k_ordernum3","",time()-3600,"/","");

//echo $_COOKIE[valid_k_name];
//exit;
// 세션 설정
$valid_user = $id;
$_SESSION[valid_user] = $valid_user;

$t_ptr=mktime(date("H"));
$d_ptr=date("Ymd", $t_ptr);
$query = "SELECT  password('$id'), password('$d_ptr')";
//echo "SELECT password('taek'), password('$id'), password('$d_ptr')";

$result = mysql_query($query,$DBconn);
$row = mysql_fetch_row($result);
$edata1 = $row[0];
$edata2 = $row[1];
$edata3 = $row[2];

$edata=$edata1.$edata2.$edata3;
SetCookie("cook_data",$edata,0,"/","");
SetCookie("freeshipping",$freeshipping,time()+86400,"/","");
$cdate=time();
$query = "UPDATE $member SET ";
$query = $query . "cnt=cnt+1,cdate='$cdate' ";
$query = $query . "WHERE id = '$id'";
$result = mysql_query($query,$DBconn);

$encoded_para = urlencode($cur_para);
if($session_url != "") {
	echo "<meta http-equiv='Refresh' content='0; URL=../main/main.html'>";
}
else {
	echo "<meta http-equiv='Refresh' content='0; URL=../main/main.html'>";
}

#####################################################################
?>
