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
	$coin_type	= $_POST['coin_type'];

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
				$result = array("result"=>"0","msg"=>"withdrawal suspended");
				echo json_encode($result);
				exit;
			}

			$member_code = $custs[0]['C_CODE'];
			include "total_su.php";
			
			$DB->get("select * from $su_list", $infos, $infon);

			if ($coin_type == "ripple")
			{
			$balance = $ripple;
			}
			else if ($coin_type == "xch")
			{
			$balance = $xch;
			}
			

			$wfee = $infos[0]['c_wfee'];
			$fee = $amount * $wfee / 100;
			$total = $amount + $fee;


			//$qty = floor(($amount / $price) * 10000) / 10000;
			$qty = $total;
			if ($balance < $total)
			{
				$result = array("result"=>"0","msg"=>"not enough");
				echo json_encode($result);
			}
			/*
			else if (100 > $amount)
			{
				$result = array("result"=>"0","msg"=>"100$ more than");
				echo json_encode($result);
			}
			*/
			else
			{

				


				$date = date("Y-m-d H:i:s");
				$sql = "c_date		='$date',
						c_code		='$member_code',
						c_id		='$userid',
						c_qty		='$qty',
						c_addr		='$addr',
						c_fee		='$fee',
						c_total		='$total',
						c_state		='Request',
						c_amount	='$amount',
						c_price		='$price',
						c_type		='$coin_type'";

				$DB->insert($with_list, $sql);


				$result = array("result"=>"1","msg"=>"Withdrawal request complete");
				echo json_encode($result);
			}
		}	
	}
?>