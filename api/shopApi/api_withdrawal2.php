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
			

			$member_code = $custs[0]['C_CODE'];
			include "total_su.php";
			
			

			if ($total_ex_lanx < $amount)
			{
				$result = array("result"=>"0","msg"=>"not enough Lanx");
				echo json_encode($result);
			}
			else
			{

/*
					$ch = curl_init();
					curl_setopt ($ch, CURLOPT_URL, $api_lanx_send);
					curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
					curl_setopt ($ch, CURLOPT_POST, 1);
					curl_setopt ($ch, CURLOPT_POSTFIELDS, 'deId='.$api_btc_key.'&bitAccount='.$master_account."&sendAddress=".$addr."&sendBtc=".$amount);
					curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
					curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
					$result = curl_exec ($ch);
					curl_close ($ch);
							
				   $json_o = json_decode($result, true);	
		
				 if ($json_o['result'] != "1")
				 {
					$result = array("result"=>"0","msg"=>$json_o['msg']);
					echo json_encode($result);
				 }
				 else if ($json_o['txid'] == "")
				 {
					$result = array("result"=>"0","msg"=>$json_o['msg']);
					echo json_encode($result);
				 }
				 else
				 {

*/						$date = date("Y-m-d H:i:s");
						$sql = "c_code		='$member_code',
								c_id		='$userid',
								c_date		='$date',
								c_amount	='$amount',
								c_addr		='$addr', 
								c_txid		='".$json_o['txid']."',
								c_state		='Complete'";

						$DB->insert($with_list2, $sql);


						$result = array("result"=>"1","msg"=>"complete");
						echo json_encode($result);
//				 }
//				
			}

		}	
	}
?>