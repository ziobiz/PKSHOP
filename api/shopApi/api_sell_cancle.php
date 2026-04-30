<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config_write.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 	


	$userid		= $_POST['userid'];
	$idx		= $_POST['idx'];
	$deId		= $_POST['deId'];

	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{
		$date = date("Y-m-d H:i:s");

		$DB->get("select * from $sell_table where idx='$idx'", $sells, $selln);
		$code	= $sells[0]['c_code'];
		$c_id	= $sells[0]['c_id'];

		$sql =  "c_state='Cancle', c_e_date='$date' where c_code='$code'";
		$DB->update($sell_table, $sql);

		$DB->get("select C_C_CODE form $member_table where C_CODE='$code'", $custs, $custn);
		$c_c_code = $custs[0]['C_C_CODE'];

		$sql = "C_C_CNT=C_C_CNT-1 where C_CODE='$c_c_code'";
		$DB->update($member_table, $sql);


		$sell_date = strtotime($sells[0]['c_date']);
		$now		= strtotime(date("Y-m-d H:i:s"));

		$now=($now-$sell_date)+1;
		$cnum= $now/86400;

		$cnum = round($cnum,1);

		$DB->get("select sum(sil) as total from $bonus_table  where c_code='$code'", $sus, $sun);
		
		// 추천 및 롤업 제거 
		$DB->get("select * from $bonus_table where c_pay_id='$c_id'", $backs, $backn);

		
		for($i=0;$i<$backn;$i++)
		{
			$code	= $backs[$i]['c_code'];
			$amount = $backs[$i]['sil'];
			
			$sql = "c_acc = c_acc + $amount where c_code='$code'";
			$DB->update($su_cancle_list, $sql);
		}


		function getFromUrl($url, $method = 'GET')
		{
					
					$ch = curl_init();
					$agent = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0)';
					
					
					switch(strtoupper($method))
					{
						case 'GET':     
							curl_setopt($ch, CURLOPT_URL, $url);
							break;
				 
						case 'POST':
							$info = parse_url($url);
							$url = $info['scheme'] . '://' . $info['host'] . $info['path'];
							curl_setopt($ch, CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_POST, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $info['query']);
							break;
				 
						default:
							return false;
					}
					
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
					curl_setopt($ch, CURLOPT_TIMEOUT, 5);
					curl_setopt($ch, CURLOPT_REFERER, $url);
					curl_setopt($ch, CURLOPT_USERAGENT, $agent);
					

					$res = curl_exec($ch);

					curl_close($ch);
					
					return $res;
		}

		$api		= "https://api.binance.com/api/v1/ticker/price?symbol=DASHUSDT";
		$datas2		= getFromUrl($api);
		$dash_o = json_decode($datas2, true);
		$dash_price = $dash_o['price'];

		$api		= "https://api.binance.com/api/v1/ticker/price?symbol=ETHUSDT";
		$datas2		= getFromUrl($api);
		$eth_o = json_decode($datas2, true);
		$eth_price = $eth_o['price'];

		$api		= "https://api.binance.com/api/v1/ticker/price?symbol=BCHABCUSDT";
		$datas2		= getFromUrl($api);
		$bch_o = json_decode($datas2, true);
		$bch_price = $bch_o['price'];

		$set_price = 0;
		if ($sells[0]['c_type'] == "eth" || $sells[0]['c_type'] == "ethp")		$set_price = $eth_price;
		if ($sells[0]['c_type'] == "dash" || $sells[0]['c_type'] == "dashp")	$set_price = $dash_price;
		if ($sells[0]['c_type'] == "bch" || $sells[0]['c_type'] == "bchp")		$set_price = $bch_price;

		$date = date("Y-m-d H:i:s");
		
		$DB->get("select * from $su_list", $infos, $infon);

		$c_coin			= $sells[0]['c_bit'];
		$c_cash			= $sells[0]['c_cash'];
		$coin_type		= $sells[0]['c_type'];
		$total_bonus	= $sus[0]['total'];
		$g50_price		= $infos[0]['c_g50'];
		$total_cash		= $total_bonus * $g50_price;
		$turn_cash		= $c_cash - $total_cash;

		if ($turn_cash <= 0) $turn_cash = 0;

		$coin_qty = 0;

		if ($turn_cash > 0)
		{
			$coin_qty = $turn_cash / $set_price;

			$coin_qty = round($coin_qty,5);
		}
		
		$sql = "";
		if ($cnum < 91)
		{

			$sql = "c_calc_date='$cnum',c_state='Request',c_sell_idx='$idx',c_g50_price='$g50_price',c_code='$code',c_id='$c_id',c_date='$date',c_cash='$c_cash',c_coin='$c_coin',c_su='$total_bonus',c_price='$set_price',c_type='$coin_type',c_turn_coin='$coin_qty',c_turn_cash='$turn_cash'";

			$DB->insert($cancle_sell,$sql);
			
			echo $sql;
			
		}
		else 
		{

			$turn_cash = $total_cash;
			$coin_qty = $turn_cash / $set_price;
			
			$sql = "c_calc_date='$cnum',c_state='Request',c_sell_idx='$idx',c_g50_price='$g50_price',c_code='$code',c_id='$c_id',c_date='$date',c_cash='$c_cash',c_coin='$c_coin',c_su='$total_bonus',c_price='$set_price',	c_type='$coin_type',c_turn_coin='$coin_qty',c_turn_cash='$turn_cash'";
			$DB->insert($cancle_sell,$sql);


			
		}

		$result = array("result"=>"1","msg"=>"Complete");
		echo json_encode($result);

	}			
?>