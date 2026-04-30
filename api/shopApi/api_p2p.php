<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 	


	$user_code	= $_POST['sell_id'];
	$passwd		= $_POST['passwd'];
	$amount		= $_POST['amount'];
	$deId		= $_POST['deId'];
	$my_id		= $_POST['my_id'];

	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{
		$DB->get("select * from $member_table where C_ID='$my_id' and C_FIN_PASS='$passwd'", $custs, $custn);

//	echo "1---";
		if ($custn == 0)
		{
				$result = array("result"=>"0","msg"=>"password is wrong");
				echo json_encode($result);
		}
		else
		{
//	echo "2---";

			$member_code = $custs[0]['C_CODE'];

			include "total_su.php";

			if ($E_MONEY < $amount)
			{
				$result = array("result"=>"0","msg"=>"not enough Credit");
				echo json_encode($result);
			}
			else
			{
				$DB->get("select * from $member_table where C_ID='$user_code'", $custs2, $custn2);

				if ($custn2 > 0)
				{
					$userid = $custs2[0]['C_ID'];
					$user_code = $custs2[0]['C_CODE'];

					$date = date("Y-m-d H:i:s");

					$sql = "c_code		='$member_code',
							c_date		='$date',
							c_id		='$my_id',
							c_used_id	='$userid',
							c_credit	='$amount'";
					$DB->insert($p2p_list, $sql);

				
					$code		= $custs2[0]['C_CODE'];
					$rec_code	= $custs2[0]['C_C_CODE'];

					$DB->get("select * from $sell_table where c_code='$code'", $monyes, $moneyn);
					 if ($moneyn == 0)
					 {
						$DB->get("select * from $member_table where C_CODE='$rec_code'", $ccs, $ccn);
						$c_c_cnt = $ccs[0]['C_C_CNT'] +1;

						$sql_c = "C_C_CNT='$c_c_cnt' where C_CODE='$rec_code'";
						$DB->update($member_table, $sql_c);
					 }
					
					$DB->get("select * from $su_list", $infos, $infon);
					
					$calc_value = $amount * $infos[0]['c_use_cashback'];
					
					$price  =  $infos[0]['c_price'];
					$cash	= $calc_value * $infos[0]['c_pay_cash']   / 100;
					$credit = $calc_value * $infos[0]['c_pay_credit'] / 100;


					$sql = "c_code	='$code',
							c_id	='$userid',
							c_date	='$date',
							c_cash	='$amount',
							c_price	='$price',
							c_pay_cash		='$cash',
							c_pay_credit	='$credit',
							c_state	='Active',
							c_bit	='$calc_value'";

					$DB->insert($sell_table, $sql);



					$DB->get("select * from $member_table where C_CODE='$rec_code'", $ccs, $ccn);
					$low_code = $ccs[0]['C_C_CODE']; 		
					include "low_acc2.php";
					
					$c_c_code = $ccs[0]['C_C_CODE'];
					$amount = $calc_value ;

					$su_type =  "p2p";
					$userid  = $my_id;
				//	include "matching.php";


					$result = array("result"=>"1","msg"=>"Complete");
					echo json_encode($result);
				}
				else 
				{
//	echo "3---";

					$result = array("result"=>"0","msg"=>"user phone number is wrong");
					echo json_encode($result);
				
				}
//	echo "4---";

			}
//	echo "5---";

		}

	}
?>