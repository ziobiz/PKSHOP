<? 
include '../admin/admin_board_01/db_config/dbcon.php';
 
IF($keynum>3){//광고글 차단

//========단 따음표나 쌍따음표 치환==================================
$Board_No	= $Board_No;
$Comm_Writer = addslashes($Comm_Writer);					$Comm_Pass = addslashes($Comm_Pass);
$Comm_Cont = addslashes($Comm_Cont);						$Comm_Wdate="now()";	

$Comm_Cont=trim($Comm_Cont);
//====================================================================

$Result="insert into $DBtable2 values";
$Result=$Result."(";
$Result=$Result."''"; #no 값이 들어 간다...자동 증가.
$Result=$Result.",'$Board_No'";
$Result=$Result.",'$Comm_Writer'";
$Result=$Result.",'$Comm_Pass'";
$Result=$Result.",'$Comm_Cont'";
$Result=$Result.",$Comm_Wdate";
$Result=$Result.")";
$Rs_table= mysql_query($Result);
//echo $Result."<br>";
//=============================================================
 
mysql_close($DB); 

if (!$Rs_table) 	{
		echo "<h1>오류발생".$Result."</h1>"; 
}else {
		echo "<meta http-equiv='refresh' content='0;url=board01_view.htm?No=$Board_No&page=$page'>"; 
}

}ELSE{
		echo "<meta http-equiv='refresh' content='0;url=board01_view.htm?Sub_No=$Sub_No'>"; 
}
?>
