<?
include "../common/user_function.php";
include "../common/dbconn.php";
$c_exchange = $_POST["exchange_t"];
$signdate = time();


$query ="INSERT INTO $coin_goods";
$query = $query."( ";
$query = $query."coin_price,signdate";
$query = $query.") ";
$query = $query."VALUES";
$query = $query."( ";
$query = $query." '$c_exchange', '$signdate' ";
$query = $query." )";

$DB->get($query,$rs,$rn);

if(!$result){
	echo($query);
	echo"<br>";
	echo("query ERORR!");
	exit;
}else{
	echo"<script>alert('성공적으로 수정되었습니다.'); location.href='category.php'</script>";
}

?>