<meta charset="utf-8">
<?
//  error_reporting( E_ALL );
//  ini_set( "display_errors", 1 );

$title = trim($title);
$title = addslashes($title);
$info = addslashes($info);
$detail = addslashes($detail);
$feature = addslashes($feature);


$old_imgl=$_POST["old_imgl"];
$old_imgm=$_POST["old_imgm"];
$old_imgb1=$_POST["old_imgb1"];
$old_imgb2=$_POST["old_imgb2"];
$old_imgb3=$_POST["old_imgb3"];
$old_imgb4=$_POST["old_imgb4"];
$old_imgb5=$_POST["old_imgb5"];
$onlypoint=$_POST["onlypoint"];
$c_pv=$_POST["c_pv"];
$dis=$_POST["dis"];
$country=$_POST["country"];
// echo $c_pv;exit;





// print_r($_FILES);exit;


########## 입력값에 대한 타당성 검사를 수행한다. ###########

include "../common/user_function.php";
$shop_img="../../upload/";
$signdate = time();
$esigndate = mktime(23,59,59,$char_month,$char_day,$char_year); 
$savedir = "$shop_img";



########## 데이터베이스에 연결한다. ###########

include "../common/dbconn.php";
$imgl =$_FILES["imgl"]["tmp_name"];
$imgl_name = $_FILES["imgl"]["name"];
$F_l = $_POST["F_l"];
$F_m = $_POST["F_m"];
$F_b1 = $_POST["F_b1"];
$F_b3 = $_POST["F_b3"];
$code1_tmp = $_POST["code1_tmp"];
$code2_tmp = $_POST["code2_tmp"];
$code3_tmp = $_POST["code3_tmp"];
$code4_tmp = $_POST["code4_tmp"];
$old_code = $_POST["old_code"];


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
				error("UPLOAD_DELETE_FAIL");
				exit;
			}
		}

	$imgl_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgl_name = $old_imgl;
	}
}

$imgm =$_FILES["imgm"]["tmp_name"];
$imgm_name = $_FILES["imgm"]["name"];
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
				error("UPLOAD_DELETE_FAIL");
				exit;
			}
		}

	$imgm_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgm_name = $old_imgm;
	}
}


$imgb1= $_FILES['imgb1']['tmp_name'];
$imgb1_name = $_FILES['imgb1']['name'];

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
				error("UPLOAD_DELETE_FAIL");
				exit;
			}
		}

	$imgb1_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgb1_name = $old_imgb1;
	}
} 

$imgb2= $_FILES['imgb2']['tmp_name'];
$imgb2_name = $_FILES['imgb2']['name'];
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
				error("UPLOAD_DELETE_FAIL");
				exit;
			}
		}

	$imgb2_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgb2_name = $old_imgb2;
	}
} 
$imgb3 =$_FILES["imgb3"]["tmp_name"];
$imgb3_name = $_FILES["imgb3"]["name"];
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
				error("UPLOAD_DELETE_FAIL");
				exit;
			}
		}

	$imgb3_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgb3_name = $old_imgb3;
	}
}
$imgb4 =$_FILES["imgb4"]["tmp_name"];
$imgb4_name = $_FILES["imgb4"]["name"];
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
				error("UPLOAD_DELETE_FAIL");
				exit;
			}
		}

	$imgb4_name = "";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$imgb4_name = $old_imgb4;
	}
}
$imgb5 =$_FILES["imgb5"]["tmp_name"];
$imgb5_name = $_FILES["imgb5"]["name"];
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
				error("UPLOAD_DELETE_FAIL");
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

####################################################
//$theme=$theme_g.",".$theme_r.",".$theme_n.",".$theme_b.",".$theme_p;
//$event=$event1.",".$event2.",".$event3.",".$event4.",".$event5;
//$event_str=$event1_str.",".$event2_str.",".$event3_str.",".$event4_str.",".$event5_str;



$relation = $relation1."-".$relation2."-".$relation3."-".$relation4;

########## shop 데이터베이스에 입력값을 삽입한다. ###################

### 새로운 코드번호 생성 ###

if($code1_tmp == $code1 && $code2_tmp == $code2 && $code3_tmp == $code3 && $code4_tmp == $code4  ){
	$code = $old_code;
}else{


	$code=$code1.$code2.$code3.$code4;
	$DB->get("SELECT max(code) FROM $shop_goods WHERE code LIKE '$code%' ",$rs,$rn);

	if($rs[0][0]) {	
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

				// $query="UPDATE $shop_goods SET";
				$query=$query."					
								code1='$code1',
								code2='$code2',
								code3='$code3',
								code='$code',
								title='$title',
								info='".addslashes($info)."',
								company='$company',
								color='$color',
								size='$size',
								home='$home',
								shelf='$shelf',
								theme='$theme',
								event='$event',
								event_str='$event_str',
								new='$new',
								pricec='$pricec',
								priced='$priced',
								prices='$prices',
								coin='$coin',
								pr_kind='$pr_kind',
								point='$point',
								point_dis='$point_dis',
								currnum='$currnum',
								warnnum='$warnnum',
								imgl='$imgl',
								imgm='$imgm',
								imgb1='$imgb1',
								imgb2='$imgb2',
								imgb3='$imgb3',
								imgb4='$imgb4',
								imgb5='$imgb5',
								detail='".addslashes($detail)."',
								feature='$feature',
								signdate='$signdate',
								soldout='$soldout',
								rank='$rank',
								option_t1='$option_t1',
								option_n1='$option_n1',
								option_p1='$option_p1',
								option_k1='$option_k1',
								option_t2='$option_t2',
								option_n2='$option_n2',
								option_p2='$option_p2',
								option_k2='$option_k2',
								option_t3='$option_t3',
								option_n3='$option_n3',
								option_p3='$option_p3',
								option_k3='$option_k3',
								country='$country',
								onlypoint='$onlypoint',
								
								option_t4='$option_t4',option_n4='$option_n4',option_p4='$option_p4',option_k4='$option_k4',
								option_t5='$option_t5',option_n5='$option_n5',option_p5='$option_p5',option_k5='$option_k5',
								order1='$order1',order2='$order2',order3='$order3',
								color_opt='$color_opt',
								c_pv='$c_pv',
								size_opt='$size_opt',
								add_opt1='$add_opt1',add_opt2='$add_opt2',add_opt3='$add_opt3',add_opt4='$add_opt4',add_opt5='$add_opt5',
								price_dis='$price_dis',best='$best',cut='$cut',recommend='$recommend',theme_g='$theme_g',theme_n='$theme_n',theme_r='$theme_r',theme_f='$theme_f',theme_x='$theme_x',theme_y='$theme_y',theme_z='$theme_z',opt_num='$opt_num',opt_num_str='$opt_num_str',theme_s='$theme_s',code4='$code4',order4='$order4',p_id='$p_id',esigndate='$esigndate',c_dis='$dis' where No='$No'";
								
				$DB->update($shop_goods,$query);
	// 			echo $query;
	// exit;

$encoded_key = urlencode($key);

$mode="page=$page&keyfield=$keyfield&key=$encoded_key&sel_code1=$sel_code1&sel_code2=$sel_code2&sel_code3=$sel_code3&chk_order=$chk_order&sel_cate=$sel_cate&code=$code&No=$No";

// $tmpphp = "products.php?$mode";
$tmpphp = "pro_info.php?$mode";
echo("<meta http-equiv='Refresh' content='0; URL=./$tmpphp'>");
?>
