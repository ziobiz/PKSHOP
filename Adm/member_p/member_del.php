<?
#####################################################################

include "../common/user_function.php";
include "../common/dbconn.php";

for ($i = 0; $i < $chk_num; $i++) {
 	$tmpchk = "check" . $i;
 	$sel_check = $$tmpchk;
 	if ($sel_check != "") {
 		$query = "DELETE from $member_table_p WHERE no = '$sel_check'";
		$DB->get($query,$rs,$rn);
 		if(!$result) {
 			error("QUERY_ERROR");
 			exit;
 		}
 	}
}
$encoded_key = urlencode($key);
echo "<meta http-equiv='Refresh' content='0; URL=member.php?keyfield=$keyfield&key=$encoded_key&page=$page&id=$id'>";

#####################################################################
?>