<?php
// default redirection
$url = $_REQUEST["callback"].'?callback_func='.$_REQUEST["callback_func"];

##########파일 전송전 temp화일을 크기 변환 후 업로드###############
include '../../../htm_config/setting.php';

function thumbnail($file, $save_filename, $max_width, $max_height, $type)
{		
		global $quality_gm;
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
			ImageJPEG($dst_img,  $save_filename,$quality_gm); //실제로 이미지파일을 생성합니다
			break;
		case "png":
			ImagePNG($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다
			break;
		case "bmp":
			ImageBMP($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다
			break;
		}
		
		$Files=$save_filename;

        ImageDestroy($dst_img);
        ImageDestroy($src_img);
}

if(is_uploaded_file($_FILES['Filedata']['tmp_name']) && ($_FILES['Filedata']['size'] > 0)) {
	$srcFile=$_FILES['Filedata']['tmp_name']; //서버 임시폴더에 저장된 이미지화일을 원본으로 사용
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
			goBack('GIF,JPG,PNG 확장자가 업로드 가능합니다.');
		break;
	}
	//1 = gif, 2 = jpg, 3 = png, 4 = swf, 5 = psd, 6 = bmp

	$imgsize = (int)$_POST['imgsize']; //새로 입력한 이미지 가로 사이즈
	$imgsize=$imgsize ? $imgsize : $U_width_gm; //새로 입력한 사이즈가 없으면 setting.php에 정한 크기로
	
	if($imgsize<$img_width) {//입력한 사이즈가 원본보다 작으면
		
		$imgsize_h=($img_height*$imgsize)/$img_width; //높이크기 계산

		$dst_width=$max_width;
		$dst_height=$max_height;
		thumbnail($srcFile,$targetFile,$imgsize,$imgsize_h,$img_type); 
	}else{
		//입력한 사이즈가 원본보다 크면 사이즈조절 작업 없음
	}
}

#################################################


if(is_uploaded_file($_FILES['Filedata']['tmp_name']) && ($_FILES['Filedata']['size'] > 0)) {
	$srcFile_k=$_FILES['Filedata']['tmp_name']; //서버 임시폴더에 저장된 이미지화일을 원본으로 사용
	$img_info_k = getImageSize($srcFile_k);//원본이미지의 정보를 얻어옵니다
	$img_width_k = $img_info_k[0];
	$img_height_k = $img_info_k[1];
}
#################################################


$bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);

// SUCCESSFUL
if(bSuccessUpload) {
	$tmp_name = $_FILES['Filedata']['tmp_name'];
	$name = $_FILES['Filedata']['name'];
	$filename_ext = strtolower(array_pop(explode('.',$name)));
	$allow_file = array("jpg", "png", "bmp", "gif");

	if(!in_array($filename_ext, $allow_file)) {
		$url .= '&errstr='.$name;
	} else {
		$uploadDir = '../../../data/';

		if(!is_dir($uploadDir)){
			mkdir($uploadDir, 0777);
		}
		

$File_name = $name;

$savedir = $uploadDir;

 ############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	
	$full_filename = explode(".", "$File_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") 	&& strcmp($extension,"jpg")	&&
	   strcmp($extension,"JPG")&&strcmp($extension,"png") && strcmp($extension,"bmp") &&
	   strcmp($extension,"txt") && strcmp($extension,"hwp")&&strcmp($extension,"doc") && strcmp($extension,"xls") &&
	   strcmp($extension,"ppt") && strcmp($extension,"html")&&strcmp($extension,"exe") && strcmp($extension,"zip") &&	
	   strcmp($extension,"rar") && strcmp($extension,"swp")&&strcmp($extension,"mov") && strcmp($extension,"asf") &&
	   strcmp($extension,"html") && strcmp($extension,"htm") &&
	   strcmp($extension,"mp3") && strcmp($extension,"wav")&&strcmp($extension,"rm") && strcmp($extension,"wmv") && strcmp($extension,"PDF") && strcmp($extension,"pdf") && strcmp($extension,"ppt") && strcmp($extension,"PPT")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

	
  ##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	//$files= rand(10000,100000000);
	$files= mktime();
	$File_name=$files . "." . $extension;
	//echo $File_name;
	$xxx = $savedir . $File_name;
	$countFileName = 0;
	$bExist=1;
   while (file_exists($xxx)) 
	 {
     	if (file_exists($xxx))
			{	
				
				$countFileName = $countFileName + 1;
        		 $File_name = $files . "_" . $countFileName . "." . $extension;
				//$File_name = $full_filename[0] . "_" . $countFileName . "." . $extension;
				$xxx = $savedir . $File_name;
			}
	}	

$name = $File_name;








		$newPath = $uploadDir.urlencode($name);
		
		@move_uploaded_file($tmp_name, $newPath);
		
		$url .= "&bNewLine=true";
		if($U_width_gm!="" && $img_width_k!=""){
			$url .= "&sWidth=".$U_width_gm;//기준 
			$url .= "&fWidth=".$img_width_k;//파일사이즈
		}
		$url .= "&sFileName=".urlencode(urlencode($name));
		$url .= "&sFileURL=/Adm/admin_board_01/data/".urlencode(urlencode($name));
	}
}
// FAILED
else {
	$url .= '&errstr=error';
}
	
header('Location: '. $url);
?>