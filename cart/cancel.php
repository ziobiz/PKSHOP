<? 
####################################################################
// error_reporting( E_ALL );
//   ini_set( "display_errors", 1 );
include "../include/top_session.php";
$ordnum = $_GET["ordnum"];
$rOrdNo = $_GET["rOrdNo"];

// include "../../Adm/common/dbconn.php";
// include "../../Adm/common/user_function.php";


$ordnum = $_REQUEST["ordnum"];
curl_d($api_category,"&Type=sellCancle&ordnum=$ordnum");




	

// mysql_close($DBconn);

echo("<meta http-equiv='Refresh' content='0; URL=./overview.php?kk_name=$kk_name&kk_num=$kk_num'>");

#####################################################################
?>