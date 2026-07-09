<?

include "../include/get_balance.php";
include "../include/login_check.php";

$session_cart = isset($_SESSION['session_cart']) ? $_SESSION['session_cart'] : '';
$pkshop_head_style = 'shop';
$pkshop_page_title = 'My Page';

if (!function_exists('pkshop_order_status_label_en')) {
	function pkshop_order_status_label_en($status) {
		$map = array(
			'주문접수' => 'Order received',
			'입금완료' => 'Payment completed',
			'입금확인메일발송' => 'Payment confirmation sent',
			'배송예정' => 'Shipping scheduled',
			'배송완료' => 'Delivered',
			'주문취소' => 'Order cancelled',
		);
		$status = trim((string)$status);
		return isset($map[$status]) ? $map[$status] : $status;
	}
}

?>
<!doctype html>
<html lang="en">
 <head>
<?php include "../include/pkshop_html_head.php"; ?>
<?php
if (!function_exists('pkshop_get_payment_currency')) {
	require_once dirname(__FILE__) . '/../include/site_settings_lib.php';
}
?>
<script type="text/javascript">
<!--
	function cancel_go(ordnum) {
	ans = confirm("I cancel the purchase of the product you want to purchase. Do you want to cancel?");
	if(ans == true) {
		location.href="./cancel.php?ordnum="+ordnum;
	}
	else {
		
	}
}
//-->
</script>
<script type="text/javascript">
<!--
	function cancel_go1(ordnum) {
	ans = confirm("Do you want to confirm your purchase?");
	if(ans == true) {
		location.href="./cancel1.php?ordnum="+ordnum;
	}
	else {
		
	}
}
//-->
</script>
 </head>
 <body>
	<div id="wrap">

	<!-- 상단(Top) -->

	 
	  <? include "../include/top.php"; ?>

		<div class="content_inner">

			<div class="sp40"></div>

			<!-- 카테고리 -->
				
			<? include "../include/category_info.php"; ?>

			<!-- 카테고리 끝 -->

			<div class="content">
				<div class="page_title">
					My Order History
				</div>

				<table class="cart_table">
					<tr>
						<th width="12%">Date</th>
						<th width="13%">Order Number</th>
						<th width="30%">Product</th>
						<th width="15%">Amount</th>
						<th width="10%">Delivery</th>
						<th width="20%">Progress</th>
					</tr>
					<?
	
	$name = isset($json_balance['name']) ? $json_balance['name'] : '';
	$payment_currency = function_exists('pkshop_get_payment_currency') ? pkshop_get_payment_currency() : 'USD';
	
	$pay_mobile = (isset($_COOKIE['valid_k_ordernum1']) ? $_COOKIE['valid_k_ordernum1'] : '') . '-'
		. (isset($_COOKIE['valid_k_ordernum2']) ? $_COOKIE['valid_k_ordernum2'] : '') . '-'
		. (isset($_COOKIE['valid_k_ordernum3']) ? $_COOKIE['valid_k_ordernum3'] : '');
//echo $name;




#####################################################################

$ords = json_decode(curl_d($api_cart,"&Type=orderCount&session_cart=$session_cart"), true);
$total_record = 0;
if (is_array($ords) && isset($ords[0]['count'])) {
	$total_record = (int)$ords[0]['count'];
}
if($total_record == 0) {
?>

              <tr>
                <td colspan="6" height="100" align="center"><B>There is no product you ordered.</B></td>
              </tr>
<?
#####################################################################
} else {
	
  $flag = 0;
  for($i=0;$i<$total_record;$i++) {
	if (!is_array($ords) || !isset($ords[$i]) || !is_array($ords[$i])) {
		continue;
	}
	$ordernum	= isset($ords[$i]['ordernum']) ? $ords[$i]['ordernum'] : '';
	$kind		= isset($ords[$i]['kind']) ? $ords[$i]['kind'] : '';
	$charge		= isset($ords[$i]['charge']) ? $ords[$i]['charge'] : 0;
	$status		= isset($ords[$i]['status']) ? $ords[$i]['status'] : '';
	$char_num	= isset($ords[$i]['char_num']) ? $ords[$i]['char_num'] : '';
	$usepoint	= isset($ords[$i]['usepoint']) ? $ords[$i]['usepoint'] : 0;

	$ord2s = json_decode(curl_d($api_cart,"&Type=sellList&ordernum=$ordernum"), true);

    $total_record1 = 0;
	if (is_array($ord2s) && isset($ord2s['total'])) {
		$total_record1 = (int)$ord2s['total'];
	}

	if($i==0) $ordernum_last=$ordernum;
	

	for($j = 0; $j < $total_record1; $j++) {
		if (!isset($ord2s[$j]) || !is_array($ord2s[$j])) {
			continue;
		}

		$o_ordernum		= isset($ord2s[$j]['ordernum']) ? $ord2s[$j]['ordernum'] : '';
		$o_signdate		= isset($ord2s[$j]['signdate']) ? $ord2s[$j]['signdate'] : 0;
		$o_title		= isset($ord2s[$j]['title']) ? $ord2s[$j]['title'] : '';
		$o_money1		= isset($ord2s[$j]['money']) ? $ord2s[$j]['money'] : 0;
		$count_sm		= isset($ord2s[$j]['count']) ? $ord2s[$j]['count'] : 0;
		$o_opt1			= isset($ord2s[$j]['opt1']) ? $ord2s[$j]['opt1'] : '';
		$o_code			= isset($ord2s[$j]['code']) ? $ord2s[$j]['code'] : '';
		$o_coin			= isset($ord2s[$j]['coin']) ? $ord2s[$j]['coin'] : 0;
		$o_price		= isset($ord2s[$j]['prices']) ? $ord2s[$j]['prices'] : 0;
		
		$o_signdate = date("Y.m.d",$o_signdate);	

		$o_money_display = function_exists('pkshop_format_currency_amount')
			? pkshop_format_currency_amount(pkshop_payment_amount_from_usd($o_money1), $payment_currency)
			: ('$ ' . number_format($o_money1));
		$charge_display = function_exists('pkshop_format_currency_amount')
			? pkshop_format_currency_amount(pkshop_payment_amount_from_usd($charge), $payment_currency)
			: ('$ ' . number_format($charge));
		
		
#####################################################################
?>                      
					<tr>
                      <td height="25"><?=$o_signdate?></td>
                      <td ><?=$ordernum?></td>
                      <td ><?=$o_title?></td>
                      <td ><?=$count_sm?> - <?=$o_money_display?> <br>Delivery Fee : <?=$charge_display?></td>
                      <td ><?=htmlspecialchars(pkshop_order_status_label_en($status), ENT_QUOTES, 'UTF-8')?></td>
                      <td >				<?
										#####################################################################
										if($status=="주문접수"  || $status=="입금완료" || $status=="입금확인메일발송" || $status=="배송예정") {
										#####################################################################
										?>
												Order accepted.<br>
												<a href="javascript:cancel_go(<?=$ordernum?>)" class="tlink">[order cancellation]
												</a>
										<?
										#####################################################################
										}else if($status=="배송완료") {
										#####################################################################
										?>
												Delivery completed.<br>
												<a href="javascript:cancel_go1(<?=$ordernum?>)" class="tlink">[Purchase confirmed.]
												</a>
										<?															
										} else if($status=="주문취소"){
										?>
													order cancellation
										<?															
										} else {
										?>
													You can't cancel it.
										<?  }  ?></td>
                    </tr>             
                  
<?
#####################################################################

// $query_out = "SELECT pointout FROM $shop_order WHERE id='$valid_user' and ordernum = '$ordernum'";


// $DB->get($query_out, $ord3s,$ord3n);



// $pointout = $ord3s[0]['pointout']; //쓰인 POINT
//결제금액 계산


//############################같은 주문 상품에 대한 합계만 구하기
if($o_ordernum==$ordernum_last) {	
$o_money1 =$o_money1*$count_sm;
$o_sell   = $o_price *$count_sm;
$coin_total = $o_coin *$count_sm;


$total_settle_all_s=$total_settle_all_s+$o_money1;
$total_settle_sales=$total_settle_sales+$o_sell;
$coin_total_all = $coin_total_all + $coin_total; 
}else{
$total_settle_all_s=0;
$total_settle_sales = 0;
$coin_total_all = 0 ;

$o_money1 =$o_money1*$count_sm;
$o_sell   = $o_price *$count_sm;
$coin_total = $o_coin *$count_sm;

$total_settle_all_s=$total_settle_all_s+$o_money1;
$ordernum_last=$o_ordernum;
$total_settle_sales=$total_settle_sales+$o_sell;
$coin_total_all = $coin_total_all + $coin_total; 

}

//############################같은 주문 상품에 대한 합계만 구하기



#####################################################################

$last_j=$j+1;   //같은 주문번호 상품의 합계를 한번만 출력 하기 위한 체크 변수
if($total_record1==$last_j){






$total_money=$total_settle_all_s;
$total_settle_all = $total_settle_all_s+$charge-$usepoint;
$total_settle_all_display = function_exists('pkshop_format_currency_amount')
	? pkshop_format_currency_amount(pkshop_payment_amount_from_usd($total_settle_all), $payment_currency)
	: ('$ ' . number_format($total_settle_all));

// $coin_total_st = number_format($coin_total_all)." GP";
// $sall_st = Number_format($total_settle_sales)." POINT";
?>
              <tr>
                <td colspan="6" height="36" bgcolor="#DFE0EE"><span style="text-align:right; color:#c3070b"> - Total Purchase Amount : <?=$total_settle_all_display?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
              </tr>
 <?

  }
	   $flag = 1;
	}
  }
}
?> 
				</table>
			</div>
		</div>			
			
	</div>
	<!-- 컨텐츠 종료 -->


	<!-- 하단(Copy) -->

	 <div class="sp50"></div>
	  <? include "../include/bottom.php"; ?>	  
				
				
	<!-- 하단(Copy) -->

	


</div>
</body>
</html>
