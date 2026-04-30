<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");

	$userid			= $_POST['userid'];
	$newpass		= trim($_POST['passwd']);
	$deId			= $_POST['deId'];
	$old_pass		= trim($_POST['oldpass']);
	
	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{
			$DB->get("select * from $member_table where C_ID='$userid' and C_PASS='$old_pass'", $rs, $rn);

			if ($rn == 0)
			{
				$result = array("result"=>"0","msg"=>"old password is wrong");
				echo json_encode($result);
			}
			else
			{
				$sql = "C_PASS='$newpass' where C_ID='$userid'";
				$DB->update($member_table, $sql);

				$result = array("result"=>"1","msg"=>"Complete");
				echo json_encode($result);
			}
	}
?>