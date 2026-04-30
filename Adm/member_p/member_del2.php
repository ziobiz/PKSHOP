<?
#####################################################################

include "../common/user_function.php";
include "../common/dbconn.php";
$k_tel="";
for ($i = 0; $i < $chk_num; $i++) {
 	$tmpchk = "check" . $i;
 	$sel_check = $$tmpchk;
 	if ($sel_check != "") {
 		
		$query = "SELECT handphone from $member_table WHERE id='$sel_check'";
		//echo "$query";
		$DB->get($query,$rs,$rn);
		if(!$result) {
			error("QUERY_ERROR");
			exit;
		}
		
		$tel = $rs[0][0];

		if($k_tel!=""){
			$k_tel=$k_tel."=".$tel;
		}else{
			$k_tel=$tel;
		}
 	}
	
}

$encoded_key = urlencode($key);
?>
<script type="text/javascript">
<!--
	window.parent.location="sms.php?stran_phone1=<?=$k_tel?>&dis=<?=$dis?>&page_num=<?=$page_num?>&total_page=<?=$total_page?>";
//-->
</script>
<?
#####################################################################
?>