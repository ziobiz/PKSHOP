<?
header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=$file_name.xls" );  //엑셀 파일이름 지정
header( "Content-Description: PHP4 Generated Data" );
?>
<?
#####################################################################

include "../common/user_function.php";
include "../common/dbconn.php";

$encoded_key = urlencode($key);
$query = "SELECT No,Cid,Cont,Point,Wdate,Signdate FROM $shop_point ";

if($key != ""){
	$query = $query." where Cont LIKE '%$key%' ";
}

$query = $query."ORDER BY No DESC";	


$DB->get($query,$rs,$rn);

#####################################################################
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
</head>

<body onContextMenu="return false" onSelectStart="return false" onDragStart="return false" onUnload="if (sub_popup != null) sub_popup.close();" onLoad="MM_preloadImages('images/tap02o.gif')">
								 
	
								<table border='1' cellpadding='0' cellspacing='0'>
									<tr><td colspan=4 height=3 bgcolor='#88B7DA'></td></tr>
									<tr align="center" bgcolor='#EBF0F4'> 
										<td height="30">아이디</td>
										<td height="30">코인</td>
										<td height="30">내역</td>
										<td height="30">날짜</td>
									</tr>
<?
#####################################################################

$ii=0;
for($i = 0; $i < $total_record; $i++) { 
	$No =$rs[$i][0];
	$Cid =$rs[$i][1];
	$Cont =$rs[$i][2];
	$Point =$rs[$i][3];
	$Wdate =$rs[$i][4];
	$Signdate =$rs[$i][5];
	
#####################################################################
?>
								<tr align="center"> 
									<td height="30"><?=$Cid?></td>
									<td height="30"><?=$Point?></td>
									<td height="30"><?=$Cont?></td>
									<td height="30"><?=$Wdate?></td>
								</tr>


<?}?>
							</table>
				</body>
</html>
