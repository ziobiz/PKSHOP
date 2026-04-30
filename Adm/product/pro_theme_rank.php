<?
###########################우선순위 변경#############################
include "../common/dbconn.php";
include "../common/user_function.php";
$rank_num=$_POST["sel_num"];
// print_r($_POST);
// exit;
$rank_tmp = "rank_".$theme;
for ($i = 0; $i < $rank_num; $i++) {
	$ii=$i+1;
 	$tmprank = "rank" . $ii;
 	$tmp_rank = $_POST[$tmprank];	
 	
	$tmpcode = "code" . $ii;
 	$tmp_code = $_POST[$tmpcode];	
	if ($tmp_rank!="") {	
		// echo "$rank_tmp='$tmp_rank' WHERE code = '$tmp_code'";
		// exit;
		$DB->update($shop_goods," $rank_tmp='$tmp_rank' WHERE code = '$tmp_code'");

		
	}	
}

if ($theme=="r") $tmpphp = "pro_propose.php";
else if ($theme=="f") $tmpphp = "pro_like.php";
else if ($theme=="n") $tmpphp = "pro_new.php";
else if ($theme=="x") $tmpphp = "pro_x.php";
else if ($theme=="y") $tmpphp = "pro_y.php";
else if ($theme=="z") $tmpphp = "pro_z.php";
else if ($theme=="s") $tmpphp = "pro_s.php";
else $tmpphp = "pro_new.php";
// 

echo "<meta http-equiv='Refresh' content='0; URL=$tmpphp'>";

#####################################################################
?>
