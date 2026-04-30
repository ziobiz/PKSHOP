<? 
//   error_reporting( E_ALL );
//   ini_set( "display_errors", 1 );
	
	include "../include/get_balance.php";
	include "cartfunc.php"; 
	include "../include/login_check.php"; 

$session_cart = $_SESSION["session_cart"];

?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <script language="javascript">

		
		<!--
		function select_all(){ 
			for(var i=0; i<document.form.chk_num.value; i++){ 
				
				if(document.form.elements[ "check" + i ].checked==true){
					document.form.elements[ "check" + i ].checked=false;
				}else{
					document.form.elements[ "check" + i ].checked=true;
				}
			} 
		}

		function go_del() {
			go=confirm('\nAre you sure you want to delete the data?\n')
			if(go==true){
				document.form.action="cart_del.php";
				document.form.submit();
			}else{return false;}
		}

		function go_order() {
			
			var total=document.form.chk_num.value;
			var check_ok=0;
			for(var i=0; i<total; i++){ 
				
				if(document.form.elements[ "check" + i ].checked==true){
					check_ok=check_ok+1;
				}else{
					check_ok=check_ok+0;
				}
			} 

	//alert(check_ok);

	if(check_ok>0){
		document.form.action="cart_order.php";
		document.form.submit();
	}else{
		alert("Choose the product you want to order.");
		return;
	}
}

function on_print(){
	window.open("print.php","print","width=630,height=600,scrollbars=yes");
}
//-->

function NumObj(obj) { 
	
	if (event.keyCode) { 
		if (escape(event.keyCode) >= 48 && escape(event.keyCode) <= 57) { 

			

    return true; 
        }else if(escape(event.keyCode) == 13){

			idx = obj.getAttribute("valid.idx");
			
			go_recal1();

		} else { 
            event.returnValue = false; 
        } 
    } 
} 
// function changesu(idx){
// 	location.href="./cart_racal.php?idx="+idx
// }

function go_buy() {
	tmp = '<?echo("$session_cart");?>';
	if (tmp=='') {
		alert('I don\'\t have any products to buy.');
		return;
	}else{
		/*
		go=confirm('\n주문시 5시이전에 입금하셔야 제품이 발송됩니다.\n\n단, 토요일은 2시이전')
		if(go==true){
			document.location='./order_write.php';
		}
		*/
		document.location='./order.php';
	}
}

function no_cart() {
	alert("There are products that are sold out. Please check and purchase it.");
	return ;
}

//gas_sel
function go_buy_selected() {
	tmp = '<?echo '$session_cart';?>';
	if (tmp=='') {
		alert('I dont have any products to buy.');
		return;
	}else{
		go=confirm('\nWhen ordering, you have to deposit it before 5 clock to send the product.\n\n. Saturday is before 2 clock.')
		if(go==true){
			document.form.action="cart_sel.php";
		document.form.submit();
		}else{return false;}
	}
}
//-->

</script>
<script language="javascript">
function go_recal1() {
	document.form.action='./cart_racal.php';
    document.form.submit();
}

</script>
 </head>
 <body>
	<div class="wrap">	

		<!-- 상단(Top) -->

		
		<? include "../include/top.php"; ?>

		
		<!-- 상단(Top) -->

		<!-- 컨텐츠 시작 -->
		<div id="content">
			
			<div class="content_inner">

				<div class="sp40"></div>

				<!-- 카테고리 -->

				<? include "../include/category_info.php"; ?>

				<!-- 카테고리 끝 -->

				<form method="post" name="form" class="content"  onSubmit="return false;">
					<div class="page_title">
						My Shopping Cart
					</div>

					<table class="cart_table">
						<tr>
					<th width="10%">Product</th>
					<th width="35%">Name</th>
					<th width="15%">Qty</th>
					<th width="10%">Price</th>
					
					<th width="10%">Total</th>
					<th width="10%">Cancel</th>
						</tr>
						<form name=form method=post>
<?



#####################################################################
$tot=totCount();
$total_price=0;

for($i=0;$i<$tot;$i++) {
	$ii=$i; //gas_sel
	getCart($i,$arr);


	if($arr[1] < 1 || $arr[1] ==''){
		echo "<script type='text/javascript'>
		<!--
			alert('There is less than one product in the shopping basket.');
		//-->
		</script>";
		echo "<meta http-equiv='refresh' content='0;url=cart.php'>"; 
		exit;
	}



// echo curl_d($api_category,"&Type=proView&code=$arr[0]");
// echo "ASd";
	$gods = json_decode(curl_d($api_category,"&Type=proView&code=$arr[0]"),true);
	$code		= $gods[0]['code'];
	$title		= $gods[0]['title'];
	if($title == "")continue;
	$pricec		= $gods[0]['pricec'];
	$prices		= $gods[0]['prices'];
	$priced		= $gods[0]['priced'];
	$point		= $gods[0]['point'];
	$soldout	= $gods[0]['soldout'];
	$price_dis	= $gods[0]['price_dis'];
	$imgl		= $gods[0]['imgl'];
	$opt_num	= $gods[0]['opt_num'];
	$opt_num_str = $gods[0]['opt_num_str'];

	$option_t1 = $gods[0]['option_t1'];
	$option_n1 = $gods[0]['option_n1'];
	$option_p1 = $gods[0]['option_p1'];
	$option_k1 = $gods[0]['option_k1'];

	$option_t2 = $gods[0]['option_t2'];
	$option_n2 = $gods[0]['option_n2'];
	$option_p2 = $gods[0]['option_p2'];
	$option_k2 = $gods[0]['option_k2'];

	$option_t3 = $gods[0]['option_t3'];
	$option_n3 = $gods[0]['option_n3'];
	$option_p3 = $gods[0]['option_p3'];
	$option_k3 = $gods[0]['option_k3'];

	$option_t4 = $gods[0]['option_t4'];
	$option_n4 = $gods[0]['option_n4'];
	$option_p4 = $gods[0]['option_p4'];
	$option_k4 = $gods[0]['option_k4'];

	$option_t5 = $gods[0]['option_t5'];
	$option_n5 = $gods[0]['option_n5'];
	$option_p5 = $gods[0]['option_p5'];
	$option_k5 = $gods[0]['option_k5'];

	$point_dis = $gods[0]['point_dis'];
	$imgb1	   = $gods[0]['imgb1'];
	$imgb2	   = $gods[0]['imgb2'];
	$No		   = $gods[0]['No'];
	$coin      = $gods[0]['coin'];
	if($soldout=="Y"){
		$out111="Y";
	}
	
	$title = stripslashes($title);
	
	
	$detail = stripslashes($detail);

	##############회&nbsp;원등급에 따른 가격계산###################################3
	
		if($priced>0){
			$price_tmp = $priced;
		}else{
			$price_tmp = $pricec;
		}
	
	// $price_tmp = $pricec;
	#################################################
$sail_price= $priced;


	$asize = explode(",",$size);				/*사이즈 분리*/			 $acolor = explode(",",$color);					/*색상 분리*/


	$aopt_num = explode(",",$opt_num);

	
	$aoption_n1=explode("\r\n",$option_n1);		
	$aoption_p1=explode("\r\n",$option_p1);		
	$aoption_k1=explode("\r\n",$option_k1);
	$aoption_n2=explode("\r\n",$option_n2);	 	
	$aoption_p2=explode("\r\n",$option_p2);		
	$aoption_k2=explode("\r\n",$option_k2);
	$aoption_n3=explode("\r\n",$option_n3);		
	$aoption_p3=explode("\r\n",$option_p3);		
	$aoption_k3=explode("\r\n",$option_k3);
	$aoption_n4=explode("\r\n",$option_n4);		
	$aoption_p4=explode("\r\n",$option_p4);	 	
	$aoption_k4=explode("\r\n",$option_k4);
	$aoption_n5=explode("\r\n",$option_n5);		
	$aoption_p5=explode("\r\n",$option_p5);		
	$aoption_k5=explode("\r\n",$option_k5);

	$aaoption_n1=explode("\r\n",$option_n1);		
	$aaoption_p1=explode("\r\n",$option_p1);		
	$aaoption_k1=explode("\r\n",$option_k1);
	$aaoption_n2=explode("\r\n",$option_n2);	 	
	$aaoption_p2=explode("\r\n",$option_p2);		
	$aaoption_k2=explode("\r\n",$option_k2);
	$aaoption_n3=explode("\r\n",$option_n3);		
	$aaoption_p3=explode("\r\n",$option_p3);		
	$aaoption_k3=explode("\r\n",$option_k3);
	$aaoption_n4=explode("\r\n",$option_n4);		
	$aaoption_p4=explode("\r\n",$option_p4);	 	
	$aaoption_k4=explode("\r\n",$option_k4);
	$aaoption_n5=explode("\r\n",$option_n5);		
	$aaoption_p5=explode("\r\n",$option_p5);		
	$aaoption_k5=explode("\r\n",$option_k5);

$ki=0;

	if($option_t1!=""){	
		$ki=0;
		while(list($key,$value) = each($aoption_n1)) {
			if($value == "") {
			}else {
				if($value==$arr[5]){	
					$price1=$aoption_p1[$ki];
					$priced1=$aoption_p1[$ki];
					$point1=$aoption_k1[$ki];
				}
			}
			$ki++;
		}
	}else{
		$price1=0;
		$priced1=0;
		if($point_dis!="pe")  $point1=0;	
	}

	if($option_t2!=""){	
	$ki=0;
	while(list($key,$value) = each($aoption_n2)) {
		if($value == "") {
		}else {
			if($value==$arr[6]){	
				$price2=$aoption_p2[$ki];
				$priced2=$aoption_p2[$ki];
				$point2=$aoption_k2[$ki];	
			}
		}
	$ki++;
	}
	}else{
		$price2=0;
		$priced2=0;
		if($point_dis!="pe") $point2=0;	
	}

	if($option_t3!=""){	
	$ki=0;
	while(list($key,$value) = each($aoption_n3)) {
		if($value == "") {
		}else {
			if($value==$arr[7]){	
				$price3=$aoption_p3[$ki];
				$priced3=$aoption_p3[$ki];
				$point3=$aoption_k3[$ki];	
			}
		}
	$ki++;
	}
	}else{
		$price3=0;
		$priced3=0;
		if($point_dis!="pe") $point3=0;	
	}
	
	if($option_t4!=""){	
	$ki=0;
	while(list($key,$value) = each($aoption_n4)) {
		if($value == "") {
		}else {
			if($value==$arr[8]){	
				$price4=$aoption_p4[$ki];
				$priced4=$aoption_p4[$ki];
				$point4=$aoption_k4[$ki];	
			}
		}
	$ki++;
	}
	}else{
		$price4=0;
		$priced4=0;
		if($point_dis!="pe") $point4=0;	
	}

	if($option_t5!=""){	
	$ki=0;
	while(list($key,$value) = each($aoption_n5)) {
		if($value == "") {
		}else {
			if($value==$arr[9]){	
				$price5=$aoption_p5[$ki];
				$priced5=$aoption_p5[$ki];
				$point5=$aoption_k5[$ki];	
			}
		}
	$ki++;
	}
	}else{
		$price5=0;
		$priced5=0;
		if($point_dis!="pe") $point5=0;	
	}


	$title = stripslashes($title);

	if($point_dis=="pe"){
			$point=floor($price_tmp*$point/100);
			$point1=floor($price1*$point1/100);
			$point2=floor($price2*$point2/100);
			$point3=floor($price3*$point3/100);
			$point4=floor($price4*$point4/100);
			$point5=floor($price5*$point5/100);
			$point = ($point+$point1+$point2+$point3+$point4+$point5) * $arr[1];

	}else{
		$point = ($point+$point1+$point2+$point3+$point4+$point5) * $arr[1];
	}

	$sum_price = ($price_tmp+$price1+$price2+$price3+$price4+$price5) * $arr[1];
	$price =  number_format($price_tmp+$price1+$price2+$price3+$price4+$price5);
	$price =  number_format($price_tmp+$price1+$price2+$price3+$price4+$price5)."&nbsp;";
	$price_tmp = $price_tmp;
	$price = $price;
	$price =  number_format($price_tmp+$price1+$price2+$price3+$price4+$price5)."&nbsp;";
	
	$sum_price = $sum_price;
	
	
	$coin_total =  $coin * $arr[1]; 
	$result_coin = $result_coin + $coin_total;
	$coin_total_sett = number_format($coin_total)."&nbsp;GP";
	$result_coin_total = number_format($result_coin)."&nbsp;GP";


	$sale_price_total = $sail_price   *$arr[1];

	$result_price = $result_price + $sale_price_total;
	$sale_price_total_stt = "$&npsp;".number_format($sale_price_total);
	$result_price_total = "$&npsp;".number_format($result_price);
	
	
	//echo $sum_price;
	$total_price = $total_price + $sum_price;
	
//	$sum_price =  number_format($sum_price);
	$sum_price =  number_format($sum_price)."&nbsp;";
	
	$total_point=$total_point+$point;
	$point_tot=$point;
	$point =  number_format($point);


	### 이미지 파일 저장 디렉토리 ###
	$savedir = "//pentakleva.shop/upload/";

	$img_name = $savedir.$imbg;

?>
<tr>					
					<td><a href="../sub04/view.php?left_code=<?=$code?>"><?if($imgl) {?><img src="<?=$savedir?><?=$imgl?>" width="120"><?}else{?><img src="<?=$savedir?><?=$imgb1?>" width="120"><?}?></a></td>
					<td class="review_cont">
						<a href="../product/view.php?left_code=<?=$code?>" class="a_3">
							<?=$title?><br/>
							<span class="cart_list_option">
							<?if($arr[5]!=""){?>&nbsp;Option. :
						<?if($arr[5]!=""){?> &nbsp;<?=$arr[5]?><?}?>
						<?if($arr[6]!=""){?> &nbsp;<?=$arr[6]?><?}?>
						<?if($arr[7]!=""){?> &nbsp;<?=$arr[7]?><?}?>
						<?if($arr[8]!=""){?> &nbsp;<?=$arr[8]?><?}?>
						<?if($arr[9]!=""){?> &nbsp;<?=$arr[9]?><?}?>
						<?}?></span>
						</a>
						<input type="hidden" name="size<?=$i?>" value="<?=$arr[2]?>">
						<input type="hidden" name="color<?=$i?>" value="<?=$arr[3]?>">
						<input type="hidden" name="option1<?=$i?>" value="<?=$arr[5]?>">
						<input type="hidden" name="option2<?=$i?>" value="<?=$arr[6]?>">
						<input type="hidden" name="option3<?=$i?>" value="<?=$arr[7]?>">
						<input type="hidden" name="option4<?=$i?>" value="<?=$arr[8]?>">
						<input type="hidden" name="option5<?=$i?>" value="<?=$arr[9]?>"></a><?if($soldout=="Y"){?><FONT COLOR="#EC7600">[Out of stock]</FONT><?}?>
					</td>
					<td><input name="qty<?=$i?>" OnkeyPress = "NumObj(this)" valid.idx="<?=$i?>" Style = "ime-mode : disabled;text-align:right;" value="<?=$arr[1]?>" type="text" class="formbox3" id="textfield" size="2">Qty 
					<input type="button" onclick="javascript:go_recal1()" class="search_bar" value="Modify"></td>
					<td class="font_b"><?=$price?></td>
					<td class="c_redb"><?=$sum_price?></td>
					<td><a href="./cart_del.php?del_num=<?=$i?>" onFocus='this.blur()'><img src="images/cart_delet.png" alt="삭제" width='30px'></a></td>
				</tr>
	<?}?>       
<?



// echo $total_price;
if (50 < $total_price) $charge=0;
else $charge=3;

$total_settle = $total_price + $charge;
$charge =  number_format($charge)."&nbsp;";
$total_price =  number_format($total_price)."&nbsp;";
$total_settle =  number_format($total_settle)."&nbsp;";
$coin_total_settle = number_format($coin_total)."&nbsp;";


?>	
				
			</table>

		<div class="cart_price">
			<div class="sp30"></div>
			<div class="cart_price_inner">
				Total [&nbsp;Amount(<?= $sum_price ?>) + Delivery(<?= $charge ?>)&nbsp;]&nbsp;&nbsp;<span class="c_redb font_24"><?=$total_settle?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</div>
			<div class="sp15"></div>
			<div class="price_text">
				Additional shipping costs may be incurred depending on the manufacturer and supplier.&nbsp;&nbsp;&nbsp;&nbsp;
<div class="sp15"></div>
				Additional charges (payment) may be incurred in islands and mountainous areas.&nbsp;&nbsp;&nbsp;&nbsp;
			</div>
			<div class="sp30"></div>
		</div>


		<div class="sp30"></div>


		<div class="cart_btn_left">
			<!-- <input type="button" value="Delete the optional product." class="cart_btn_delet" onclick=""> -->
			<!-- <input type="button" value="Empty your shopping cart." class="cart_btn_clearall" onclick="location='./cart_del2.php?del_num=all'"> -->
		</div>
		<div class="cart_btn_right" align=center>
			<!-- <input type="button" value="Order" class="cart_btn_order" onclick="">&nbsp; -->
			<input type="button" class="btn010"  value="Order" class="cart_btn_order" onclick="location.href='cart_order.php'">&nbsp;
			
		</div>


		</div>
</form>
<!-- 컨텐츠 종료 -->


<!-- 하단(Copy) -->

<div class="sp40"></div>
<? include "../include/bottom.php"; ?>	  


<!-- 하단(Copy) -->




</div>
</body>
</html>
