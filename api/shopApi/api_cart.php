<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 

	$Type	= $_POST['Type'];
	$deId	= $_POST['deId'];
	$user_id= $_POST['user_id'];
	$code1	= $_POST['code1'];
	$code2	= $_POST['code2'];
	$code3	= $_POST['code3'];
	$code4	= $_POST['code4'];



	
	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{
		
		// echo 
		$DB->get("select * from $member_table where c_id=:user_id", $custs, $custn,array("user_id"=>$user_id));
		$member_code = $custs[0]['c_code'];


		$data_list = array();


		if ($Type == "orderCount")
		{
			
			$k = 0;
			
			$query ="select * from $shop_order where id = :user_id and status<>'주문대기' order by ordernum desc";
			
            $DB->get($query,$ords,$ordn,array("user_id"=>$user_id));
			for($i=0;$i<$ordn;$i++)
			{	
                
                $ords[$i]["count"] = $ordn;
				$data_list[$k]=$ords[$i];
				$k++;
			}

	
			echo json_encode($data_list);
		
		}
		if ($Type == "pointList")
		{
			
			$k = 0;
			
			$query ="select * from $shop_order where id = :user_id and (status<>'주문취소' && status <> '주문자취소') and usepoint+0>0 order by ordernum desc";
			
            $DB->get($query,$ords,$ordn,array("user_id"=>$user_id));
			for($i=0;$i<$ordn;$i++)
			{	
                
                $ords[$i]["count"] = $ordn;
				$data_list[$k]=$ords[$i];
				$k++;
			}

	
			echo json_encode($data_list);
		
		}
		else if ($Type == "sellList")
		{
			
			$k = 0;
			$ordernum = $_POST["ordernum"];

			$query1 = "SELECT ordernum,signdate, title, money , count , opt1,code, coin, prices FROM $shop_sell where ordernum = :ordernum";

			$DB->get($query1,$ord2s,$ord2n,array("ordernum"=>$ordernum));
			for($i=0;$i<$ord2n;$i++)
			{	
                
                
				$data_list[$k]=$ord2s[$i];
				$k++;
			}
			
			$data_list["total"]=$ord2n;
			echo json_encode($data_list);
		
		}


		
}




?>