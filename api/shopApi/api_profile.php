<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");

	$member_id		= $_POST['userid'];
	$deId			= $_POST['deId'];
	$name			= trim($_POST['name']);

	$DB->get("select * from $member_table where C_ID='$member_id'", $custs, $custn);

	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else if ($custn == 0)
	{
		$result = array("result"=>"0","msg"=>"member info does not exist");
		echo json_encode($result);
	}
	else
	{
		$sql = "C_NAME='$name' where C_ID='$member_id'";
		$DB->update($member_table, $sql);

		$result = array("result"=>"1","msg"=>"update Complete");
		echo json_encode($result);
	}
	
?>