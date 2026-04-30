<? include "../include/get_balance.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../include/css/reset.css" rel="stylesheet" type="text/css" media="all"/>
<link href="../include/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta property="og:title" content="Pentakleva">
<meta property="og:type" content="website">
<meta property="og:image" content="../images/kakao.jpg?=1">
<meta property="og:image:width" content="800"/>
<meta property="og:image:height" content="400"/> 
<meta property="og:description" content="Pentakleva">
<!-- Chrome, Safari, IE -->
<link rel="shortcut icon" href="../images/webicon2.png">
<!-- Firefox, Opera (Chrome and Safari say thanks but no thanks) -->
<link rel="icon" href="../images/webicon2.png">

</head>

<body>
<div id="wrap">	

	<!-- 상단(Top) -->

	 
	  <? include "../include/top.php"; ?>

				
	<!-- 상단(Top) -->

	<!-- 컨텐츠 시작 -->
	<div id="content">
		
		<div class="content_inner">

			<div class="sp40"></div>

			 <? include "../include/mypage_menu.php"; ?>

			<div class="sp30"></div>

			<div class="page_title">
				주문서확인
			</div>
<?
#####################################################################

$query="SELECT id,pay_name,pay_tel,pay_mobile,pay_zip,pay_addr,pay_email,receive_name,receive_tel,receive_mobile,receive_zip,receive_addr,receive_email,receive_etc,kind,bank,pointin,pointout,in_name,charge,char_name,char_num,signdate,m_price,p_status,p_name,p_signdate,p_detail,status,c_name,c_signdate,c_detail,approve,transaction,send_no,appr_tm ";
$query=$query."FROM ";
$query=$query."$shop_order WHERE ordernum='$ordernum'";

	
	$result = mysql_query($query,$DBconn);
	
	
	if(!$result) {
   	error("QUERY_ERROR");
   	exit;
	}
	$row = mysql_fetch_row($result);
	
	$id = $row[0];					$pay_name = $row[1];	
	$pay_tel = $row[2];				$pay_mobile = $row[3];	
	$pay_zip = $row[4];				$pay_addr = $row[5];	
	$pay_email = $row[6];			$receive_name = $row[7];	
	$receive_tel = $row[8];			$receive_mobile = $row[9];	
	$receive_zip = $row[10];		$receive_addr = $row[11];	
	$receive_email = $row[12];		$receive_etc = $row[13];	
	$kind = $row[14];				$bank = $row[15];
	$pointin = $row[16];			$pointout = $row[17];	
	$in_name = $row[18];			$charge = $row[19];
	$char_name = $row[20];			$char_num = $row[21];	
	$signdate = $row[22];			$m_price = $row[23];	
	$p_status = $row[24];			$p_name = $row[25];	
	$p_signdate = $row[26];			$p_detail = $row[27];
	$status = $row[28];				$c_name = $row[29];
	$c_signdate = $row[30];			$c_detail = $row[31];
	$approve = $row[32];			$transaction = $row[33];	
	$send_no = $row[34];			$appr_tm = $row[35];	
	
	
	$signdate = date("Y.m.d H:i:s",$signdate);

	if($p_signdate>0){
		$p_signdate = date("Y.m.d H:i:s",$p_signdate);
	}else{
		$p_signdate = "00.00.00 00:00:00";
	}

	if($c_signdate>0){
		$c_signdate = date("Y.m.d H:i:s",$c_signdate);
	}else{
		$c_signdate = "00.00.00 00:00:00";
	}

	$receive_etc = str_replace( chr(13),"<br>",$receive_etc );

	$ostatus_tmp=$status;

	if($m_price==""){
		$m_price=0;
	}
#####################################################################
?> 
			<table class="cart_table">
				<tr>
					<th width="12%">주문번호</th>
					<th width="15%">샘플이미지</th>
					<th width="43%">주문정보</th>
					<th width="10%">가격/인원</th>
					<th width="10%">적립금</th>
					<th width="10%">소계</th>
				</tr>
<?
#####################################################################

$query = "SELECT No,title,money,point,code1,code2,code3,code4,code,c_type,c_hangul,c_english,c_homepage,c_up,c_ju,c_color,c_company,c_manual,c_text,c_option1,c_option2,c_option3,c_option4,c_option5,c_option6,c_option7,c_amount,c_form_n,c_sample,c_pro_n,c_text_f,c_text_b,c_fname,c_webhard,c_talk,c_hu_name,c_hu_price,detail,fname1,fname2,a_detail,c_status,name,signdate FROM $shop_sell WHERE ordernum='$ordernum'";
$result = mysql_query($query,$DBconn);
if(!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_num_rows($result);
for ($i=0;$i<$total_record;$i++) {
	
	$No = mysql_result($result,$i,0);				$title = mysql_result($result,$i,1);	
	$money = mysql_result($result,$i,2);			$point = mysql_result($result,$i,3);	
	$code1 = mysql_result($result,$i,4);			$code2 = mysql_result($result,$i,5);	
	$code3 = mysql_result($result,$i,6);			$code4 = mysql_result($result,$i,7);	
	$code = mysql_result($result,$i,8);				$c_type = mysql_result($result,$i,9);	
	$c_hangul = mysql_result($result,$i,10);		$c_english = mysql_result($result,$i,11);	
	$c_homepage = mysql_result($result,$i,12);		$c_up = mysql_result($result,$i,13);	
	$c_ju = mysql_result($result,$i,14);			$c_color = mysql_result($result,$i,15);	
	$c_company = mysql_result($result,$i,16);		$c_manual = mysql_result($result,$i,17);
	$c_text = mysql_result($result,$i,18);			$c_option1 = mysql_result($result,$i,19);	
	$c_option2 = mysql_result($result,$i,20);		$c_option3 = mysql_result($result,$i,21);	
	$c_option4 = mysql_result($result,$i,22);		$c_option5 = mysql_result($result,$i,23);	
	$c_option6 = mysql_result($result,$i,24);		$c_option7 = mysql_result($result,$i,25);	
	$c_amount = mysql_result($result,$i,26);		$c_form_n = mysql_result($result,$i,27);	
	$c_sample = mysql_result($result,$i,28);		$c_pro_n = mysql_result($result,$i,29);	
	$c_text_f = mysql_result($result,$i,30);		$c_text_b = mysql_result($result,$i,31);	
	$c_fname = mysql_result($result,$i,32);			$c_webhard = mysql_result($result,$i,33);	
	$c_talk = mysql_result($result,$i,34);			$c_hu_name = mysql_result($result,$i,35);
	$c_hu_price = mysql_result($result,$i,36);		$detail = mysql_result($result,$i,37);	
	$fname1 = mysql_result($result,$i,38);			$fname2 = mysql_result($result,$i,39);	
	$a_detail = mysql_result($result,$i,40);		$c_status = mysql_result($result,$i,41);	
	$name = mysql_result($result,$i,42);			$signdate = mysql_result($result,$i,43);					
							
	$sum_money = $money;	
	$point = $point;
	$total_money = $total_money + $sum_money;		
	$title = stripslashes($title);
	$money =  number_format($money)."원";				
	$sum_money =  number_format($sum_money)."원";
	$c_company = str_replace( chr(13),"<br>",$c_company);
	$c_text_f = str_replace( chr(13),"<br>",$c_text_f);
	$c_text_b = str_replace( chr(13),"<br>",$c_text_b);
	$detail = str_replace( chr(13),"<br>",$detail);
	

	$str = split(",", $c_fname); 
	$c_fname_link="";
	for($im=0; $im < sizeof($str); $im++){ 
		$c_fname_link=$c_fname_link."[<a href='../shop_img/$str[$im]' target='_blank'>$str[$im]</a>]";
	} 
	

	$str1 = split(",", $c_sample); 
	$c_fname_link1="";
	for($im=0; $im < sizeof($str1); $im++){ 
		if($str1[$im]!=""){
		$c_fname_link1=$c_fname_link1."&nbsp;<img src='../shop_img/$str1[$im]' width='100'>";
		}
	} 
 
	


	if($signdate>0){
		$signdate = date("Y.m.d H:i:s",$signdate);
	}else{
		$signdate = "00.00.00 00:00:00";
	}


#####################################################################
?>
				<tr class="cart_table_line">
					<td><?=$ordernum?><p class="c_9"><?=$signdate?></p></td>
					<td class="cart_img"><?=$c_fname_link1?></td>
					<td class="align_right">
						<?if($c_status!="시안확정"){?>
						<a href="draft.php?ordernum=<?=$ordernum?>" class="a_3">
						<?}?>
						<?=$title?><p class="font_thin a_9"><?if($code1=="01"){?>
						<?if($c_option1!=""){?>&nbsp;/&nbsp;<?=$c_option1?><?}?>
						<?if($c_hangul!=""){?>&nbsp;/&nbsp;<?=$c_hangul?><?}?>
						<?if($c_english!=""){?>&nbsp;/&nbsp;<?=$c_english?><?}?>
						<?if($c_homepage!=""){?>&nbsp;/&nbsp;<?=$c_homepage?><?}?>
						<?if($c_up!=""){?>&nbsp;/&nbsp;<?=$c_up?><?}?>
						<?if($c_ju!=""){?>&nbsp;/&nbsp;<?=$c_ju?><?}?>
						<?if($c_color!=""){?>&nbsp;/&nbsp;<?=$c_color?><?}?>
						<?if($c_manual!=""){?>&nbsp;/&nbsp;<?=$c_manual?><?}?>
						<?if($c_text!=""){?>&nbsp;/&nbsp;<?=$c_text?><?}?>
						<?}else{?>

						<?if($c_option1!=""){?>&nbsp;/&nbsp;<?=$c_option1?><?}?>
						<?if($c_option2!=""){?>&nbsp;/&nbsp;<?=$c_option2?><?}?>
						<?if($c_option3!=""){?>&nbsp;/&nbsp;<?=$c_option3?><?}?>
						<?if($c_option4!=""){?>&nbsp;/&nbsp;<?=$c_option4?><?}?>
						<?if($c_option5!=""){?>&nbsp;/&nbsp;<?=$c_option5?><?}?>
						<?if($c_option6!=""){?>&nbsp;/&nbsp;<?=$c_option6?><?}?>
						<?if($c_option7!=""){?>&nbsp;/&nbsp;<?=$c_option7?><?}?>
						<?if($c_form_n!=""){?>&nbsp;/&nbsp;<?=$c_form_n?><?}?>
						<?if($c_pro_n!=""){?>&nbsp;/&nbsp;<?=$c_pro_n?><?}?>
						<?if($c_hu_name!=""){?>&nbsp;/&nbsp;<?=$c_hu_name?><?}?>
						<?}?></p></a>
					</td>
					<td><?=$money?> / <?=$c_amount?></td>
					<td class="c_sky"><?=$point?></td>
					<td class="c_red"><?=$sum_money?></td>
				</tr>
				<?if($c_text_f!="" || $c_text_b!=""){?>
				<tr>
					<td colspan="3" class="table_in"><?=$c_text_f?></td>
					<td colspan="3" class="table_in"><?=$c_text_b?></td>
				</tr>				
				<tr>
					<td colspan="6" class="t_in_line"></td>
				</tr>
				<?}?>
<?
#####################################################################

}
//추가옵션금액
$query_s = "SELECT sum(o_price) as o_price FROM $shop_cart_option where o_ordernum='$ordernum'";
$result_s = mysql_query($query_s,$DBconn);
if(!$result_s) {
   error("QUERY_ERROR");
   exit;
}
$row_s = mysql_fetch_assoc($result_s);
$o_price = $row_s['o_price'];

$total_settle = $total_money + $charge;
$total_input = $total_settle - $pointout+$o_price;
$total_price = $total_input-$m_price; //미확인 입금금액
$total_money =  number_format($total_money)."원";
$total_settle =  number_format($total_settle)."원";
$total_input =  number_format($total_input)."원";
$total_price =  number_format($total_price)."원";
$point =  number_format($point);
$o_price_settle=$o_price;
$m_price =  number_format($m_price)."원"; //결제된금액
$o_price =  number_format($o_price)."원"; //추가옵션금액
#####################################################################
?>   
				 <tr>
					<td colspan="6" class="cart_price">
						<div class="sp5"></div>
						주문비용 <?=$total_money?>
						<?if($charge>0){?> + 배송비 <?=number_format($charge)?>원<?}?>
						<?if($pointout>0){?> - 포인트사용 <?=number_format($pointout)?>원<?}?>
						<?if($o_price_settle>0){?> + 추가비용 <?=number_format($o_price_settle)?>원<?}?>
						
						<span class="c_red font_22"><?=$total_input?></span>
						<div class="sp5"></div>
					</td>
				</tr>
			</table>

			<div class="sp30"></div>

			<div class="order_table_title">
				주문하시는 분
			</div>

			<table class="order_table">
				<tr>
					<th width="18%">이 름</th>
					<td width="78%"><?=$pay_name?></td>
				</tr>
				<tr>
					<th>핸드폰</th>
					<td><?=$pay_mobile?></td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td><?=$pay_tel?></td>
				</tr>
				<tr>
					<th>E-Mail</th>
					<td><?=$pay_email?></td>
				</tr>
				<tr>
					<th>주 소</th>
					<td>
						[<?=$pay_zip?>] <?=$pay_addr?>
					</td>
				</tr>
			</table>

			<div class="sp30"></div>

			<div class="order_table_title">
				받으시는 분&nbsp;&nbsp;
			</div>

			<table class="order_table">
				<tr>
					<th width="18%">이 름</th>
					<td width="78%"><?=$receive_name?></td>
				</tr>
				<tr>
					<th>핸드폰</th>
					<td><?=$receive_mobile?></td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td><?=$receive_tel?></td>
				</tr>
				<tr>
					<th>E-Mail</th>
					<td>help@paxm.net</td>
				</tr>
				<tr>
					<th>주 소</th>
					<td>
						[<?=$receive_zip?>] <?=$receive_addr?>
					</td>
				</tr>
				<tr>
					<th class="align_top">전하실 말</th>
					<td>
						<?=$receive_etc?>
					</td>
				</tr>
			</table>

			<div class="sp30"></div>

			<div class="order_table_title">
				결제정보
			</div>

			<table class="order_table">
				<tr>
					<th width="18%">결제수단</th>
					<td width="78%"><?if($kind=="1"){?>
										무통장입금
										<?}else if($kind=="2"){?>
										신용카드 
										<?}else if($kind=="3"){?>
										실시간계좌이체
										<?}else{?>
										에스크로결제
										<?}?></td>
				</tr>

				<?if($kind=="1"){?>
			
				<tr>
					<th>입금자명</th>
					<td><?=$in_name?></td>
				</tr>
				<tr>
					<th>입금계좌</th>
					<td class="pay"><?=$bank?></td>
				</tr>
				<?}?>
			</table>

			<div class="sp20"></div>

			<div class="view_btn">
				<input type="button" value="메인으로" class="cart_btn01" onclick="location.href='../main/main.php'">&nbsp;
				<input type="button" value="주문내역" class="cart_btn03" onclick="location.href='overview.php'">
			</div>

		</div>			
			
	</div>
	<!-- 컨텐츠 종료 -->


	<!-- 하단(Copy) -->

	 
	  <? include "../include/bottom.html"; ?>	  
				
				
	<!-- 하단(Copy) -->

	


</div>
</body>
</html>
