<meta charset="utf-8">
<?
#디비관련 셋팅파일 불러 오기
include "../../Adm/common/dbconn.php";
include '../../Adm/admin_board_01/db_config/dbcon.php';
				
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
		echo "<script>alert('Password does not match.');"; 
		echo "window.close();"; 
		echo "</script>"; 
	} 

	
}else{

$Result = "select Pass,No1 from t_admin_board_01 where No=$No"; 

			$Rs_table= mysql_query($Result);
			$Comm_d=mysql_fetch_array($Rs_table); 
			
			//-------------------------------				
				$Pwd=$Comm_d[Pass];	
				$Pno1=$Comm_d[No1];

			//-------------------------------

$Result = "select Pass from t_admin_board_01 where No=$Pno1"; 

			$result= mysql_query($Result);
			$total_record = mysql_num_rows($result);
			for($i1=0;$i1<$total_record;$i1++) {
				$epass = mysql_result($result,$i1,0);
				if($epass==$PassWord){
					$Pwd_kk="ok";
				}
			}

	mysql_close($DB); 

	if ($PassWord==$Pwd || $Pwd_kk=="ok")  { 
		if($Edit=="Edit_ok"){//수정으로보네기
			echo "<meta http-equiv='refresh' content='0;url=view.php?No=$No&Sub_No=$Sub_No'>"; 	
		}else if($Del_ok=="ok"){//글삭제로보네기
			echo "<meta http-equiv='refresh' content='0;url=erase.php?No=$No'>"; 	
		}
	}else{ 
		 echo "<script>alert('Password does not match.');"; 
		 echo "history.back();"; 
		 echo "</script>"; 
	} 

}
?>