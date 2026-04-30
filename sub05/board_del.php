<?
#####################################################################
include "../common/dbconn.php";
include "../common/user_function.php";
include "../inc/set_com.php";
for ($i = 0; $i < $chk_num; $i++) {
 	$tmpchk = "check" . $i;
 	$sel_check = $_POST[$tmpchk];
 	if ($sel_check != "") {
 		$query = "DELETE from $table WHERE No = '$sel_check'";
		$result = mysql_query($query,$DBconn);
 		if(!$result) {
 			error("QUERY_ERROR");
 			exit;
 		}
 	}
}
$encoded_key = urlencode($key);
echo "<meta http-equiv='Refresh' content='0; URL=list.php?keyfield=$keyfield&key=$encoded_key&page=$page'>";

#####################################################################
?>