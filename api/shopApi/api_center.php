<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 

	
	$deId	= $_POST['deId'];

	if ($deId != $store_key)
	{
		//$result = array("result"=>"0","msg"=>"deId is wrong");
		//echo json_encode($result);
	}
	else
	{
	
		$data_list = array();
		$DB->get("select * from $center_table", $cs,$cn);
		
		for($i=0;$i<$cn;$i++)
		{
			$name = $cs[$i]['c_name'];

			$data_list[$i]=array("name"=>$name);

		}
	
			echo json_encode($data_list);
	}
?>