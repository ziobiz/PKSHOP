<?
@session_start();


include_once( $_SERVER["DOCUMENT_ROOT"]."/Adm/lib/config.php"); 
include_once( $_SERVER["DOCUMENT_ROOT"]."/Adm/lib/basic_class.php");
include_once( $_SERVER["DOCUMENT_ROOT"]."/Adm/lib/common_db.php");
include_once( $_SERVER["DOCUMENT_ROOT"]."/Adm/lib/api_list.php"); 
include_once( $_SERVER["DOCUMENT_ROOT"]."/Adm/lib/common.php");


$amount_array = array("0","50","150","300","600","1200","2400","3600","5000","10000");
$amount_array2 = array("0","25","30","45","50","100","500");
$pv_array = array("0","50","150","300","600","1200","2400","3600","5000","10000");
$jik_array = array("0","M","1★","2★","3★","4★","5★","6★","Full","All");
$jik_color =array("#fd34b5","#ffd017","#009900","#0066FF","#9933CC","#ff3333","#00ec2f","#ec9000","#000","#009688");


$member_table="cust_member";		//회원테이블2
$sell_table 			= "money_upgrade";
$shop_cate="shop_cate";		//상품분류테이블 
$shop_goods="shop_goods";		//상품정보테이블
$shop_order="shop_order";		//주문정보
$shop_sell="shop_sell";		//매출정보테이블
$member="member";				//회원테이블
$member_log="member_log";				//접속
$state="state";				//접속통계테이블
$admin_member="admin";		//관리자테이블
$shop_point="point";		//관리자테이블
$shop_cart="cart";		//장바구니 저장공간
$shop_save="save";		//찜하기
$attendance="attendance";
$member_p="member_p";				//이벤트데이타
$coin_goods="coin_goods";

$shop_key		= "459sdfwodlfjsx342255";

$globaltop_id = $_REQUEST['globaltop_id'];
$sel_cate = $_REQUEST['sel_cate'];

$sel_code1 = $_REQUEST['sel_code1'];
$sel_code2 = $_REQUEST['sel_code2'];
$sel_code3 = $_REQUEST['sel_code3'];
$sel_code4 = $_REQUEST['sel_code4'];

$sel_code1 = $_REQUEST['sel_code1'];
$sel_code2 = $_REQUEST['sel_code2'];
$sel_code3 = $_REQUEST['sel_code3'];
$sel_code4 = $_REQUEST['sel_code4'];

$chk_order = $_REQUEST['chk_order'];
$soldout = $_REQUEST['soldout'];
$mode = $_REQUEST['mode'];

$keyfield = $_REQUEST['keyfield'];
$key = $_REQUEST['key'];
$page_num =$_REQUEST['page'];

$theme = $_REQUEST['theme'];
$sel_goods = $_REQUEST['sel_goods'];
$File_name = $_FILES['File']['name'];

$File_size = $_FILES['File']['size'];
$File_name1 = $_FILES['File1']['name'];
$File_size1 = $_FILES['File1']['size'];
$File = $_FILES['File']['tmp_name'];
$File1 = $_FILES['File1']['tmp_name'];

$imgb1_name = $_FILES['imgb1']['name'];
$imgb1_size = $_FILES['imgb1']['size'];
$imgb2_name = $_FILES['imgb2']['name'];
$imgb2_size = $_FILES['imgb2']['size'];
$imgb1 = $_FILES['imgb1']['tmp_name'];
$imgb2 = $_FILES['imgb2']['tmp_name'];

$imgb3_name = $_FILES['imgb3']['name'];
$imgb3_size = $_FILES['imgb3']['size'];
$imgb4_name = $_FILES['imgb4']['name'];
$imgb4_size = $_FILES['imgb4']['size'];
$imgb3 = $_FILES['imgb3']['tmp_name'];
$imgb4 = $_FILES['imgb4']['tmp_name'];

$imgb5_name = $_FILES['imgb6']['name'];
$imgb5_size = $_FILES['imgb6']['size'];
$imgb6_name = $_FILES['imgb6']['name'];
$imgb6_size = $_FILES['imgb6']['size'];
$imgb5 = $_FILES['imgb5']['tmp_name'];
$imgb6 = $_FILES['imgb6']['tmp_name'];



$Sub_No = $_REQUEST['Sub_No'];
$Name = $_REQUEST['Name'];
$P_Up = $_REQUEST['P_Up'];
$P_Name = $_REQUEST['P_Name'];
$P_Location = $_REQUEST['P_Location'];
$P_Size = $_REQUEST['P_Size'];
$P_Link = $_REQUEST['P_Link'];
$P_Target = $_REQUEST['P_Target'];
$Cont = $_REQUEST['Cont'];
$P_Fname = $_REQUEST['P_Fname'];
$P_Fsize = $_REQUEST['P_Fsize'];
$Cnt = $_REQUEST['Cnt'];
$Wdate = $_REQUEST['Wdate'];
$Ip = $_REQUEST['Ip'];
$Pass = $_REQUEST['Pass'];
$Cont_type = $_REQUEST['Cont_type'];

$title = $_REQUEST['title'];
$info = $_REQUEST['info'];
$detail = $_REQUEST['detail'];
$company = $_REQUEST['company'];
$home = $_REQUEST['home'];
$shelf = $_REQUEST['shelf'];
$feature = $_REQUEST['feature'];
$code1=$_REQUEST['code1'];
$code2=$_REQUEST['code2'];
$code3=$_REQUEST['code3'];

$code=$_REQUEST['code'];

$color=$_REQUEST['color'];
$size=$_REQUEST['size'];
$theme=$_REQUEST['theme'];
$event=$_REQUEST['event'];
$event_str=$_REQUEST['event_str'];
$new=$_REQUEST['new'];
$pricec=$_REQUEST['pricec'];
$prices=$_REQUEST['prices'];
$priced=$_REQUEST['priced'];
$coin=$_REQUEST['coin'];
$pr_kind=$_REQUEST['pr_kind'];
$point=$_REQUEST['point'];
$point_dis=$_REQUEST['point_dis'];
$currnum=$_REQUEST['currnum'];
$warnnum=$_REQUEST['warnnum'];
$imgl=$_REQUEST['imgl'];
$imgm=$_REQUEST['imgm']; $soldout=$_REQUEST['soldout']; $rank=$_REQUEST['rank']; $option_t1=$_REQUEST['option_t1']; $option_n1=$_REQUEST['option_n1']; $option_p1=$_REQUEST['option_p1']; $option_k1=$_REQUEST['option_k1']; $option_t2=$_REQUEST['option_t2']; $option_n2=$_REQUEST['option_n2']; $option_p2=$_REQUEST['option_p2']; $option_k2=$_REQUEST['option_k2']; 
$option_t3=$_REQUEST['option_t3']; $option_n3=$_REQUEST['option_n3']; $option_p3=$_REQUEST['option_p3']; $option_k3=$_REQUEST['option_k3']; 
$option_t4=$_REQUEST['option_t4']; $option_n4=$_REQUEST['option_n4']; $option_p4=$_REQUEST['option_p4']; $option_k4=$_REQUEST['option_k4']; 
$option_t5=$_REQUEST['option_t5']; $option_n5=$_REQUEST['option_n5']; $option_p5=$_REQUEST['option_p5']; $option_k5=$_REQUEST['option_k5']; 
$order1=$_REQUEST['order1']; $order2=$_REQUEST['order2']; $order3=$_REQUEST['order3']; $color_opt=$_REQUEST['color_opt']; 
$size_opt=$_REQUEST['size_opt']; $add_opt1=$_REQUEST['add_opt1']; $add_opt2=$_REQUEST['add_opt2']; $add_opt3=$_REQUEST['add_opt3']; 
$add_opt4=$_REQUEST['add_opt4']; $add_opt5=$_REQUEST['add_opt5']; $relation=$_REQUEST['relation']; $price_dis=$_REQUEST['price_dis']; 
$best=$_REQUEST['best']; $cut=$_REQUEST['cut']; $recommend=$_REQUEST['recommend']; $theme_g=$_REQUEST['theme_g']; $theme_n=$_REQUEST['theme_n']; 
$theme_r=$_REQUEST['theme_r']; $theme_f=$_REQUEST['theme_f']; $theme_x=$_REQUEST['theme_x']; $theme_y=$_REQUEST['theme_y']; $theme_z=$_REQUEST['theme_z']; $rank_g=$_REQUEST['rank_g']; $rank_n=$_REQUEST['rank_n']; $rank_r=$_REQUEST['rank_r']; $rank_f=$_REQUEST['rank_f']; $rank_x=$_REQUEST['rank_x']; $rank_y=$_REQUEST['rank_y']; $rank_z=$_REQUEST['rank_z']; $opt_num=$_REQUEST['opt_num']; $opt_num_str=$_REQUEST['opt_num_str']; $theme_s=$_REQUEST['theme_s']; $rank_s=$_REQUEST['rank_s']; $code4=$_REQUEST['code4'];$order4=$_REQUEST['order4']; $p_id=$_REQUEST['p_id'];

$cate = $_REQUEST['cate'];
$cate1 = $_REQUEST['cate1'];
$cate2 = $_REQUEST['cate2'];
$cate3 = $_REQUEST['cate3'];
$cate4 = $_REQUEST['cate4'];

$catenum1 = $_REQUEST['catenum1'];
$catenum2 = $_REQUEST['catenum2'];
$catenum3 = $_REQUEST['catenum3'];
$catenum4 = $_REQUEST['catenum4'];

$code1 = $_REQUEST['code1'];
$code2 = $_REQUEST['code2'];
$code3 = $_REQUEST['code3'];
$code4 = $_REQUEST['code4'];
$cateuid1 = $_REQUEST['cateuid1'];
$cateuid2 = $_REQUEST['cateuid2'];
$cateuid3 = $_REQUEST['cateuid3'];
$cateuid4 = $_REQUEST['cateuid4'];


  ##########어드민 팝업##########
	$board_cook = $_COOKIE['board_cook'];
	$File_name = $_FILES['File']['name'];

	$File_size = $_FILES['File']['size'];
	$File_name1 = $_FILES['File1']['name'];
	$File_size1 = $_FILES['File1']['size'];
	$File = $_FILES['File']['tmp_name'];
	$File1 = $_FILES['File1']['tmp_name'];

	$Sub_No = $_REQUEST['Sub_No'];
	$Name = $_REQUEST['Name'];
	$P_Up = $_REQUEST['P_Up'];
	$P_Name = $_REQUEST['P_Name'];
	$P_Location = $_REQUEST['P_Location'];
	$P_Size = $_REQUEST['P_Size'];
	$P_Link = $_REQUEST['P_Link'];
	$P_Target = $_REQUEST['P_Target'];
	$Cont = $_REQUEST['Cont'];
	$P_Fname = $_REQUEST['P_Fname'];
	$P_Fsize = $_REQUEST['P_Fsize'];
	$Cnt = $_REQUEST['Cnt'];
	$Wdate = $_REQUEST['Wdate'];
	$Ip = $_REQUEST['Ip'];
	$Pass = $_REQUEST['Pass'];
	$Cont_type = $_REQUEST['Cont_type'];
	$Old_file = $_REQUEST['Old_file'];
	$Old_size = $_REQUEST['Old_size'];
	
	$select = $_REQUEST['select'];
	$page = $_REQUEST['page'];
	$sword = $_REQUEST['sword'];
	$mode = $_REQUEST['mode'];

	   ##########답변##########

	$File_name = $_FILES['File']['name'];

	$File_size = $_FILES['File']['size'];
	$File_name1 = $_FILES['File1']['name'];
	$File_size1 = $_FILES['File1']['size'];
	$File = $_FILES['File']['tmp_name'];
	$File1 = $_FILES['File1']['tmp_name'];

	$Sub_No = $_REQUEST['Sub_No'];
	$Name = $_REQUEST['Name'];
	$P_Up = $_REQUEST['P_Up'];
	$P_Name = $_REQUEST['P_Name'];
	$P_Location = $_REQUEST['P_Location'];
	$P_Size = $_REQUEST['P_Size'];
	$P_Link = $_REQUEST['P_Link'];
	$P_Target = $_REQUEST['P_Target'];
	$Cont = $_REQUEST['Cont'];
	$P_Fname = $_REQUEST['P_Fname'];
	$P_Fsize = $_REQUEST['P_Fsize'];
	$Cnt = $_REQUEST['Cnt'];
	$Wdate = $_REQUEST['Wdate'];
	$Ip = $_REQUEST['Ip'];
	$Pass = $_REQUEST['Pass'];
	$Cont_type = $_REQUEST['Cont_type'];
	$Old_file = $_REQUEST['Old_file'];
	$Old_size = $_REQUEST['Old_size'];
	$page = $_REQUEST['page'];

  ########################

  ########################
$cmenu=$_REQUEST['cmenu'];
$ordernum=$_REQUEST['ordernum'];
$sel_kind = $_REQUEST['sel_kind'];
$pay_name = $_REQUEST['pay_name'];
$pay_email = $_REQUEST['pay_email'];
$sel_status = $_REQUEST['sel_status'];
$signdate = $_REQUEST['signdate'];
$total_money_num = $_REQUEST['total_money_num'];

$sel_kind = $_REQUEST['sel_kind'];
$com_no = $_REQUEST['com_no'];
$ostatus_tmp = $_REQUEST['ostatus_tmp'];
$char_num = $_REQUEST['char_num'];
$ostatus = $_REQUEST['ostatus'];
$char_year = $_REQUEST['char_year'];
$char_month = $_REQUEST['char_month'];
$char_day=$_REQUEST['char_day'];
$char_num=$_REQUEST['char_num'];
$ydate1=$_REQUEST['ydate1'];
$mdate1=$_REQUEST['mdate1'];
$ddate1=$_REQUEST['ddate1'];
$ydate2=$_REQUEST['ydate2'];
$mdate2=$_REQUEST['mdate2'];
$ddate2=$_REQUEST['ddate2'];

#########################

$kkid = $_REQUEST['kkid'];
$kkid1 = $_REQUEST['kkid1'];
$tyear = $_REQUEST['tyear'];
$dis = $_REQUEST['dis'];
$member_count = $_REQUEST['member_count'];
$level_l = $_REQUEST['level_l'];
$file_name = $_REQUEST['file_name'];
$member_count = $_REQUEST['member_count'];
$chk_num = $_REQUEST['chk_num'];
$passwd = $_REQUEST['passwd'];
$passwd2 = $_REQUEST['passwd2'];
$name = $_REQUEST['name'];
$Email = $_REQUEST['Email'];
$handphone = $_REQUEST['handphone'];
$zipcorde = $_REQUEST['zipcorde'];
$address = $_REQUEST['address'];
$recommend = $_REQUEST['recommend'];
$company = $_REQUEST['company'];

$real_pass = $_REQUEST['chk_num'];
$Cid = $_REQUEST['Cid'];
$no = $_REQUEST['no'];
$No = $_REQUEST['No'];
$Point = $_REQUEST['Point'];
$Cont = $_REQUEST['Cont'];
$keynum = $_REQUEST['keynum'];

$B_Title = $_REQUEST['B_Title'];
$Secret = $_REQUEST['Secret'];
$Homepage = $_REQUEST['Homepage'];
$Title = $_REQUEST['Title'];
$Cont_type = $_REQUEST['Cont_type'];
$PassWord = $_REQUEST['PassWord'];
$button = $_REQUEST['button'];
$Edit = $_REQUEST['Edit'];
$email = $_REQUEST['email'];
$center = $_REQUEST['center'];
$handphone = $_REQUEST['handphone'];
$zipcorde = $_REQUEST['zipcorde'];
$address = $_REQUEST['address'];
$recommend = $_REQUEST['recommend'];
$company = $_REQUEST['company'];

$board_cook = $_COOKIE['board_cook'];
$recommend2 = $_REQUEST['recommend2'];

$cook_dis = $_COOKIE['cook_dis'];
$cook_dis1 = $_COOKIE['cook_dis1'];
$craddr = $_COOKIE['craddr'];

$cook_data = $_COOKIE['cook_data'];


$title_cate1 = $_REQUEST['title_cate1'];
$order_kk = $_REQUEST['order_kk'];



$buyername = $_REQUEST['buyername'];
$post = $_REQUEST['post'];
$addr1 = $_REQUEST['addr1'];
$htel = $_REQUEST['htel'];
$email = $_REQUEST['email'];
$buytype = $_REQUEST['buytype'];
$recvname = $_REQUEST['recvname'];
$rpost = $_REQUEST['rpost'];
$raddr1 = $_REQUEST['raddr1'];
$rhtel = $_REQUEST['rhtel'];
$rcontent = $_REQUEST['rcontent'];
$usepoint = $_REQUEST['usepoint'];
$kkpoint1 = $_REQUEST['kkpoint1'];
$total_coin1 = $_REQUEST['total_coin1'];
$total_price123 = $_REQUEST['total_price123'];
$paymentkind = $_REQUEST['paymentkind'];
$bank = $_REQUEST['bank'];
$in_name = $_REQUEST['in_name'];
$in_day = $_REQUEST['in_day'];
$query_dis = $_REQUEST['query_dis'];
$ordnum = $_REQUEST['ordnum'];
$id = $_REQUEST['id'];
$handphone1 = $_REQUEST['handphone1'];
$handphone2 = $_REQUEST['handphone2'];
$handphone3 = $_REQUEST['handphone3'];
$address1 = $_REQUEST['address1'];

	$old_img = $_REQUEST['old_img'];
	$old_imgm = $_REQUEST['old_imgm'];
	$old_imgb1 = $_REQUEST['old_imgb1'];
	$old_imgb2 = $_REQUEST['old_imgb2'];
	$old_imgb3 = $_REQUEST['old_imgb3'];
	$old_imgb4 = $_REQUEST['old_imgb4'];
	$old_imgb5 = $_REQUEST['old_imgb5'];

$left_code = $_REQUEST['left_code'];
$code = $_REQUEST['code'];
$amount = $_REQUEST['amount'];
$del_num = $_REQUEST['del_num'];
$sel_theme = $_REQUEST['sel_theme'];
$theme_str = $_REQUEST['theme_str'];
$type = $_REQUEST['type'];
$word = $_REQUEST['word'];
$Secret_ok = $_REQUEST['Secret_ok'];
$k_ordernum1 = $_REQUEST['k_ordernum1'];
$k_ordernum3 = $_REQUEST['k_ordernum3'];
$k_ordernum2 = $_REQUEST['k_ordernum2'];
$k_name = $_REQUEST['k_name'];

$api_mnss_balance  = "https://ms-platform.app/shop_api/api_balance.php";
$api_mnss_payment	= "https://ms-platform.app/shop_api/api_mnss_payment.php";





?>
