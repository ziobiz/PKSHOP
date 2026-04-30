<?
#####################################################################

include "../common/user_function.php";
include "../common/dbconn.php";
for ($i = 0; $i < $chk_num; $i++) {
 	$tmpchk = "check" . $i;
 	$sel_check = $$tmpchk;
 	if ($sel_check != "") {
 		
		$query = "UPDATE $member SET dis='$sel_dis' WHERE id = '$sel_check'";
		//echo "$query";
		//exit;
		
		$DB->get($query,$rs,$rn);
 		if(!$result) {
 			error("QUERY_ERROR");
 			exit;
 		}
 	}
}
$encoded_key = urlencode($key);
echo "<meta http-equiv='Refresh' content='0; URL=member.php?keyfield=$keyfield&key=$encoded_key&page=$page&dis=$dis'>";

#####################################################################
?>