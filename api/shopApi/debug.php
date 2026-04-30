<?
	include "../lib/basic_class2.php";
	include "../lib/config.php";
	include "../lib/common.php";
	include "../lib/php_page.php"; 
	include "../lib/php_function.php"; 
	
	/*
exit;
$DB->get("select * from $sell_table order by c_code", $rs, $rn);

for ($j=0;$j<$rn;$j++)
	{
		$code=$rs[$j]['c_code'];
		$c_cash=$rs[$j]['c_cash'];
		echo $rs[$j]['c_id']."/".$code."<br>";
		//추천업데이트

		if($c_cash=='500'){
			$k_jik=1;
		}else if($c_cash=='1000'){
			$k_jik=2;
		}else if($c_cash=='2000'){
			$k_jik=3;
		}else if($c_cash=='5000'){
			$k_jik=4;
		}else if($c_cash=='10000'){
			$k_jik=5;
		}

		//직급업데이트
		$sql = "C_JIK='$k_jik' where c_code='$code'";
		$DB->update($member_table, $sql);

		$sql = "c_level='$k_jik' where c_code='$code'";
		$DB->update($board_type, $sql);

		echo "select * from $member_table where c_code='$code' <br>";
		$DB->get("select * from $member_table where c_code='$code'", $custss, $custnn);
		$c_c_code = $custss[0]['C_C_CODE'];

		echo $c_c_code."<br>";
		if ($c_c_code != "")
		{
			$sql = "C_C_CNT = C_C_CNT +1  where c_code='$c_c_code'";
			echo $sql."<br>";
			$DB->update($member_table, $sql);
		}
		
	}	

	*/

$board_type = "board1";

	$DB->get("select * from $board_type order by idx", $rs, $rn);

	for($i=1;$i<$rn;$i++)
	{
	
		$code		= $rs[$i]['c_code'];
		$up_code	= $rs[$i]['c_up_code'];

		$DB->get("select * from $member_table where c_code='$code'", $custs, $custn);

		$c_c_code	= $custs[0]['C_C_CODE'];


		echo $code."/".$c_c_code."<br>";

		$DB->get("select * from $board_type where c_code='$code' order by idx", $lows, $lown);
		$up_code	= $lows[0]['c_up_code'];
		$nal		= $lows[0]['c_gu'];

		$DB->get("select * from $board_type where idx='$up_code' order by idx", $lows, $lown);
		$up_code	= $lows[0]['c_up_code'];
		$su_code	= $lows[0]['c_code'];
		$c_l		= $lows[0]['c_l_c'];
		$c_r		= $lows[0]['c_r_c'];
		
		echo $su_code."/".$nal."<br>";
		$check_low = 1;

		
		while ($check_low)
		{
				$sql = '';
				
				if ($c_c_code == $su_code)
				{
					$c_l = $c_l +1;
					$c_r = $c_r +1;

					if ($nal == 1)		$sql = "c_l_c = '$c_l'  where idx='$up_code'";
					else if ($nal == 2)	$sql = "c_r_c = '$c_r'  where idx='$up_code'";	

					if ($sql != "")	$DB->update($board_type, $sql);

					echo $sql."<br>";
					break;
				}	
		
				
				$DB->get("select * from $board_type where idx='$up_code' order by idx", $lows2, $lown2);

				$up_code  	= $lows2[0]['c_up_code'];
				$nal 	  	= $lows2[0]['c_gu'];
				$su_code	= $lows2[0]['c_code'];
				$c_l		= $lows2[0]['c_l_c'];
				$c_r		= $lows2[0]['c_r_c'];

				echo $su_code."<br>";

				if ($up_code == "0" || $up_code =='') 
				{
					$check_low = 0; 
					break;
				}		
		}


		
	}
?>
