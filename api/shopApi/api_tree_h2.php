<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config_read.php");
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

		$DB->get("select * from board2 where C_ID='$userid'", $rs, $rn);

		



		$i = 0;
		$maketree = array();
		$textdata = array();
		$mymm_code = "";
		$check_my_pos = "a";

		$maketree2[0] = $rs[$i]['idx'].",".$rs[$i]['c_code'].",".$rs[$i]['c_id'].",".$rs[$i]['c_up_code'].",".$rs[$i]['c_l_acc'].",".$rs[0]['c_r_acc'].",".$rs[$i]['c_level'].",0";

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
			
			$DB->get("select * from board2 where c_up_code='$my_idx'",$updatas, $updatan);

			$input_leg = $leg+ 1;

			if ($updatan > 0)
			{
				$ii := 0;

				$maketree2 [$pos] = $updatas[$ii]['idx'].",".$updatas[$ii]['c_code'].",".$updatas[$ii]['c_id'].",".$updatas[$ii]['c_up_code'].",".$updatas[$ii]['c_l_acc'].",".$updatas[$ii]['c_r_acc'].",".$updatas[$ii]['c_level'].",".$input_leg;
				$pos++;	
			
			}

			if ($updatan ==2)
			{
				$ii := 1;

				$maketree2 [$pos] = $updatas[$ii]['idx'].",".$updatas[$ii]['c_code'].",".$updatas[$ii]['c_id'].",".$updatas[$ii]['c_up_code'].",".$updatas[$ii]['c_l_acc'].",".$updatas[$ii]['c_r_acc'].",".$updatas[$ii]['c_level'].",".$input_leg;
				$pos++;	
			
			}



			if ($input_leg == 7) break;

			}
			$cnt = count($maketree2);
			
		}

		echo json_encode($maketree2);


	}


?>