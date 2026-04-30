<?
#디비관련 셋팅파일 불러 오기
include "../common/user_function.php";
include "../common/dbconn.php";

############################################

//메모글 삭제..
$Result = "delete from $shop_point where No=$No"; 

$Rs_table= mysql_query($Result);
echo "<meta http-equiv='refresh' content='0;url=member_modify.php?id=$Comm_No'>"; 	
?>

