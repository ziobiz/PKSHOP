<?
#####################################################################

$title = trim($title);
$title = addslashes($title);

########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../common/user_function.php";

$signdate = time();


########## shop 데이터베이스에서 현재값을 추출 ######################

$result = mysql_query("SELECT currnum FROM $shop_goods WHERE code='$code'",$DBconn);

if (!$result) {
   error("QUERY_ERROR");
   exit;
}


$postnum2 = intval($postnum2);
$currnum = $row[0] + $postnum2;

########## shop 데이터베이스에 입력값을 삽입한다. ###################


$query="UPDATE $shop_goods SET";
$query=$query." theme='$theme',pricec='$pricec',prices='$prices',priced='$priced'";
$query=$query.",currnum='$currnum',point='$point',warnnum='$warnnum'";
$query=$query."WHERE code = '$code'";

$DB->get($query,$rs,$rn);



echo("<meta http-equiv='Refresh' content='0; URL=./pro_buy.php?page=$page'>");
?>
