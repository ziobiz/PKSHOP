<?

	include "../../pc/include/core_api.php";

	$m_balance = $_POST["m_balance"];
	$m_receive = $_POST["m_receive"];
	$m_amount = $_POST["m_amount"];

	if($m_balance<$m_amount){
		echo"<script>alert('송금액이 Mater지갑 잔액보다 큽니다.');  location.href='master_acount.php';</script>";
		exit;
	}

	//Master 지갑 잔액 갖고 오기
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $acount_api);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, 'deId='.Decrypt($api_key,$secret_key,$secret_iv).'&bitAccount='.'cereimall_master_wallet');
	curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	$json_o = json_decode($result, true);
	$arr = $json_o['bitcoin'];
	$mater_bitbalance = $arr["bitbalance"];
	if($mater_bitbalance!=$m_balance){
		echo"<script>alert('Mater 지갑 잔액 오류입니다.'); location.href='master_acount.php';</script>";
		exit;
	}
	if($mater_bitbalance<$m_amount){
		echo"<script>alert('송금액이 Mater지갑 잔액보다 큽니다.');  location.href='master_acount.php';</script>";
		exit;
	}
	//Mater 지갑 잔액 갖고 오기

	//송금 받을 지갑 확인

	//송금 받을 지갑 확인

		//송금 시키기
		$ch2 = curl_init();
//		curl_setopt ($ch2, CURLOPT_URL, $move_api);
		curl_setopt ($ch2, CURLOPT_URL, $send_api);
		curl_setopt ($ch2, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt ($ch2, CURLOPT_POST, 1);
//		curl_setopt ($ch2, CURLOPT_POSTFIELDS,'deId=$api_btc_key&bitAccount='.'cereimall_master_wallet'.'&sendAccount='.'????'.'&sendBtc='.$m_amount);	//move	acount = 계좌이름?
		curl_setopt ($ch2, CURLOPT_POSTFIELDS,'deId=$api_btc_key&bitAccount=cereimall_master_wallet&sendAddress='.$m_receive.'&sendBtc='.$m_amount);	//send	addrs = 지갑주소
		curl_setopt ($ch2, CURLOPT_TIMEOUT, 30);
		curl_setopt ($ch2, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch2);
		$json_o = json_decode($result, true);
		$arr_api = $json_o['result'];	
		if($arr_api =="1"){
			$state = "결제완료";
			echo($state);
			echo "1";
			echo"<script>alert('송금이 완료되었습니다.'); location.href='master.acount.php'</script>";
			exit;
		}else{
			$state = "주문대기";
			echo"<script>alert('$arr_api');alert('송금 오류가 발생하였습니다.'); location.href='master_acount.php';</script>";
			echo($state);
			echo "2";
			exit;
		}
		//송금 시키기

?>