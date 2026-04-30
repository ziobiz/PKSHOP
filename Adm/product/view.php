<?include "../include/top_session.php";?>
<? include "../../Adm/common/dbconn.php"; ?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus  ">

<SCRIPT LANGUAGE="JavaScript">
<!--
function imgview(code) {
	window.open("./zoom.php?code="+code,"imgview","toolbar=no,resizable=no,status=no,width=648,height=505,scrollbars=no");
}

function no_cart() {
	alert("품절된 상품입니다.");
	return ;
}

function go_cart(code,cate,color,size,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5) {

	amount = document.p_form.qty.value;

	document.p_form.action="../cart/cart1.php?code=" + code + "&amount=" + amount ;
	document.p_form.submit();

}

function buy_go(code,cate,color,size,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5) {
	amount = document.p_form.qty.value;



	document.p_form.action="../cart/cart2.php?code=" + code + "&amount=" + amount ;
	document.p_form.submit();

}


function go_save(code,cate,color,size,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5) { //
	amount = document.p_form.qty.value;
	size = document.p_form.size.value;
	color = document.p_form.color.value;
	option1 = document.p_form.option1.value;
	option2 = document.p_form.option2.value;
	option3 = document.p_form.option3.value;
	option4 = document.p_form.option4.value;
	option5 = document.p_form.option5.value;
	cprice1 = document.p_form.cprice1.value;

	size=encodeURIComponent(size);
	color=encodeURIComponent(color);
	option1=encodeURIComponent(option1);
	option2=encodeURIComponent(option2);
	option3=encodeURIComponent(option3);
	option4=encodeURIComponent(option4);
	option5=encodeURIComponent(option5);

var valid_user = '<?=$valid_user?>';//???

	url="./save_do.php?code=" + code + "&amount=" + amount + "&size=" + size + "&color=" + color + "&option1=" + option1 + "&option2=" + option2 + "&option3=" + option3 + "&option4=" + option4 + "&option5=" + option5 + "&cprice1=" + cprice1 + "&valid_user=" + valid_user;
	window.open(url,"","width=50,height=50");
}

//-->
</SCRIPT>
<?



if($left_code != "") {
	$code1 = substr($left_code, 0, 2);
	$code2 = substr($left_code, 2, 2);
	$code3 = substr($left_code, 4, 2);
	$code4 = substr($left_code, 6, 2);
	$left_code_tmp = $left_code;
	$code=$left_code;
}else{
	$code1 = '01';
}

if($code != "") {
	$code1 = substr($code, 0, 2);
	$code2 = substr($code, 2, 2);
	$code3 = substr($code, 4, 2);
	$code4 = substr($code, 6, 2);
	$code=$code;
}

//접속접보
$signdate=time();
$ip=$REMOTE_ADDR;

$query_ip = "insert into $attendance value ('','$code','$signdate','$ip')";
$result_ip = mysql_query($query_ip);

$code1_cate_tmp = $code1;
$code2_cate_tmp = $code2;
$code3_cate_tmp = $code3;
$code4_cate_tmp = $code4;

//echo "$code1 $code2 $code3 $code4,$theme_str";
if($theme_str==""){//정렬순서 관련

	if($code1!=""){
	$query_title1 = "SELECT cate1 FROM $shop_cate WHERE code1='$code1'";
	$result_title1 = mysql_query($query_title1,$DBconn);
	if(!$result_title1) {
	   error("QUERY_ERROR");
	   exit;
	}
		$tmp_cate1 = mysql_result($result_title1,$i,0);
		$title_cate_1 = $tmp_cate1;	//대분류 이름기억
		$title_code_1 = $code1;
	}

	if($code2!=""){
	$query_title2 = "SELECT cate2 FROM $shop_cate WHERE code1='$code1' and code2='$code2'";

	$result_title2 = mysql_query($query_title2,$DBconn);
	$total_record2 = mysql_num_rows($result_title2);
	if($total_record2>0){
	if(!$result_title2) {
	   error("QUERY_ERROR");
	   exit;
	}
		$tmp_cate2 = mysql_result($result_title2,$i,0);
		$title_cate_2 = $tmp_cate2;	//중분류 이름기억
		$title_code_2 = $code2;
	}
	}

	if($code3!=""){
	$query_title3 = "SELECT cate3 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3'";

	$result_title3 = mysql_query($query_title3,$DBconn);

	$total_record3 = mysql_num_rows($result_title3);
	if($total_record3>0){
	if(!$result_title3) {
	   error("QUERY_ERROR");
	   exit;
	}
		$tmp_cate3 = mysql_result($result_title3,$i,0);
		$title_cate_3 = $tmp_cate3;	//중분류 이름기억
		$title_code_3 = $code3;
	}
	}

	if($code4!=""){
	$query_title4 = "SELECT cate4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4='$code4'";

	$result_title4 = mysql_query($query_title4,$DBconn);
	$total_record4 = mysql_num_rows($result_title4);
	if($total_record4>0){
	if(!$result_title4) {
	   error("QUERY_ERROR");
	   exit;
	}

	$total_record_cnt = mysql_num_rows($result_title4);

	if($total_record_cnt > 0){
		$tmp_cate4 = mysql_result($result_title4,$i,0);
		$title_cate_4 = $tmp_cate4;	//중분류 이름기억
		$title_code_4 = $code4;
	}

	}
	}

}


#####################################################################
?>
 </head>

 <body>

	 <div class="wrap">

		<!-- 상단 (top) -->

		<? include "../include/top.php"; ?>

		<!-- 상단 (top) 끝 -->

		<div class="sp50"></div>
		<div class="sub04_container">
			<!-- 카테고리 -->



			<!-- 카테고리 끝 -->



			<!-- view -->



					<?

	$query = "SELECT title,info,pricec,prices,priced,point,size,color,currnum,detail,company,feature,soldout,relation,price_dis,imgm,opt_num,opt_num_str,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,point_dis,color_opt,size_opt,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5,home,event_str,imgb1,imgb2,imgb3,imgb4,imgb5 FROM $shop_goods WHERE code='$code'";


	$DB->get($query,$rs,$rn);
	if(!$result) {
	   error("QUERY_ERROR");
	   exit;
	}

	


	$title = $rs[0][0];		/*상품명*/					$info = $row[1];
	$pricec = $row[2];		/*판매*/				$prices = $row[3];     /*입고*/
	$priced = $row[4];     /*할인*/
	$point = $row[5];		/*상품 적립금*/				$size = $row[6];			/*사이즈*/
	$color = $row[7];	/*색상*/							$currnum = $row[8];	/*현재수량*/
	$detail = $row[9];	/*상품정보*/						$company = $row[10];	/*제조사*/
	$feature = $row[11];	 /*규격설명*/				$soldout = $row[12];
	$relation=$row[13];			$price_dis=$row[14];			$imgm=$row[15];
	$opt_num=$row[16];		$opt_num_str=$row[17];

	$option_t1=$row[18];	 $option_n1=$row[19];	$option_p1=$row[20];	$option_k1=$row[21];
	$option_t2=$row[22];	 $option_n2=$row[23];	$option_p2=$row[24];	$option_k2=$row[25];
	$option_t3=$row[26];	 $option_n3=$row[27];	$option_p3=$row[28];	$option_k3=$row[29];
	$option_t4=$row[30];	 $option_n4=$row[31];	$option_p4=$row[32];	$option_k4=$row[33];
	$option_t5=$row[34];	 $option_n5=$row[35];	$option_p5=$row[36];	$option_k5=$row[37];
	$point_dis=$row[38];

	$color_opt=$row[39];
	$size_opt=$row[40];
	$add_opt1=$row[41];
	$add_opt2=$row[42];
	$add_opt3=$row[43];
	$add_opt4=$row[44];
	$add_opt5=$row[45];
	$home=$row[46];

	$event_str=$row[47];


	$imgb1=$row[48];
	$imgb2=$row[49];
	$imgb3=$row[50];
	$imgb4=$row[51];
	$imgb5=$row[52];







	$event_str = preg_replace("/\r/", "", $event_str);
	$event_str = preg_replace("/(\>[ ]*)\n/", ">\n", $event_str);
	$event_str = preg_replace("/((font|span|a)\>[ ]*|[^\>])\n/i", "\\1<br />\n", $event_str);

	$pricec_code = $pricec;  //판매
	$prices_code = $prices;  //코인사용
	$priced_code = $priced;  //할인

	$detail = stripslashes($detail);
##############회&nbsp;원등급에 따른 가격계산###################################3
	if($cook_dis=="1" && $cook_dis1=="승인"){
		$price_tmp = $priced;
	}else	if($cook_dis=="2" && $cook_dis1=="승인"){
		$price_tmp = $pricec;
	}else if($cook_dis=="3" && $cook_dis1=="승인"){
		$price_tmp = $prices;
	}else{
		if($priced>0){
			$price_tmp = $priced;
		}else{
			$price_tmp = $pricec;
		}
	}

$price_tmp_kk = $price_tmp; //shop_view.htm용
#################################################

#################포인트 계산################################
if($point_dis=='pe'){
	$cpoint=number_format(floor($price_tmp*$point/100))."&nbsp;원";
	$cpoint1=floor($price_tmp*$point/100);
}else{
	$cpoint=number_format($point)."&nbsp;원";
	$cpoint1=$point;
}
#################################################

$price_tmp = number_format($price_tmp).'&nbsp;원'; //표시용 가격


	$asize = split(",",$size);				/*사이즈 분리*/			 $acolor = split(",",$color);					/*색상 분리*/
	$price = number_format($price); /*가격표시변환*/
	//$prices = number_format($prices); /*가격표시변환*/
	$priced = number_format($priced); /*가격표시변환*/

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


	### 이미지 파일 저장 디렉토리 ###
	$savedir = "../../shop_img";

	$img_name = $imgb1;

	$img_info = getImageSize($savedir.'/'.$imgb1);//&nbsp;원본이미지의 정보를 얻어옵니다
	$img_width = $img_info[0];
	$img_height = $img_info[1];

	if($img_width > $img_height){
		$img_size = "width='274'";
	}else{
		$img_size = "height='238'";
	}






?>
<?if($option_t1!=""){?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function window::onload(){ go_price3(); }
//-->
</SCRIPT>
<?}?>

<SCRIPT LANGUAGE="JavaScript">
<!--

function go_price3() {
	frm = document.p_form;

		<?if($price_tmp_kk>0){?>
			frm.cprice.value = '<?=number_format($price_tmp_kk)?>'+'&nbsp;LANX';
			frm.cprice1.value = <?=$price_tmp_kk?>;
		<?}?>

		<?if($point>0){?>
			<?if($point_dis=='wo' || $point_dis==""){?>
				frm.cpoint.value = '<?=number_format(point)?>'+'&nbsp;LANX';
				frm.cpoint1.value = <?=$point?>;
			<?}else if($point_dis=='pe'){?>
				<?if($price_tmp_kk!="" && $price_tmp_kk!="0"){
					$pricep=floor($price_tmp_kk*$point/100);
				}?>

				frm.cpoint.value = '<?=number_format($pricep)?>'+'&nbsp;LANX';
				frm.cpoint1.value = <?=$pricep?>;
			<?}?>
		<?}?>

	<?if($option_t1!=""){?>
	<?
	while(list($key1,$value1) = each($aaoption_n1)) {
	?>
	if (frm.option1[<?=$key1?>].selected == true) {
		<?if($price_tmp!=""){?>
			o1_1 = <?=$aoption_p1[$key1]?>;
			o1=o1_1;
		<?}?>

		<?if($point!=""){?>
			<?if($point_dis=='wo' || $point_dis==""){?>
				o3_1  = <?=$aoption_k1[$key1]?>;
				o3=o3_1;
			<?}else if($point_dis=='pe'){?>
				<?
					$pricep1=floor($aoption_p1[$key1]*$aoption_k1[$key1]/100);
					$aoption_k1[$key1]=$pricep1;
				?>

				o3_1  = <?=$aoption_k1[$key1]?>;
				o3=o3_1;
			<?}?>
		<?}?>
	}
	<?}?>
	<?}?>

	<?if($option_t2!=""){?>
	<?
	while(list($key1,$value1) = each($aaoption_n2)) {
	?>
	if (frm.option2[<?=$key1?>].selected == true) {
		<?if($price_tmp!=""){?>
			o1_2 = o1_1+<?=$aoption_p2[$key1]?>;
			o1=o1_2;
		<?}?>

		<?if($point!=""){?>
			<?if($point_dis=='wo' || $point_dis==""){?>
				o3_2 =o3_1+<?=$aoption_k2[$key1]?>;
				o3=o3_2;
			<?}else if($point_dis=='pe'){?>

				<?
					$pricep2=floor($aoption_p2[$key1]*$aoption_k2[$key1]/100);
					$aoption_k2[$key1]=$pricep2;
				?>
				o3_2 =o3_1+<?=$aoption_k2[$key1]?>;
				o3=o3_2;
			<?}?>
		<?}?>
	}
	<?}?>
	<?}?>

	<?if($option_t3!=""){?>
	<?
	while(list($key1,$value1) = each($aaoption_n3)) {
	?>
	if (frm.option3[<?=$key1?>].selected == true) {
		<?if($price_tmp!=""){?>
			o1_3 = o1_2+<?=$aoption_p3[$key1]?>;
			o1=o1_3;
		<?}?>

		<?if($point!=""){?>
			<?if($point_dis=='wo' || $point_dis==""){?>
				o3_3 =o3_2+<?=$aoption_k3[$key1]?>;
				o3=o3_3;
			<?}else if($point_dis=='pe'){?>

				<?
					$pricep3=floor($aoption_p3[$key1]*$aoption_k3[$key1]/100);
					$aoption_k3[$key1]=$pricep3;
				?>
				o3_3 =o3_2+<?=$aoption_k3[$key1]?>;
				o3=o3_3;
			<?}?>

		<?}?>
	}
	<?}?>
	<?}?>

	<?if($option_t4!=""){?>
	<?
	while(list($key1,$value1) = each($aaoption_n4)) {
	?>
	if (frm.option4[<?=$key1?>].selected == true) {
		<?if($price_tmp!=""){?>
			o1_4 = o1_3+<?=$aoption_p4[$key1]?>;
			o1=o1_4;
		<?}?>

		<?if($point!=""){?>
			<?if($point_dis=='wo' || $point_dis==""){?>
				o3_4 = o3_3+<?=$aoption_k4[$key1]?>;
				o3=o3_4;
			<?}else if($point_dis=='pe'){?>

				<?
					$pricep4=floor($aoption_p4[$key1]*$aoption_k4[$key1]/100);
					$aoption_k4[$key1]=$pricep4;
				?>
				o3_4 = o3_3+<?=$aoption_k4[$key1]?>;
				o3=o3_4;
			<?}?>

		<?}?>
	}
	<?}?>
	<?}?>

	<?if($option_t5!=""){?>
	<?
	while(list($key1,$value1) = each($aaoption_n5)) {
	?>
	if (frm.option5[<?=$key1?>].selected == true) {
		<?if($price_tmp!=""){?>
			o1_5 = o1_4+<?=$aoption_p5[$key1]?>;
			o1=o1_5;
		<?}?>

		<?if($point!=""){?>
		<?if($point_dis=='wo' || $point_dis==""){?>
				o3_5 =o3_4+<?=$aoption_k5[$key1]?>;
				o3=o3_5;
			<?}else if($point_dis=='pe'){?>

				<?
					$pricep5=floor($aoption_p5[$key1]*$aoption_k5[$key1]/100);
					$aoption_k5[$key1]=$pricep5;
				?>
				o3_5 =o3_4+<?=$aoption_k5[$key1]?>;
				o3=o3_5;
			<?}?>

		<?}?>
	}
	<?}?>
	<?}?>


<?if($option_t1!=""){?>
	<?if($price_tmp>0){?>
	total_sum1=eval(frm.cprice1.value)+o1;
	total_sum1_kk=total_sum1;
	var s = total_sum1.toString();
	var s2 = s.replace(/(,|\s)+/g,'');
	total_sum1 = s2.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,');
	frm.cprice.value =total_sum1+"&nbsp;원";
	frm.cprice1.value =total_sum1_kk;
	<?}?>

	<?if($point>0){?>
	 total_sum3= eval(frm.cpoint1.value)+o3;
	 total_sum3_kk=total_sum3;
	 var s = total_sum3.toString();
	 var s2 = s.replace(/(,|\s)+/g,'');
	 total_sum3 = s2.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,');
	 frm.cpoint.value =total_sum3+"&nbsp;원";
	 frm.cpoint1.value =total_sum3_kk;

	<?}?>
<?}else{?>
	<?if($price_tmp>0){?>
	total_sum1=eval(frm.cprice1.value);
	otal_sum1_kk=total_sum1;
	var s = total_sum1.toString();
	var s2 = s.replace(/(,|\s)+/g,'');
	total_sum1 = s2.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,');
	frm.cprice.value =total_sum1+"&nbsp;원";
	frm.cprice1.value =total_sum1_kk;
	<?}?>

	<?if($point>0){?>
	 total_sum3= eval(frm.cpoint1.value);
	 otal_sum1_kk=total_sum1;
	 var s = total_sum3.toString();
	 var s2 = s.replace(/(,|\s)+/g,'');
	 total_sum3 = s2.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,');
	 frm.cpoint.value =total_sum3+"&nbsp;원";
	 frm.cpoint1.value =total_sum3_kk;
	<?}?>
<?}?>
}
function price_change(){
var frm = document.p_form;
var price = document.getElementById('pricec_code').value;
var qty = document.getElementById('qty').value;
var price2 = qty*price;

$price_total = price2;
price2 = price2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
document.getElementById('totalprice').innerHTML=price2+"&nbsp;LANX";


}

//-->
</SCRIPT>
			<div class="content">
        <div class="sp30"><?=$title_cate_1?> > <?=$title_cate_2?></div>
				<p class="view_title"><?=$title?></p>
				<div class="view_line"></div>

				<div class="sp30"></div>
				<div class="view_content">
					<div class="view_img">
						<div class="sp20"></div>
						<p><img src="../shop_img/<?=$imgb3?>"></p>

					</div>
<form name=p_form method=post>
<input type="hidden" name="cprice1" value="<?=$cprice1?>">
<input type="hidden" name="cpoint1" value="<?=$cpoint1?>">
<input type="hidden" name="pricec_code" id="pricec_code" value="<?=$pricec_code?>">
					<div class="view_imformation">
						<table class="view_table">
							<tr>
								<td class="option_td">가격</td>
								<td class="option_price"><?=number_format($pricec_code)?>원</font>&nbsp;&nbsp;&nbsp;</td>
							</tr>

							<tr>
								<td class="option_td">포인트</td>
								<td class="option_price"><?=number_format($priced_code)?></font>&nbsp;&nbsp;&nbsp;</td>
							</tr>


							<? if($point>0){?>
							<tr>
								<td class="option_td">적립금</td>
								<td class="option_price"><?=$cpoint1?></td>
							</tr>
							<?}else{?>
								<input type="hidden" name="cpoint" value="<?=$cpoint?>" onFocus="this.blur();" style="border:0;">
							<?}?>
							<tr class="option_tr03">
								<td class="option_td">수량</td>
								<td>
								<select id="qty" name="qty">
							<?for($i=1; $i<=20; $i++){?>
							<option value=<?=$i?>><?=$i?></option>
							<?}?>
								</select>
									개<?=$price_total?>
								</td>
							</tr>
						</table>
						<div class="sp50"></div>

						<div class="sp30"></div>
						<div class="view_btn_sub01">
							<input type="button" value="바로구매" class="sub04_btn00 sub04_btn02" onclick="javascript:buy_go('<?=$code?>','<?=$title_cate1?>')">
							<input type="button" value="장바구니" class="sub04_btn00 sub04_btn03" onclick="javascript:go_cart('<?=$code?>','<?=$title_cate1?>');">
						</div>
					</div>
				</div>
</form>

				<div class="sp30"></div>

				<div class="view_section">


					<div class="view_line_btn">
						<div class="view_line"></div>
						<input type="button" value="제품상세보기" class="sub04_btn" onclick=""></input>
						<input type="button" value="배송정보" class="sub04_btn" onclick=""></input>
					</div>


					<div class="sp50"></div>
					<div class="view_pg" style="text-align: center;">
					<?="shop/".$detail?>
						<img src="../sub04/images/content.jpg">
					</div>


					<div class="view_line_btn">
						<input type="button" value="제품상세보기" class="sub04_btn"  onclick="">
						<input type="button" value="배송정보" class="sub04_btn"  onclick="">
						<div class="view_line"></div>
					</div>

				</div>
			</div>



           <!-- view 끝 -->
		</div>

		<div class="sp50"></div>


		<!--  footer      -->

		<? include "../include/bottom.php"; ?>

		<!--  footer    -->
	</div>
