<?
#디비관련 셋팅파일 불러 오기
include '../../Adm/common/dbconn.php';
include '../../Adm/admin_board_01/db_config/dbcon.php';
include "../../Adm/admin_board_01/error/error.inc";

############################################

//메모글 삭제..
if($Memo=='Y')	{
	$Result = "delete from $DBtable2 where Comm_No=$Comm_No"; 
	$Rs_table= mysql_query($Result);
	mysql_close($DB); 
				
	if($Cm_del!="OK"){
		echo "<meta http-equiv='refresh' content='0;url=view.php?No=$No&page$page'>"; 	
	}else{
?>			
		<SCRIPT LANGUAGE="JavaScript">
		<!--
			opener.parent.location="view.php?No=<?=$No?>&page=<?=$page?>"; 
			window.close();
		//-->
		</SCRIPT>
			
<?
	}// 커맨드 Url 분리 if else ... end

//일반글 삭제
} else {
	$Result = "select No,Sub_No,Fname,Fname1,No1,Cont from $DBtable where No=$No"; 
	$Board_d=mysql_fetch_array(mysql_query($Result)); 

	//------------------------------------------------
	$No=$Board_d[No];
	$Sub_No=$Board_d[Sub_No]; 
	$Fname=$Board_d[Fname]; 
	$Fname1=$Board_d[Fname1];
	$No1=$Board_d[No1];
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
if($No==$No1){
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
##################################

	if($No==$No1){//답변글이 아니야..
		$Result = "select No from $DBtable where No1=$No1 and No<>$No1"; 
		$tn=mysql_num_rows( mysql_query($Result));  
																
		if($tn > 0){
			$Result = "update $DBtable set Cont_type='Del' where No='$No'";
			$Rs_table= mysql_query($Result);
			//echo "$Result";
										
			//$Result = "delete from $DBtable2 where Board_No=$No"; 
			//$Rs_table= mysql_query($Result);
		}else{
			$Result = "delete from $DBtable where No=$No"; 
			$Rs_table= mysql_query($Result);
			//echo "$Result ";
										
			$Result = "delete from $DBtable2 where Board_No=$No"; 
			$Rs_table= mysql_query($Result);
		}
							
	}else{
		$Result = "select No from $DBtable where No1=$No1 and No<>$No1"; 
		$Rs_table= mysql_query($Result);
		$tn=mysql_num_rows($Rs_table);  
		$Board_d=mysql_fetch_array($Rs_table); 
								
		if($tn > 1){
			$Result = "delete from $DBtable where No=$No"; 
			$Rs_table= mysql_query($Result);
			//echo "$Result ";

			$Result = "delete from $DBtable2 where Board_No=$No"; 
			$Rs_table= mysql_query($Result);
									
		}else{
			$Result = "select No , Cont_type from $DBtable where No=$No1"; 
			$Rs_table= mysql_query($Result);
			$Board_d=mysql_fetch_array($Rs_table);
										
			$Check=$Board_d[Cont_type];

			if($Check=="Del") {
				$Result = "delete from $DBtable where No=$No1"; 
				$Rs_table= mysql_query($Result);
				//echo "$Result<BR> ";
												
				$Result = "delete from $DBtable2 where Board_No=$No1"; 
				$Rs_table= mysql_query($Result);
				//echo "$Result <BR>";
												
				$Result = "delete from $DBtable where No=$No"; 
				$Rs_table= mysql_query($Result);
				//echo "$Result <BR>";
				
				$Result = "delete from $DBtable2 where Board_No=$No"; 
				$Rs_table= mysql_query($Result);
				//echo "$Result<BR> ";
												
			}else{
				$Result = "delete from $DBtable where No=$No"; 
				$Rs_table= mysql_query($Result);
				//echo "$Result ";
												
				$Result = "delete from $DBtable2 where Board_No=$No"; 
				$Rs_table= mysql_query($Result);
			}

		}

	}
	mysql_close($DB); 
			
	echo "<meta http-equiv='refresh' content='0;url=list.php?Sub_No=$Sub_No'>"; 
}  
?>

