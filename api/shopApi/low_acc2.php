<? 
	
	$DB->get("select * from $member_table where c_code='$member_code'", $lows, $lown);
	
	$up_code = $lows[0]['C_C_CODE'];
			
	$check_low = 1;
	

	while ($check_low)
	{

			if ($my_volume ==0)		$sql = "C_C_ACC=C_C_ACC+$amount,C_C_CNT = C_C_CNT +1  where C_CODE='$up_code'";
			else $sql = "C_C_ACC=C_C_ACC+$amount  where C_CODE='$up_code'";
	
			if ($sql != "")	$DB->update($member_table, $sql);
	
		$DB->get("select * from $member_table where C_CODE='$up_code'", $lows2, $lown2);
		$up_code  	= $lows2[0]['C_C_CODE'];
		
		if ($up_code == "0" || $up_code =='') 
		{
			$check_low = 0; 
			break;
		}
	}
	
	

?>