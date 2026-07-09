<? include "../include/get_balance.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
#####################################################################


$kkid = $_REQUEST['kkid'];
$kkid1 = $_REQUEST['kkid1'];
$tyear = $_REQUEST['tyear'];
$dis = $_REQUEST['dis'];
$member_count = $_REQUEST['member_count'];
$level_l = $_REQUEST['level_l'];
$file_name = $_REQUEST['file_name'];
$member_count = $_REQUEST['member_count'];
$chk_num = $_REQUEST['chk_num'];
$passwd = $_REQUEST['passwd'];
$passwd2 = $_REQUEST['passwd2'];
$name = $_REQUEST['name'];
$Email = $_REQUEST['Email'];
$handphone = $_REQUEST['handphone'];
$zipcorde = $_REQUEST['zipcorde'];
$address = $_REQUEST['address'];
$recommend = $_REQUEST['recommend'];
$company = $_REQUEST['company'];
$real_pass = $_REQUEST['chk_num'];


/*
if(ereg("([^[:space:]]+)", $email) && (!ereg("(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)", $email))  ) {
   error("INVALID_EMAIL");   
   exit;
}
if(!ereg("(^[0-9a-zA-Z]{4,}$)", $passwd) && $passwd!="") {
   error("INVALID_PASSWD");
   exit;
}*/

$jumin = $Birth_year ."-". $Birth_month ."-". $Birth_day;

//$oldpass=trim($oldpass);
$passwd=trim($passwd);
$passwd2=trim($passwd2);

$tel=$tel1."-".$tel2."-".$tel3;
$handphone=$handphone1."-".$handphone2."-".$handphone3;


/*
if($passwd!="") {
	if(!ereg("([a-z0-9]{3,}$)", $passwd)) {
		echo "<script language=javascript> alert('Password must be at least 4 characters.'); </script>";
		echo "<script language=javascript> history.go(-1); </script>";
		exit;
	}
	if($passwd!=$passwd2) {
		echo "<script language=javascript> alert('Passwords do not match.'); </script>";
		echo "<script language=javascript> history.go(-1); </script>";
		exit;
	}
	$query = "SELECT '$passwd'";

	

	$result = mysql_query($query,$DBconn);
	$row = mysql_fetch_row($result);
	$newpasswd = $row[0];
	
} else {
	$newpasswd = $real_pass;
}
*/

//데이터베이스에 입력값을 삽입한다
	
	$sql = "passwd='$newpasswd',
			name='$name',
			jumin='$jumin',
			solar='$solar',
			sex='$sex',
			job='$job',
			email='$email',
			tel='$tel',
			handphone='$handphone',
			zip='$zip',
			address='$address',
			info='$info',
			point='$point',
			dis='$dis',
			dis1='$dis1',
			company='$company',
			recommend='$recommend',
			comnum='$comnum',
			etc1='$etc1',
			etc2='$etc2',
			cont='$cont',
			admail='$admail',
			adsms='$adsms' where id='$id'";


	$DB->update($member, $sql);

?>
<script type="text/javascript">
<!--
	alert("Your information has been updated.");
	location="modify.php";
//-->
</script>
<?

?>
