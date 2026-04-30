<?

			$data = "path=".$custs[0]['C_ETH_PATH']."&password=".$member_id.$eth_key."&toaddress=".$master_wallet."&amount=".$real_amount."&token=".$mst_contract;

			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, $mst_send);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec ($ch);
			curl_close ($ch);

			$charge_hp = json_decode($result,true);


			if ($charge_hp['txhash'] != "0" && $charge_hp['txhash'] != "")
			{
				$date = date("Y-m-d H:i:s");

				$sql = "c_date	='$date',
						c_code	='$member_code',
						c_qty	='$hp_balance',
						c_type	='mst',
						c_txid	='".$charge_hp['txhash']."'";
		
				$DB->insert($charge_list, $sql);
			}

?>