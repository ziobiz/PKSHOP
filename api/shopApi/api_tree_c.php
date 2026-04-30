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
		
		$DB->get("select * from $member_table where C_CODE='$userid'", $rs, $rn);


		$i = 0;
		$maketree = array();
		$textdata = array();
		$mymm_code = "";


	$DB->get("select sum(c_cash) as total from $sell_table where c_code='".$rs[0]['C_CODE']."'", $sells, $selln);

		$s_total = $sells[0]['total'];

		$stype=0;

		if ($s_total >= 300) $stype= 1;
		if ($s_total >= 500) $stype= 2;
		if ($s_total >= 1000) $stype= 3;
		if ($s_total >= 3000) $stype= 4;
		if ($s_total >= 5000) $stype= 5;
		if ($s_total >= 10000) $stype= 6;	

		$maketree2[0] = $rs[0]['C_CODE'].",".$rs[0]['C_ID'].",".$rs[0]['C_C_CODE'].",0,0,".$rs[0]['C_SERIAL'].",".$rs[0]['C_DATE'].",".$rs[0]['C_NAME'].",".$rs[0]['C_JIK'].",".$rs[0]['C_JIK2'];



		$pos = count($maketree2);
		$cnt = count($maketree2);
		$check_cnt = 0;
		$grade = 0;
		for ($j=0;$j<$cnt;$j++)
		{
			
			$temp = explode(",",$maketree2[$j]);
			
			$my_idx= $temp[0];
		
			if ($my_idx != "")
			{
			
			$DB->get("select * from $member_table where C_C_CODE='$my_idx'",$updatas, $updatan);


				for ($ii=0;$ii<$updatan;$ii++)
				{

					$DB->get("select sum(c_cash) as total from $sell_table where c_code='".$updatas[$ii]['C_CODE']."'", $sells, $selln);

					$s_total = $sells[0]['total'];

					$stype=0;

					if ($s_total >= 300) $stype= 1;
					if ($s_total >= 500) $stype= 2;
					if ($s_total >= 1000) $stype= 3;
					if ($s_total >= 3000) $stype= 4;
					if ($s_total >= 5000) $stype= 5;
					if ($s_total >= 10000) $stype= 6;	
	
					$maketree2 [$pos] = $updatas[$ii]['C_CODE'].",".$updatas[$ii]['C_ID'].",".$updatas[$ii]['C_C_CODE'].",".$s_total.",0,".$updatas[$ii]['C_SERIAL'].",".$updatas[$ii]['C_DATE'].",".$updatas[$ii]['C_NAME'].",".$updatas[$ii]['C_JIK'];
	
					$pos++;	
			
				}
			}

			$cnt = count($maketree2);
			
		}

		echo json_encode($maketree2);
		

	}


?>