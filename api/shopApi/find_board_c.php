<?
		$sql = "select * from $board_type where c_code='$find_code' order by idx";	
		$DB->get($sql, $mys, $myn);	

		$maketree = array();
		
		$maketree[0] = $mys[0]['idx'].",".$mys[0]['c_code'].",".$mys[0]['c_id'].",".$mys[0]['c_up_code'].",0,0,".$mys[0]['idx'];
		
		$pos = count($maketree);
		$cnt = count($maketree);

		for ($j=0;$j<$cnt;$j++)
		{			
			$temp = explode(",",$maketree[$j]);
			
			$my_idx= $temp[0];
			
			if ($my_idx != ""){
			
				$DB->get("select * from $board_type where c_up_code='$my_idx'",$updatas, $updatan);

			
				$maketree[$pos] = $updatas[0]['idx'].",".$updatas[0]['c_id'].",".$updatas[0]['c_code'].",".$updatas[0]['c_up_code'].",".$nal.",".$updatas[0]['c_date'];
				$pos++;	
			
				if ($updatan == 2)
				{
					$maketree[$pos] = $updatas[1]['idx'].",".$updatas[1]['c_id'].",".$updatas[1]['c_code'].",".$updatas[1]['c_up_code'].",".$nal.",".$updatas[1]['c_date'];
					$pos++;	
				}
		
				$cnt = count($maketree);
				
				if ($updatan == 0 || $updatan == 1)
				{
					$board_up_idx= $my_idx	;
					break;
				}
			}
		}
		

?>