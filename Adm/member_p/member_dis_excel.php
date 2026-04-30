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
$query = "SELECT no,id,name,jumin,sex,email,handphone,zip,address,info,signdate,Fname,admail,adsms from $member_table_p where id='$id'";


$query = $query."ORDER BY signdate DESC";	


$DB->get($query,$rs,$rn);

#####################################################################
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
</head>

<body>
								 
	
								<table border='1' cellpadding='0' cellspacing='0'>
									<tr align="center"> 
										<td height="30">번호</td>
										<td height="30">이름</td>
										<td height="30">생년월일</td>
										<td height="30">성별</td>
										<td height="30">이메일</td>
										<td height="30">핸드폰</td>
										<td height="30">우편번호</td>
										<td height="30">주소</td>
										<td height="30">등록일</td>
									</tr>
<?
#####################################################################

$ii=0;
for($i = 0; $i < $total_record; $i++) { 
	$name =$rs[$i][2];
	$jumin =$rs[$i][3];
	$sex =$rs[$i][4];
	$email =$rs[$i][5];
	$handphone =$rs[$i][6];
	$zip =$rs[$i][7];
	$address =$rs[$i][8];
	$signdate =$rs[$i][10];

	$jumin = explode("-",$jumin);
	$Birth_year = $jumin[0];
	$Birth_month = $jumin[1];
	$Birth_day = $jumin[2];

	$signdate = date("Y-m-d H:i:s",$signdate);


	
#####################################################################
?>
								<tr align="center"> 
									<td height="30"><?=$i+1?></td>
									<td height="30"><?=$name?></td>
									<td height="30"><?=$Birth_year?>년 <?=$Birth_month?>월 <?=$Birth_day?>일</td>
									<td height="30"><?if($sex=="M"){?>남<?}else{?>여<?}?></td>
									<td height="30"><?=$email?></td>
									<td height="30" style='mso-number-format:\@;'><?=$handphone?></td>
									<td height="30"><?=$zip?></td>
									<td height="30"><?=$address?></td>
									<td height="30"><?=$signdate?></td>
								</tr>


<?}?>
							</table>
				</body>
</html>
