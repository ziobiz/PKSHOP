<? include "../include/top_session.php";
	include "../../Adm/common/dbconn.php";
	include "../include/login_check.php";
echo $_SESSION['connect_check']."1212";

//=========== 중복 결제 확인 삭제 =====================
//$result = session_unregister("connect_check");
unset($_SESSION["connect_check"]);
$session_cart = $_SESSION['session_cart'];
//=====================================================

include "cartfunc.php";
//echo $session_cart;
//exit;

/*
$query = "SELECT coin_price FROM $coin_goods order by no desc";
$result = mysql_query($query,$DBconn);
$value = mysql_fetch_row($result);
$exchange = $value[0];
*/
if($buyselected=='Y'){
	//선택주문
	$session_cart=$session_cart_selected;
}else if($order_kk=="Y"){
	//바로주문
	$ss_dis=time();
	
	
	$numresults = mysql_query("select count(*) as soo from $shop_cart where cart_id='$valid_user'");
	$row_num = mysql_fetch_array($numresults);
	$total_su=$row_num[soo];	
	if ($total_su=='0'){
		mysql_query("insert into $shop_cart values ('','$valid_user','$session_cart')");	
	}else{

		if ($session_cart!="") {
			mysql_query("update $shop_cart set cart_cont='$session_cart' where cart_id='$valid_user' "); 	
		}
	}
	
}else{
	//전체주문
}

?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  HCBRS
  <link rel="stylesheet" href="../include/reset.css">
  <link rel="stylesheet" href="../include/style.css">
  <?
  if ($session_cart=="") {
	popup_msg("장바구니에 선택하신 상품이 없습니다.");
	exit;
  }

#####################################################################

$query = "SELECT name,email,zip,address,tel,handphone,point from $member_table WHERE id='$valid_user'";
$result = mysql_query($query,$DBconn);
if(!$result) {
   error("QUERY_ERROR");
   exit;
}
$row = mysql_fetch_row($result);
$name = $row[0];
$email = $row[1];
$zip = $row[2];
$address = $row[3];
$tel = $row[4];
$handphone = $row[5];
$point = $row[6];
$kk_point=$point;

//$point =  number_format($point);

$query_p = "SELECT sum(Point) as point_cur FROM $shop_point WHERE Cid='$valid_user'";
$row_p = mysql_fetch_assoc($result_p = mysql_query($query_p));
$point_cur = $row_p[point_cur]; 
$kk_point=$point_cur;

if($kk_point==""){
	$kk_point=0;
}
#####################################################################
?>
<script type="text/javascript" src="../include/js/jquery-1.12.2.min.js"></script>
<script language="JavaScript">
<!--

function paygo() {
	<?
		if(!$_SESSION['valid_user']){
	?>
			alert("로그인 하셔야 결제 할 수 있습니다");
			location.href='cart.php';
			return false;
	<?}?>
	
	var GP = "<?=$GP?>";
   if(!document.join.buyername.value) {
      alert('주문자 이를을 입력하세요.');
      document.join.buyername.focus();
      return;
   }
   if(!document.join.post.value) {
      alert('주문자 우편번호를 입력하세요.');
      document.join.post1.focus();
      return;
   }
   if(!document.join.addr1.value) {
      alert('주문자 주소를 입력하세요.');
      document.join.addr1.focus();
      return;
   }

   if(!document.join.htel.value) {
      alert('주문자 연락처를 입력하세요.');
      document.join.htel.focus();
      return;
   }
  
   if(!document.join.email.value) {
      alert('주문자 E-mail을 입력하세요.');
      document.join.email.focus();
      return;
   }

   if(!document.join.recvname.value) {
      alert('수신자 이름을 입력하세요.');
      document.join.recvname.focus();
      return;
   }

	//if (Number(GP) < Number(document.join.usepoint.value) )
	{
     // alert('코인이 부족합니다.');
     // document.join.usepoint.focus();
     // return;
	}
//   if(!document.join.rhtel.value) {
//      alert('배송지 연락처를 입력하세요.');
//      document.join.rhtel.focus();
//      return;
//   }
//   <?if($valid_user) {?>
//	   if(document.join.usepoint.value!="") {		
//		  if(parseInt(document.join.usepoint.value)>'<?=$kk_point?>'){
//			 alert('사용하실코인이 보유코인을 초과하였습니다.');
//			document.join.usepoint.focus();
//			return;
//		  }
//	   }		
//	   var kk_point = '<?=$kk_point?>';
//	   if(document.join.usepoint.value!="") {		
//		  if(parseInt(document.join.usepoint.value)>parseInt(document.join.total_coin1.value)){
//			 alert('사용가능한 코인을 초과하였습니다.');
//			document.join.usepoint.focus();
//			return;
//		  }
//	   }
//	<?}?>
//	if(document.join.paymentkind[0].checked==true){
//		if(document.join.in_name.value==""){
//			alert('입금자명을 입력해주세요.');
//			document.join.in_name.focus();
//			return;
//		}
//	}

//alert(document.join.receive.value);
   document.join.submit();
}

function no_cart() {
	alert("품절된 상품이 있습니다. 확인후 구입해주세요.");
	return ;
}
//-->
</script>
<script language="javascript">
function go_recal1() {
	document.form.action='./cart_racal.php';
    document.form.submit();
}
//-->
</script>
 </head>
 <body>
	<div class="wrap">

		<!-- 상단(Top) -->

		
		<? include "../include/top.php"; ?>

		
		<!-- 상단(Top) -->

		<!-- 컨텐츠 시작 -->
		<div class="content_inner">
			<div class="sp40"></div>
				<!-- 카테고리 -->
				
				<? include "../include/category_info.php"; ?>

				<!-- 카테고리 끝 -->


			<div class="content_inner">


				<div class="content">
					<div class="page_title">
						주문서작성
					</div>

									<table class="cart_table">
						<tr>
					<th width="10%">상품이미지</th>
					<th width="35%">상품명</th>
					<th width="15%">수량</th>
					<th width="10%">상품가격</th>
					<th width="10%">GP</th>
					<th width="10%">상품합계</th>
					<th width="10%">삭제</th>
						</tr>
						<form name=form method=post>
<?
#####################################################################
$tot=totCount();
$total_price=0;
$total_coin=0;

for($i=0;$i<$tot;$i++) {
	$ii=$i; //gas_sel
	getCart($i,$arr);


	if($arr[1] < 1 || $arr[1] ==''){
		echo "<script type='text/javascript'>
		<!--
			alert('장바구니에 수량이 1개 보다 적은 제품이 있습니다.');
		//-->
		</script>";
		echo "<meta http-equiv='refresh' content='0;url=cart.php'>"; 
		exit;
	}



	$query = "SELECT code,title,pricec,prices,priced,point,soldout,price_dis,imgl,opt_num,opt_num_str,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,point_dis,imgb1,imgb2,No,coin FROM $shop_goods WHERE code='$arr[0]'";
	$result= mysql_query($query,$DBconn);
	
	
	if (!$result) {
   	  error("QUERY_ERROR");
   	  exit;
	}

	/*	
	$No = mysql_result($result,0,34);
	$query1="SELECT coin_price FROM $coin_goods WHERE no='$No' ";
	$result1 = mysql_query($query1,$DBconn);
	$value = mysql_fetch_row($result1);
	$priced_diot = $value[0];
	if (!$result1) {
   	  error("QUERY_ERROR");
   	  exit;
	}
*/
	$code = mysql_result($result,0,0);
	$title = mysql_result($result,0,1);
	$pricec = mysql_result($result,0,2);
	$prices = mysql_result($result,0,3);
	$priced = mysql_result($result,0,4);
//	$priced_diot = mysql_result($result1,0,0);
	$point = mysql_result($result,0,5);
	$soldout = mysql_result($result,0,6);
	$price_dis = mysql_result($result,0,7);
	$imgl = mysql_result($result,0,8);
	$opt_num = mysql_result($result,0,9);
	$opt_num_str = mysql_result($result,0,10);

	$option_t1 = mysql_result($result,0,11);
	$option_n1 = mysql_result($result,0,12);
	$option_p1 = mysql_result($result,0,13);
	$option_k1 = mysql_result($result,0,14);

	$option_t2 = mysql_result($result,0,15);
	$option_n2 = mysql_result($result,0,16);
	$option_p2 = mysql_result($result,0,17);
	$option_k2 = mysql_result($result,0,18);

	$option_t3 = mysql_result($result,0,19);
	$option_n3 = mysql_result($result,0,20);
	$option_p3 = mysql_result($result,0,21);
	$option_k3 = mysql_result($result,0,22);

	$option_t4 = mysql_result($result,0,23);
	$option_n4 = mysql_result($result,0,24);
	$option_p4 = mysql_result($result,0,25);
	$option_k4 = mysql_result($result,0,26);

	$option_t5 = mysql_result($result,0,27);
	$option_n5 = mysql_result($result,0,28);
	$option_p5 = mysql_result($result,0,29);
	$option_k5 = mysql_result($result,0,30);

	$point_dis = mysql_result($result,0,31);
	$imgb1 = mysql_result($result,0,32);
	$imgb2 = mysql_result($result,0,33);
	$coin = mysql_result($result,0,35);
	

	
	if($soldout=="Y"){
		$out111="Y";
	}
	
	$title = stripslashes($title);
	
	
	$detail = stripslashes($detail);

	##############가격계산###################################3

/*	if($priced>0){
		$price_tmp = $priced;
	}else{
		$price_tmp = $pricec;
	}
*/
		$price_tmp = $pricec;
		$sail_price = $priced;


	#################################################

	if($point_dis=='pe'){
		$cpoint=number_format(floor($price_tmp*$point/100))."&nbsp;원";
		$cpoint1=floor($price_tmp*$point/100);
	}else{
		$cpoint=number_format($point)."&nbsp;원";
		$cpoint1=$point;
	}

	$asize = split(",",$size);				/*사이즈 분리*/			 $acolor = split(",",$color);					/*색상 분리*/


	$aopt_num = explode(",",$opt_num);

	
	$aoption_n1=split("\r\n",$option_n1);		$aoption_p1=split("\r\n",$option_p1);		$aoption_k1=split("\r\n",$option_k1);
	$aoption_n2=split("\r\n",$option_n2);	 	$aoption_p2=split("\r\n",$option_p2);		$aoption_k2=split("\r\n",$option_k2);
	$aoption_n3=split("\r\n",$option_n3);		$aoption_p3=split("\r\n",$option_p3);		$aoption_k3=split("\r\n",$option_k3);
	$aoption_n4=split("\r\n",$option_n4);		$aoption_p4=split("\r\n",$option_p4);	 	$aoption_k4=split("\r\n",$option_k4);
	$aoption_n5=split("\r\n",$option_n5);		$aoption_p5=split("\r\n",$option_p5);		$aoption_k5=split("\r\n",$option_k5);

	$aaoption_n1=split("\r\n",$option_n1);		$aaoption_p1=split("\r\n",$option_p1);		$aaoption_k1=split("\r\n",$option_k1);
	$aaoption_n2=split("\r\n",$option_n2);	 	$aaoption_p2=split("\r\n",$option_p2);		$aaoption_k2=split("\r\n",$option_k2);
	$aaoption_n3=split("\r\n",$option_n3);		$aaoption_p3=split("\r\n",$option_p3);		$aaoption_k3=split("\r\n",$option_k3);
	$aaoption_n4=split("\r\n",$option_n4);		$aaoption_p4=split("\r\n",$option_p4);	 	$aaoption_k4=split("\r\n",$option_k4);
	$aaoption_n5=split("\r\n",$option_n5);		$aaoption_p5=split("\r\n",$option_p5);		$aaoption_k5=split("\r\n",$option_k5);

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

	$price_tmp = $price_tmp;
	$price = $price;
	$price =  number_format($price_tmp+$price1+$price2+$price3+$price4+$price5)."&nbsp;원";
	
	$coin_tatal = $coin *$arr[1];
	$result_coin = $result_coin + $coin_tatal;
	$coin_total_sett = number_format($coin_tatal)."&nbsp;GP";
	$result_coin_total = number_format($result_coin)."&nbsp;GP";

	$sale_price_total = $sail_price   *$arr[1];
	$result_price = $result_price + $sale_price_total;
	$sale_price_total_stt = number_format($sale_price_total)."&nbsp;원";
	$result_price_total = number_format($result_price)."&nbsp;원";

	$sum_price = $sum_price;
	$total_price = $total_price + $sum_price;

//	$sum_price =  number_format($sum_price)."&nbsp;원";
	$sum_price =  number_format($sum_price)."&nbsp;원";

	$total_point=$total_point+$point;
	$point_tot=$point;
	$point =  number_format($point);

	### 이미지 파일 저장 디렉토리 ###
	$savedir = "../shop_img/";

	$img_name = $savedir.$imgl;

?>		
				

				<tr>					
					<td><a href="../product/view.php?left_code=<?=$code?>"><?if($imgl) {?><img src="<?=$imgl?>" width="120" border="0" /><?}else{?><img src="<?=$savedir?><?=$imgb1?>" width="120"><?}?></a></td>
					<td class="review_cont">
						<a href="../product/view.php?left_code=<?=$code?>" class="a_3">
							<?=$title?><br/>
							<span class="cart_list_option"><?if($arr[5]!=""){?>&nbsp;옵션 :
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
						<input type="hidden" name="option5<?=$i?>" value="<?=$arr[9]?>"></a><?if($soldout=="Y"){?><FONT COLOR="#EC7600">[품절]</FONT><?}?>
					</td>
					<td><?=$arr[1]?>개</td>
					<td class="font_b"><?=$price?></td>
					<td class="font_b"><?=$sale_price_total_stt?>+<?=$coin_total_sett?></td>

					<td class="c_redb"><?=$sum_price?></td>
					<td><a href="./cart_del1.php?del_num=<?=$i?>" onFocus='this.blur()'><img src="images/cart_delet.png" alt="삭제" width='30px'></a></td>
				</tr>
	<?}?>       
<?


if (50 <= $total_price) $charge=0;
else $charge=3;

$total_settle = $total_price + $charge;
$total_settle_diot = $total_settle + $charge;
$total_settle_num=$total_settle;
$total_settle_num_diot=$total_settle_diot;	//diot 로 계산 한 값
$charge =  number_format($charge)."&nbsp;원";
$total_price =  number_format($total_price)."&nbsp;원";
$total_settle =  number_format($total_settle)."&nbsp;원";


?>	
				
			</table>
<div class="cart_price">
			<div class="sp30"></div>
			<div class="cart_price_inner">
				총결제금액[총금액(<?=$result_price_total?>) + <?=$result_coin_total?>+ 배송비(<?=$charge?>)]&nbsp;&nbsp;<span class="c_redb font_24"><?=$total_settle?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</div>
			<div class="sp15"></div>
			<div class="price_text">
				제조사및 공급사에 따라 추가 배송비가 발생할 수 있습니다.&nbsp;&nbsp;&nbsp;&nbsp;<br/>
				도서산간지역은 추가요금(착불)이 발생할 수 있습니다.&nbsp;&nbsp;&nbsp;&nbsp;
			</div>
			<div class="sp30"></div>
		</div>
		</form>
						<div class="sp20"></div>
<form name=join method=post action="confirm.php">
<script language="javascript">
<!--
function sync_data(m) {
	if(m==1) {
		document.join.recvname.value=document.join.buyername.value;
		document.join.rpost.value=document.join.post.value;
		document.join.raddr1.value=document.join.addr1.value;
		//document.join.rtel.value=document.join.tel.value;
		document.join.rhtel.value=document.join.htel.value;
	}
	if(m==2) {
		document.join.recvname.value="";
		document.join.rpost.value="";
		document.join.raddr1.value="";
		//document.join.rtel.value="";
		document.join.rhtel.value="";
	}
}
//-->
</script>
						<table class="order_table">
			<tr>
				<th>주문자</th>
				<td><input type="text" name="buyername" value="<?=$name?>" class="input_name"></td>
			</tr>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    function sample6_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if(data.userSelectedType === 'R'){
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if(data.buildingName !== '' && data.apartment === 'Y'){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if(extraAddr !== ''){
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // 조합된 참고항목을 해당 필드에 넣는다.
                   // document.getElementById("addr1").value = extraAddr;
                
                } else {
                    document.getElementById("addr1").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('post').value = data.zonecode;
                document.getElementById("addr1").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("addr1").focus();
            }
        }).open();
    }
</script>
			<tr>
				<th>주소</th>
				<td>
					<input type="text" name="post" value="<?=$zip?>" id="post" class="input_name">&nbsp;<input type="button" value="Find Address" class="find_address" onclick="sample6_execDaumPostcode();">
					<div class="sp5"></div>
					<input type="text" name="addr1" value="<?=$address?>" id="addr1" class="input_addr">
				</td>
			</tr>
			<tr>
				<th>이메일</th>
				<td><input type="text" name="email" value="<?=$email?>" class="input_email"></td>
			</tr>
			<!-- <tr>
				<th>일반전화</th>
				<td><input type="text" class="input_tel">&nbsp;-&nbsp;<input type="text" class="input_tel">&nbsp;-&nbsp;<input type="text" class="input_tel"></td>
			</tr> -->
			<tr>
				<th>휴대폰</th>
				<td><input type="text"  name="htel" value="<?=$handphone?>" class="input_email"></td>
			</tr>
		</table>

		<div class="sp30"></div>

		<div class="order_title">
			상품 받으실 분&nbsp;&nbsp; <span class="font_12 font_thin c_gary">주문자와 동일</span><input name="buytype" type="radio" value="radiobutton" onClick="sync_data(1);">
						  예 
						  <input type="radio" name="buytype" value="radiobutton" onClick="sync_data(2);">
						  아니오
		</div>

		<div class="sp10"></div>

		<table class="order_table">
			<tr>
				<th>받는 분</th>
				<td><input type="text" name="recvname" class="input_name"></td>
			</tr>
			<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
						<script>
							function openDaumPostcode1() {							
							new daum.Postcode({
								oncomplete: function(data) {
									// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

									// 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
									// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
									var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
									var extraRoadAddr = ''; // 도로명 조합형 주소 변수

									// 법정원 MALL이 있을 경우 추가한다. (법정리는 제외)
									// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
									if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
										extraRoadAddr += data.bname;
									}
									// 건물명이 있고, 공동주택일 경우 추가한다.
									if(data.buildingName !== '' && data.apartment === 'Y'){
									   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
									}
									// 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
									if(extraRoadAddr !== ''){
										extraRoadAddr = ' (' + extraRoadAddr + ')';
									}
									// 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
									if(fullRoadAddr !== ''){
										fullRoadAddr += extraRoadAddr;
									}

									// 우편번호와 주소 정보를 해당 필드에 넣는다.
									document.getElementById('rpost').value = data.zonecode; //5자리 새우편번호 사용
									document.getElementById('raddr1').value = fullRoadAddr;
									//document.getElementById('address').value = data.jibunAddress;

									
								}
							}).open();	
							}
						</script>
			<tr>
				<th>배송지 주소</th>
				<td>
					<input type="text" name="rpost" id="rpost" class="input_name">&nbsp;<input type="button" value="Find Address" class="find_address" onClick="openDaumPostcode1('rpost','raddr1');">
					<div class="sp5"></div>
					<input type="text" name="raddr1" id="raddr1" class="input_addr">
				</td>
			</tr>
			<!-- <tr>
				<th>일반전화</th>
				<td><input type="text" class="input_tel">&nbsp;-&nbsp;<input type="text" class="input_tel">&nbsp;-&nbsp;<input type="text" class="input_tel"></td>
			</tr> -->
			<tr>
				<th>휴대폰</th>
				<td><input type="text" name="rhtel" class="input_email"></td>
			</tr>
			
			<tr>
				<th>배송시 요구사항</th>
				<td><input type="text" name="rcontent" class="input_name"></td>
			</tr>
		</table>

		<div class="sp30"></div>

		<div class="order_title">
			결제수단
		</div>

		<div class="sp10"></div>
<!-- <script type="text/javascript"> -->
<!-- <!-- -->
<!-- 	function coin_sum(){ -->
<!-- 		total_price1=<?=$total_settle_num?>-document.join.usepoint.value; -->
<!-- 		var s = total_price1.toString();  -->
<!-- 		var s2 = s.replace(/(,|\s)+/g,'');  -->
<!-- 		total_price1 = s2.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,');  -->
<!-- 		document.join.total_price123.value=total_price1+"&nbsp;원"; -->
<!-- 		} -->
<!-- //--> 
<!-- </script> -->
		<table class="order_table">
		 <tr>
				<th>코인결제</th>
				<td>
					<input name="usepoint" type="text" class="input_name" readonly value="<?=$result_coin?>" id="textfield7" size="15">
						<input type="hidden" name="total_coin1" value="<?=$coin_tatal?>" readonly>
						<br><br>
                        <span class="cart5">GP <font color="#cc0000"><b><?=$result_coin?></b></font>결재됩니다. (총 사용가능 코인 : <?=$kk_point?>)  </span><br>
						
				</td>
			</tr>

 			<tr> 
 				<th>입금 정보</th> 
 				<td> 
 					농협 301-0260-3885-91  K.S.P
 				</td> 
					</tr> 

				<th>결제수단</th> 
 				<td> 
 					<input name="paymentkind" type="radio" value="2" checked> 
 					무통장결제  
<!-- 					<input name="paymentkind" type="radio" value="1"> -->
<!-- 					카드결제 -->
<!-- 					<input name="paymentkind" type="radio" value="3"> -->
<!-- 					계좌이체(에스크로) -->
 				</td> 
					</tr> 
			<tr>
			
		</table>


						<div class="sp20"></div>

						<div class="view_btn">
							<input type="button" value="취 소" class="cart_btn01" onclick="location.href='./cart.php'">

							<input type="button" value="주문하기" class="cart_btn03" <?if($out111=="Y"){?>onclick="javascript:sold_out()"<?}else{?>onclick="javascript:paygo();"<?}?>>&nbsp;
						</div>
					</form>

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