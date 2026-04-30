<?

include "../common/user_function.php";

$DBurl="localhost";
$dbname="codckey";     
$DBid="codckey"; 
$DBpass="dckey1129"; 
$DBconn =mysql_connect($DBurl, $DBid, $DBpass);
$status = mysql_select_db($dbname);

$shop_img="../../shop_img/";

	$query="select uid,code1,code2,code3,cate1,cate2,cate3,rank,order_rank";
	$query=$query." FROM ";
	$query=$query." shop_cate";
	
		
	$DB->get($query,$rs,$rn);
	

$DB->get($query,$rs,$rn);
while($row=mysql_fetch_row($result)){
	$uid = $rs[0][0];										$code1 = $row[1];
	$code2 = $row[2];									$code3 = $row[3];
	$cate1 = $row[4];									$cate2 = $row[5];
	$cate3 = $row[6];									$rank = $row[7];
	$order_rank = $row[8];

	$code4 = '00';

// 카테고리 백업용 쿼리
$query_w="insert into 2013_shop_cate( 
				uid,
				code1,
				code2,
				code3,
				cate1,
				cate2,
				cate3,
				rank,
				order_rank,
				code4,
				cate4
				) 
				values
				(
				'$uid',
				'$code1',
				'$code2',
				'$code3',
				'$cate1',
				'$cate2',
				'$cate3',
				'$rank',
				'$order_rank',
				'$code4',
				'$cate4'
				)";

//echo $query_w;

	//$Rs_table= mysql_query($query_w);

	if (!$Rs_table){
		echo "<h1>오류발생".$query_w."</h1>"; 
	}
};
?>
