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
	$Result = "select Pass,Sub_No,No1 from $DBtable where No=$No"; 
	$Rs_table= mysql_query($Result);
	$Board_d=mysql_fetch_array($Rs_table) ;
	$Pwd=$Board_d[Pass];
	$Sno=$Board_d[Sub_No];
	$Pno1=$Board_d[No1];

	$Result = "select Pass from $DBtable where No1=$Pno1"; 
			$result= mysql_query($Result);
			$total_record = $rn;
			for($i1=0;$i1<$total_record=$rn;$i1++) {
				$epass = mysql_result($result,$i1,0);
				if($epass==$PassWord){
					$Pwd_kk="ok";
				}
			}

	mysql_close($DB); 
		
if ($PassWord==$Pwd || $Pwd_kk=="ok")  { 
		if($Edit=="Edit_ok"){//수정으로보네기
			echo "<meta http-equiv='refresh' content='0;url=board01_view.htm?No=$No&Sub_No=$Sno'>"; 	
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