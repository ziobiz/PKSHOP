<?
include "../common/dbconn.php";
$title = trim($title);
$title = addslashes($title);
$info = addslashes($info);
$detail = addslashes($detail);
$feature = addslashes($feature);
########## 입력값에 대한 타당성 검사를 수행한다. ####################
include "../common/user_function.php";
$shop_img="../shop_img/";
$signdate = time();

########## 새로운 상품의 중복을 결정한다. ###########################

$result = mysql_query("SELECT code FROM $shop_goods WHERE code='$code'",$DBconn);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}


if($row[0]) {
	popup_msg('상품코드가 이미 등록되어 있습니다. 확인 후 등록하십시오.');
	exit;
}   



#########[imgs 이미지 저장]##########################################
# <input type="file" name="imgs" size="30" maxlength="30" class="adminbttn">
# $imgs_name : 실제파일이름(확장자 포함) ####################################
# $imgs      : 임시폴더에 저장되는 경로포함 파일이름 #############################
#################################################################
if(($imgs!="none") && ($imgs!="")) {
########## 파일이 저장될 자료실의 디렉토리를 설정한다. ##########
	$savedir = "$shop_img";

########## 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. ##########
//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장

	$full_filename = explode(".", "$imgs_name");
	//sizeof() 배열의 크기를 반환 , 여기서는 배열크기에 -1을 했으므로 맨끝문자열 즉 확장자를 받는다.
	
	$extension = $full_filename[sizeof($full_filename)-1];	   
	//문자열을 소문자로 바꾸는역할
	
	$extension = strtolower($extension);	
	if(strcmp($extension,"gif") && strcmp($extension,"jpg") && strcmp($extension,"png")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

########## 등록한 파일명을 자동으로 변경한다. #######################
	
	$imgs_name = $code . "_s." . $extension;
	
//########## 등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하는지를 검사한다. ########## 
	
//	$same_file_exist = file_exists("$savedir/$imgs_name");
//	if($same_file_exist) {
// 	error("SAME_FILE_EXIST");
//   	exit;
//}
########## 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ######
	
	if(!copy($imgs,"$savedir/$imgs_name")) {
   	error("UPLOAD_COPY_FAILURE");
   	exit;
	}

########## 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ########## 

	if(!unlink($imgs)) {
   	error("UPLOAD_DELETE_FAILURE");
   	exit;
	}	
}

#################################[imgl 이미지저장]###################
if(($imgl!="none") && ($imgl!="")) {
########## 파일이 저장될 자료실의 디렉토리를 설정한다. ##########
	
	$savedir = "$shop_img";

########## 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. ##########
	
	$full_filename = explode(".", "$imgl_name");
	$extension = $full_filename[sizeof($full_filename)-1];	   
	$extension = strtolower($extension);	
	if(strcmp($extension,"gif") && strcmp($extension,"jpg") && strcmp($extension,"png")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

########## 등록한 파일명을 자동으로 변경한다. ##########
	$imgl_name = $code . "_l." . $extension;
	
########## 등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하는지를 검사한다. ########## 
	
//	$same_file_exist = file_exists("$savedir/$imgl_name");
//	if($same_file_exist) {
//   	error("SAME_FILE_EXIST");
//   	exit;
//	}

########## 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ######
	
	if(!copy($imgl,"$savedir/$imgl_name")) {
   	error("UPLOAD_COPY_FAILURE");
   	exit;
	}

########## 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ##### 

	if(!unlink($imgl)) {
   	error("UPLOAD_DELETE_FAILURE");
   	exit;
	}	
}
###################[imgm 이미지 저장]################################

if(($imgm!="none") && ($imgm!="")) {

########## 파일이 저장될 자료실의 디렉토리를 설정한다. ##########
	
	$savedir = "$shop_img";

########## 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. ######
	
	$full_filename = explode(".", "$imgm_name");
	$extension = $full_filename[sizeof($full_filename)-1];	   
	$extension = strtolower($extension);	
	if(strcmp($extension,"gif") && strcmp($extension,"jpg") && strcmp($extension,"png")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

########## 등록한 파일명을 자동으로 변경한다. ##########
	
	$imgm_name = $code . "_m." . $extension;
	
########## 등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하는지를 검사한다. ########## 
//	$same_file_exist = file_exists("$savedir/$imgm_name");
//	if($same_file_exist) {
//   	error("SAME_FILE_EXIST");
//   	exit;
//	}

########## 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ########## 
	
	if(!copy($imgm,"$savedir/$imgm_name")) {
   	error("UPLOAD_COPY_FAILURE");
   	exit;
	}

########## 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ########## 

	if(!unlink($imgm)) {
   	error("UPLOAD_DELETE_FAILURE");
   	exit;
	}	
}



$imgb1= $_FILES['imgb1']['tmp_name'];
$imgb1_name = $_FILES['imgb1']['name'];
#################################[imgb1 이미지 저장]#################

if(($imgb1!="none") && ($imgb1!="")) {

########## 파일이 저장될 자료실의 디렉토리를 설정한다. ##########
	
	$savedir = "$shop_img";

########## 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. ##########
	
	$full_filename = explode(".", "$imgb1_name");
	$extension = $full_filename[sizeof($full_filename)-1];	   
	$extension = strtolower($extension);	
	if(strcmp($extension,"gif") && strcmp($extension,"jpg") && strcmp($extension,"png")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

########## 등록한 파일명을 자동으로 변경한다. ##########
	
	$imgb1_name = $code . "_b1." . $extension;
	
########## 등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하는지를 검사한다. ########## 
//	$same_file_exist = file_exists("$savedir/$imgb1_name");
//	if($same_file_exist) {
//   	error("SAME_FILE_EXIST");
//   	exit;
//	}
########## 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ########## 

	if(!copy($imgb1,"$savedir/$imgb1_name")) {
   	error("UPLOAD_COPY_FAILURE");
   	exit;
	}

########## 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ########## 

	if(!unlink($imgb1)) {
   	error("UPLOAD_DELETE_FAILURE");
   	exit;
	}	
}


$imgb2= $_FILES['imgb2']['tmp_name'];
$imgb2_name = $_FILES['imgb2']['name'];
#################################[imgb2 이미지 저장]#################

if(($imgb2!="none") && ($imgb2!="")) {

########## 파일이 저장될 자료실의 디렉토리를 설정한다. ##############
	$savedir = "$shop_img";

########## 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. ##########
	$full_filename = explode(".", "$imgb2_name");
	$extension = $full_filename[sizeof($full_filename)-1];	   
	$extension = strtolower($extension);	
	if(strcmp($extension,"gif") && strcmp($extension,"jpg") && strcmp($extension,"png")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

########## 등록한 파일명을 자동으로 변경한다. ##########

	$imgb2_name = $code . "_b2." . $extension;
	
########## 등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하는지를 검사한다. ########## 
//	$same_file_exist = file_exists("$savedir/$imgb2_name");
//	if($same_file_exist) {
//   	error("SAME_FILE_EXIST");
//   	exit;
//	}
########## 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ######

	if(!copy($imgb2,"$savedir/$imgb2_name")) {
   	error("UPLOAD_COPY_FAILURE");
   	exit;
	}

########## 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. #####

	if(!unlink($imgb2)) {
   	error("UPLOAD_DELETE_FAILURE");
   	exit;
	}	
}
#################################[imgb3 이미지 저장]#################

if(($imgb3!="none") && ($imgb3!="")) {

########## 파일이 저장될 자료실의 디렉토리를 설정한다. ##############
	
	$savedir = "$shop_img";

########## 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. ##########
	
	$full_filename = explode(".", "$imgb3_name");
	$extension = $full_filename[sizeof($full_filename)-1];	   
	$extension = strtolower($extension);	
	if(strcmp($extension,"gif") && strcmp($extension,"jpg") && strcmp($extension,"png")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

########## 등록한 파일명을 자동으로 변경한다. ##########
	
	$imgb3_name = $code . "_b3." . $extension;
	
########## 등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하는지를 검사한다. ########## 
//	$same_file_exist = file_exists("$savedir/$imgb3_name");
//	if($same_file_exist) {
//   	error("SAME_FILE_EXIST");
//   	exit;
//	}
######### 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ####### 
	
	if(!copy($imgb3,"$savedir/$imgb3_name")) {
   	error("UPLOAD_COPY_FAILURE");
   	exit;
	}

########## 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ##### 

	if(!unlink($imgb3)) {
   	error("UPLOAD_DELETE_FAILURE");
   	exit;
	}	
}

###########################[imgb4 이미지 저장]#######################

if(($imgb4!="none") && ($imgb4!="")) {

########## 파일이 저장될 자료실의 디렉토리를 설정한다. ##############
	
	$savedir = "$shop_img";

########## 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. ##########
	
	$full_filename = explode(".", "$imgb4_name");
	$extension = $full_filename[sizeof($full_filename)-1];	   
	$extension = strtolower($extension);	
	if(strcmp($extension,"gif") && strcmp($extension,"jpg") && strcmp($extension,"png")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

########## 등록한 파일명을 자동으로 변경한다. ##########
	
	$imgb4_name = $code . "_b4." . $extension;
	
########## 등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하는지를 검사한다. ########## 
	
//	$same_file_exist = file_exists("$savedir/$imgb4_name");
//	if($same_file_exist) {
//   	error("SAME_FILE_EXIST");
//   	exit;
//	}

########## 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ###### 
	
	if(!copy($imgb4,"$savedir/$imgb4_name")) {
   	error("UPLOAD_COPY_FAILURE");
   	exit;
	}

########## 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ########## 

	if(!unlink($imgb4)) {
   	error("UPLOAD_DELETE_FAILURE");
   	exit;
	}	
}


#############################[imgb5 이미지 저장]#####################

if(($imgb5!="none") && ($imgb5!="")) {

########## 파일이 저장될 자료실의 디렉토리를 설정한다. ##########
	
	$savedir = "$shop_img";

########## 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. ##########
	
	$full_filename = explode(".", "$imgb5_name");
	$extension = $full_filename[sizeof($full_filename)-1];	   
	$extension = strtolower($extension);	
	if(strcmp($extension,"gif") && strcmp($extension,"jpg") && strcmp($extension,"png")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

########## 등록한 파일명을 자동으로 변경한다. ##########
	
	$imgb5_name = $code . "_b5." . $extension;
	
########## 등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하는지를 검사한다. ########## 

//	$same_file_exist = file_exists("$savedir/$imgb5_name");
//	if($same_file_exist) {
 //  	error("SAME_FILE_EXIST");
 //  	exit;
//	}

########## 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ###### 
	
	if(!copy($imgb5,"$savedir/$imgb5_name")) {
   	error("UPLOAD_COPY_FAILURE");
   	exit;
	}

########## 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ########## 

	if(!unlink($imgb5)) {
   	error("UPLOAD_DELETE_FAILURE");
   	exit;
	}	
}


############################[imgmotion 이미지 저장]##################

if(($imgmotion!="none") && ($imgmotion!="")) {

########## 파일이 저장될 자료실의 디렉토리를 설정한다. ##############
	
	$savedir = "$shop_img";

########## 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. ##########
	
	$full_filename = explode(".", "$imgmotion_name");
	$extension = $full_filename[sizeof($full_filename)-1];	   
	$extension = strtolower($extension);	
	if(strcmp($extension,"gif") && strcmp($extension,"jpg") && strcmp($extension,"png")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

########## 등록한 파일명을 자동으로 변경한다. #######################
	
	$imgmotion_name = $code . "_motion." . $extension;
	
########## 등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하는지를 검사한다. ########## 
//	$same_file_exist = file_exists("$savedir/$imgmotion_name");
//	if($same_file_exist) {
//   	error("SAME_FILE_EXIST");
//   	exit;
//	}
########## 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ######

	if(!copy($imgmotion,"$savedir/$imgmotion_name")) {
   	error("UPLOAD_COPY_FAILURE");
   	exit;
	}

########## 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ########## 

	if(!unlink($imgmotion)) {
   	error("UPLOAD_DELETE_FAILURE");
   	exit;
	}	
}
###################[imgetc 이미지 저장]##############################

if(($imgetc!="none") && ($imgetc!="")) {

########## 파일이 저장될 자료실의 디렉토리를 설정한다. ##########

	$savedir = "$shop_img";

########## 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. ##########
	
	$full_filename = explode(".", "$imgetc_name");
	$extension = $full_filename[sizeof($full_filename)-1];	   
	$extension = strtolower($extension);	
	if(strcmp($extension,"gif") && strcmp($extension,"jpg") && strcmp($extension,"png")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

########## 등록한 파일명을 자동으로 변경한다. ##########
	
	$imgetc_name = $code . "_etc." . $extension;
	
########## 등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하는지를 검사한다. ########## 
	
//	$same_file_exist = file_exists("$savedir/$imgetc_name");
//	if($same_file_exist) {
//  	error("SAME_FILE_EXIST");
//   	exit;
//	}

########## 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ########## 

	if(!copy($imgetc,"$savedir/$imgetc_name")) {
   	error("UPLOAD_COPY_FAILURE");
  	exit;
	}

########## 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ##### 

	if(!unlink($imgetc)) {
   	error("UPLOAD_DELETE_FAILURE");
   	exit;
	}	
}

########## shop 데이터베이스에 입력값을 삽입한다. ###################

				$query="INSERT INTO $shop_goods";
				$query=$query."(";
				$query=$query."code1,code2,code3,code,title,info,theme,pricec,prices,priced,point,color,size";
				$query=$query.",currnum,warnnum,company,detail,feature,soldout,signdate,new,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5";
				$query=$query.")";
				$query=$query."VALUES";
				$query=$query."(";
				$query=$query."'$code1','$code2','$code3','$code','$title','$info','$theme','$pricec','$prices'";
				$query=$query.",'$priced','$point','$color','$size','$currnum','$warnnum'";
				$query=$query.",'$company','$detail','$feature','N',$signdate,'$new','$option_t1','$option_n1','$option_p1','$option_k1','$option_t2','$option_n2','$option_p2','$option_k2','$option_t3','$option_n3','$option_p3','$option_k3','$option_t4','$option_n4','$option_p4','$option_k4','$option_t5','$option_n5','$option_p5','$option_k5')";


$DB->get($query,$rs,$rn);



//새로운코드로 수정이완료되면 기존건 지운다.

echo("<meta http-equiv='Refresh' content='0; URL=./products.php'>");   
?>
