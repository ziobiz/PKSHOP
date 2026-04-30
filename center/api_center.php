<?	
echo "fdsfds";




$query = "SELECT * FROM center";

echo $query;
$result = mysql_query($query,$DBconn);
if(!$result) {
   error("QUERY_ERROR");
   exit;
}

$total_record = mysql_num_rows($result);

echo $total_record;


$dicName = "center";
$dic = array('11st_syn' , 'syn_index' , 'syn_common' , 'syn_color' , 'token_dic');



foreach($dic as $dicName){

    echo $dicName . "처리중 ... " ;



    $result = mysql_query("SELECT c_name from $dicName");

    while($row = mysql_fetch_array($result)){



        if(in_array($row['c_name'] , $syn0arr)){

            fwrite($syn0 , $row['c_name'] . "\t" . $row['keyword'] . "\n");

            continue;

        }

    }

    echo "완료 </br>";

}



출처: https://ra2kstar.tistory.com/115 [초보개발자 이야기.]


/*
	include_once( "../lib/basic_class.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 

	
	$deId	= $_POST['deId'];

	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{
	
		$DB->get("select * from $center_table", $cs,$cn);
		$data_list = "";
		for($i=0;$i<$cn;$i++)
		{

			$data_list .=$cs[$i]['c_name'].",";

		}
	
			echo ($data_list);
	}*/
?>