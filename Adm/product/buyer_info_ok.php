<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

include "../common/dbconn.php";
include "../common/user_function.php";
include "../inc/set_com.php";
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?

$usepoint = $_POST["usepoint"];
$ostatus = $_POST["ostatus"];
#### 택배 저장하기 #################################
for ($i = 0; $i < $com_no; $i++){
	$tmpchk = "com_code" . $i;
	$sel_com_code = $_POST[$tmpchk];

	$tmpchk1 = "company" . $i;
	$sel_company = $_POST[$tmpchk1];

	$tmpchk2 = "com_num" . $i;
	$sel_com_num = $_POST[$tmpchk2];

	$DB->update($shop_sell,"company='$sel_company',com_num='$sel_com_num'WHERE ordernum='$ordernum' and code='$sel_com_code'");
	
	if($ostatus=="결제완료"){
		
		$query="select * from $shop_sell  WHERE ordernum='$ordernum' and code='$sel_com_code';";
		$DB->get($query,$rs,$rn);
		
		$query="select * from $shop_order  WHERE ordernum='$ordernum' ;";
		$DB->get($query,$os,$on);
		
		
		$idx = $rs[0]["idx"];
		

		$query1 = "SELECT * FROM $shop_sell where  ordernum ='$ordernum' order by idx asc";
		
		$DB->get($query1,$ord2s,$ord2n);
		
		for($i=0;$i<$ord2n;$i++){
		$idx = $ord2s[$i]["idx"];
		
		$price = $ord2s[$i]["money"];
		$title = $ord2s[$i]["title"];
		$c_pv = $ord2s[$i]["c_pv"];
		$code = $ord2s[$i]["code"];
		$user_id = $ord2s[$i]["id"];
		$c_dis = $ord2s[$i]["c_dis"];
		$query1 = "SELECT * FROM cust_member where  C_ID ='$user_id'";
		$DB->get($query1,$ms,$mn);
		$member_code=$ms[0]["C_CODE"];
		$count = $ord2s[$i]["count"];
		$price=$price*$count;
		$c_pv=$c_pv*$count;
		if($c_dis=="1"){
			$c_state="resell";
		}else{
			$c_state="upgrade";
		}
		
		foreach($amount_array as $key => $value){
			if($price >= $value){
				$type=$key;
			}
		}	

		$date = date("Y-m-d H:i:s");
		$sql = "c_ordernum = '$ordernum',c_sellnum = '$idx',c_code='$member_code',c_id='$user_id',c_date='$date',c_cash='$price',c_state='$c_state',c_state1='Active',code='$code',title='$title',c_pv='$c_pv',c_type='$type',c_type2='USD'		";
		
		 $DB->insert($sell_table, $sql);	


		 $DB->get("select sum(c_cash) as total from $sell_table  where c_code = '$member_code' and c_state1='Active' and c_state <> 'resell'"  ,$moneys_all,$moneyn_all);



		foreach ($amount_array as $key => $value) {
			if($moneys_all[0]['total']>=$value){
				$type = $key;
			}
		}
			

		//직급업데이트
		$sql = "C_JIK='$type' where C_CODE='$member_code'";
		$DB->update($member_table, $sql);


		$sql = "c_level='$type' where c_code='$member_code'";
		$DB->update("board1", $sql);

		// echo $sql;
		}
		
		
	}
	//echo "$query<br>";
	
}
// exit;
####################################################

#####################################################
if($ostatus!=''){//전체가 아니면

	$DB->update($shop_order,"status='$ostatus',char_year='$char_year',char_month='$char_month' ,char_day='$char_day',char_num='$char_num'  WHERE ordernum='$ordernum'"); 

}
#####################################################


#####################################################


$query="";
if($ostatus=="결제완료"){//전체가 아니면


	
	$query=$query." status='$ostatus',char_year='$char_year',char_month='$char_month'";
	$query=$query.",char_day='$char_day',char_num='$char_num' ";
	$query=$query."WHERE ordernum='$ordernum'";
	// echo $query;
	$DB->update($shop_order,$query);
//	$result = mysql_query($query);

	// 금액
	$sql = "select * from $shop_sell where  ordernum='$ordernum'";
	$DB->get($sql,$rs,$rn);

	$amount = 0;

	if (count($rs)>0)
	{
		$amount		= $rs[0]['money'];
		$pv			= $rs[0]['prices'];	
		$per		= $rs[0]['point'];
		$pr_kind	= $rs[0]['pr_kind'];
		$coin		= $rs[0]['coin'];
	}

	$sql = "select * from $shop_order where  ordernum='$ordernum'";
	$DB->get($sql,$rs,$rn);
	// $result_order = mysql_query($sql);	

	$c_id = "";
	if (count($rs)>0)
	{
		$c_id = $rs[0]['id'];
	}

	$sql = "select * from $member_table where  C_ID='$c_id'";
	$DB->get($sql,$rs,$rn);
	

	if (count($rs)>0)
	{
		$c_code = $rs[0]['c_code'];
	}

	// $pay_back = $coin* 0.5;
	
	// $data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&user_id=".$valid_user."&qty=".$pay_back;


	// 		$api_balance = "https://work.GP.app/shop_api/api_shop_used2.php";
	// 		$ch = curl_init();
	// 		curl_setopt ($ch, CURLOPT_URL, $api_balance);
	// 		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
	// 		curl_setopt ($ch, CURLOPT_POST, 1);
	// 		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
	// 		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
	// 		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	// 		$result = curl_exec ($ch);
	// 		curl_close ($ch);

	// 	$date = date("Y-m-d H:i:s");

		$query="status='$ostatus' WHERE id='$valid_user' and ordernum='$ordernum'";
		
		$DB->update($shop_order,$query);
		


}
#####################################################


#####################################################
##배송중일때 상품 수량 을 신청 수량 많큼 빼주기...##
if ($ostatus=="배송중" && $ostatus_tmp!=$ostatus) {

	
	$query = "SELECT code,count FROM $shop_sell WHERE ordernum='$ordernum'";

	

	$DB->get($query,$rs1,$rn1);
$total_record=$rn1;
	for ($j=0;$j<$total_record=$rn;$j++) {
		$code = $rs1[$j][0];
		$count = $rs1[$j][1];

		// $result = mysql_query("SELECT currnum FROM $shop_goods WHERE code='$code'",$DBconn);
		$DB->get("SELECT currnum FROM $shop_goods WHERE code='$code'",$rs2,$rn2);

		$currnum = $rs2[0][0] - $count;

		// shop 데이터베이스에 입력값을 삽입한다. 
		$query=" currnum='$currnum' WHERE code = '$code'";
		$DB->update($shop_goods,$query);

	}
}
#####################################################


/*
포인트 적용 시점
	finish.htm - 결제완료까지 정상적으로 갔을때 사용 포인트 차감.
	주문취소시 주문자취소시 포인트 반환.
	주문자취소시 cancel.php에서 포인트 반환.
	주문대기에서 주문취소로 변할시 코인반환 안함.
	배송완료시 포인트 적립.
	주문대기에서 배송완료로 변할시 코인적립 안함.

	반품시 코인반환 및 적립포인트 삭제 기록.
	반송시 포인트관련 기록 안함.
*/

#####################################################
##주문취소 및 주문자취소시 코인반환에 대한 기록##
if($ostatus=="주문취소"){



	$query="status='$ostatus' WHERE ordernum = '$ordernum'";
	$DB->update($shop_order,$query);
	


/*
	if($ostatus_tmp!=$ostatus && $ostatus_tmp!="주문대기"){
		$query = "SELECT pointin,pointout,signdate FROM $shop_order WHERE id='$valid_user' and ordernum=$ordernum";
		$DB->get($query,$rs,$rn);
			if(!$result) {
				error("QUERY_ERROR");
				exit;
			}
		
		$pointin = $rs[0][0]; //적립된 포인트
		$pointout = $row[1]; //쓰인 포인트
		$signdate = $row[2]; //주문날짜

		$Signdate_kk = date("Y-m-d h:i:s",$signdate); 
		$Cont = "주문취소 코인반환[주문번호:$ordernum 주문일:$Signdate_kk]";
		$query="insert into $shop_point values";
		$query=$query."(";
		$query=$query."''"; #no 값이 들어 간다...자동 증가.
		$query=$query.",'$valid_user'";
		$query=$query.",'$Cont'";
		$query=$query.",'$pointout'";
		$query=$query.",now()";
		$query=$query.",'$signdate'";
		$query=$query.")";

		if($pointout>0) $result = mysql_query($query);

	}*/
}
#####################################################


#####################################################
##주문취소 및 주문자취소시 코인반환에 대한 기록##
if($ostatus=="주문자취소"){
	if($ostatus_tmp!=$ostatus && $ostatus_tmp!="주문대기"){
		$query = "SELECT pointin,pointout,signdate FROM $shop_order WHERE id='$valid_user' and ordernum=$ordernum";
		$DB->get($query,$rs,$rn);
		
		
		$pointin = $rs[0][0]; //적립된 포인트
		$pointout = $rs[0][1]; //쓰인 포인트
		$signdate = $rs[0][2]; //주문날짜

		$Signdate_kk = date("Y-m-d h:i:s",$signdate); 
		$Cont = "주문자취소(admin) 코인반환[주문번호:$ordernum 주문일:$Signdate_kk]";
		
		
		if($pointout>0) $DB->insert($shop_point,"Cid='$valid_user',Cont='$Cont',Point='$pointout',Wdate=now(),Signdate='$signdate'");

	}
}
#####################################################

#####################################################
##배송완료시 코인적립에 대한 기록##
if($ostatus=="구매확정" && ($ostatus_tmp!=$ostatus && $ostatus_tmp!="주문대기" && $ostatus_tmp!="반품")){
	$query = "SELECT pointin,pointout,signdate FROM $shop_order WHERE id='$valid_user' and ordernum=$ordernum";
		$DB->get($query,$rs,$rn);
	
		
		$pointin = $rs[0][0]; //적립된 포인트
		$pointout = $rs[0][1]; //쓰인 포인트
		$signdate = $rs[0][2]; //주문날짜

		$Signdate_kk = date("Y-m-d h:i:s",$signdate); 
		$Cont = "구매확정 코인적립[주문번호:$ordernum 주문일:$Signdate_kk]";

		if($pointin>0) $DB->insert($shop_point,"Cid='$valid_user',Cont='$Cont',Point='$pointin',Wdate=now(),Signdate='$signdate'");

}
#####################################################


#####################################################
if($ostatus=="반품"){
	if($ostatus_tmp!=$ostatus){

		$query = "SELECT status FROM $shop_order WHERE id='$valid_user' and ordernum=$ordernum";
		$DB->get($query,$rs,$rn);

		
		$pointin = $rs[0][0]; //적립된 포인트
		$pointout = $rs[0][1]; //쓰인 포인트
		$signdate = $rs[0][2]; //주문날짜

	}
}
#####################################################

/*
#####################################################
if($ostatus=="결제완료"){
	if($ostatus_tmp!=$ostatus){

		// shop 데이터베이스에 입력값을 삽입한다. 
		$query="UPDATE $shop_order SET status='$ostatus' WHERE id='$valid_user' and ordernum=$ordernum";
		$DB->get($query,$rs,$rn);
		if(!$result) {
			error("QUERY_ERROR");
			exit;
		}

	}
}
#####################################################
*/

$encoded_key = urlencode($key);
echo "<meta http-equiv='Refresh' content='0; URL=./pro_order.php?cmenu=order&ordernum=$ordernum&keyfield=$keyfield&key=$encoded_key&sel_kind=$sel_kind&sel_status=$ostatus'>";
?>
