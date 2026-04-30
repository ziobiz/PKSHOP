<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 

	
	$deId		= $_POST['deId'];
	$userid		= $_POST['userid123'];

	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{

		$DB->get("select * from $member_table where C_ID='$userid'", $rs, $rn);

		



		$i = 0;
		$maketree = array();
		$textdata = array();
		$mymm_code = "";
		$check_my_pos = "a";
		$DB->get("select sum(c_cash) as total from $sell_table where c_code='".$rs[$i]['C_CODE']."'", $sells, $selln);

		$maketree2[0] = $rs[$i]['C_CODE'].",".$rs[$i]['C_ID'].",".$rs[$i]['C_C_CODE'].",".$rs[$i]['C_C_ACC'].",".$sells[0]['total'].",".$rs[$i]['C_SERIAL'].",0";

		$pos = count($maketree2);
		$cnt = count($maketree2);
		$check_cnt = 0;
		$grade = 0;
		for ($j=0;$j<$cnt;$j++)
		{
			
			$temp = explode(",",$maketree2[$j]);
			
			$my_idx	= $temp[0];
			$leg	= $temp[5];

			if ($my_idx != "")
			{
			
			$DB->get("select * from $member_table where C_C_CODE='$my_idx'",$updatas, $updatan);

			$input_leg = $leg+ 1;
			for ($ii=0;$ii<$updatan;$ii++)
			{
				$DB->get("select sum(c_cash) as total from $sell_table where c_state='Active' and c_code='".$updatas[$ii]['C_CODE']."'", $sells, $selln);

				$maketree2 [$pos] = $updatas[$ii]['C_CODE'].",".$updatas[$ii]['C_ID'].",".$updatas[$ii]['C_C_CODE'].",".$updatas[$ii]['C_C_ACC'].",".$sells[0]['total'].",".$updatas[$ii]['C_SERIAL'].",".$input_leg;
;
				$pos++;	
			
			}

			if ($input_leg == 7) break;

			}
			$cnt = count($maketree2);
			
		}

		echo json_encode($maketree2);


	}


?>