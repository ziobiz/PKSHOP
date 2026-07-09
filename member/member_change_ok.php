<? include "../include/get_balance.php";?>
  <? include "../../Adm/common/dbconn.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
#####################################################################
	$c_id		= $_POST['c_id'];
	$change_id		= $_POST['change_id'];

	$c_qry = "select * from $member_table where id='$c_id'";
	
	

	$result_c = mysql_query($c_qry);
	$rowc = mysql_fetch_array($result_c);

	$code = $rowc['c_code'];

//데이터베이스에 입력값을 삽입한다
	$query = "UPDATE $member SET";
	$query = $query . " id='$change_id'";
	$query = $query . " WHERE c_code = '$code'";
$result = mysql_query($query,$DBconn);

/*
if($result) {
?>
<script type="text/javascript">
<!--
	alert("Your information has been updated.");
	location="modify.php";
//-->
</script>
<?
} else {
   	error("QUERY_ERROR");
	exit;
}
*/
mysql_close($DBconn);
?>
