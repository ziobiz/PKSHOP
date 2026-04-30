<? 
include "../common/dbconn.php";
include "./db_config/dbcon.php";
include './htm_config/setting.php';
include "./error/error.inc";

function thumbnail($file, $save_filename, $max_width, $max_height, $type)
{		
		global $quality;
		//ini_set('memory_limit',-1);
		switch ($type){
			case "gif":
				$src_img = ImageCreateFromGif($file); //GIF파일로부터 이미지를 읽어옵니다
			break;
			case "jpg":
				$src_img = ImageCreateFromJPEG($file); //JPG파일로부터 이미지를 읽어옵니다
			break;
			case "png":
				$src_img = ImageCreateFromPNG($file); //PNG파일로부터 이미지를 읽어옵니다
			break;
			case "bmp":
				$src_img = ImageCreateFromBMP($file); //BMP파일로부터 이미지를 읽어옵니다
			break;
		}

        $img_info = getImageSize($file);//원본이미지의 정보를 얻어옵니다
        $img_width = $img_info[0];
        $img_height = $img_info[1];
 
        if(($img_width/$max_width) == ($img_height/$max_height))
        {//원본과 썸네일의 가로세로비율이 같은경우
            $dst_width=$max_width;
            $dst_height=$max_height;
        }
        elseif(($img_width/$max_width) < ($img_height/$max_height))
        {//세로에 기준을 둔경우
            $dst_width=$max_height*($img_width/$img_height);
            $dst_height=$max_height;
        }
        else{//가로에 기준을 둔경우
            $dst_width=$max_width;
            $dst_height=$max_width*($img_height/$img_width);
        }//그림사이즈를 비교해 원하는 썸네일 크기이하로 가로세로 크기를 설정합니다.
 
        $dst_img = imagecreatetruecolor($dst_width, $dst_height); //타겟이미지를 생성합니다
 
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $img_width, $img_height); //타겟이미지에 원하는 사이즈의 이미지를 저장합니다
 
        ImageInterlace($dst_img);
		switch($type){
			case "gif":
			 ImageGif($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다
			break;
		case "jpg":
			ImageJPEG($dst_img,  $save_filename,$quality); //실제로 이미지파일을 생성합니다
			break;
		case "png":
			ImagePNG($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다
			break;
		case "bmp":
			ImageBMP($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다
			break;
		}

        ImageDestroy($dst_img);
        ImageDestroy($src_img);

		return $save_filename;
}
#################################################

############## gmEditor 본문 내용 비교용 ###############
$Result = "select Cont from $DBtable where No=$No"; 
$Board_d=mysql_fetch_array(mysql_query($Result));
$Cont_b=$Board_d[Cont];	//수정전 Cont

$pattern="/\d+.img.gm/";
preg_match_all($pattern,$Cont_b,$matches);
foreach ($matches as $value){
	$value_b=$value;
}

############################################
 
################# 파일이 저장될 자료실의 디렉토리를 설정한다. 
$savedir = "./data/";

#############이미지 사이즈 변환1#########################
if($File) {
	$srcFile=$File; //서버 임시폴더에 저장된 이미지화일을 원본으로 사용

	$targetFile=$srcFile; //서버임시폴더에 저장된 이미지를 사이즈를 줄인 이미지로 그냥 덮어씀

	$img_info = getImageSize($srcFile);//원본이미지의 정보를 얻어옵니다
	$img_width = $img_info[0];
	$img_height = $img_info[1];
	switch ($img_info[2]){
		case 1:
			$img_type="gif";
			break;
		case 2:
			$img_type="jpg";
			break;
		case 3:
			$img_type="png";
			break;
		/*
		case 6:
			$img_type="bmp";
			break;
		*/
		default :
			$img_type="No_Img";
		break;
	}
	//1 = gif, 2 = jpg, 3 = png, 4 = swf, 5 = psd, 6 = bmp
    if($img_type!="No_Img"){
	$imgsize=$U_width ? $U_width : $img_width; //새로운 이미지 사이즈600으로
	if($imgsize>$img_width) $imgsize=$img_width; //입력한 사이즈가 원본보다 크면 원본사이즈 크기로
		
	$imgsize_h=($img_height*$imgsize)/$img_width; //높이크기 계산

	$dst_width=$max_width;
	$dst_height=$max_height;

		$File=thumbnail($srcFile,$targetFile,$imgsize,$imgsize_h,$img_type); 
	}
}

#################################################

### 파일 1번 업로드 ########################################################################
if (strcmp($File,"")){
	if($Old_file!=""){
		$img_name = $savedir . $Old_file;
		$img_exist = file_exists("$img_name");
		if($img_exist){
			if(!unlink("$img_name")){
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}
	}
	############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
	//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	
	$full_filename = explode(".", "$File_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"bmp") && strcmp($extension,"txt") && strcmp($extension,"hwp") && strcmp($extension,"doc") && strcmp($extension,"xls") && strcmp($extension,"ppt") && strcmp($extension,"html") && strcmp($extension,"exe") && strcmp($extension,"zip") && strcmp($extension,"rar") && strcmp($extension,"swp") && strcmp($extension,"mov") && strcmp($extension,"asf") && strcmp($extension,"html") && strcmp($extension,"htm") && strcmp($extension,"mp3") && strcmp($extension,"wav") && strcmp($extension,"rm") && strcmp($extension,"wmv") && strcmp($extension,"PDF") && strcmp($extension,"pdf") && strcmp($extension,"ppt") && strcmp($extension,"PPT") && strcmp($extension,"dwg") && strcmp($extension,"DWG") && strcmp($extension,"XLSX") && strcmp($extension,"xlsx")&&
	   strcmp($extension,"pptx") &&
	   strcmp($extension,"PPTX")){ 
	   	error("NO_ACCESS_UPLOAD");
   		exit;
	}

	##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$File_name=$files . "." . $extension;
	//echo $File_name;
	$xxx = $savedir . $File_name;
	$countFileName = 0;
	$bExist=1;
	while (file_exists($xxx)){
		if (file_exists($xxx)){	
			$countFileName = $countFileName + 1;
        	$File_name = $files . "_" . $countFileName . "." . $extension;
			//$File_name = $full_filename[0] . "_" . $countFileName . "." . $extension;
			$xxx = $savedir . $File_name;
		}
	}	
	
	################### 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ################## 	
	if(!copy($File,"$xxx"))	{
	   	error("UPLOAD_COPY_FAILURE");
   		exit;
	}
  
	################ 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ################## 
	if(!unlink($File))	{
   		error("UPLOAD_DELETE_FAILURE");
   		exit;	
	}	
}else {  
//	파일은 저장하지 않고 이전 파일 삭제시~
	if($F_del=="0"){
		$edit_name = $savedir . $Old_file;
		$img_edit_exist = file_exists("$edit_name");
		if($img_edit_exist){
			if(!unlink("$edit_name"))	{
				error("UPLOAD_DELETE_FAIL");
				exit;
			}
		}
	$File_name = "";
	$File_size="";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$File_name = $Old_file;
	$File_size=$Old_size;
	}
} 

#############이미지 사이즈 변환2#########################
if($File1) {
	$srcFile=$File1; //서버 임시폴더에 저장된 이미지화일을 원본으로 사용

	$targetFile=$srcFile; //서버임시폴더에 저장된 이미지를 사이즈를 줄인 이미지로 그냥 덮어씀

	$img_info = getImageSize($srcFile);//원본이미지의 정보를 얻어옵니다
	$img_width = $img_info[0];
	$img_height = $img_info[1];
	switch ($img_info[2]){
		case 1:
			$img_type="gif";
			break;
		case 2:
			$img_type="jpg";
			break;
		case 3:
			$img_type="png";
			break;
		case 6:
			$img_type="bmp";
			break;
		default :
			$img_type="No_Img";
		break;
	}
	//1 = gif, 2 = jpg, 3 = png, 4 = swf, 5 = psd, 6 = bmp
    if($img_type!="No_Img"){
	$imgsize=$U_width ? $U_width : $img_width; //새로운 이미지 사이즈600으로
	if($imgsize>$img_width) $imgsize=$img_width; //입력한 사이즈가 원본보다 크면 원본사이즈 크기로
		
	$imgsize_h=($img_height*$imgsize)/$img_width; //높이크기 계산

	$dst_width=$max_width;
	$dst_height=$max_height;

		$File1=thumbnail($srcFile,$targetFile,$imgsize,$imgsize_h,$img_type); 
	}
}

#################################################

### 파일2 업로드 ######################################################################
if (strcmp($File1,"")){
	if($Old_file1!=""){
		$img_name2 = $savedir . $Old_file1;
		$img_exist2 = file_exists("$img_name2");
		if($img_exist2){
			if(!unlink("$img_name2")){
				error("UPLOAD_DELETE_FAILURE");
				exit;
			}
		}
	}

	
	############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
	//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	
	$full_filename = explode(".", "$File1_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"bmp") && strcmp($extension,"txt") && strcmp($extension,"hwp") && strcmp($extension,"doc") && strcmp($extension,"xls") && strcmp($extension,"ppt") && strcmp($extension,"html") && strcmp($extension,"exe") && strcmp($extension,"zip") && strcmp($extension,"rar") && strcmp($extension,"swp") && strcmp($extension,"mov") && strcmp($extension,"asf") && strcmp($extension,"html") && strcmp($extension,"htm") && strcmp($extension,"mp3") && strcmp($extension,"wav") && strcmp($extension,"rm") && strcmp($extension,"wmv") && strcmp($extension,"PDF") && strcmp($extension,"pdf") && strcmp($extension,"ppt") && strcmp($extension,"PPT") && strcmp($extension,"dwg") && strcmp($extension,"DWG") && strcmp($extension,"XLSX") && strcmp($extension,"xlsx")) { 
   		error("NO_ACCESS_UPLOAD");
   		exit;
	}
	
	##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$File1_name=$files . "." . $extension;
	//echo $File1_name;
	$xxx = $savedir . $File1_name;
	$countFileName = 0;
	$bExist=1;
	while (file_exists($xxx)){
		if (file_exists($xxx)){	
			$countFileName = $countFileName + 1;
        	$File1_name = $files . "_" . $countFileName . "." . $extension;
			//$File1_name = $full_filename[0] . "_" . $countFileName . "." . $extension;
			$xxx = $savedir . $File1_name;
		}
	}	
	
	################### 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ################## 
	if(!copy($File1,"$xxx"))	{
   		error("UPLOAD_COPY_FAILURE");
   		exit;
	}
  
	################ 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ################## 
	if(!unlink($File1))	{
   		error("UPLOAD_DELETE_FAILURE");
   		exit;	
	}	
}else {  //	파일은 저장하지 않고 이전 파일 삭제시~
	if($F1_del=="0"){
		$edit_name1 = $savedir . $Old_file1;
		$img_edit_exist1 = file_exists("$edit_name1");
		if($img_edit_exist1){
			if(!unlink("$edit_name1"))	{
				error("UPLOAD_DELETE_FAIL");
				exit;
			}
		}

	$File1_name = "";
	$File1_size="";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$File1_name = $Old_file1;
	$File1_size=$Old_size1;
	}
} 


//========단 따음표나 쌍따음표 치환==================================	
$Name = addslashes($Name);				$Pass = addslashes($Pass);
$Email=addslashes($Email);				$Homepage = addslashes($Homepage);
$Title = addslashes($Title);					$Cont = addslashes($Cont);
$Cont_type;										$Ip=$REMOTE_ADDR;										

$Fname=$File_name;							$Fsize=$File_size;
$Fname1=$File1_name;						$Fsize1=$File1_size;

if($Homepage=="http://") {$Homepage="";}


//====================================================================
$Result="update $DBtable set ";
$Result=$Result." Sub_No='$Sub_No'";
$Result=$Result." ,Name='$Name'";
$Result=$Result.",Pass='$Pass'";
$Result=$Result.",Email='$Email'";
$Result=$Result.",Homepage='$Homepage'";
$Result=$Result.",Title='$Title'";
$Result=$Result.",Cont='$Cont'";
$Result=$Result.",Cont_type='$Cont_type'";
$Result=$Result.",Ip='$Ip'";
$Result=$Result.",Pass='$Pass'";
$Result=$Result.",Fname='$Fname'";
$Result=$Result.",Fsize='$Fsize'";
$Result=$Result.",Fname1='$Fname1'";
$Result=$Result.",Fsize1='$Fsize1'";
$Result=$Result.",B_Title='$B_Title' ";
$Result=$Result.",Secret='$Secret' ";
$Result=$Result."where No='$No'";

$Rs_table= mysql_query($Result);
//echo "$Result";	
//=============================================================
 
#########gmEditor본문에서 이미지 삭제시 data폴더 이미지도 삭제########
$pattern="/\d+.img.gm/";
preg_match_all($pattern,$Cont,$matches); //수정 후 Cont
foreach ($matches as $value){
	$value_a=$value;
}

$arr_del=array_diff($value_b, $value_a);
foreach ($arr_del as $Dname){
		$savedir = "./data/";
		$img_name = $savedir . $Dname;
		$img_name_exist = file_exists("$img_name");
		if($img_name_exist){
			if(!unlink("$img_name")){
				error("UPLOAD_DELETE_FAILURE");
				exit;
		}
	}
}
#############################################

mysql_close($DB); 

if (!$Rs_table){
	echo "<h1>오류발생".$Result."</h1>"; 
}else{
	echo "<meta http-equiv='refresh' content='1;url=view.php?No=$No&page=$page&Sub_No=$Sub_No'>"; 
}
?>