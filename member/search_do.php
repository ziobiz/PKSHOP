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
$name=trim($name);
$email=trim($email);

$query = "select id,passwd,name,handphone from $member_table where name = '$name'";

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

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
alert("아이디는 '<?=$real_id?>' 입니다. \n\n 즐거운 하루 보내세요.");
location="find.php";
//-->
</SCRIPT>
</body>
</html>
