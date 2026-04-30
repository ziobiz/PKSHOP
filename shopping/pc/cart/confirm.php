<?php
include "../include/top_session.php";

$total_price123=str_replace(",","",$total_price123);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Generator" content="EditPlus®">
    <title>HCBRS </title>
    <link rel="stylesheet" href="../include/reset.css">
    <link rel="stylesheet" href="../include/style.css">
    <link href="../include/css/reset.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="../include/css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <?
    include "../../Adm/common/dbconn.php";
    include "../include/login_check.php";   

    include "cartfunc.php";
    $session_cart = $_SESSION['session_cart'];
    $buyselected=='Y'? $session_cart=$session_cart_selected:$session_cart=$session_cart;

    if ($session_cart=="") {
        popup_msg("장바구니에 선택하신 상품이 없습니다.");
        exit;
    }

    ?>


    

</head>
<body >
<div id="wrap">

    <!-- 상단(Top) -->


    <?  include "../include/top.php"; ?>


    <!-- 상단(Top) -->

    <!-- 컨텐츠 시작 -->

    <div class="content_inner">

        <div class="sp40"></div>

        <!-- 카테고리 -->

        <? include "../include/category_info.php"; ?>

        <!-- 카테고리 끝 -->

        <div class="content">
            <div class="page_title">
                주문완료
            </div>

            <!-- 				<div class="confrim_title"> -->
            <!-- 					<img src="images/confirm_icon01.png" alt="아이콘"><br/> -->
            <!-- 					주문이 완료되었습니다!<br/> -->
            <!-- 					<span class="confrim_title01">이용해주셔서 감사합니다.</span> -->
            <!-- 				</div> -->

            <div class="sp40"></div>

            <table class="cart_table">
                <tr>
                    <th width="10%">상품이미지</th>
                    <th width="35%">상품명</th>
                    <th width="15%">수량</th>
                    <th width="10%">상품가격</th>
                    <th width="10%">결재가격</th>
  
                    <th width="10%">상품합계</th>
                    <th width="10%">삭제</th>
                </tr>
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



                    $query = "SELECT code,title,pricec,prices,priced,point,soldout,price_dis,imgl,opt_num,opt_num_str,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,point_dis,imgb1,imgb2,coin FROM $shop_goods WHERE code='$arr[0]'";

					


                    $result= mysql_query($query,$DBconn);
                    if (!$result) {
                        error("QUERY_ERROR");
                        exit;
                    }

                    $code = mysql_result($result,0,0);
                    if($code==""){
                        continue;
                    }
                    $title = mysql_result($result,0,1);
                    $pricec = mysql_result($result,0,2);
                    $prices = mysql_result($result,0,3);
                    $priced = mysql_result($result,0,4);
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
                    $coin = mysql_result($result,0,34);

                    if($soldout=="Y"){
                        $out111="Y";
                    }

                    $title = stripslashes($title);


                    $detail = stripslashes($detail);

                    ##############가격계산###################################3
/*
                    if($priced>0){
                        if($pro_sale=="") {     //정상가
                            $price_tmp = $priced;
                        }else if($pro_sale!=""){    //할인가
                            $price_tmp = $pricec;
                        }
                    }else{
                        $price_tmp = $pricec;
                    }
*/
  				        $price_tmp = $pricec;
						$sail_price= $priced;


                    #################################################

                    if($point_dis=='pe'){
                        $cpoint=number_format(floor($price_tmp*$point/100))."&nbsp;";
                        $cpoint1=floor($price_tmp*$point/100);
                    }else{
                        $cpoint=number_format($point)."&nbsp;";
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

					$coin_tatal = $coin *$arr[1];
					$coin_total_sett = number_format($coin_tatal)."&nbsp;GP";

					$sale_price_total = $sail_price   *$arr[1];
					$sale_price_total_stt = number_format($sale_price_total)."&nbsp;원";

                    $sum_price = ($price_tmp+$price1+$price2+$price3+$price4+$price5) * $arr[1];
                    $price =  number_format($price_tmp+$price1+$price2+$price3+$price4+$price5)."&nbsp;";

                    $total_price = $total_price + $sum_price;

                    $sum_price =  number_format($sum_price)."&nbsp;";

                    $total_point=$total_point+$point;
                    $point_tot=$point;
                    $point =  number_format($point);


                    ### 이미지 파일 저장 디렉토리 ###
                    $savedir = "../shop_img/";

                    $img_name = $savedir.$imgb1;

                    ?>


                    <tr>
                        <td><a href="../product/view.php?left_code=<?=$code?>"><?if($imgl) {?><img src="<?=$img_name?>" width="120" border="0" /><?}else{?><img src="<?=$savedir?><?=$imgb1?>" width="120"><?}?></a></td>
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
                        <td></td>
                    </tr>
                <?}?>
                <?
                if (50 > $total_price) $charge=3;
                else $charge=0;

                $total_settle = $total_price + $charge-$usepoint;
                $total_settle_num=$total_settle;
                $charge =  number_format($charge)."&nbsp;";
                $total_price =  number_format($total_price)."&nbsp;";
                $total_settle =  number_format($total_settle)."&nbsp;";
                ?>
            </table>

            <div class="cart_price">
                <div class="sp30"></div>
                <div class="cart_price_inner">
                    총결제금액[총금액(<?=$sale_price_total_stt?>) + <?=$coin_total_sett?> 배송비(<?=$charge?>) &nbsp;&nbsp;<span class="c_redb font_24"><?=$total_settle?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="sp15"></div>
                <div class="price_text">
                    제조사및 공급사에 따라 추가 배송비가 발생할 수 있습니다.&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                    도서산간지역은 추가요금(착불)이 발생할 수 있습니다.&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="sp30"></div>
            </div>


            <div class="sp30"></div>

            <div class="order_title">
                주문하신 상품
            </div>

            <div class="sp10"></div>

            <table class="order_table">
                <tr>
                    <th>주문자</th>
                    <td><?=$buyername?></td>
                </tr>
                <tr>
                    <th>주소</th>
                    <td>[<?=$post?>] <?=$addr1?></td>
                </tr>
                <tr>
                    <th>이메일</th>
                    <td><?=$email?></td>
                </tr>
                <tr>
                    <th>휴대폰</th>
                    <td><?=$htel?></td>
                </tr>
            </table>

            <div class="sp30"></div>

            <div class="order_title">
                상품 받으실 분
            </div>

            <div class="sp10"></div>

            <table class="order_table">
                <tr>
                    <th>받는 분</th>
                    <td><?=$recvname?></td>
                </tr>
                <tr>
                    <th>배송지 주소</th>
                    <td>[<?=$rpost?>] <?=$raddr1?></td>
                </tr>
                <tr>
                    <th>휴대폰</th>
                    <td><?=$rhtel?></td>
                </tr>

                <tr>
                    <th>배송시 요구사항</th>
                    <td><?=$rcontent?></td>
                </tr>
            </table>

            <div class="sp30"></div>

            <div class="order_title">
                결제수단
            </div>

            <div class="sp10"></div>

            <table class="order_table">
         
                <tr>
                    <th>무통장</th>
                    <td>  	농협 301-0260-3885-91 K.S.P</td>
                </tr>
              
            </table>

            <div class="sp20"></div>

            <!-- ############ 데이터베이스 입력 ######################################################## -->
            <?

			$tot=totCount();
				$total_price=0;


				for($i=0;$i<$tot;$i++) {
					$ii=$i; //gas_sel
					getCart($i,$arr);
					$query = "SELECT code,title,pricec,prices,priced,point,soldout,price_dis,imgl,opt_num,opt_num_str,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,point_dis FROM $shop_goods WHERE code='$arr[0]'";
					$result= mysql_query($query,$DBconn);

					
					if (!$result) {
						error("QUERY_ERROR");
						exit;
					}
					$code = mysql_result($result,0,0);
					if($code==""){
						continue;
					}
					$title = mysql_result($result,0,1);
					$pricec = mysql_result($result,0,2);

					$prices = mysql_result($result,0,3);
					$priced = mysql_result($result,0,4);
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


					if($soldout=="Y"){
						$out111="Y";
					}

					$title = stripslashes($title);


					$detail = stripslashes($detail);

					##############회&nbsp;원등급에 따른 가격계산###################################3
					if($cook_dis=="1" && $cook_dis1=="1"){
						$price_tmp = $priced;
					}else	if($cook_dis=="2" && $cook_dis1=="1"){
						$price_tmp = $pricec;
					}else if($cook_dis=="3" && $cook_dis1=="1"){
						$price_tmp = $prices;
					}else{
						if($priced>0){
							$price_tmp = $priced;
						}else{
							$price_tmp = $pricec;
						}
					}

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
						$my_point = ($point+$point1+$point2+$point3+$point4+$point5);

					}else{
						$my_point = ($point+$point1+$point2+$point3+$point4+$point5);
					}


					$price = ($price_tmp+$price1+$price2+$price3+$price4+$price5);

					$total_price = $total_price + $price ;

				
				}


			
			if($_SESSION['connect_check']!="ok"){
					
	
			
				// 새로운 주문번호를 생성한다
				$result = mysql_query("SELECT max(ordernum) FROM $shop_order",$DBconn);
				if (!$result) {
					error("QUERY_ERROR");
					exit;
				}
				$row = mysql_fetch_row($result);
				if($row[0]) {
					$new_num = $row[0] + 1;
				} else {
					$new_num = 10000001;
				}

				#####################################################################
				?>
				<?
				#####################################################################
				if($valid_user!="") {
					$cook_id = $valid_user;
				}
				else {
					$cook_id = "g".$new_num;
				}
				$state="주문접수";

				$new_num = $new_num;			//주문번호
				$cook_id = $cook_id;			//아이디
				$pay_name = $buyername;			//주문자 이름
				$pay_tel = $tel;				//주문자 연락처
				$pay_mobile = $htel;
				$post=split("-",$post);
				$pay_zip1 = $post[0];				//주문자 우편번호1
				$pay_zip2 = $post[1];				//주문자 우편번호2
				$pay_addr = $addr1;				//주문자 주소
				$pay_email = $email;			//주문자 이메일

				$receive_name = $recvname;		//수신자 이름
				$receive_tel = $rtel;			//수신자 연락처
				$receive_mobile = $rhtel;
				$rpost=split("-",$rpost);
				$receive_zip1 = $rpost[0];		//배송지 우편번호1
				$receive_zip2 = $rpost[1];		//배송지 우편번호2
				$receive_addr = $raddr1;		//배송지 주소
				$receive_email = $remail;		//수신자 이메일
				$receive_etc = addslashes($rcontent); //특이사항

				$paymentkind=2;
				$kind = $paymentkind;			//결재종류 무통장:2 , 신용카드:1

				$total_point = $total_point;	//총 적립되는 금액
				$usepoint = $total_price123;				//쓰이는 적립금 금액
				$usepoint=str_replace(",","",$usepoint);

				
				$charge=$charge_num;

				$passwd = $passwd;				//비밀번호
				$signdate = time();				//주문일자


				//주문 데이터베이스에 입력값을 삽입한다.

				$query1="INSERT INTO $shop_order";
				$query1=$query1."(";
				$query1=$query1." ordernum,id,pay_name,pay_tel,pay_mobile,pay_zip1,pay_zip2,pay_addr,pay_email,pay_etc";
				$query1=$query1.",receive_name,receive_tel,receive_mobile,receive_zip1,receive_zip2";
				$query1=$query1.",receive_addr,receive_email,receive_etc,kind,bank,pointin,pointout,in_name,in_year,in_month,in_day,charge,char_year,char_month,char_day,char_num,status,passwd,signdate,tid";
				$query1=$query1.") ";
				$query1=$query1."VALUES";
				$query1=$query1." (";
				$query1=$query1." '$new_num','$cook_id','$pay_name','$pay_tel','$pay_mobile','$pay_zip1','$pay_zip2'";
				$query1=$query1.",'$pay_addr','$pay_email','pay_etc','$receive_name','$receive_tel','$receive_mobile'";
				$query1=$query1.",'$receive_zip1','$receive_zip2','$receive_addr','$receive_email','$receive_etc'";
				$query1=$query1.",'$kind','$bank','$total_point','$usepoint','$in_name','$in_year','$in_month','$in_day','$charge','$char_year','$char_month','$char_day','','$state','$passwd',$signdate,'$tid'";
				$query1=$query1.")";

				$result1 = mysql_query($query1,$DBconn);

				

				if(!$result1) {
					error("QUERY_ERROR");
					exit;
				}


	

				$tot=totCount();
				$total_price=0;
				for($i=0;$i<$tot;$i++) {
					$ii=$i; //gas_sel
					getCart($i,$arr);
					$query = "SELECT code,title,pricec,prices,priced,point,soldout,price_dis,imgl,opt_num,opt_num_str,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,point_dis FROM $shop_goods WHERE code='$arr[0]'";
					$result= mysql_query($query,$DBconn);
					if (!$result) {
						error("QUERY_ERROR");
						exit;
					}
					$code = mysql_result($result,0,0);
					if($code==""){
						continue;
					}
					$title = mysql_result($result,0,1);
					$pricec = mysql_result($result,0,2);
					$prices = mysql_result($result,0,3);
					$priced = mysql_result($result,0,4);
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


					if($soldout=="Y"){
						$out111="Y";
					}

					$title = stripslashes($title);


					$detail = stripslashes($detail);

					##############회&nbsp;원등급에 따른 가격계산###################################3
/*					if($cook_dis=="1" && $cook_dis1=="1"){
						$price_tmp = $priced;
					}else	if($cook_dis=="2" && $cook_dis1=="1"){
						$price_tmp = $pricec;
					}else if($cook_dis=="3" && $cook_dis1=="1"){
						$price_tmp = $prices;
					}else{
						if($priced>0){
							$price_tmp = $priced;
						}else{
							$price_tmp = $pricec;
						}
					}*/
							$price_tmp = $pricec;
							$sell_price = $priced; 		

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
						$my_point = ($point+$point1+$point2+$point3+$point4+$point5);

					}else{
						$my_point = ($point+$point1+$point2+$point3+$point4+$point5);
					}

					$price = ($price_tmp+$price1+$price2+$price3+$price4+$price5);

					$total_price = $total_price + $sum_price;

					$total_point=$total_point+$point;
					$point_tot=$point;


					//데이터베이스에 입력값을 삽입한다.
					$query="INSERT INTO $shop_sell ";
					$query=$query."(";
					$query=$query."ordernum,code,title,money,point,count,code1,code2,code3,signdate,opt1,opt2,new_opt1,new_opt2,new_opt3,new_opt4,new_opt5,code4,prices,coin";
					$query=$query.")";
					$query=$query."VALUES";
					$query=$query."(";
					$query=$query."'$new_num','$arr[0]','$title','$price','$my_point','$arr[1]','$code1'";
					$query=$query.",'$code2','$code3',$signdate,'$arr[2]','$arr[3]','$arr[5]','$arr[6]','$arr[7]','$arr[8]','$arr[9]','$code4','$priced','$coin'";
					$query=$query.")";


					$result = mysql_query($query,$DBconn);
					$title_11111=$title_11111.$title;
					if (!$result) {
						error("QUERY_ERROR");
						exit;
					}
			
			$query = "SELECT coin FROM $shop_goods WHERE code='$arr[0]'";
			$result= mysql_query($query,$DBconn);
			$coin = mysql_result($result,0,0);



			$used_coin = $coin * $arr[1];

			$data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&user_id=".$cook_id."&qty=".$used_coin;


			$api_balance = "https://work.GP.app/shop_api/api_shop_used.php";
			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, $api_balance);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec ($ch);
			curl_close ($ch);

				}

				

				//데이터베이스에 적립금 변경한다.
				mysql_close($DBconn);

			   
				//중복 실행 방지
				$connect_check="ok";
				//session_register("connect_check");
				$_SESSION['connect_check'] = $connect_check;
			
				$_SESSION['connect_check'] = $connect_check;

				$_SESSION[session_cart] = "";
		}

			


            ?>

            

            <SCRIPT LANGUAGE="JavaScript">
                //<!--
                function bank_link(){
                    location="finish.php?ordernum=<?=$new_num?>&kind=2&total_point=<?=$total_point?>&usepoint=<?=$usepoint?>";
                }
                //-->
            </SCRIPT>

            
                <form name="frmTofinish" method="post" action="finish.php">
                    <div class="order_btn">
                        <input type="button" value="주문이 완료되었습니다." style="    border: 0px;
    width: 105px;
    height: 40px;
    color: #fff;
    cursor: pointer;
    background-color: #ffb911;
    font-weight: bold;" class="cart_btn_order" onclick="bank_link();">
                    </div>
                </form>
           
        </div>
    </div>
    <!-- 컨텐츠 종료 -->
    <!-- 하단(Copy) -->
    <div class="sp50"></div>
    <? include "../include/bottom.html"; ?>
    <!-- 하단(Copy) -->

</div>
</body>
</html>
