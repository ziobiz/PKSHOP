<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 	


	

	$deId		= $_POST['deId'];
	$userid		= $_POST['userid'];
	$passwd		= $_POST['passwd'];
	$amount		= $_POST['ytx_qty'];
	$ex_point	= $_POST['ex_point'];

	$yoil = date("w");

	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{

	

		$DB->get("select * from $member_table where C_ID='$userid' and C_FIN_PASS='$passwd'", $custs, $custn);
		
	
		if ($custn == 0)
		{
				$result = array("result"=>"0","msg"=>"Payment password is wrong");
				echo json_encode($result);
		}
		else
		{

			$member_code = $custs[0]['C_CODE'];
		
			include "total_su.php";
			
 
			if ($E_MONEY < $amount)
			{
				$result = array("result"=>"0","msg"=>"not enough ytx");
				echo json_encode($result);
			}
			else
			{
				$date = date("Y-m-d H:i:s");
				$DB->get("select * from $su_list", $infos, $infon);
				$price = $infos[0]['c_price'];

				$sql	=	"c_code	='$member_code',
							c_id	='$userid',
							c_date	='$date',
							c_ytx	='$amount',
							c_price	='$price',
							c_point	='$ex_point'";
				$DB->insert($ex_shop, $sql);
							

				$result = array("result"=>"1","msg"=>"complete");
				echo json_encode($result);
				
			}

		}	
	}
?>