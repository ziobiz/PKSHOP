<meta charset="utf-8">
<?
//  error_reporting( E_ALL );
//  ini_set( "display_errors", 1 );

function pkshop_post($key, $default = '') {
	return isset($_POST[$key]) ? $_POST[$key] : $default;
}

function pkshop_file_tmp($field) {
	return (isset($_FILES[$field]['tmp_name']) && $_FILES[$field]['tmp_name'] !== '') ? $_FILES[$field]['tmp_name'] : '';
}

function pkshop_file_name($field) {
	return isset($_FILES[$field]['name']) ? $_FILES[$field]['name'] : '';
}

function pkshop_sql_q($value) {
	global $DB;
	if (isset($DB) && $DB->dbh) {
		return $DB->dbh->quote((string)$value);
	}
	return "'" . str_replace("'", "''", (string)$value) . "'";
}

function pkshop_reload_post_fields() {
	global $title, $info, $detail, $feature, $company, $home, $shelf, $color, $size;
	global $code1, $code2, $code3, $code4, $code, $new, $pricec, $prices, $priced, $coin, $pr_kind;
	global $point, $point_dis, $currnum, $warnnum, $soldout, $rank;
	global $option_t1, $option_n1, $option_p1, $option_k1, $option_t2, $option_n2, $option_p2, $option_k2;
	global $option_t3, $option_n3, $option_p3, $option_k3, $option_t4, $option_n4, $option_p4, $option_k4;
	global $option_t5, $option_n5, $option_p5, $option_k5;
	global $order1, $order2, $order3, $order4, $color_opt, $size_opt;
	global $add_opt1, $add_opt2, $add_opt3, $add_opt4, $add_opt5, $price_dis, $best, $cut, $recommend;
	global $theme_g, $theme_n, $theme_r, $theme_f, $theme_x, $theme_y, $theme_z, $theme_s;
	global $rank_g, $rank_n, $rank_r, $rank_f, $rank_x, $rank_y, $rank_z, $rank_s;
	global $opt_num, $opt_num_str, $p_id, $event_str;
	global $event1, $event2, $event3, $event4, $event5;
	global $event1_str, $event2_str, $event3_str, $event4_str, $event5_str;
	global $relation1, $relation2, $relation3, $relation4;
	global $No, $page, $keyfield, $key, $sel_code1, $sel_code2, $sel_code3, $sel_code4, $sel_code;
	global $chk_order, $sel_cate, $old_imgl, $old_imgm, $old_imgb1, $old_imgb2, $old_imgb3, $old_imgb4, $old_imgb5;
	global $onlypoint, $c_pv, $dis, $country, $F_l, $F_m, $F_b1, $F_b2, $F_b3, $F_b4, $F_b5;
	global $code1_tmp, $code2_tmp, $code3_tmp, $code4_tmp, $old_code;

	$title      = pkshop_post('title');
	$info       = pkshop_post('info');
	$detail     = pkshop_post('detail');
	$feature    = pkshop_post('feature');
	$company    = pkshop_post('company');
	$home       = pkshop_post('home');
	$shelf      = pkshop_post('shelf');
	$color      = pkshop_post('color');
	$size       = pkshop_post('size');
	$code1      = pkshop_post('code1');
	$code2      = pkshop_post('code2');
	$code3      = pkshop_post('code3');
	$code4      = pkshop_post('code4');
	$code       = pkshop_post('code');
	$new        = pkshop_post('new');
	$pricec     = pkshop_post('pricec');
	$prices     = pkshop_post('prices');
	$priced     = pkshop_post('priced');
	$coin       = pkshop_post('coin');
	$pr_kind    = pkshop_post('pr_kind');
	$point      = pkshop_post('point');
	$point_dis  = pkshop_post('point_dis');
	$currnum    = pkshop_post('currnum');
	$warnnum    = pkshop_post('warnnum');
	$soldout    = pkshop_post('soldout');
	$rank       = pkshop_post('rank');
	$option_t1  = pkshop_post('option_t1'); $option_n1 = pkshop_post('option_n1'); $option_p1 = pkshop_post('option_p1'); $option_k1 = pkshop_post('option_k1');
	$option_t2  = pkshop_post('option_t2'); $option_n2 = pkshop_post('option_n2'); $option_p2 = pkshop_post('option_p2'); $option_k2 = pkshop_post('option_k2');
	$option_t3  = pkshop_post('option_t3'); $option_n3 = pkshop_post('option_n3'); $option_p3 = pkshop_post('option_p3'); $option_k3 = pkshop_post('option_k3');
	$option_t4  = pkshop_post('option_t4'); $option_n4 = pkshop_post('option_n4'); $option_p4 = pkshop_post('option_p4'); $option_k4 = pkshop_post('option_k4');
	$option_t5  = pkshop_post('option_t5'); $option_n5 = pkshop_post('option_n5'); $option_p5 = pkshop_post('option_p5'); $option_k5 = pkshop_post('option_k5');
	$order1     = pkshop_post('order1'); $order2 = pkshop_post('order2'); $order3 = pkshop_post('order3'); $order4 = pkshop_post('order4');
	$color_opt  = pkshop_post('color_opt'); $size_opt = pkshop_post('size_opt');
	$add_opt1   = pkshop_post('add_opt1'); $add_opt2 = pkshop_post('add_opt2'); $add_opt3 = pkshop_post('add_opt3'); $add_opt4 = pkshop_post('add_opt4'); $add_opt5 = pkshop_post('add_opt5');
	$price_dis  = pkshop_post('price_dis');
	$best       = pkshop_post('best'); $cut = pkshop_post('cut'); $recommend = pkshop_post('recommend');
	$theme_g    = pkshop_post('theme_g'); $theme_n = pkshop_post('theme_n'); $theme_r = pkshop_post('theme_r'); $theme_f = pkshop_post('theme_f');
	$theme_x    = pkshop_post('theme_x'); $theme_y = pkshop_post('theme_y'); $theme_z = pkshop_post('theme_z'); $theme_s = pkshop_post('theme_s');
	$rank_g     = pkshop_post('rank_g'); $rank_n = pkshop_post('rank_n'); $rank_r = pkshop_post('rank_r'); $rank_f = pkshop_post('rank_f');
	$rank_x     = pkshop_post('rank_x'); $rank_y = pkshop_post('rank_y'); $rank_z = pkshop_post('rank_z'); $rank_s = pkshop_post('rank_s');
	$opt_num    = pkshop_post('opt_num'); $opt_num_str = pkshop_post('opt_num_str');
	$p_id       = pkshop_post('p_id');
	$event_str  = pkshop_post('event_str');
	$event1     = pkshop_post('event1'); $event2 = pkshop_post('event2'); $event3 = pkshop_post('event3'); $event4 = pkshop_post('event4'); $event5 = pkshop_post('event5');
	$event1_str = pkshop_post('event1_str'); $event2_str = pkshop_post('event2_str'); $event3_str = pkshop_post('event3_str'); $event4_str = pkshop_post('event4_str'); $event5_str = pkshop_post('event5_str');
	$relation1  = pkshop_post('relation1'); $relation2 = pkshop_post('relation2'); $relation3 = pkshop_post('relation3'); $relation4 = pkshop_post('relation4');
	$No         = pkshop_post('No');
	$page       = pkshop_post('page');
	$keyfield   = pkshop_post('keyfield');
	$key        = pkshop_post('key');
	$sel_code1  = pkshop_post('sel_code1'); $sel_code2 = pkshop_post('sel_code2'); $sel_code3 = pkshop_post('sel_code3'); $sel_code4 = pkshop_post('sel_code4');
	$sel_code   = pkshop_post('sel_code');
	$chk_order  = pkshop_post('chk_order');
	$sel_cate   = pkshop_post('sel_cate');
	$old_imgl   = pkshop_post('old_imgl');
	$old_imgm   = pkshop_post('old_imgm');
	$old_imgb1  = pkshop_post('old_imgb1');
	$old_imgb2  = pkshop_post('old_imgb2');
	$old_imgb3  = pkshop_post('old_imgb3');
	$old_imgb4  = pkshop_post('old_imgb4');
	$old_imgb5  = pkshop_post('old_imgb5');
	$onlypoint  = pkshop_post('onlypoint');
	$c_pv       = pkshop_post('c_pv');
	$dis        = pkshop_post('dis');
	$country    = pkshop_post('country');
	$F_l        = pkshop_post('F_l');
	$F_m        = pkshop_post('F_m');
	$F_b1       = pkshop_post('F_b1');
	$F_b2       = pkshop_post('F_b2');
	$F_b3       = pkshop_post('F_b3');
	$F_b4       = pkshop_post('F_b4');
	$F_b5       = pkshop_post('F_b5');
	$code1_tmp  = pkshop_post('code1_tmp');
	$code2_tmp  = pkshop_post('code2_tmp');
	$code3_tmp  = pkshop_post('code3_tmp');
	$code4_tmp  = pkshop_post('code4_tmp');
	$old_code   = pkshop_post('old_code');
	$title = trim($title);
}

$title      = pkshop_post('title');
$info       = pkshop_post('info');
$detail     = pkshop_post('detail');
$feature    = pkshop_post('feature');
$company    = pkshop_post('company');
$home       = pkshop_post('home');
$shelf      = pkshop_post('shelf');
$color      = pkshop_post('color');
$size       = pkshop_post('size');
$code1      = pkshop_post('code1');
$code2      = pkshop_post('code2');
$code3      = pkshop_post('code3');
$code4      = pkshop_post('code4');
$code       = pkshop_post('code');
$new        = pkshop_post('new');
$pricec     = pkshop_post('pricec');
$prices     = pkshop_post('prices');
$priced     = pkshop_post('priced');
$coin       = pkshop_post('coin');
$pr_kind    = pkshop_post('pr_kind');
$point      = pkshop_post('point');
$point_dis  = pkshop_post('point_dis');
$currnum    = pkshop_post('currnum');
$warnnum    = pkshop_post('warnnum');
$soldout    = pkshop_post('soldout');
$rank       = pkshop_post('rank');
$option_t1  = pkshop_post('option_t1'); $option_n1 = pkshop_post('option_n1'); $option_p1 = pkshop_post('option_p1'); $option_k1 = pkshop_post('option_k1');
$option_t2  = pkshop_post('option_t2'); $option_n2 = pkshop_post('option_n2'); $option_p2 = pkshop_post('option_p2'); $option_k2 = pkshop_post('option_k2');
$option_t3  = pkshop_post('option_t3'); $option_n3 = pkshop_post('option_n3'); $option_p3 = pkshop_post('option_p3'); $option_k3 = pkshop_post('option_k3');
$option_t4  = pkshop_post('option_t4'); $option_n4 = pkshop_post('option_n4'); $option_p4 = pkshop_post('option_p4'); $option_k4 = pkshop_post('option_k4');
$option_t5  = pkshop_post('option_t5'); $option_n5 = pkshop_post('option_n5'); $option_p5 = pkshop_post('option_p5'); $option_k5 = pkshop_post('option_k5');
$order1     = pkshop_post('order1'); $order2 = pkshop_post('order2'); $order3 = pkshop_post('order3'); $order4 = pkshop_post('order4');
$color_opt  = pkshop_post('color_opt'); $size_opt = pkshop_post('size_opt');
$add_opt1   = pkshop_post('add_opt1'); $add_opt2 = pkshop_post('add_opt2'); $add_opt3 = pkshop_post('add_opt3'); $add_opt4 = pkshop_post('add_opt4'); $add_opt5 = pkshop_post('add_opt5');
$price_dis  = pkshop_post('price_dis');
$best       = pkshop_post('best'); $cut = pkshop_post('cut'); $recommend = pkshop_post('recommend');
$theme_g    = pkshop_post('theme_g'); $theme_n = pkshop_post('theme_n'); $theme_r = pkshop_post('theme_r'); $theme_f = pkshop_post('theme_f');
$theme_x    = pkshop_post('theme_x'); $theme_y = pkshop_post('theme_y'); $theme_z = pkshop_post('theme_z'); $theme_s = pkshop_post('theme_s');
$rank_g     = pkshop_post('rank_g'); $rank_n = pkshop_post('rank_n'); $rank_r = pkshop_post('rank_r'); $rank_f = pkshop_post('rank_f');
$rank_x     = pkshop_post('rank_x'); $rank_y = pkshop_post('rank_y'); $rank_z = pkshop_post('rank_z'); $rank_s = pkshop_post('rank_s');
$opt_num    = pkshop_post('opt_num'); $opt_num_str = pkshop_post('opt_num_str');
$p_id       = pkshop_post('p_id');
$event_str  = pkshop_post('event_str');
$event1     = pkshop_post('event1'); $event2 = pkshop_post('event2'); $event3 = pkshop_post('event3'); $event4 = pkshop_post('event4'); $event5 = pkshop_post('event5');
$event1_str = pkshop_post('event1_str'); $event2_str = pkshop_post('event2_str'); $event3_str = pkshop_post('event3_str'); $event4_str = pkshop_post('event4_str'); $event5_str = pkshop_post('event5_str');
$relation1  = pkshop_post('relation1'); $relation2 = pkshop_post('relation2'); $relation3 = pkshop_post('relation3'); $relation4 = pkshop_post('relation4');
$No         = pkshop_post('No');
$page       = pkshop_post('page');
$keyfield   = pkshop_post('keyfield');
$key        = pkshop_post('key');
$sel_code1  = pkshop_post('sel_code1'); $sel_code2 = pkshop_post('sel_code2'); $sel_code3 = pkshop_post('sel_code3'); $sel_code4 = pkshop_post('sel_code4');
$sel_code   = pkshop_post('sel_code');
$chk_order  = pkshop_post('chk_order');
$sel_cate   = pkshop_post('sel_cate');
$old_imgl   = pkshop_post('old_imgl');
$old_imgm   = pkshop_post('old_imgm');
$old_imgb1  = pkshop_post('old_imgb1');
$old_imgb2  = pkshop_post('old_imgb2');
$old_imgb3  = pkshop_post('old_imgb3');
$old_imgb4  = pkshop_post('old_imgb4');
$old_imgb5  = pkshop_post('old_imgb5');
$onlypoint  = pkshop_post('onlypoint');
$c_pv       = pkshop_post('c_pv');
$dis        = pkshop_post('dis');
$country    = pkshop_post('country');
if ($country === '' || $country === null) {
	$country = '1';
}
$F_l        = pkshop_post('F_l');
$F_m        = pkshop_post('F_m');
$F_b1       = pkshop_post('F_b1');
$F_b2       = pkshop_post('F_b2');
$F_b3       = pkshop_post('F_b3');
$F_b4       = pkshop_post('F_b4');
$F_b5       = pkshop_post('F_b5');
$code1_tmp  = pkshop_post('code1_tmp');
$code2_tmp  = pkshop_post('code2_tmp');
$code3_tmp  = pkshop_post('code3_tmp');
$code4_tmp  = pkshop_post('code4_tmp');
$old_code   = pkshop_post('old_code');

$title = trim($title);

########## 입력값에 대한 타당성 검사를 수행한다. ###########

include "../common/user_function.php";
$shop_img="../../upload/";
$signdate = time();
if (pkshop_post('char_year') !== '' && pkshop_post('char_month') !== '' && pkshop_post('char_day') !== '') {
	$esigndate = mktime(23, 59, 59, (int)pkshop_post('char_month'), (int)pkshop_post('char_day'), (int)pkshop_post('char_year'));
} else {
	$esigndate = time();
}
$savedir = "$shop_img";

########## 데이터베이스에 연결한다. ###########

include "../common/dbconn.php";
pkshop_reload_post_fields();
$imgl = pkshop_file_tmp('imgl');
$imgl_name = pkshop_file_name('imgl');


// echo $imgl_name;exit;
##리스트이미지 업로드#####################################################
if (strcmp($imgl,"")){
	if($old_imgl!=""){
		$imgl_name= $savedir . $old_imgl;
		$img_existl = file_exists("$imgl_name");
		
		if($img_existl){
			if(!unlink("$imgl_name")){
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}
	}

	
	############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
	//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	
	$full_filename = explode(".", "$imgl_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"PNG")) { 
   		error("NO_ACCESS_UPLOAD");
   		exit;
	}
	
	##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$imgl_name=$files . "." . $extension;
	
	//echo $File1_name;
	$xxx = $savedir . $imgl_name;
	$countFileName = 0;
	$bExist=1;
	while (file_exists($xxx)){
		if (file_exists($xxx)){	
			$countFileName = $countFileName + 1;
        	$imgl_name = $files . "_" . $countFileName . "." . $extension;
			//$File1_name = $full_filename[0] . "_" . $countFileName . "." . $extension;
			$xxx = $savedir . $imgl_name;
		}
	}	
	
	
	################### 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ################## 
	if(!copy($imgl,"$xxx"))	{
   		error("UPLOAD_COPY_FAILURE");
   		exit;
	}
  
	################ 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ################## 
	if(!unlink($imgl))	{
   		error("UPLOAD_DELETE_FAILURE");
   		exit;	
	}	
}else {  //	파일은 저장하지 않고 이전 파일 삭제시~
	if($F_l=="0"){
		$edit_namel = $savedir . $old_imgl;
		$img_edit_existl = file_exists("$edit_namel");
		if($img_edit_existl){
			if(!unlink("$edit_namel"))	{
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}

	$imgl_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgl_name = $old_imgl;
	}
}

$imgm = pkshop_file_tmp('imgm');
$imgm_name = pkshop_file_name('imgm');
##중간이미지 업로드#####################################################
if (strcmp($imgm,"")){
	if($old_imgm!=""){
		$img_namem= $savedir . $old_imgm;
		$img_existm = file_exists("$img_namem");
		if($img_existm){
			if(!unlink("$img_namem")){
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}
	}

	
	############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
	//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	
	$full_filename = explode(".", "$imgm_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"PNG")) { 
   		error("NO_ACCESS_UPLOAD");
   		exit;
	}
	
	##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$imgm_name=$files . "." . $extension;
	//echo $File1_name;
	$xxx = $savedir . $imgm_name;
	$countFileName = 0;
	$bExist=1;
	while (file_exists($xxx)){
		if (file_exists($xxx)){	
			$countFileName = $countFileName + 1;
        	$imgm_name = $files . "_" . $countFileName . "." . $extension;
			//$File1_name = $full_filename[0] . "_" . $countFileName . "." . $extension;
			$xxx = $savedir . $imgm_name;
		}
	}	
	
	################### 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ################## 
	if(!copy($imgm,"$xxx"))	{
   		error("UPLOAD_COPY_FAILURE");
   		exit;
	}
  
	################ 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ################## 
	if(!unlink($imgm))	{
   		error("UPLOAD_DELETE_FAILURE");
   		exit;	
	}	
}else {  //	파일은 저장하지 않고 이전 파일 삭제시~
	if($F_m=="0"){
		$edit_namem = $savedir . $old_imgm;
		$img_edit_existm = file_exists("$edit_namem");
		if($img_edit_existm){
			if(!unlink("$edit_namem"))	{
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}

	$imgm_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgm_name = $old_imgm;
	}
}


$imgb1 = pkshop_file_tmp('imgb1');
$imgb1_name = pkshop_file_name('imgb1');

##상세이미지1 업로드#####################################################
	if (strcmp($imgb1,"")){
		if($old_imgb1!=""){
			$img_name1= $savedir . $old_imgb1;
			$img_exist1 = file_exists("$img_name1");
			if($img_exist1){
				if(!unlink("$img_name1")){
					error("UPLOAD_DELETE_FAILURE");
					exit;
				}
			}
		}
	
	############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
	
	$full_filename = explode(".", "$imgb1_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"PNG")) { 
   		error("NO_ACCESS_UPLOAD");
   		exit;
	}
	
	##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$imgb1_name=$files . "." . $extension;
	//echo $File1_name;
	$xxx = $savedir . $imgb1_name;
	$countFileName = 0;
	$bExist=1;
	while (file_exists($xxx)){
		if (file_exists($xxx)){	
			$countFileName = $countFileName + 1;
        	$imgb1_name = $files . "_" . $countFileName . "." . $extension;
			//$File1_name = $full_filename[0] . "_" . $countFileName . "." . $extension;
			$xxx = $savedir . $imgb1_name;
		}
	}	
	
	################### 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ################## 
	if(!copy($imgb1,"$xxx"))	{
   		error("UPLOAD_COPY_FAILURE");
   		exit;
	}
  
	################ 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ################## 
	if(!unlink($imgb1))	{
   		error("UPLOAD_DELETE_FAILURE");
   		exit;	
	}	
}else {  //	파일은 저장하지 않고 이전 파일 삭제시~
	if($F_b1=="0"){
		$edit_name1 = $savedir . $old_imgb1;
		$img_edit_exist1 = file_exists("$edit_name1");
		if($img_edit_exist1){
			if(!unlink("$edit_name1"))	{
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}

	$imgb1_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgb1_name = $old_imgb1;
	}
} 

$imgb2 = pkshop_file_tmp('imgb2');
$imgb2_name = pkshop_file_name('imgb2');
##상세이미지2 업로드#####################################################
	if (strcmp($imgb2,"")){
		if($old_imgb2!=""){
			$img_name2= $savedir . $old_imgb2;
			$img_exist2 = file_exists("$img_name2");
			if($img_exist2){
				if(!unlink("$img_name2")){
					error("UPLOAD_DELETE_FAILURE");
					exit;
				}
			}
		}
	
	############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
	$full_filename = explode(".", "$imgb2_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"PNG")) { 
   		error("NO_ACCESS_UPLOAD");
   		exit;
	}
	
	##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$imgb2_name=$files . "." . $extension;
	//echo $File1_name;
	$xxx = $savedir . $imgb2_name;
	$countFileName = 0;
	$bExist=1;
	while (file_exists($xxx)){
		if (file_exists($xxx)){	
			$countFileName = $countFileName + 1;
        	$imgb2_name = $files . "_" . $countFileName . "." . $extension;
			//$File1_name = $full_filename[0] . "_" . $countFileName . "." . $extension;
			$xxx = $savedir . $imgb2_name;
		}
	}	
	
	################### 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ################## 
	if(!copy($imgb2,"$xxx"))	{
   		error("UPLOAD_COPY_FAILURE");
   		exit;
	}
  
	################ 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ################## 
	if(!unlink($imgb2))	{
   		error("UPLOAD_DELETE_FAILURE");
   		exit;	
	}	
}else {  //	파일은 저장하지 않고 이전 파일 삭제시~
	if($F_b2=="0"){
		$edit_name2 = $savedir . $old_imgb2;
		$img_edit_exist2 = file_exists("$edit_name2");
		if($img_edit_exist2){
			if(!unlink("$edit_name2"))	{
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}

	$imgb2_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgb2_name = $old_imgb2;
	}
} 
$imgb3 = pkshop_file_tmp('imgb3');
$imgb3_name = pkshop_file_name('imgb3');
##상세이미지3 업로드#####################################################
	if (strcmp($imgb3,"")){
		if($old_imgb3!=""){
			$img_name3= $savedir . $old_imgb3;
			$img_exist3 = file_exists("$img_name3");
			if($img_exist3){
				if(!unlink("$img_name3")){
					error("UPLOAD_DELETE_FAILURE");
					exit;
				}
			}
		}
	
	############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
	$full_filename = explode(".", "$imgb3_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"PNG")) { 
   		error("NO_ACCESS_UPLOAD");
   		exit;
	}
	
	##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$imgb3_name=$files . "." . $extension;
	//echo $File1_name;
	$xxx = $savedir . $imgb3_name;
	$countFileName = 0;
	$bExist=1;
	while (file_exists($xxx)){
		if (file_exists($xxx)){	
			$countFileName = $countFileName + 1;
        	$imgb3_name = $files . "_" . $countFileName . "." . $extension;
			//$File1_name = $full_filename[0] . "_" . $countFileName . "." . $extension;
			$xxx = $savedir . $imgb3_name;
		}
	}	
	
	################### 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ################## 
	if(!copy($imgb3,"$xxx"))	{
   		error("UPLOAD_COPY_FAILURE");
   		exit;
	}
  
	################ 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ################## 
	if(!unlink($imgb3))	{
   		error("UPLOAD_DELETE_FAILURE");
   		exit;	
	}	
}else {  //	파일은 저장하지 않고 이전 파일 삭제시~
	if($F_b3=="0"){
		$edit_name3 = $savedir . $old_imgb3;
		$img_edit_exist3 = file_exists("$edit_name3");
		if($img_edit_exist3){
			if(!unlink("$edit_name3"))	{
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}

	$imgb3_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgb3_name = $old_imgb3;
	}
}
$imgb4 = pkshop_file_tmp('imgb4');
$imgb4_name = pkshop_file_name('imgb4');
##상세이미지4 업로드#####################################################
	if (strcmp($imgb4,"")){
		if($old_imgb4!=""){
			$img_name4= $savedir . $old_imgb4;
			$img_exist4 = file_exists("$img_name4");
			if($img_exist4){
				if(!unlink("$img_name4")){
					error("UPLOAD_DELETE_FAILURE");
					exit;
				}
			}
		}
	
	############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
	$full_filename = explode(".", "$imgb4_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"PNG")) { 
   		error("NO_ACCESS_UPLOAD");
   		exit;
	}
	
	##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$imgb4_name=$files . "." . $extension;
	//echo $File1_name;
	$xxx = $savedir . $imgb4_name;
	$countFileName = 0;
	$bExist=1;
	while (file_exists($xxx)){
		if (file_exists($xxx)){	
			$countFileName = $countFileName + 1;
        	$imgb4_name = $files . "_" . $countFileName . "." . $extension;
			//$File1_name = $full_filename[0] . "_" . $countFileName . "." . $extension;
			$xxx = $savedir . $imgb4_name;
		}
	}	
	
	################### 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ################## 
	if(!copy($imgb4,"$xxx"))	{
   		error("UPLOAD_COPY_FAILURE");
   		exit;
	}
  
	################ 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ################## 
	if(!unlink($imgb4))	{
   		error("UPLOAD_DELETE_FAILURE");
   		exit;	
	}	
}else {  //	파일은 저장하지 않고 이전 파일 삭제시~
	if($F_b4=="0"){
		$edit_name4 = $savedir . $old_imgb4;
		$img_edit_exist4 = file_exists("$edit_name4");
		if($img_edit_exist4){
			if(!unlink("$edit_name4"))	{
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}

	$imgb4_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgb4_name = $old_imgb4;
	}
}
$imgb5 = pkshop_file_tmp('imgb5');
$imgb5_name = pkshop_file_name('imgb5');
##상세이미지5 업로드#####################################################
	if (strcmp($imgb5,"")){
		if($old_imgb5!=""){
			$img_name5= $savedir . $old_imgb5;
			$img_exist5 = file_exists("$img_name5");
			if($img_exist5){
				if(!unlink("$img_name5")){
					error("UPLOAD_DELETE_FAILURE");
					exit;
				}
			}
		}
	
	############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
	$full_filename = explode(".", "$imgb5_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"PNG")) { 
   		error("NO_ACCESS_UPLOAD");
   		exit;
	}
	
	##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$imgb5_name=$files . "." . $extension;
	//echo $File1_name;
	$xxx = $savedir . $imgb5_name;
	$countFileName = 0;
	$bExist=1;
	while (file_exists($xxx)){
		if (file_exists($xxx)){	
			$countFileName = $countFileName + 1;
        	$imgb5_name = $files . "_" . $countFileName . "." . $extension;
			//$File1_name = $full_filename[0] . "_" . $countFileName . "." . $extension;
			$xxx = $savedir . $imgb5_name;
		}
	}	
	
	################### 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ################## 
	if(!copy($imgb5,"$xxx"))	{
   		error("UPLOAD_COPY_FAILURE");
   		exit;
	}
  
	################ 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ################## 
	if(!unlink($imgb5))	{
   		error("UPLOAD_DELETE_FAILURE");
   		exit;	
	}	
}else {  //	파일은 저장하지 않고 이전 파일 삭제시~
	if($F_b5=="0"){
		$edit_name5 = $savedir . $old_imgb5;
		$img_edit_exist5 = file_exists("$edit_name5");
		if($img_edit_exist5){
			if(!unlink("$edit_name5"))	{
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}

	$imgb5_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgb5_name = $old_imgb5;
	}
}
$imgl=$imgl_name;			$imgm=$imgm_name;
$imgb1=$imgb1_name;		$imgb2=$imgb2_name;
$imgb3=$imgb3_name;		$imgb4=$imgb4_name;
$imgb5=$imgb5_name;

include_once dirname(__FILE__) . '/../../include/product_detail_helper.php';
$detail = pkshop_sanitize_product_detail_html($detail, array(
	'imgm'  => $imgm,
	'imgb1' => $imgb1,
	'imgb2' => $imgb2,
	'imgb3' => $imgb3,
	'imgb4' => $imgb4,
	'imgb5' => $imgb5,
));

####################################################
//$theme=$theme_g.",".$theme_r.",".$theme_n.",".$theme_b.",".$theme_p;
$theme = trim($theme_g." ".$theme_r." ".$theme_n." ".$theme_f." ".$theme_x." ".$theme_y." ".$theme_z." ".$theme_s);
$event = $event1.",".$event2.",".$event3.",".$event4.",".$event5;
if (trim($event_str) === '') {
	$event_str = $event1_str.",".$event2_str.",".$event3_str.",".$event4_str.",".$event5_str;
}
//$event=$event1.",".$event2.",".$event3.",".$event4.",".$event5;
//$event_str=$event1_str.",".$event2_str.",".$event3_str.",".$event4_str.",".$event5_str;



$relation = $relation1."-".$relation2."-".$relation3."-".$relation4;

########## shop 데이터베이스에 입력값을 삽입한다. ###################

### 새로운 코드번호 생성 ###

if($code1_tmp == $code1 && $code2_tmp == $code2 && $code3_tmp == $code3 && $code4_tmp == $code4  ){
	$code = $old_code;
}else{


	$code=$code1.$code2.$code3.$code4;
	$DB->get("SELECT max(code) FROM $shop_goods WHERE code LIKE '".$code."%' ",$rs,$rn);

	if(!empty($rs) && !empty($rs[0][0])) {	
	$new_code = substr($rs[0][0],-3);
	$new_code = $new_code + 1;
	$new_code = sprintf("%03d",$new_code);
	} else {
	$new_code = "001";
	}   

	if ($code!="") $code=$code.$new_code;
}
### 새로운 코드번호 생성 ###
$signdate = time();
//$query1 = "UPDATE $coin_goods SET ";
//$query1 = $query1."coin_price = '$prices', title = '$title', signdate='$signdate' where no = '$No' ";
//$result1 = mysql_query($query1,$DBconn);
//if(!$result1){
//	error("QUERY ERROR");
//	exit;
//}
// echo "Asd";exit;

if ($No === '' || $No === '0') {
	echo '<meta charset="utf-8"><p>상품 번호(No)가 없습니다. 목록에서 다시 선택해 주세요.</p>';
	exit;
}

$query = "code1=".pkshop_sql_q($code1)
	.",code2=".pkshop_sql_q($code2)
	.",code3=".pkshop_sql_q($code3)
	.",code=".pkshop_sql_q($code)
	.",title=".pkshop_sql_q($title)
	.",info=".pkshop_sql_q($info)
	.",company=".pkshop_sql_q($company)
	.",color=".pkshop_sql_q($color)
	.",size=".pkshop_sql_q($size)
	.",home=".pkshop_sql_q($home)
	.",shelf=".pkshop_sql_q($shelf)
	.",theme=".pkshop_sql_q($theme)
	.",event=".pkshop_sql_q($event)
	.",event_str=".pkshop_sql_q($event_str)
	.",new=".pkshop_sql_q($new)
	.",pricec=".pkshop_sql_q($pricec)
	.",priced=".pkshop_sql_q($priced)
	.",prices=".pkshop_sql_q($prices)
	.",coin=".pkshop_sql_q($coin)
	.",pr_kind=".pkshop_sql_q($pr_kind)
	.",point=".pkshop_sql_q($point)
	.",point_dis=".pkshop_sql_q($point_dis)
	.",currnum=".pkshop_sql_q($currnum)
	.",warnnum=".pkshop_sql_q($warnnum)
	.",imgl=".pkshop_sql_q($imgl)
	.",imgm=".pkshop_sql_q($imgm)
	.",imgb1=".pkshop_sql_q($imgb1)
	.",imgb2=".pkshop_sql_q($imgb2)
	.",imgb3=".pkshop_sql_q($imgb3)
	.",imgb4=".pkshop_sql_q($imgb4)
	.",imgb5=".pkshop_sql_q($imgb5)
	.",detail=".pkshop_sql_q($detail)
	.",feature=".pkshop_sql_q($feature)
	.",signdate=".pkshop_sql_q($signdate)
	.",soldout=".pkshop_sql_q($soldout)
	.",rank=".pkshop_sql_q($rank)
	.",option_t1=".pkshop_sql_q($option_t1)
	.",option_n1=".pkshop_sql_q($option_n1)
	.",option_p1=".pkshop_sql_q($option_p1)
	.",option_k1=".pkshop_sql_q($option_k1)
	.",option_t2=".pkshop_sql_q($option_t2)
	.",option_n2=".pkshop_sql_q($option_n2)
	.",option_p2=".pkshop_sql_q($option_p2)
	.",option_k2=".pkshop_sql_q($option_k2)
	.",option_t3=".pkshop_sql_q($option_t3)
	.",option_n3=".pkshop_sql_q($option_n3)
	.",option_p3=".pkshop_sql_q($option_p3)
	.",option_k3=".pkshop_sql_q($option_k3)
	.",country=".pkshop_sql_q($country)
	.",onlypoint=".pkshop_sql_q($onlypoint)
	.",option_t4=".pkshop_sql_q($option_t4)
	.",option_n4=".pkshop_sql_q($option_n4)
	.",option_p4=".pkshop_sql_q($option_p4)
	.",option_k4=".pkshop_sql_q($option_k4)
	.",option_t5=".pkshop_sql_q($option_t5)
	.",option_n5=".pkshop_sql_q($option_n5)
	.",option_p5=".pkshop_sql_q($option_p5)
	.",option_k5=".pkshop_sql_q($option_k5)
	.",order1=".pkshop_sql_q($order1)
	.",order2=".pkshop_sql_q($order2)
	.",order3=".pkshop_sql_q($order3)
	.",color_opt=".pkshop_sql_q($color_opt)
	.",c_pv=".pkshop_sql_q($c_pv)
	.",size_opt=".pkshop_sql_q($size_opt)
	.",add_opt1=".pkshop_sql_q($add_opt1)
	.",add_opt2=".pkshop_sql_q($add_opt2)
	.",add_opt3=".pkshop_sql_q($add_opt3)
	.",add_opt4=".pkshop_sql_q($add_opt4)
	.",add_opt5=".pkshop_sql_q($add_opt5)
	.",relation=".pkshop_sql_q($relation)
	.",price_dis=".pkshop_sql_q($price_dis)
	.",best=".pkshop_sql_q($best)
	.",cut=".pkshop_sql_q($cut)
	.",recommend=".pkshop_sql_q($recommend)
	.",theme_g=".pkshop_sql_q($theme_g)
	.",theme_n=".pkshop_sql_q($theme_n)
	.",theme_r=".pkshop_sql_q($theme_r)
	.",theme_f=".pkshop_sql_q($theme_f)
	.",theme_x=".pkshop_sql_q($theme_x)
	.",theme_y=".pkshop_sql_q($theme_y)
	.",theme_z=".pkshop_sql_q($theme_z)
	.",opt_num=".pkshop_sql_q($opt_num)
	.",opt_num_str=".pkshop_sql_q($opt_num_str)
	.",theme_s=".pkshop_sql_q($theme_s)
	.",code4=".pkshop_sql_q($code4)
	.",order4=".pkshop_sql_q($order4)
	.",p_id=".pkshop_sql_q($p_id)
	.",esigndate=".pkshop_sql_q($esigndate)
	.",c_dis=".pkshop_sql_q($dis)
	." where No=".intval($No);

try {
	$DB->update($shop_goods, $query);
} catch (Exception $e) {
	echo '<meta charset="utf-8">';
	echo '<p>상품 수정 중 오류가 발생했습니다.</p>';
	echo '<pre style="white-space:pre-wrap;">'.htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8').'</pre>';
	echo '<p><a href="javascript:history.back()">돌아가기</a></p>';
	exit;
}

$encoded_key = urlencode($key);

$return_url = pkshop_post('return_url');
if ($return_url !== '' && preg_match('/^[a-z0-9_]+\.php$/i', $return_url)) {
	$tmpphp = $return_url;
} else if ($p_id === 'admin_ai') {
	$tmpphp = 'pro_ai_products.php';
} else {
	$mode = "page=$page&keyfield=$keyfield&key=$encoded_key&sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&chk_order=$chk_order&sel_cate=$sel_cate&code=$code&No=$No";
	$tmpphp = "pro_info.php?$mode";
}
header("Location: ./$tmpphp");
exit;
?>
