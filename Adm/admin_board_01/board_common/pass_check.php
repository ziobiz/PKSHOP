<?
#디비관련 셋팅파일 불러 오기
include '../admin/admin_board_01/db_config/dbcon.php';
				
if($Memo=="Y"){
			
	$Result = "select Comm_Pass from $DBtable2 where Comm_No=$Comm_No"; 
	$Rs_table= mysql_query($Result);
	$Comm_d=mysql_fetch_array($Rs_table); 
			
	//-------------------------------
	$Pwd=$Comm_d[Comm_Pass];
	//-------------------------------
	
	if ($PassWord==$Pwd)  { 	
		echo "<meta http-equiv='refresh' content='0;url=erase.php?Memo=Y&Comm_No=$Comm_No&No=$No&page=$page&Cm_del=$Cm_del'>"; 	
	} else { 
		echo "<script>alert('비밀번호가 일치하지 않습니다.');"; 
		echo "window.close();"; 
		echo "</script>"; 
	} 

	
}else{
	$Result = "select Pass,Sub_No from $DBtable where No=$No"; 
	$Rs_table= mysql_query($Result);
	$Board_d=mysql_fetch_array($Rs_table) ;
	$Pwd=$Board_d[Pass];
	$Sub_No=$Board_d[Sub_No];
	mysql_close($DB); 

	if ($PassWord==$Pwd)  { 
		if($Edit=="Edit_ok"){//수정으로보네기
			echo "<meta http-equiv='refresh' content='0;url=board01_write.htm?No=$No&mode=edit&page=$page&Sub_No=$Sub_No'>"; 	
		}else if($Del_ok=="ok"){//글삭제로보네기
			echo "<meta http-equiv='refresh' content='0;url=erase.php?No=$No'>"; 	
		}
	}else{ 
		 echo "<script>alert('비밀번호가 일치하지 않습니다.');"; 
		 echo "history.back();"; 
		 echo "</script>"; 
	} 

}
?>

