<?
include "../common/user_function.php";

$DBurl="localhost";
$dbname="mcasand";     
$DBid="mcasand"; 
$DBpass="mca1234"; 
$DBconn =mysql_connect($DBurl, $DBid, $DBpass);
$status = mysql_select_db($dbname);

	$query="select id,passwd,name,jumin,sex,job,email,tel,handphone,zip,address,info,signdate,point,admail,dis";
	$query=$query." FROM ";
	$query=$query." member";
	
		
	$DB->get($query,$rs,$rn);
	

$DB->get($query,$rs,$rn);
while($row=mysql_fetch_row($result)){
	$id = $rs[0][0];										$passwd = $row[1];
	$name = $row[2];								$jumin = $row[3];
	$sex = $row[4];									$job = $row[5];
	$email = $row[6];								$tel = $row[7];
	$handphone = $row[8];						$zip = $row[9];
	$address = $row[10];							$info = $row[11];
	$signdate = $row[12];							$point = $row[13];
	$admail = $row[14];								$dis = $row[15];

// 카테고리 백업용 쿼리

$query_w="insert into 2013_member( 
				id,
				passwd,
				name,
				jumin,
				solar,
				sex,
				job,
				email,
				tel,
				handphone,
				zip,
				address,
				info,
				signdate,
				point,
				admail,
				adsms,
				dis,
				cont,
				dis1,
				company,
				recommend,
				member_cnt,
				etc1,
				etc2
				) 
				values
				(
				'$id',
				'$passwd',
				'$name',
				'$jumin',
				'$solar',
				'$sex',
				'$job',
				'$email',
				'$tel',
				'$handphone',
				'$zip',
				'$address',
				'$info',
				'$signdate',
				'$point',
				'$admail',
				'$adsms',
				'$dis',
				'$cont',
				'$dis1',
				'$company',
				'$recommend',
				'$member_cnt',
				'$etc1',
				'$etc2'
				)";

//echo $query_w."<br>";

	$Rs_table= mysql_query($query_w);

	if (!$Rs_table){
		echo "<h1>오류발생".$query_w."</h1>"; 
	}
};
?>
