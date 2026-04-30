<?
include '../common/dbconn.php';
include './db_config/dbcon.php';
include "./error/error.inc";

for ($i = 0; $i < $chk_num; $i++){
 		$tmpchk = "check" . $i;
		$tmpchk_r = "check" . $i."_r";
 		$sel_check = $$tmpchk;
		$sel_check_r = $$tmpchk_r;

if($sel_check!=""){
##########/admin/data/ 폴더 화일 삭제
	$Result = "select Fname,Fname1,Cont from $DBtable where No=$sel_check"; 
	$Rs= mysql_query($Result);
	$tn=mysql_num_rows($Rs); 
	if($tn!=0){
	$Board_d=mysql_fetch_array($Rs); 

	//------------------------------------------------
	$Fname=$Board_d[Fname]; 
	$Fname1=$Board_d[Fname1];
	$Cont=$Board_d[Cont];
	//---------------------------------------------


	if ($Fname!="") {
		$savedir = "./data/";
		$img_name = $savedir . $Fname;
		$img_name_exist = file_exists("$img_name");
		if($img_name_exist){
			if(!unlink("$img_name")){
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}
	}	

	if ($Fname1!="")	{
		$savedir = "./data/";
		$img_name = $savedir . $Fname1;
		$img_name_exist = file_exists("$img_name");
		if($img_name_exist){
			if(!unlink("$img_name")){
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}
	}

#########gmEditor로 올린 이미지 삭제########

	$pattern="/\d+.img.gm/";
	preg_match_all($pattern,$Cont,$matches); 
	foreach ($matches as $value){
		$savedir = "./data/";
		for ($i=0; $i<count($value); $i++) {
			$img_name = $savedir . $value[$i];
			$img_name_exist = file_exists("$img_name");
			if($img_name_exist){
				if(!unlink("$img_name")){
					error("UPLOAD_DELETE_FAILURE");
					exit;
				}
			}
		}
	}

}
#################################

 		if ($sel_check != "") {
			if($sel_check==$sel_check_r){//답변글이 아니야..
				$Result = "select No from $DBtable where No1=$sel_check_r and No<>$sel_check_r"; 
				$tn=mysql_num_rows( mysql_query($Result));  
																
				if($tn > 0){
					$Result = "update $DBtable set Cont_type='Del' where No='$sel_check'";
					$Rs_table= mysql_query($Result);
					}else{
					$Result = "delete from $DBtable where No=$sel_check"; 
						$Rs_table= mysql_query($Result);
															
						$Result = "delete from $DBtable2 where Board_No=$sel_check"; 
						$Rs_table= mysql_query($Result);
				}
			}else{
				$Result = "select No from $DBtable where No1=$sel_check_r and No<>$sel_check_r"; 
				$Rs_table= mysql_query($Result);
				$tn=mysql_num_rows($Rs_table);  
				$Board_d=mysql_fetch_array($Rs_table); 
										
				if($tn > 1){//답글 본인 삭제
					$Result = "delete from $DBtable where No=$sel_check"; 
					$Rs_table= mysql_query($Result);
					//echo "$Result ";

					$Result = "delete from $DBtable2 where Board_No=$sel_check"; 
					$Rs_table= mysql_query($Result);
											
				}else{
					$Result = "select No , Cont_type from $DBtable where No=$sel_check_r"; 
					$Rs_table= mysql_query($Result);
					$Board_d=mysql_fetch_array($Rs_table);
												
					$Check=$Board_d[Cont_type];

					if($Check=="Del") {
						$Result = "delete from $DBtable where No=$sel_check_r"; 
						$Rs_table= mysql_query($Result);
						//echo "$Result<BR> ";
														
						$Result = "delete from $DBtable2 where Board_No=$sel_check_r"; 
						$Rs_table= mysql_query($Result);
						//echo "$Result <BR>";
														
						$Result = "delete from $DBtable where No=$sel_check"; 
						$Rs_table= mysql_query($Result);
						//echo "$Result <BR>";
						
						$Result = "delete from $DBtable2 where Board_No=$sel_check"; 
						$Rs_table= mysql_query($Result);
						//echo "$Result<BR> ";
														
					}else{
						$Result = "delete from $DBtable where No=$sel_check"; 
						$Rs_table= mysql_query($Result);
						//echo "$Result ";
														
						$Result = "delete from $DBtable2 where Board_No=$sel_check"; 
						$Rs_table= mysql_query($Result);
					}
				}
			}
 		}
}
	}
	$tmp_url = "list.php?Sub_No=$Sub_No";
echo "<meta http-equiv='Refresh' content='0; URL=$tmp_url'>";
?>