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
	echo "<script language=javascript>alert('Name does not match.');</script>";
	echo "<script language=javascript>history.go(-1);</script>";
	exit;	
}

if($email!="$real_email") {
	echo "<script language=javascript>alert('Phone number does not match.');</script>";
	echo "<script language=javascript>history.go(-1);</script>";
	exit;
} 

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
alert("Your ID is '<?=$real_id?>'. \n\n Have a great day.");
location="find.php";
//-->
</SCRIPT>
</body>
</html>
