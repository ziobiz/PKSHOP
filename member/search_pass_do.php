<? include "../include/get_balance.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>NGT MALL</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<? 
$id=trim($id);
$name=trim($name);
$email=trim($email);

$query = "select id,passwd,name,handphone from $member_table where id = '$id'";

$result = mysql_query($query,$DBconn);
if (!$result) {
	echo "QUERY_ERROR1 ";
	exit;
}
$row = mysql_fetch_row($result);
$real_id= $row[0];
$real_passwd = $row[1];
$real_name = $row[2];
$real_email = $row[3];

if($name!="$real_name") {
	echo "<script language=javascript>alert('성명이 일치하지 않습니다.');</script>";
	echo "<script language=javascript>history.go(-1);</script>";
	exit;	
}

if($email!="$real_email") {
	echo "<script language=javascript>alert('휴대폰이 일치 하지 않습니다.');</script>";
	echo "<script language=javascript>history.go(-1);</script>";
	exit;
}


$nc = 6;
$a='0123456789';
$l=strlen($a)-1; $r='';
while($nc-->0) $r.=$a{mt_rand(0,$l)};

$rand =  $r;

$query = "UPDATE $member SET";
$query = $query . " passwd='$rand' ";
$query = $query . " WHERE id = '$real_id'";

$result = mysql_query($query,$DBconn);
if($result) {

	include "./class.http.php";
	include "./class.EmmaSMS.php";



	$sms_id = "newglobaltop";
	$sms_passwd = "gt283828";
	$sms_type = "L";
	$sms_to = $real_email;
	$sms_from = "010-5839-0200";
	$sms_date = "0";
	$sms_msg = "[NGTMALL] ".$name." 님 비밀번호 : ".$rand;

	$sms = new EmmaSMS();
	$sms->login($sms_id, $sms_passwd);
	$ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date, $sms_type);



	?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	alert("비밀번호가 문자로 전송됩니다. \n\n 즐거운 하루 보내세요.");
	location="login.php";
	//-->
	</SCRIPT>
<?
}else{

	echo "<script language=javascript>alert('잘못된 접근입니다.');</script>";
	echo "<script language=javascript>history.go(-1);</script>";
	exit;

}?>
</body>
</html>
