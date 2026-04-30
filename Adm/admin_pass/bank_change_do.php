<? 
include "../common/dbconn.php";
$c_bank = $_POST['c_bank'];
$c_banknum = $_POST['c_banknum'];
$c_bankname = $_POST['c_bankname'];

		
	$DB->update("su_info"," c_bank='$c_bank',c_banknum='$c_banknum',c_bankname='$c_bankname' where idx='1' ");
	
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
{
	alert('성공적으로 변경 되었습니다.!!');
	location='bank_change.php';
	
}
//-->
</SCRIPT>
