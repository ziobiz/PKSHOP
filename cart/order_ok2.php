<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

if (!ob_get_level()) {
	ob_start();
}

include "../include/get_balance.php";

include "../include/login_check.php";
include "../cart/cartfunc.php";
include_once dirname(__FILE__) . '/../lib/icopay_pg_config.php';

$session_cart = $_SESSION['session_cart'];

$buyselected=='Y'? $session_cart=$session_cart_selected:$session_cart=$session_cart;

if ($session_cart=="") {
    // popup_msg("장바구니에 선택하신 상품이 없습니다.");
    // exit;
}

$total_price123=str_replace(",","",$total_price123);
$usepoint = $_POST["usepoint"];
$ordNo = $_POST["ordNo"];
$ediDate = $_POST["ediDate"];
$bank = $_POST["bank"];
$in_name = $_POST["in_name"];
$totalPrice = $_POST["total_settle"];

$tot=totCount();
$total_price=0;
$total_coin=0;
$title_11111 = '';

// echo $tot;exit;
for($i=0;$i<$tot;$i++) {
    $ii=$i; //gas_sel
    getCart($i,$arr);

    $gods = json_decode(curl_d($api_category,"&Type=proView&code=$arr[0]"),true);

                    $code		= $gods[0]['code'];
                    if($code==""){
                        continue;
                    }
                    $title		= $gods[0]['title'];
                    $pricec		= $gods[0]['pricec'];
                    $prices		= $gods[0]['prices'];
                    $priced		= $gods[0]['priced'];
                    $point		= $gods[0]['point'];
                    $soldout	= $gods[0]['soldout'];
                    $price_dis  = $gods[0]['price_dis'];
                    $imgl		= $gods[0]['imgl'];
                    $opt_num	= $gods[0]['opt_num'];
                    $opt_num_str= $gods[0]['opt_num_str'];

                    $option_t1	= $gods[0]['option_t1'];
                    $option_n1  = $gods[0]['option_n1'];
                    $option_p1	= $gods[0]['option_p1'];
                    $option_k1	= $gods[0]['option_k1'];

                    $option_t2	= $gods[0]['option_t2'];
                    $option_n2	= $gods[0]['option_n2'];
                    $option_p2	= $gods[0]['option_p2'];
                    $option_k2	= $gods[0]['option_k2'];

                    $option_t3	= $gods[0]['option_t3'];
                    $option_n3	= $gods[0]['option_n3'];
                    $option_p3	= $gods[0]['option_p3'];
                    $option_k3	= $gods[0]['option_k3'];

                    $option_t4	= $gods[0]['option_t4'];
                    $option_n4	= $gods[0]['option_n4'];
                    $option_p4	= $gods[0]['option_p4'];
                    $option_k4	= $gods[0]['option_k4'];

                    $option_t5	= $gods[0]['option_t5'];
                    $option_n5	= $gods[0]['option_n5'];
                    $option_p5	= $gods[0]['option_p5'];
                    $option_k5	= $gods[0]['option_k5'];

                    $point_dis	= $gods[0]['point_dis'];
                    $imgb1		= $gods[0]['imgb1'];
                    $imgb2		= $gods[0]['imgb2'];
                    $coin		= $gods[0]['coin'];
                    $c_pv		= $gods[0]['coin'];

                    if($soldout=="Y"){
                        $out111="Y";
                    }

                    $title = stripslashes($title);


                    $detail = stripslashes($detail);

                    ##############가격계산###################################3

                    if($priced>0){
                        if($pro_sale=="") {     //정상가
                            $price_tmp = $priced;
                        }else if($pro_sale!=""){    //할인가
                            $price_tmp = $pricec;
                        }
                    }else{
                        $price_tmp = $pricec;
                    }

  				        // $price_tmp = $pricec;
						$sail_price= $priced;


                    #################################################

                    if($point_dis=='pe'){
                        $cpoint=number_format(floor($price_tmp*$point/100))."&nbsp;";
                        $cpoint1=floor($price_tmp*$point/100);
                    }else{
                        $cpoint=number_format($point)."&nbsp;";
                        $cpoint1=$point;
                    }

                    $asize = explode(",",$size);				/*사이즈 분리*/			 
					$acolor = explode(",",$color);					/*색상 분리*/
                    $aopt_num = explode(",",$opt_num);
                    $aoption_n1=explode("\r\n",$option_n1);		$aoption_p1=explode("\r\n",$option_p1);		$aoption_k1=explode("\r\n",$option_k1);
                    $aoption_n2=explode("\r\n",$option_n2);	 	$aoption_p2=explode("\r\n",$option_p2);		$aoption_k2=explode("\r\n",$option_k2);
                    $aoption_n3=explode("\r\n",$option_n3);		$aoption_p3=explode("\r\n",$option_p3);		$aoption_k3=explode("\r\n",$option_k3);
                    $aoption_n4=explode("\r\n",$option_n4);		$aoption_p4=explode("\r\n",$option_p4);	 	$aoption_k4=explode("\r\n",$option_k4);
                    $aoption_n5=explode("\r\n",$option_n5);		$aoption_p5=explode("\r\n",$option_p5);		$aoption_k5=explode("\r\n",$option_k5);

                    $aaoption_n1=explode("\r\n",$option_n1);		$aaoption_p1=explode("\r\n",$option_p1);		$aaoption_k1=explode("\r\n",$option_k1);
                    $aaoption_n2=explode("\r\n",$option_n2);	 	$aaoption_p2=explode("\r\n",$option_p2);		$aaoption_k2=explode("\r\n",$option_k2);
                    $aaoption_n3=explode("\r\n",$option_n3);		$aaoption_p3=explode("\r\n",$option_p3);		$aaoption_k3=explode("\r\n",$option_k3);
                    $aaoption_n4=explode("\r\n",$option_n4);		$aaoption_p4=explode("\r\n",$option_p4);	 	$aaoption_k4=explode("\r\n",$option_k4);
                    $aaoption_n5=explode("\r\n",$option_n5);		$aaoption_p5=explode("\r\n",$option_p5);		$aaoption_k5=explode("\r\n",$option_k5);

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
                    $savedir = "//pentakleva.shop/upload/";

                    $img_name = $savedir.$imgl;

                }
                if (50 <= $total_price || $code ="09000000039") $charge=0;
                else $charge=3;
                $total_settle = $total_price + $charge-$usepoint;
                $total_settle_num=$total_settle;
                $total_pv = $total_pv +floor($total_price*($c_pv/100));
				$charge_num = $charge;
                $chargeT =  number_format($charge)."&nbsp;";
                $total_price =  number_format($total_price)."&nbsp;";
                $total_settle =  number_format($total_settle)."&nbsp;";

                // if($_SESSION['connect_check']!="ok"){
					
                    
                    
                    // 새로운 주문번호를 생성한다
                    $ords = json_decode(curl_d($api_category,"&Type=orderMax&code=$arr[0]"),true);
                    
                    //echo $ords[0]['max(ordernum)'];
                    if($ords[0]['max(ordernum)']) {
                        $new_num = $ords[0]['max(ordernum)'] + 1;
                    } else {
                        $new_num = 10000001;
                    }
                    $new_num=date("mdHis").rand(00000,99999);
                    
                    // $new_num=$new_num.rand(0,1000);
                    // echo $new_num;exit;
    
                    if($valid_user!="") {
                        $cook_id = $valid_user;
                    }
                    else {
                        $cook_id = "g".$new_num;
                    }
    
                    if($usepoint == $totalPrice && $usepoint >0){
                        $state="결제완료";
                    }else{
                        $state="주문접수";
                    }
                    // $state="결제완료";
                    // echo $buyername;
    
                    
                    $new_num = $new_num;			//주문번호
                    $cook_id = $cook_id;			//아이디
                    $pay_name = $_POST['buyername'];			//주문자 이름
                    $pay_tel = $_POST['htel'];				//주문자 연락처
                    $pay_mobile = $htel;
                    $post=explode("-",$_POST['post']);
                    $pay_zip1 = $post[0];				//주문자 우편번호1
                    $pay_zip2 = $post[1];				//주문자 우편번호2
                    $pay_addr = $_POST['addr1'];				//주문자 주소
              
                    $pay_email = $_POST['email'];			//주문자 이메일
                    $buyername_l = $_POST['buyername_l'];			//주문자 이메일
                    $city = $_POST['city'];			//주문자 이메일
                    $c_state = $_POST['state'];			//주문자 이메일
                    $pay_name2=$buyername_l." ".$pay_name;
                    $pay_addr2=$pay_addr."(".$city."/".$c_state.")";
    
                    $receive_name = $_POST['recvname'];		//수신자 이름
                    $receive_tel = $_POST['rhtel'];			//수신자 연락처
                    $receive_mobile = $rhtel;
                    $rpost=explode("-",$_POST['rpost']);
                    $receive_zip1 = $rpost[0];		//배송지 우편번호1
                    $receive_zip2 = $rpost[1];		//배송지 우편번호2
                    $receive_addr = $_POST['raddr1'];		//배송지 주소
                    $receive_email = $_POST['email'];		//수신자 이메일
                    $receive_etc = addslashes($_POST["rcontent"]); //특이사항
    
                    $paymentkind=$_POST['paymentkind'];
                    $kind = $paymentkind;			//결재종류 무통장:2 , 신용카드:1
    
                    $total_point = $total_point;	//총 적립되는 금액
                    
    
                    
                    $charge=$charge_num;
    
                    $passwd = $passwd;				//비밀번호
                    $signdate = time();				//주문일자
    
    
                    //주문 데이터베이스에 입력값을 삽입한다.
                
                    curl_d($api_category,"&Type=orderSave&new_num=$new_num&cook_id=$cook_id&pay_name=$pay_name2&pay_tel=$pay_tel&pay_mobile=$pay_mobile&pay_zip1=$pay_zip1&pay_zip2=$pay_zip2&pay_addr=$pay_addr2&pay_email=$pay_email&pay_etc=$receive_etc&receive_name=$receive_name&receive_tel=$receive_tel&receive_mobile=$receive_mobile&receive_zip1=$receive_zip1&receive_zip2=$receive_zip2&receive_addr=$receive_addr&receive_email=$receive_email&receive_etc=$receive_etc&kind=$kind&bank=$bank&pointin=$pointin&pointout=$pointout&in_name=$in_name&in_year=$in_year&in_month=$in_month&in_day=$in_day&charge=$charge&char_year=$char_year&char_month=$char_month&char_day=$char_day&state=$state&passwd=$passwd&signdate=$signdate&total_settle_num=$total_settle_num&tid=$tid&usepoint=$usepoint&bank=$bank&in_name=$in_name&total_pv=$total_pv&ordNo=$ordNo&ediDate=$ediDate");
                    
                    
    
    
        
    
                    $tot=totCount();
                    $total_price=0;
                    // echo $tot;exit;
                    for($i=0;$i<$tot;$i++) {
                        $ii=$i; //gas_sel
                        getCart($i,$arr);
                
                        
                        
                        $goods = json_decode(curl_d($api_category,"&Type=proView&code=$arr[0]"),true);
                        $code		= $goods[0]['code'];
    
                        if($code==""){
                            continue;
                        }
    
                        $title		= $goods[0]['title'];
                        $pricec		= $goods[0]['pricec'];
                        $prices		= $goods[0]['prices'];
                        $priced		= $goods[0]['priced'];
                        //	$priced_diot = mysql_result($result1,0,0);
                        $point		= $goods[0]['point'];
                        $soldout	= $goods[0]['soldout'];
                        $price_dis  = $goods[0]['price_dis'];
                        $imgl		= $goods[0]['imgl'];
                        $opt_num	= $goods[0]['opt_num'];
                        $opt_num_str = $goods[0]['opt_num_str'];
    
                        $option_t1	= $goods[0]['option_t1'];
                        $option_n1	= $goods[0]['option_n1'];
                        $option_p1	= $goods[0]['option_p1'];
                        $option_k1	= $goods[0]['option_k1'];
    
                        $option_t2	= $goods[0]['option_t2'];
                        $option_n2	= $goods[0]['option_n2'];
                        $option_p2	= $goods[0]['option_p2'];
                        $option_k2	= $goods[0]['option_k2'];
    
                        $option_t3	= $goods[0]['option_t3'];
                        $option_n3	= $goods[0]['option_n3'];
                        $option_p3	= $goods[0]['option_p3'];
                        $option_k3	= $goods[0]['option_k3'];
    
                        $option_t4	= $goods[0]['option_t4'];
                        $option_n4	= $goods[0]['option_n4'];
                        $option_p4	= $goods[0]['option_p4'];
                        $option_k4	= $goods[0]['option_k4'];
    
                        $option_t5	= $goods[0]['option_t5'];
                        $option_n5	= $goods[0]['option_n5'];
                        $option_p5	= $goods[0]['option_p5'];
                        $option_k5	= $goods[0]['option_k5'];
    
                        $point_dis	= $goods[0]['point_dis'];
						$c_dis	= $goods[0]['c_dis'];
                        $c_pv	= $goods[0]['c_pv'];
                        if($soldout=="Y"){
                            $out111="Y";
                        }
    
                        $title = stripslashes($title);
                        
    
                        $detail = stripslashes($detail);
                        $title_arr=$title.",";
                        $detail_arr=$title.",";
                        $code_arr=$code.",";
                 
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
                                // $price_tmp = $pricec;
                                $sell_price = $priced; 		
                               
                        #################################################
    
                        if($point_dis=='pe'){
                            $cpoint=number_format(floor($price_tmp*$point/100))."&nbsp;원";
                            $cpoint1=floor($price_tmp*$point/100);
                        }else{
                            $cpoint=number_format($point)."&nbsp;원";
                            $cpoint1=$point;
                        }
    
                        $asize = explode(",",$size);				/*사이즈 분리*/			 $acolor = explode(",",$color);					/*색상 분리*/
    
    
                        $aopt_num = explode(",",$opt_num);
    
    
                        $aoption_n1=explode("\r\n",$option_n1);		$aoption_p1=explode("\r\n",$option_p1);		$aoption_k1=explode("\r\n",$option_k1);
                        $aoption_n2=explode("\r\n",$option_n2);	 	$aoption_p2=explode("\r\n",$option_p2);		$aoption_k2=explode("\r\n",$option_k2);
                        $aoption_n3=explode("\r\n",$option_n3);		$aoption_p3=explode("\r\n",$option_p3);		$aoption_k3=explode("\r\n",$option_k3);
                        $aoption_n4=explode("\r\n",$option_n4);		$aoption_p4=explode("\r\n",$option_p4);	 	$aoption_k4=explode("\r\n",$option_k4);
                        $aoption_n5=explode("\r\n",$option_n5);		$aoption_p5=explode("\r\n",$option_p5);		$aoption_k5=explode("\r\n",$option_k5);
    
                        $aaoption_n1=explode("\r\n",$option_n1);		$aaoption_p1=explode("\r\n",$option_p1);		$aaoption_k1=explode("\r\n",$option_k1);
                        $aaoption_n2=explode("\r\n",$option_n2);	 	$aaoption_p2=explode("\r\n",$option_p2);		$aaoption_k2=explode("\r\n",$option_k2);
                        $aaoption_n3=explode("\r\n",$option_n3);		$aaoption_p3=explode("\r\n",$option_p3);		$aaoption_k3=explode("\r\n",$option_k3);
                        $aaoption_n4=explode("\r\n",$option_n4);		$aaoption_p4=explode("\r\n",$option_p4);	 	$aaoption_k4=explode("\r\n",$option_k4);
                        $aaoption_n5=explode("\r\n",$option_n5);		$aaoption_p5=explode("\r\n",$option_p5);		$aaoption_k5=explode("\r\n",$option_k5);
    
    
    
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
                        $total_price=0;
                        $total_pv=0;
                        $total_price = $total_price + $sum_price;
                        $total_pv = $total_pv +floor($price*($c_pv/100));
                        $total_point=$total_point+$point;
                        $point_tot=$point;
                        
                        
                        //데이터베이스에 입력값을 삽입한다.
                        
                        
                         curl_d($api_category,"&Type=sellSave&&new_num=$new_num&code=$arr[0]&title=$title&price=$price&my_point=$my_point&count=$arr[1]&code1=$code1&code2=$code2&code3=$code3&signdate=$signdate&opt1=$arr[2]&opt2=$arr[3]&new_opt1=$arr[5]&new_opt2=$arr[6]&new_opt3=$arr[7]&new_opt4=$arr[8]&new_opt5=$arr[9]&code4=$code4&prices=$prices&coin=$coin&state=$state&cook_id=$cook_id&total_pv=$total_pv&ordNo=$ordNo&ediDate=$ediDate&c_dis=$c_dis");
                         
                        $title_11111=$title_11111.$title;
                        $goods_array[] = array(
                            "name"=>$title,
                            "description"=>$detail_arr,
                            "sku"=>$code,
                            "imgUrl"=>"pentakleva.shop/upload/".$imgl,
                            "virtualProduct"=>"N",
                            "orgPrice"=>$price                            
                        );
                        
                    }
                    
                    
                   
                    //중복 실행 방지
                    $connect_check="ok";
                    //session_register("connect_check");
                    $_SESSION['connect_check'] = $connect_check;
                    if (defined('ICOPAY_CHILLPAY_ENABLED') && ICOPAY_CHILLPAY_ENABLED
                        && isset($_POST['paymentkind']) && (string)$_POST['paymentkind'] === '1'
                        && isset($state) && $state !== "결제완료") {
                        $_SESSION['icopay_pending_checkout'] = array(
                            'ediDate' => $ediDate,
                            'amount' => (string)$total_settle_num,
                            'ordNo' => $ordNo,
                            'new_num' => $new_num,
                            'description' => isset($title_11111) ? $title_11111 : '',
                            'ts' => time(),
                        );
                        while (ob_get_level() > 0) {
                            ob_end_clean();
                        }
                        header('Content-Type: application/json; charset=utf-8');
                        echo json_encode(array(
                            'result' => '1',
                            'icopayChillpay' => true,
                            'ediDate' => $ediDate,
                            'ordNo' => $ordNo,
                            'new_num' => $new_num,
                            'amount' => $total_settle_num,
                            'description' => isset($title_11111) ? $title_11111 : '',
                        ));
                        exit;
                    }

                    // 체크
                    // $_SESSION["session_cart"] = "";
            // }
                
                // 주문


                // 카드

// $merchantTransactionId=rand(100000000,999999999);

// echo "!";
//         exit;
if($state != "결제완료"){
    
$md5 = md5("5933757143C1DA395C1AECD1accId=2021121005433420956302&amount=$total_settle_num&currency=USD&merchantTransactionId=$new_num&notificationUrl=https://pentakleva.shop/cart/card_finish.php&shopperResultUrl=https://pentakleva.shop/cart/finish.php&signType=MD5");
    

$a=array(
    "accId"=> "2021121005433420956302",
    "amount"=> $total_settle_num,
    "currency"=> "USD",
    "merchantTransactionId"=> $new_num,
    "notificationUrl"=> "https://pentakleva.shop/cart/card_finish.php",
    "shopperResultUrl"=> "https://pentakleva.shop/cart/finish.php",
    "signType"=> "MD5",
    "sign"=> $md5,
    "riskInfo"=> array(
        "billing"=>array(
            "city"=>$city,
            "country"=>"US",
            "email"=>$pay_email,
            "firstName"=>$pay_name,
            "lastName"=>$buyername_l,
            "phone"=>str_replace("-","",$pay_tel),
            "postcode"=>$pay_zip1.$pay_zip2,
            "state"=>$c_state,
            "street"=>$pay_addr
        ),
        "customer"=>array(
            "customerId"=>$_SESSION['member_id'],
            "phone"=>$pay_tel,
            "firstName"=>$pay_name,
            "lastName"=>$buyername_l,
            "email"=>$pay_email,
            
        ),
        "device"=>array(
            "orderTerminal"=>"01"
            
            
        ),
        "eCommerce"=>array(
            "freeShipping"=>"Y",
            "shippingMethod"=>"sea",

        ),
        "shipping"=> array(
            "firstName"=> $pay_name,
            "lastName"=> $buyername_l,
            "phone"=> str_replace("-","",$pay_tel),
            "email"=> $pay_email,
            "street"=> $pay_addr,
            "postcode"=> $pay_zip1.$pay_zip2,
            "city"=> $city,
            "state"=> $c_state,
            "country"=> "US",
            "lastModifierStreetTime"=> date("YmdHis",strtotime($json_balance["regDate"])),
            "lastModifierPhoneTime"=> date("YmdHis",strtotime($json_balance["regDate"]))
    ),
        "goods"=>
            $goods_array
            
         
        )
    );    
	$log=json_encode($a);
	
	function fn_logSave($log){ //로그내용 인자
        $logPathDir = "/var/www/_log";  //로그위치 지정
 
        $filePath = $logPathDir."/".date("Y")."/".date("n");
        $folderName1 = date("Y"); //폴더 1 년도 생성
        $folderName2 = date("n"); //폴더 2 월 생성
 
        if(!is_dir($logPathDir."/".$folderName1)){
            mkdir($logPathDir."/".$folderName1, 0777);
        }
         
        if(!is_dir($logPathDir."/".$folderName1."/".$folderName2)){
            mkdir(($logPathDir."/".$folderName1."/".$folderName2), 0777);
        }
             
            $log_file = fopen($logPathDir."/".$folderName1."/".$folderName2."/".date("Ymd").".txt", "a");
            fwrite($log_file, $log."\r\n");
            fclose($log_file);
    }
	fn_logSave($log);

    $body=json_encode($a);
    
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, "https://acquirer-payment.pingpongx.com/v2/checkout");
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec ($ch);
    curl_close ($ch);
    // print_r($a);
    // echo "<br>";
    // echo $result;echo "AsD";exit;
    $res = json_decode($result,true);
    $paymentUrl=$res["paymentUrl"];
    if($paymentUrl == ""){
        $result = array("result"=>"0","msg"=>"Payment window call failed. Please check the card information address information and try again.");
        echo json_encode($result);
        exit;
    }else{
        $result = array("result"=>"1","msg"=>"I'll call the payment window. Please do not exit the page until you finish making the payment.","paymentUrl"=>$paymentUrl);
        echo json_encode($result);
        exit;
    }
    // echo $result;    
    // exit;
}else{
    $result = array("result"=>"1","msg"=>"The full payment was completed using points.");
    echo json_encode($result);
    exit;
}
?>