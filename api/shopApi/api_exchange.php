<?
	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 	


	$userid		= $_POST['userid'];
	$passwd		= $_POST['passwd'];
	$amount		= $_POST['amount'];
	$deId		= $_POST['deId'];
	$coin_type	= $_POST['coin_type'];

	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{

		$DB->get("select * from $member_table where C_ID='$userid' and C_FIN_PASS='$passwd'", $custs, $custn);

		if ($custn == 0)
		{
				$result = array("result"=>"0","msg"=>"user password is wrong");
				echo json_encode($result);
		}
		else
		{
			

			$member_code = $custs[0]['C_CODE'];
			include "total_su.php";
			
			$DB->get("select * from $su_list", $infos, $infon);

			if ($coin_type == "ripple")
			{
			$balance = $E_MONEY;

			$url      = "https://api.upbit.com/v1/ticker?markets=USDT-XRP";
			$agent      = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0)';

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_REFERER, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); 
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);

			$res2 = curl_exec($ch);
			curl_close($ch);

			$eth_o = json_decode($res2 , true);
			$ripple_price = round(($eth_o[0]['trade_price']),2);
			$price	= $ripple_price;
			}
			else if ($coin_type == "xch")
			{
			$balance = $E_MONEY;
			$price	= $infos[0]['xch_price'];
			}
			
			$qty = floor(($amount / $price) * 10000) / 10000;
			
			if ($balance < $total)
			{
				$result = array("result"=>"0","msg"=>"not enough");
				echo json_encode($result);
			}
			/*
			else if (100 > $amount)
			{
				$result = array("result"=>"0","msg"=>"100$ more than");
				echo json_encode($result);
			}
			*/
			else
			{

				$wfee = $infos[0]['c_efee'];
				$fee = $amount * $wfee / 100;
				$total = $amount + $fee;


				$date = date("Y-m-d H:i:s");
				$sql = "c_date		='$date',
						c_code		='$member_code',
						c_id		='$userid',
						c_qty		='$qty',
						c_fee		='$fee',
						c_total		='$total',
						c_state		='Complete',
						c_amount	='$amount',
						c_price		='$price',
						c_type		='$coin_type'";

				$DB->insert($exchange, $sql);


				$result = array("result"=>"1","msg"=>"Complete");
				echo json_encode($result);
			}
		}	
	}
?>