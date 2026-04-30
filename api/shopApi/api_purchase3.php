<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 	

	$userid		= $_POST['userid'];
	$passwd		= $_POST['passwd'];
	$price		= $_POST['price'];
	$deId		= $_POST['deId'];

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
				$result = array("result"=>"0","msg"=>"user password is wrong");
				echo json_encode($result);
		}
		else
		{
				
				$member_code	= $custs[0]['C_CODE'];
				$jik			= $custs[0]['C_JIK'];

				$amount = 0;
				if ($jik == "1") {$amount = 600; $terra=1;}
				if ($jik == "2") {$amount = 1800; $terra=3;}
				if ($jik == "3") {$amount = 3000; $terra=5;}
				if ($jik == "4") {$amount = 6000; $terra=10;}
				if ($jik == "5") {$amount = 12000; $terra=20;}

				include "total_su.php";


				$qty = round(($amount / $price),1);




				if ($ripple < $qty)
				{
					$result = array("result"=>"0","msg"=>"not enough Ripple");
					echo json_encode($result);
				}
				else
				{
						
							
							$date = date("Y-m-d H:i:s");

							$timestamp = strtotime("+35 days");
							$su_date = date("Y-m-d", $timestamp);

							$sql = "c_code		='$member_code',
									c_id		='$userid',
									c_date		='$date',
									c_cash		='$amount',
									c_price		='$price',
									c_qty		='$qty',
									c_terra		='$terra',
									c_type		='$jik',
									c_type2		='ripple',
									c_su_date	='$su_date',
									c_state		='resell'";


							$DB->insert($sell_table, $sql);
							$result = array("result"=>"1","msg"=>"Complete");
							echo json_encode($result);
				 }
					 
				
				
		
		} // 2
	} //1

?>