<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 	


	$userid		= $_POST['userid'];
	$passwd		= $_POST['passwd'];
	$amount		= $_POST['amount'];
	$deId		= $_POST['deId'];
	$addr		= $_POST['addr'];
	

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
			
			$member_del = $custs[0]['C_DEL'];
			if ($member_del =='y')
			{
				$result = array("result"=>"0","msg"=>"withdrawal stop");
				echo json_encode($result);
				exit;
			}

			$member_code = $custs[0]['C_CODE'];
			include "total_su.php";

			if ($E_MS < $amount)
			{
				$result = array("result"=>"0","msg"=>"not enough");
				echo json_encode($result);
			}
			else if (100 > $amount)
			{
				$result = array("result"=>"0","msg"=>"100 more than");
				echo json_encode($result);
			}
			else
			{
				$DB->get("select * from $su_list", $infos, $infon);

				$usd_amount = $amount;

				$fee	= ($usd_amount * $infos[0]['c_wfee'] / 100) * 10000;
				$fee	= floor($fee) / 10000;	
				$real_qty = $usd_amount - $fee;


						$date = date("Y-m-d H:i:s");
						$sql = "c_code		='$member_code',
								c_id		='$userid',
								c_date		='$date',
								c_amount	='$amount',
								c_addr		='$addr',
								c_qty		='$real_qty',
								c_fee		='$fee',
								c_total		='$eth_qty',
								c_eth_price	='$price',
								c_state		='Request',
								c_type		='mst1'
								";

						$DB->insert($with_list, $sql);


						$result = array("result"=>"1","msg"=>"complete");
						echo json_encode($result);
				
				
			}

		}	
	}
?>