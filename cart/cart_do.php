<? include "../include/get_balance.php";?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?
$c_ip=$_SERVER["REMOTE_ADDR"];
$c_time=time();

if($pro_n1!=""){
	$c_pro_n=$c_pro_n.$pro_n1.",";
}

if($pro_n2!=""){
	$c_pro_n=$c_pro_n.$pro_n2.",";
}

if($pro_n3!=""){
	$c_pro_n=$c_pro_n.$pro_n3.",";
}

if($pro_n4!=""){
	$c_pro_n=$c_pro_n.$pro_n4.",";
}

if($pro_n5!=""){
	$c_pro_n=$c_pro_n.$pro_n5.",";
}

if($c_text_f=="※ 앞면에 들어갈 내용/메모를 입력해주세요."){
	$c_text_f="";
}

if($c_text_b=="※ 뒷면에 들어갈 내용/메모를 입력해주세요."){
	$c_text_b="";
}

if($c_color=="기타"){
	$c_color=$c_color_text;
}



########## 입력값에 대한 타당성 검사를 수행한다. ####################
$shop_img="../shop_img/";
$savedir = "$shop_img";

#####img1 이미지##################################################
if (strcmp($c_fname,"")){
	$full_filename = explode(".", "$c_fname_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg")	&& 	   strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"PNG") && strcmp($extension,"hwp") && strcmp($extension,"HWP") && strcmp($extension,"ppt") && strcmp($extension,"PPT") && strcmp($extension,"xls") && strcmp($extension,"XLS") && strcmp($extension,"xlsx") && strcmp($extension,"XLSX") && strcmp($extension,"zip") && strcmp($extension,"ZIP") && strcmp($extension,"psd") && strcmp($extension,"PSD") && strcmp($extension,"ai") && strcmp($extension,"AI")) { 
		error("NO_ACCESS_UPLOAD");
		exit;
	}

	##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$File_c_fname=$files . "." . $extension;
	$xxx = $savedir . $File_c_fname;
	$countFileName = 0;
	$bExist=1;
	while (file_exists($xxx)) {
		if (file_exists($xxx)){					
				$countFileName = $countFileName + 1;
				 $File_c_fname = $files . "_" . $countFileName . "." . $extension;
				//$File_c_fname = $full_filename[0] . "_" . $countFileName . "." . $extension;
				$xxx = $savedir . $File_c_fname;
			}
	}		
	################### 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ################## 

	if(!copy($c_fname,"$xxx"))	{
	error("UPLOAD_COPY_FAILURE");
	exit;
	}

	################ 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ################## 
	if(!unlink($c_fname))	{
		error("UPLOAD_DELETE_FAILURE");
		exit;	
	}	
}



$numresults = mysql_query("select count(*) as soo from $shop_cart where c_ip='$c_ip' and c_code='$c_code'");
$row_num = mysql_fetch_array($numresults);
$total_su=$row_num[soo];	

	$query="insert into $shop_cart values ('','$c_time','$c_ip','$c_code','$c_type','$c_hangul','$c_english','$c_homepage','$c_up','$c_ju','$c_color','$c_company','$c_manual','$c_text','$c_option1','$c_option2','$c_option3','$c_option4','$c_option5','$c_option6','$c_option7','$c_amount','$c_form_n','$c_sample','$c_pro_n','$c_text_f','$c_text_b','$File_c_fname','$c_webahrd','$c_talk','$c_hu_name','$c_hu_price')";
	$result = mysql_query($query,$DBconn);

	if(!$result) {
	   error("QUERY_ERROR");
	   exit;
	}



$tmp_url = "cart.php";
echo "<meta http-equiv='Refresh' content='0; URL=$tmp_url'>";
?>