<? 
include "../common/dbconn.php";
$admin_old = $_POST['admin_old'];
$admin_new = $_POST['admin_new'];
$admin_cid = $_POST['admin_cid'];

$query="select * from admanager where admin_id='admin' and admin_pass='$admin_old' ";
$DB->get($query,$rs,$rn);

if($rn>0) {$dup="yes";}
	
if ($dup=="yes"){			
	$DB->update("admanager"," admin_pass='$admin_new' where admin_id='$admin_cid' ");
	
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
{
	alert('성공적으로 변경 되었습니다.!!');
	location='ad_chang.php';
	
}
//-->
</SCRIPT>

<?
}else{
	echo "<script language=javascript>alert('비밀번호가 일치 하지 않습니다.');</script>";
	echo "<script language=javascript>history.go(-1);</script>";
	exit;
}
?>