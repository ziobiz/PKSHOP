<?php
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");

	$logid			= $_POST['userid'];
	$deId			= $_POST['deId'];
	$type			= $_POST['type'];

	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{
		$DB->get("select * from $member_table where C_ID='$logid'", $custs, $custn);
		$code = $custs[0]['C_CODE'];

		if ($custn == 0)
		{
			$result = array("result"=>"0","msg"=>"userid is wrong");
			echo json_encode($result);
		}
		else if ($type == "h")
		{
			$DB->get("select * from $board_type where c_code='$code'", $hs, $hn);
			$up_code = $hs[0]['idx'];

			if ($hn == 0)
			{
				$result = array("result"=>"0","msg"=>"check your sponsor1");
				echo json_encode($result);
			
			}
			else
			{
				$DB->get("select * from $board_type where c_up_code='$up_code'", $hs, $hn);

				if ($hn < 2)
				{
					$result = array("result"=>"1","msg"=>"Complete","name"=>$custs[0]['C_NAME']);
					echo json_encode($result);
				}
				else
				{
				$result = array("result"=>"0","msg"=>"check your sponsor2");
				echo json_encode($result);
				
				}
			}
		}
		else
		{
				$result = array("result"=>"1","msg"=>"Complete","name"=>$custs[0]['C_NAME']);
				echo json_encode($result);
		}
	}
	
?>