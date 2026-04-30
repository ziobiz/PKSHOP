<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 	


	

	$deId		= $_POST['deId'];
	$userid		= $_POST['userid'];
	$passwd		= $_POST['passwd'];
	$amount		= $_POST['amount'];
//	$phone      = $_POST['phone'];
	$trans_code = $_POST['trans_code'];

	$yoil = date("w");

	if ($deId != hash('sha256',"hanwul1.cafe24.com"))
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else if ($yoil != "5")
	{
		$result = array("result"=>"0","msg"=>"Available on Fridays only");
		echo json_encode($result);
	
	}
	else
	{

	

		$DB->get("select * from $member_table where C_ID='$userid' and C_FIN_PASS='$passwd'", $custs, $custn);
		
		$DB->get("select * from $member_table where C_ID='$trans_code'", $ccs, $ccn);
	

	/*	$lengh  = strlen($c_c_id);
		if ($lengh == 11) $check_phone = substr($c_c_id,7,4);
		else if ($lengh == 10) $check_phone = substr($c_c_id,6,4);
		
		else if ($check_phone != $phone)
		{
				$result = array("result"=>"0","msg"=>"Transfer Phone number is wrong");
				echo json_encode($result);
		
		}
	*/
		if ($custn == 0)
		{
				$result = array("result"=>"0","msg"=>"Payment password is wrong");
				echo json_encode($result);
		}
		else
		{

			$member_code = $custs[0]['C_CODE'];

		
			include "total_su.php";
			
			$limit =  $E_MONEY * 0.1;
			
			$sdate = date("Y-m-d")." 00:00:00";
			$edate = date("Y-m-d")." 23:59:59";

			$DB->get("select * from emoney where send_code='$member_code' and c_date between '$sdate' and '$edate'",$emoneys, $emoneyn);
 
			if ($E_MONEY < $amount)
			{
				$result = array("result"=>"0","msg"=>"not enough cash");
				echo json_encode($result);
			}
			else if ($limit < $amount)
			{
				$result = array("result"=>"0","msg"=>"trans amount is big");
				echo json_encode($result);
			}
			else if ($emoneyn > 0)
			{
				$result = array("result"=>"0","msg"=>"Only once");
				echo json_encode($result);
			}
			else
			{
				$date = date("Y-m-d H:i:s");
				$DB->result("insert into emoney(send_id,send_code,receive_id,receive_code,emoney,fee,total,c_date,c_type)values('$userid','$member_code','".$ccs[0]['C_ID']."','".$ccs[0]['C_CODE']."','$amount','0','0','$date','c')");

				$result = array("result"=>"1","msg"=>"complete");
				echo json_encode($result);
				
			}

		}	
	}
?>