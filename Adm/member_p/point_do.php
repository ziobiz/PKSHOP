<? 
include "../common/dbconn.php";

//========단 따음표나 쌍따음표 치환==================================
$Comm_Wdate="now()";	

//====================================================================
//echo $Cid."<br>";
//echo $Cont."<br>";
//echo $shop_point."<br>";
$Result="insert into $shop_point values";
$Result=$Result."(";
$Result=$Result."''"; #no 값이 들어 간다...자동 증가.
$Result=$Result.",'$Cid'";
$Result=$Result.",'$Cont'";
$Result=$Result.",'$Point'";
$Result=$Result.",$Comm_Wdate";
$Result=$Result.",'$Signdate'";
$Result=$Result.")";
//echo "$Result";
//exit;
$Rs_table= mysql_query($Result);

//=============================================================

$query_m = "SELECT point from $member_table WHERE id='$Cid'";
$result_m = mysql_query($query_m);
if(!$result_m) {
  	error("QUERY_ERROR");
  	exit;
}
$row_m = mysql_fetch_row($result_m);
$point_m = $row_m[0];

$point_tmp = $point_m + $Point;

$Result="update $member set point='$point_tmp' where id='$Cid'";
//echo $Result;
//exit;
$Rs_table= mysql_query($Result);

mysql_close($DB);
if (!$Rs_table) 	{
		echo "<h1>오류발생".$Result."</h1>"; 
}else {
		echo "<meta http-equiv='refresh' content='0;url=member_modify.php?id=$Cid'>"; 
}
?>
