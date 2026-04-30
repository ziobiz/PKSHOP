<?
include './db_config/dbcon.php';
include "./error/error.inc";
for ($i = 0; $i < $chk_num; $i++){
 		$tmpchk = "check" . $i;
		$tmppop = "P_Up" . $i;
 		$sel_check = $$tmpchk;
		$change_pop = $$tmppop;

		if($change_pop=='O'){
			$P_Up='1';
		}else if($change_pop=='X'){
			$P_Up='';
		}
 		if ($sel_check != "") {
			$Result = "update $DBtable set P_Up='$P_Up'  where No=$sel_check"; 
			$Rs_table= mysql_query($Result);
												
			$Result = "delete from $DBtable2 where Board_No=$sel_check"; 
			$Rs_table= mysql_query($Result);
 		}
	}
	$tmp_url = "list.php?Sub_No=$Sub_No";
echo "<meta http-equiv='Refresh' content='0; URL=$tmp_url'>";
?>
