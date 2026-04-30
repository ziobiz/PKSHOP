<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 	

	$userid		= $_POST['userid'];
	$passwd		= $_POST['passwd'];
	$price		= $_POST['price'];
	$deId		= $_POST['deId'];
	$type		= $_POST['stype'];


	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{
		$DB->get("select * from $member_table where C_ID='$userid' and C_FIN_PASS='$passwd'", $custs, $custn);
		$jik			= $custs[0]['C_JIK'];
		$member_code	= $custs[0]['C_CODE'];

		if ($custn == 0)
		{
				$result = array("result"=>"0","msg"=>"user password is wrong");
				echo json_encode($result);
		}
		else if ($jik >= $type)
		{
		
				$result = array("result"=>"0","msg"=>"Please choose another package");
				echo json_encode($result);
		}
		else
		{
				
				include "total_su.php";
				
				$amount = 0;


				if ($jik == "1")
				{
					if ($type == "2") {$amount = 1200; $terra=2;}
					else if ($type == "3") {$amount = 2400; $terra=4;}
					else if ($type == "4") {$amount = 5400; $terra=9;}
					else if ($type == "5") {$amount = 11400; $terra=19;}
				}
				else if ($jik == "2")
				{
					if ($type == "3") {$amount = 1200; $terra=2;}
					else if ($type == "4") {$amount = 4200; $terra=7;}
					else if ($type == "5") {$amount = 10200; $terra=17;}
				}
				else if ($jik == "3")
				{
					if ($type == "4") {$amount = 3000; $terra=5;}
					else if ($type == "5") {$amount = 9000; $terra=15;}
				}
				else if ($jik == "4")
				{
					if ($type == "5") {$amount = 6000; $terra=10;}
				}		
			
				$qty = round(($amount / $price),1);

				if ($ripple < $qty)
				{
					$result = array("result"=>"0","msg"=>"not enough eth");
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
									c_type		='$type',
									c_type2		='ripple',
									c_su_date	='$su_date',
									c_state		='upgrade'";


							$DB->insert($sell_table, $sql);
							$sql = "C_JIK='$type' where c_code='$member_code'";
							$DB->update($member_table, $sql);

							$sql = "c_level='$type' where c_code='$member_code'";
							$DB->update($board_type, $sql);


							$result = array("result"=>"1","msg"=>"Complete");
							echo json_encode($result);
				 }
					 
				
				
		
		} // 2
	} //1

?>