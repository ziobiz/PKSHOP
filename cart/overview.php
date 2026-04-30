<?

include "../include/get_balance.php";

?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
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
	
	$name = $json_balance["name"];
	
	$pay_mobile = $_COOKIE["valid_k_ordernum1"]."-".$_COOKIE["valid_k_ordernum2"]."-".$_COOKIE["valid_k_ordernum3"];
//echo $name;




#####################################################################

include "../include/login_check.php";
#####################################################################

// $DB->get("select ordernum, kind, charge, status,char_num from $shop_order where id = '$valid_user' and status<>'주문대기' order by ordernum desc",$ords,$ordn);


 
 

 ####################################################################


$ords = json_decode(curl_d($api_cart,"&Type=orderCount&session_cart=$session_cart"),true);

$total_record = $ords[0]["count"];
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
	// print_r($ords[$i]);
	// exit;
	$ordernum	= $ords[$i]['ordernum'];
	$kind		= $ords[$i]['kind'];
	$charge		= $ords[$i]['charge'];
	$status		= $ords[$i]['status'];
	$char_num	= $ords[$i]['char_num'];
	$usepoint	= $ords[$i]['usepoint'];

	$ord2s = json_decode(curl_d($api_cart,"&Type=sellList&ordernum=$ordernum"),true);
	
    $total_record1 = $ord2s["total"];

	if($i==0) $ordernum_last=$ordernum;
	

	for($j = 0; $j < $total_record1; $j++) {

		$o_ordernum		= $ord2s[$j]['ordernum'];
		$o_signdate		= $ord2s[$j]['signdate'];
		$o_title		= $ord2s[$j]['title'];
		$o_money1		= $ord2s[$j]['money'];
		$count_sm		= $ord2s[$j]['count'];
		$o_opt1			= $ord2s[$j]['opt1'];
		$o_code			= $ord2s[$j]['code'];
		$o_coin			= $ord2s[$j]['coin'];
		$o_price		= $ord2s[$j]['prices'];
		
		$o_signdate = date("Y.m.d",$o_signdate);	

		$o_money = number_format($o_money1);
		
		
#####################################################################
?>                      
					<tr>
                      <td height="25"><?=$o_signdate?></td>
                      <td ><?=$ordernum?></td>
                      <td ><?=$o_title?></td>
                      <td ><?=$count_sm?> - $ <?=$o_money?> <br>Delivery Fee : $ <?=number_format($charge); ?></td>
                      <td ><?=$status?></td>
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
$total_settle_all = number_format($total_settle_all);

// $coin_total_st = number_format($coin_total_all)." GP";
// $sall_st = Number_format($total_settle_sales)." POINT";
?>
              <tr>
                <td colspan="6" height="36" bgcolor="#DFE0EE"><span style="text-align:right; color:#c3070b"> - Total Purchase Amount : $ <?=$total_settle_all?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
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
