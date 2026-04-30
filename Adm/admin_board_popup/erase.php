<?
#디비관련 셋팅파일 불러 오기
include './db_config/dbcon.php';
include "./error/error.inc";

############################################
$Memo = $_GET[Memo];
$Comm_No = $_POST[Comm_No];
$No=$_GET[No];
$page = $_GET[page];
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
	$Result = "select No,Sub_No,P_Fname from $DBtable where No=$No"; 
	$Board_d=mysql_fetch_array(mysql_query($Result)); 

	//------------------------------------------------
	$No=$Board_d[No];
	$Sub_No=$Board_d[Sub_No]; 
	$P_Fname=$Board_d[P_Fname]; 

	//---------------------------------------------


	if ($P_Fname!="") {
		$savedir = "./data/";
		$img_name = $savedir . $P_Fname;
		$img_name_exist = file_exists("$img_name");
		if($img_name_exist){
			if(!unlink("$img_name")){
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}
	}	
	
			$Result = "delete from $DBtable where No=$No"; 
			$Rs_table= mysql_query($Result);
			//echo "$Result ";
										
			$Result = "delete from $DBtable2 where Board_No=$No"; 
			$Rs_table= mysql_query($Result);
		
	mysql_close($DB); 
			
	echo "<meta http-equiv='refresh' content='0;url=list.php?Sub_No=$Sub_No'>"; 
}  
?>

