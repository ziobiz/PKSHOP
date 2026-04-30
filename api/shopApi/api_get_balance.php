<?php
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );
include_once("../lib/basic_class.php");
include_once("../lib/config.php");
include_once("../lib/common.php");
include_once("../lib/php_function.php");

$member_id		= $_POST['user_id'];
$deId			= $_POST['deId'];


if ($deId != $store_key) {
	$result = array("result" => "0", "msg" => "deId is wrong");
	echo json_encode($result);
} else {
	

	//  $url      = "https://openapi.dooribit.com/sapi/v1/ticker?symbol=RTC1559TRX";
	//  $agent      = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0)';

	//  $ch = curl_init();
	//  curl_setopt($ch, CURLOPT_URL, $url);
	//  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	//  curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	//  curl_setopt($ch, CURLOPT_REFERER, $url);
	//  curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	//  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	//  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	//  $res2 = curl_exec($ch);

	//  curl_close($ch);

	//  $eth_o = json_decode($res2, true);
	//  $rtt_price = round(($eth_o['last']),4);




	//  $url      = "https://api.upbit.com/v1/ticker?markets=KRW-XRP";
	//  $agent      = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0)';

	//  $ch = curl_init();
	//  curl_setopt($ch, CURLOPT_URL, $url);
	//  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	//  curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	//  curl_setopt($ch, CURLOPT_REFERER, $url);
	//  curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	//  curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); 
	//  curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);

	//  $res2 = curl_exec($ch);
	//  curl_close($ch);

	//  $eth_o = json_decode($res2 , true);
	//  $ripple_price = $eth_o[0]['trade_price']/1200;
	
	 
	//  if($ripple_price>0){
	// 	 $xrp_price=round(($ripple_price),4);
		
	// 	 $sql2 = "c_tprice=:xrp_price where idx='1'";
	//  	$DB->update($sql2, array("xrp_price"=>$xrp_price), "key", $su_list);
	//  }
	
	$DB->single("select * from $su_list", $infos, $infon, array(), "key");
	$gas		= $infos['c_gas'];
	$c_price	= $infos['c_price'];
	$c_eprice	= $infos['c_eprice'];
	$c_bprice	= $infos['c_bprice'];
	$c_wlimit	= $infos['c_wlimit'];
	$c_wplimit	= $infos['c_wplimit'];
	$c_walimit	= $infos["c_walimit"];
	$c_addr		= $infos['c_addr'];
	$c_level	= $infos['c_level'];
	$c_tprice = $infos["c_tprice"];
	$su_bank = $infos["c_bank"];
	$su_banknum = $infos["c_banknum"];
	$su_bankname = $infos["c_bankname"];
	$c_usdprice = $infos["c_usdprice"];

	$DB->single("select * from $member_table where C_ID=:id ", $custs, $custn, array("id" => $member_id), "key");
	$member_code	= $custs['C_CODE'];
	$name			= $custs["C_NAME"];
	$email			= $custs['C_EMAIL'];
	$rcount			= $custs['C_C_CNT'];
	$lowacc			= $custs['C_C_LOW'];
	$level			= $custs['C_JIK'];
	$eth_addr		= $custs['C_ETH'];
	$rank			= $custs['C_JIK2'];
	$hand			= $custs['C_HAND'];

	$C_JISA			= $custs['C_JISA'];
	$qrcode			= $custs['C_OTP'];
	$regDate			= $custs['C_DATE'];

	$C_ZIP			= $custs['C_ZIP'];
	$C_ADDR			= $custs['C_ADDR'];
	$C_ADDR2			= $custs['C_ADDR2'];
	
	
	
	$c_country_num = $custs["c_country_num"];
	$camprice			= $custs['C_CAMPPRICE'];
	$C_Edate = $custs["C_Edate"];

	$level == "" ? $level = 0 : $level = $level;

	



	include "total_su.php";

	$rank == "" ? $rank = 0 : $rank = $rank;
	if($rank == 0 ){
		$rank ="M";
	}
	
	
	$bonus_array=array("CB"=>$total_CB,"SB"=>$total_SB,"MB"=>$total_MB,"ROL"=>$total_ROL,"RANK"=>$total_RANK);

	$view_month = $totals_mon1['total'] . "/" . $totals_mon2['total'] . "/" . $totals_mon3['total'];
	
	
	$DB->single("select * from $board_type where C_ID=:id  ",$rs,$rn,array("id"=>$member_id),"key");
	$c_l_acc=$rs["c_l_acc"];
	$c_r_acc=$rs["c_r_acc"];

	$DB->single("select * from center where c_charge=:member_id ", $cs, $cn, array("member_id" => $member_id), "key");
	$cn >0 ? $centerChk=true : $centerChk=false;

	
	if($c_country_num == "82" || $c_country_num == "66" || $c_country_num == "91" || $c_country_num == "1" || $c_country_num == "81" || $c_country_num == "86" || $c_country_num == "84" || $c_country_num == "62" ){
		$shop_country=$c_country_num;
	}else{
		$shop_country="1";
	}


	// $total_SP =4000000;

	$result = array("c_price" => $c_price,"su_total" => $su_total,"emoney" => $emoney,"level" => $level, "volume" => $my_volume, "name" => $name, "hand" => $hand, "wfee" => $infos['c_wfee'], "pfee" => $infos['c_pfee'],"C_CTL"=>$C_CTL,"view_month"=>$view_month,"kemoney"=>$kemoney,"c_tprice"=>$c_tprice,"xrp_total"=>$xrp_total,"HCBRS_total"=>$HCBRS_total,"bonus_array"=>$bonus_array,"c_wlimit"=>$c_wlimit,"c_wplimit"=>$c_wplimit,"C_JISA"=>$C_JISA,"spon_check"=>$rn,"rank"=>$rank,"c_l_acc"=>$c_l_acc,"c_r_acc"=>$c_r_acc,"xrp_address"=>$xrp_address,"su300"=>$su300,"with300"=>$with300,"centerChk"=>$centerChk,"sell_pv"=>$sell_pv,"qrcode"=>$qrcode,"su_bank"=>$su_bank,"su_banknum"=>$su_banknum,"su_bankname"=>$su_bankname,"total_SP"=>$total_SP,"regDate"=>$regDate,"email"=>$email,"shop_country"=>$shop_country,"C_ZIP"=>$C_ZIP,"C_ADDR"=>$C_ADDR,"C_ADDR2"=>$C_ADDR2,"c_usdprice"=>$c_usdprice);
	
	


	echo json_encode($result);
}
