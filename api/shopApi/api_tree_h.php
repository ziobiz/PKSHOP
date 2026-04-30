<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 

	
	$deId		= $_POST['deId'];
	$userid		= $_POST['userid'];

	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{

		$DB->get("select * from $board_type where c_id='$userid'", $rs, $rn);
		
		
		$maketree = array();

		$dates = explode(" ", $rs[0]['c_date']);
		$DB->get("select * from $member_table where C_ID='$userid'", $custs, $custn);
		
		$code = $custs[0]['C_CODE'];
		$DB->get("select sum(c_cash) as ctotal,sum(c_terra) as ttotal from $sell_table where c_code='$code' and c_state!='addsell' ",$repqtys,$repqtyn);

		$maketree2[0] = $rs[0]['idx'].",".$rs[0]['c_code'].",".$rs[0]['c_id'].",".$rs[0]['c_up_code'].",".$dates[0].",".$custs[0]['C_NAME'].",".$rs[0]['c_level'].",".$repqtys[0]['ttotal'].",".$repqtys[0]['ctotal'];
		
		$pos = count($maketree2);
		$cnt = count($maketree2);
		$check_cnt = 0;
		$grade = 0;
		for ($j=0;$j<$cnt;$j++)
		{
			
			$temp = explode(",",$maketree2[$j]);
			
			$my_idx	= $temp[0];
			$leg	= $temp[7];

			if ($my_idx != "")
			{
			
			$DB->get("select * from board1 where c_up_code='$my_idx'",$updatas, $updatan);

			$input_leg = $leg+ 1;

			if ($updatan > 0)
			{

				$dates = explode(" ", $updatas[0]['c_date']);

				$DB->get("select * from $member_table where C_CODE='".$updatas[0]['c_code']."'", $custs, $custn);
				
				$code = $updatas[0]['c_code'];
				$DB->get("select sum(c_cash) as ctotal,sum(c_terra) as ttotal from $sell_table where c_code='$code'  and c_state!='addsell'",$repqtys,$repqtyn);

				$maketree2 [$pos] = $updatas[0]['idx'].",".$updatas[0]['c_code'].",".$updatas[0]['c_id'].",".$updatas[0]['c_up_code'].",".$dates[0].",".$custs[0]['C_NAME'].",".$updatas[0]['c_level'].",".$repqtys[0]['ttotal'].",".$repqtys[0]['ctotal'];
				$pos++;	
			
			}

			if ($updatan ==2)
			{

						$dates = explode(" ", $updatas[1]['c_date']);

				$DB->get("select * from $member_table where C_CODE='".$updatas[1]['c_code']."'", $custs, $custn);
				
				$code = $updatas[1]['c_code'];
				$DB->get("select sum(c_cash) as ctotal,sum(c_terra) as ttotal from $sell_table where c_code='$code' and c_state!='addsell' ",$repqtys,$repqtyn);

				$maketree2 [$pos] = $updatas[1]['idx'].",".$updatas[1]['c_code'].",".$updatas[1]['c_id'].",".$updatas[1]['c_up_code'].",".$dates[0].",".$custs[0]['C_NAME'].",".$updatas[1]['c_level'].",".$repqtys[1]['ttotal'].",".$repqtys[1]['ctotal'];
				$pos++;	
			
			}




			}
			$cnt = count($maketree2);
			
		}

		echo json_encode($maketree2);


	}


?>