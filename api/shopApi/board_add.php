<?
	$DB->update($board_type,"c_nal=c_nal+1 where idx='$board_up_idx'");
	

	$cust_add1 = "c_code='$member_code',c_id='$userid', c_date='$date', c_up_code='$board_up_idx', c_state='Active',c_gu='$gu',c_level='$type'";
	$DB->insert($board_type, $cust_add1);
	
?>