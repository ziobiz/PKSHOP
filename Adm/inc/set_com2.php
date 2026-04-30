<?$sel_cate = $_POST[sel_cate];
if($_POST[sel_code1] !="" || $_POST[sel_code2] !="" || $_POST[sel_code3] !="" || $_POST[sel_code4] !=""){
$sel_code1 = $_POST[sel_code1];
$sel_code2 = $_POST[sel_code2];
$sel_code3 = $_POST[sel_code3];
$sel_code4 = $_POST[sel_code4];
}else{
$sel_code1 = $_GET[sel_code1];
$sel_code2 = $_GET[sel_code2];
$sel_code3 = $_GET[sel_code3];
$sel_code4 = $_GET[sel_code4];
}
$chk_order = $_GET[chk_order];
$soldout = $_GET[soldout];
$mode = $_GET[mode];
if($_POST[keyfield] !="" || $_POST['key'] !=""){
$keyfield = $_POST['keyfield'];
$key = $_POST['key'];
}else{
$keyfield = $_GET['keyfield'];
$key = $_GET['key'];
$page_num =$_GET[page];
}
$theme = $_GET[theme];
$sel_goods = $_POST[sel_goods];
$File_name = $_FILES['File']['name'];

$File_size = $_FILES['File']['size'];
$File_name1 = $_FILES['File1']['name'];
$File_size1 = $_FILES['File1']['size'];
$File = $_FILES['File']['tmp_name'];
$File1 = $_FILES['File1']['tmp_name'];

$Sub_No = $_POST['Sub_No'];
$Name = $_POST['Name'];
$P_Up = $_POST['P_Up'];
$P_Name = $_POST['P_Name'];
$P_Location = $_POST['P_Location'];
$P_Size = $_POST['P_Size'];
$P_Link = $_POST['P_Link'];
$P_Target = $_POST['P_Target'];
$Cont = $_POST['Cont'];
$P_Fname = $_POST['P_Fname'];
$P_Fsize = $_POST['P_Fsize'];
$Cnt = $_POST['Cnt'];
$Wdate = $_POST['Wdate'];
$Ip = $_POST['Ip'];
$Pass = $_POST['Pass'];
$Cont_type = $_POST['Cont_type'];
$imgb1_name = $_FILES['imgb1']['name'];
$imgb1_size = $_FILES['imgb1']['size'];
$imgb2_name1 = $_FILES['imgb2']['name'];
$imgb2_size1 = $_FILES['imgb2']['size'];
$imgb1 = $_FILES['imgb1']['tmp_name'];
$imgb2 = $_FILES['imgb2']['tmp_name'];
$title = $_POST[title];
$info = $_POST[info];
$detail = $_POST[detail];
$company = $_POST[company];
$home = $_POST[home];
$shelf = $_POST[shelf];
$feature = $_POST[feature];
$code1=$_POST[code1];
$code2=$_POST[code2];
$code3=$_POST[code3];
$code=$_POST[code];
$color=$_POST[color];
$size=$_POST[size];
$theme=$_POST[theme];
$event=$_POST[event];
$event_str=$_POST[event_str];
$new=$_POST['new'];
$pricec=$_POST[pricec];
$prices=$_POST[prices];
$priced=$_POST[priced];
$point=$_POST[point];
$point_dis=$_POST[point_dis];
$currnum=$_POST[currnum];
$warnnum=$_POST[warnnum];
$imgl=$_POST[imgl];
$imgm=$_POST[imgm]; $soldout=$_POST[soldout]; $rank=$_POST[rank]; $option_t1=$_POST[option_t1]; $option_n1=$_POST[option_n1]; $option_p1=$_POST[option_p1]; $option_k1=$_POST[option_k1]; $option_t2=$_POST[option_t2]; $option_n2=$_POST[option_n2]; $option_p2=$_POST[option_p2]; $option_k2=$_POST[option_k2]; 
$option_t3=$_POST[option_t3]; $option_n3=$_POST[option_n3]; $option_p3=$_POST[option_p3]; $option_k3=$_POST[option_k3]; 
$option_t4=$_POST[option_t4]; $option_n4=$_POST[option_n4]; $option_p4=$_POST[option_p4]; $option_k4=$_POST[option_k4]; 
$option_t5=$_POST[option_t5]; $option_n5=$_POST[option_n5]; $option_p5=$_POST[option_p5]; $option_k5=$_POST[option_k5]; 
$order1=$_POST[order1]; $order2=$_POST[order2]; $order3=$_POST[order3]; $color_opt=$_POST[color_opt]; 
$size_opt=$_POST[size_opt]; $add_opt1=$_POST[add_opt1]; $add_opt2=$_POST[add_opt2]; $add_opt3=$_POST[add_opt3]; 
$add_opt4=$_POST[add_opt4]; $add_opt5=$_POST[add_opt5]; $relation=$_POST[relation]; $price_dis=$_POST[price_dis]; 
$best=$_POST[best]; $cut=$_POST[cut]; $recommend=$_POST[recommend]; $theme_g=$_POST[theme_g]; $theme_n=$_POST[theme_n]; 
$theme_r=$_POST[theme_r]; $theme_f=$_POST[theme_f]; $theme_x=$_POST[theme_x]; $theme_y=$_POST[theme_y]; $theme_z=$_POST[theme_z]; $rank_g=$_POST[rank_g]; $rank_n=$_POST[rank_n]; $rank_r=$_POST[rank_r]; $rank_f=$_POST[rank_f]; $rank_x=$_POST[rank_x]; $rank_y=$_POST[rank_y]; $rank_z=$_POST[rank_z]; $opt_num=$_POST[opt_num]; $opt_num_str=$_POST[opt_num_str]; $theme_s=$_POST[theme_s]; $rank_s=$_POST[rank_s]; $code4=$_POST[code4];$order4=$_POST[order4]; $p_id=$_POST[p_id];

$cate = $_GET[cate];
$cate1 = $_POST[cate1];
$cate2 = $_POST[cate2];
$cate3 = $_POST[cate3];
$cate4 = $_POST[cate4];

$catenum1 = $_POST[catenum1];
$catenum2 = $_POST[catenum2];
$catenum3 = $_POST[catenum3];
$catenum4 = $_POST[catenum4];

$code1 = $_POST[code1];
$code2 = $_POST[code2];
$code3 = $_POST[code3];
$code4 = $_POST[code4];
$cateuid1 = $_POST[cateuid1];
$cateuid2 = $_POST[cateuid2];
$cateuid3 = $_POST[cateuid3];
$cateuid4 = $_POST[cateuid4];


  ##########어드민 팝업##########
	$board_cook = $_COOKIE[board_cook];
	$File_name = $_FILES['File']['name'];

	$File_size = $_FILES['File']['size'];
	$File_name1 = $_FILES['File1']['name'];
	$File_size1 = $_FILES['File1']['size'];
	$File = $_FILES['File']['tmp_name'];
	$File1 = $_FILES['File1']['tmp_name'];

	$Sub_No = $_POST['Sub_No'];
	$Name = $_POST['Name'];
	$P_Up = $_POST['P_Up'];
	$P_Name = $_POST['P_Name'];
	$P_Location = $_POST['P_Location'];
	$P_Size = $_POST['P_Size'];
	$P_Link = $_POST['P_Link'];
	$P_Target = $_POST['P_Target'];
	$Cont = $_POST['Cont'];
	$P_Fname = $_POST['P_Fname'];
	$P_Fsize = $_POST['P_Fsize'];
	$Cnt = $_POST['Cnt'];
	$Wdate = $_POST['Wdate'];
	$Ip = $_POST['Ip'];
	$Pass = $_POST['Pass'];
	$Cont_type = $_POST['Cont_type'];
	$Old_file = $_POST['Old_file'];
	$Old_size = $_POST['Old_size'];
	$page = $_POST['page'];
	
	$select = $_GET[select];
	$page = $_GET[page];
	$sword = $_GET[sword];
	$mode = $_GET['mode'];

	   ##########답변##########

	$File_name = $_FILES['File']['name'];

	$File_size = $_FILES['File']['size'];
	$File_name1 = $_FILES['File1']['name'];
	$File_size1 = $_FILES['File1']['size'];
	$File = $_FILES['File']['tmp_name'];
	$File1 = $_FILES['File1']['tmp_name'];

	$Sub_No = $_POST['Sub_No'];
	$Name = $_POST['Name'];
	$P_Up = $_POST['P_Up'];
	$P_Name = $_POST['P_Name'];
	$P_Location = $_POST['P_Location'];
	$P_Size = $_POST['P_Size'];
	$P_Link = $_POST['P_Link'];
	$P_Target = $_POST['P_Target'];
	$Cont = $_POST['Cont'];
	$P_Fname = $_POST['P_Fname'];
	$P_Fsize = $_POST['P_Fsize'];
	$Cnt = $_POST['Cnt'];
	$Wdate = $_POST['Wdate'];
	$Ip = $_POST['Ip'];
	$Pass = $_POST['Pass'];
	$Cont_type = $_POST['Cont_type'];
	$Old_file = $_POST['Old_file'];
	$Old_size = $_POST['Old_size'];
	$page = $_POST['page'];

  ########################

  ########################
$cmenu=$_GET[cmenu];
$ordernum=$_GET[ordernum];
$sel_kind = $_POST[sel_kind];
$pay_name = $_POST[pay_name];
$pay_email = $_POST[pay_email];
$sel_status = $_POST[sel_status];
$signdate = $_POST[signdate];
$total_money_num = $_POST[total_money_num];
$valid_user = $_POST[valid_user];
$sel_kind = $_POST[sel_kind];
$com_no = $_POST[com_no];
$ostatus_tmp = $_POST[ostatus_tmp];
$char_num = $_POST[char_num];
$ostatus = $_POST[ostatus];
$char_year = $_POST[char_year];
$char_month = $_POST[char_month];
$char_day=$_POST[char_day];
$char_num=$_POST[char_num];

?>