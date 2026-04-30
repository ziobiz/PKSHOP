<?
	$DB->get("select * from $board_type where c_code='$code'", $boards, $boadn);
	$lol_up_code = $boards[0]['c_up_code'];
	
	$DB->get("select * from $board_type where idx='$lol_up_code'", $boards, $boadn);
	$su_code	= $boards[0]['c_code'];
	$su_id		= $boards[0]['c_id'];
		
	if ($su_code != "0")
	{
		for ($lol=0;$lol < 10; $lol++)
		{
			$lol_cnt = $lol+1;
			$per = 0;

			if ($lol < 5) $per = 2;
			else {$per = 1;
			
			}

			$DB->get("select * from $member_table where C_CODE='$su_code'", $custs, $custn);
			$c_c_cnt = $custs[0]['C_C_CNT'];

			$DB->get("select sum(c_cash) as total from $sell_table where c_code='$su_code'", $sells, $selln);

			if ($sells[0]['total'] >= $upgrade_money )	$lol_cash = $upgrade_money * $per / 100;
			else 
				$lol_cash = $sells[0]['total'] * $per / 100;
				
				$lol_cash = round($lol_cash,2);
			if ($su_code != "" && $lol < 5)
			{
			$sql = "c_code		='$su_code',
					c_pay_id	='$id',
					c_id		='$su_id',
					sil			='$lol_cash',
					c_date		='$date',
					title_1		=' ROL - ".$lol_cnt."',
					title_2		='ROL'";
			
			$DB->insert("su",$sql);	
			echo $sql."<br>";
			}
			else if ($c_c_cnt >= 3 && $su_code != "")
			{
			$sql = "c_code		='$su_code',
					c_pay_id	='$id',
					c_id		='$su_id',
					sil			='$lol_cash',
					c_date		='$date',
					title_1		=' ROL - ".$lol_cnt."',
					title_2		='ROL'";
			
			$DB->insert("su",$sql);	
			echo $sql."<br>";
			
			}

			if ($lol_up_code == "0" || $lol_up_code == "") {break;}
			if ($su_code == "") {break;}
					
			$DB->get("select * from $board_type where idx='$lol_up_code'", $loldatas, $loldatan);
			$lol_up_code = $loldatas[0][c_up_code];

			$DB->get("select * from $board_type where idx='$lol_up_code'", $mydatas, $mydatan);
			$su_code = $mydatas[0][c_code];
			$su_id= $mydatas[0][c_id];
			
			if ($lol_up_code == "0" || $lol_up_code == "") break;
			
			if ($su_code == "") break;
		}
	}
?>