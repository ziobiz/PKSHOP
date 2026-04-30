<?
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/dbconn.php";
include "../common/user_function.php";

########## 데이터베이스에 연결한다. #################################

include "../inc/top_menu.php";
include "../inc/left_menu_sell.php";

include "../../pc/include/core_api.php";


//마스터 지갑 정보
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $acount_api);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, 'deId='.Decrypt($api_key,$secret_key,$secret_iv).'&bitAccount='.$mater_wallet);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	$json_o = json_decode($result, true);
	$arr = $json_o['bitcoin'];
	$master_mostaddress = $arr["bitaddress"];
	$mater_bitbalance = $arr["bitbalance"];



	// 지갑 코인 상태 확인
		$ch2 = curl_init();
        curl_setopt ($ch2, CURLOPT_URL, $list_api);
        curl_setopt ($ch2, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt ($ch2, CURLOPT_POST, 1);
        curl_setopt ($ch2, CURLOPT_POSTFIELDS, 'deId='.$deId.'&bitAccount='.'cereimall_master_wallet');
        curl_setopt ($ch2, CURLOPT_TIMEOUT, 30);
        curl_setopt ($ch2, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec ($ch2);
        curl_close ($ch2);
        $json_o = json_decode($result, true);
        $arr_api = $json_o['data'];
        $num = 0;
		$min_num=0;
        foreach($arr_api as $ex)
        {			
			if($ex['category']=="move"){
				if($min_num==0) $min_num=$num;
				if($num<=$min_num){
					$min_num=$num;
					$master_receive_date = date('Y.m.d H:i:s', $ex['time']);
				}
			}
			if($ex['category']=="send" && $ex['confirmations']>2){
				if($min_num==0) $min_num=$num;
				if($num<=$min_num){
					$min_num=$num;
					$master_send_date = date('Y.m.d H:i:s', $ex['time']);
				}
			}
			$num = $num + 1;
			if(!$master_receive_date) {$master_receive_date = "No data";}
			if(!$master_send_date) {$master_send_date = "No data";}
		}
	// 지갑 코인 상태 확인


?>

				<table width="800" border="0" cellspacing="0" cellpadding="0">
					<tr><td height=30></td></tr>
					<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>

								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>Master 계좌 관리&nbsp;&nbsp;</b></td>
								</tr>
							</table>
					</td></tr>		
					<tr> 
						<td align=left> 							
							<b><font size="3">  </font></b></p>
							<form name="to_send" action="master_send.php" method="post">
							<table width="850" border='0' cellspacing='0' cellpadding='0'>
								<tr><td colspan=12 height=3 bgcolor='#88B7DA'></td></tr>
								<tr bgcolor='#EBF0F4'>
									<td class="ttext01" align=center height="30">번호</td>
									<td class="ttext01" align=center>계좌명</td>
									<td class="ttext01" align=center>지갑주소</td>
									<td class="ttext01" align=center>Balance</td>
									<td class="ttext01" align=center>최근입금날짜</td>
									<td class="ttext01" align=center>최근송금날짜</td>
								</tr>
								<tr><td colspan=12 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr><td colspan=12 height=3></td></tr>

								<tr>
									<td align=center height=30  class="text02">1</td>
									<td align=center height=30  class="text02"><a onclick="go_send();" style="cursor:pointer"><?=$mater_wallet?></a></td>
									<td align=center height=30  class="text02"><?=$master_mostaddress?></td>
									<td align=center height=30  class="text02"><?=$mater_bitbalance?></td>
									<td align=center height=30  class="text02"><?=$master_receive_date?></td>
									<td align=center height=30  class="text02"><?=$master_send_date?></td>
									<input type="hidden" value="<?=$mater_bitbalance?>" name="balance">
									<input type="hidden" value="<?=$master_mostaddress?>" name="addr">
								</tr>
								<tr><td colspan=12 height=1 bgcolor='#D2DEE8'></td></tr>
							</table>
							<p><center>
							<center>
							</form>
							<br><br>
							</td>
					</tr>

				</table>

				<script>
					function go_send(){
						document.to_send.submit();
					}
				</script>

<? include "../inc/down_menu.php"; ?>