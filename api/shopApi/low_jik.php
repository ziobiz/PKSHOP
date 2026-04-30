<? 	
	$DB->get("select * from $board_type where c_code='$member_code' order by idx", $lows, $lown);
	$up_code	= $lows[0]['c_up_code'];
	$nal		= $lows[0]['c_gu'];

	$DB->get("select * from $board_type where idx='$up_code' order by idx", $lows, $lown);
	$su_code	= $lows[0]['c_code'];
			

	$check_low = 1;
	while ($check_low)
	{
			$sql = '';
			
			if ($c_c_code == $su_code)
			{
				if ($nal == 1)		$sql = "c_l_c = c_l_c + 1  where idx='$up_code'";
				else if ($nal == 2)	$sql = "c_r_c = c_r_c + 1  where idx='$up_code'";	
				if ($sql != "")	$DB->update($board_type, $sql);

				break;
			}	
	
			
			$DB->get("select * from $board_type where idx='$up_code' order by idx", $lows2, $lown2);

			$up_code  	= $lows2[0]['c_up_code'];
			$nal 	  	= $lows2[0]['c_gu'];

			$DB->get("select * from $board_type where idx='$up_code' order by idx", $lows2, $lown2);
			$su_code = $lows2[0]['c_code'];

		

			if ($up_code == "0" || $up_code =='') 
			{
				$check_low = 0; 
				break;
			}		
	}
?>