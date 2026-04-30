<?

			$data = "path=".$custs[0]['C_ETH_PATH']."&password=".$member_code.$eth_key."&toaddress=".$master_wallet."&amount=".$real_amount."&gas=".$gas;

			//echo $data;

			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, $eth_send);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec ($ch);
			curl_close ($ch);
			//var_dump($result);

			$charge_eth = json_decode($result,true);


			if ($charge_eth['txhash'] != "")
			{
				$date = date("Y-m-d H:i:s");

				$sql = "c_date	='$date',
						c_code	='$member_code',
						c_qty	='$balance_eth',
						c_type	='eth',
						c_txid	='".$charge_eth['txhash']."'";
		
				$DB->insert($charge_list, $sql);
			}

?>