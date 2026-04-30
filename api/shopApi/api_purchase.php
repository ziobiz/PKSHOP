<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");


	$userid		= $_POST['userid'];
	$passwd		= $_POST['passwd'];
	$stype		= $_POST['stype'];
	$deId		= $_POST['deId'];
	$price		= $_POST['price'];
	$t_type		= $_POST['t_type'];

	$hid		= $_POST['hid'];
 
	$DB->get("select * from $board_type where c_id='$hid'", $hs, $hn);
	$board_up_idx = $hs[0]['idx'];

	$DB->get("select * from $board_type where c_up_code='$board_up_idx'", $hs2, $hn2);
	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else if ($hn == 0 || $hn2 == 2)
	{
		$result = array("result"=>"0","msg"=>"check your sponsor");
		echo json_encode($result);
	}
	else
	{
		$DB->get("select * from $member_table where C_ID='$userid' and C_FIN_PASS='$passwd'", $custs, $custn);
		$DB->get("select * from $sell_table where c_id='$userid'", $sells, $selln);

		if ($custn == 0)
		{
				$result = array("result"=>"0","msg"=>"user password is wrong");
				echo json_encode($result);
		}
		else if ($selln > 0)
		{
			$result = array("result"=>"0","msg"=>"Please upgrade.");
			echo json_encode($result);
		}
		else	
		{
				$member_code	= $custs[0]['C_CODE'];
				include "total_su.php";

				$amount = 0;

				if ($stype == "1" && $t_type == "1") 
				{
					$amount = 600;
					$real_amount = 600;
					$terra = 1;
				}
				else if ($stype == "1" && $t_type == "2") 
				{
					$amount = 800;
					$real_amount = 600;
					$terra = 1;
					$asell_cnt = 1;
				}
				else if ($stype == "1" && $t_type == "3") 
				{
					$amount = 1000;
					$real_amount = 600;
					$terra = 1;
					$asell_cnt = 2;
				}
				///////////////////////////////////////////////////////////////
				if ($stype == "2" && $t_type == "1") 
				{
					$amount = 1800;
					$real_amount = 1800;
					$terra = 3;
				}
				else if ($stype == "2" && $t_type == "2") 
				{
					$amount = 2400;
					$real_amount = 1800;
					$terra = 3;
					$asell_cnt = 3;
				}
				else if ($stype == "2" && $t_type == "3") 
				{
					$amount = 3000;
					$real_amount = 1800;
					$terra = 3;
					$asell_cnt = 6;
				}
				///////////////////////////////////////////////////////////////

				if ($stype == "3" && $t_type == "1") 
				{
					$amount = 3000;
					$real_amount = 3000;
					$terra = 5;
				}
				else if ($stype == "3" && $t_type == "2") 
				{
					$amount = 4000;
					$real_amount = 3000;
					$terra = 5;
					$asell_cnt = 5;
				}
				else if ($stype == "3" && $t_type == "3") 
				{
					$amount = 5000;
					$real_amount = 3000;
					$terra = 5;
					$asell_cnt = 10;
				}
				///////////////////////////////////////////////////////////////

				if ($stype == "4" && $t_type == "1")
				{
					$amount = 6000;
					$real_amount = 6000;
					$terra = 10;
				}
				else if ($stype == "4" && $t_type == "2")
				{
					$amount = 8000;
					$real_amount = 6000;
					$terra = 10;
					$asell_cnt = 10;
				}
				else if ($stype == "4" && $t_type == "3")
				{
					$amount = 10000;
					$real_amount = 6000;
					$terra = 10;
					$asell_cnt = 20;
				}
				///////////////////////////////////////////////////////////////

				if ($stype == "5" && $t_type == "1")
				{
					$amount = 12000;
					$real_amount = 12000;
					$terra = 20;
				}
				else if ($stype == "5" && $t_type == "2")
				{
					$amount = 16000;
					$real_amount = 12000;
					$terra = 20;
					$asell_cnt = 20;
				}
				else if ($stype == "5" && $t_type == "3")
				{
					$amount = 20000;
					$real_amount = 12000;
					$terra = 20;
					$asell_cnt = 40;
				}





				$total_qty = floor(($amount / $price) * 10) / 10;

				$new_qty = floor(($real_amount / $price) * 10) / 10;
				$add_qty = floor((200 / $price) * 10) / 10;

				

				if ($ripple < $total_qty)
				{
					$result = array("result"=>"0","msg"=>"not enough Ripple");
					echo json_encode($result);
				}
				else
				{
							$date = date("Y-m-d H:i:s");
							
							$timestamp = strtotime("+35 days");
							$su_date = date("Y-m-d", $timestamp);


							$sql = "c_cash		='$real_amount',
									c_code		='$member_code',
									c_id		='$userid',
									c_date		='$date',
									c_state		='new',
									c_qty		='$new_qty',
									c_price		='$price',
									c_terra		='$terra',
									c_type		='$stype',
									c_type2		='ripple',
									c_su_date	='$su_date'";

							$DB->insert($sell_table, $sql);

							for($i=0;$i<$asell_cnt; $i++)
							{
							$sql = "c_code		='$member_code',
									c_id		='$userid',
									c_date		='$date',
									c_cash		='200',
									c_price		='$price',
									c_qty		='$add_qty',
									c_terra		='1',
									c_type		='0',
									c_type2		='ripple',
									c_su_date	='$su_date',
									c_state		='addsell'";


							$DB->insert($sell_table, $sql);
							}


							$DB->get("select sum(c_cash) as total from $sell_table  where c_code = '$member_code' and c_type2='ripple' and c_state!='addsell' " ,$buys_all,$buyn_all);
							
							if($buys_all[0]["total"] >= "12000") $type="5";
							else if($buys_all[0]["total"] >= "6000") $type="4";
							else if($buys_all[0]["total"] >= "3000") $type="3";
							else if($buys_all[0]["total"] >= "1800") $type="2";
							else if($buys_all[0]["total"] >= "600") $type="1";

							$sql = "C_JIK='$type' where C_CODE='$member_code'";
							$DB->update($member_table, $sql);
						
					$status = "new";
					if($status == "new")
					{
							$DB->get("select * from $member_table where C_CODE='$member_code'", $custss, $custnn);
							$c_c_code = $custss[0]['C_C_CODE'];

							$sql = "C_C_CNT = C_C_CNT +1  where C_CODE='$c_c_code'";
							$DB->update($member_table, $sql);

						
					}

					$gu = $hn2 +1;
					include "board_add.php";


							$result = array("result"=>"1","msg"=>"Complete");
							echo json_encode($result);
				 }

		}
	}
?>