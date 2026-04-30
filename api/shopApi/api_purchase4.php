<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 	

	$userid		= $_POST['userid'];
	$passwd		= $_POST['passwd'];
	$price		= $_POST['price'];
	$deId		= $_POST['deId'];
	$addqty		= $_POST['addqty'];

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
				
				$DB->get("select * from $sell_table where c_code='$member_code' and c_state='addsell' ", $addsells, $addselln);

				if ($jik == 1)
				{
					$cnt =2;
				}
				else if ($jik == 2)
				{
					$cnt =6;
				}
				else if ($jik == 3)
				{
					$cnt =10;
				}
				else if ($jik == 4)
				{
					$cnt =20;
				}
				else if ($jik == 5)
				{
					$cnt =40;
				}

				include "total_su.php";
				
				$qty = round((200 / $price),1); 
				$amount = 200 * $addqty;
				$total_qty = round(($amount / $price),1);

				


				if ($ripple < $total_qty)
				{
					$result = array("result"=>"0","msg"=>"not enough Ripple");
					echo json_encode($result);
				}
				else if ($cnt == $addselln)
				{
					$result = array("result"=>"0","msg"=>"Number of purchases exceeded. ");
					echo json_encode($result);
				}
				else
				{
						
							
							$date = date("Y-m-d H:i:s");

							$timestamp = strtotime("+35 days");
							$su_date = date("Y-m-d", $timestamp);
							

							for($i=0;$i<$addqty; $i++)
							{
							$sql = "c_code		='$member_code',
									c_id		='$userid',
									c_date		='$date',
									c_cash		='200',
									c_price		='$price',
									c_qty		='$qty',
									c_terra		='1',
									c_type		='0',
									c_type2		='ripple',
									c_su_date	='$su_date',
									c_state		='addsell'";


							$DB->insert($sell_table, $sql);
							}

							$result = array("result"=>"1","msg"=>"Complete");
							echo json_encode($result);
				 }
					 
				
				
		
		} // 2
	} //1

?>