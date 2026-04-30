<meta charset="utf-8">
<? 
	include "../../Adm/admin_board_01/db_config/dbcon.php";
	include '../../Adm/admin_board_01/htm_config/setting.php';
	include "../../Adm/admin_board_01/error/error.inc";

	
//$imgb1= $_FILES['imgb1']['tmp_name'];
//$imgb1_name = $_FILES['imgb1']['name'];
  ##########POST##########

	$File_name = $_FILES['File']['name'];

	$File_size = $_FILES['File']['size'];
	$File_name1 = $_FILES['File1']['name'];
	$File_size1 = $_FILES['File1']['size'];
	$File = $_FILES['File']['tmp_name'];
	$File1 = $_FILES['File1']['tmp_name'];

	$Sub_No = $_POST['Sub_No'];
	$Name = $_POST['Name'];
	$Title = $_POST['Title'];
	$Email = $_POST['Email'];
	$Homepage = $_POST['Homepage'];
	$B_Title = $_POST['B_Title'];
	$Secret = $_POST['Secret'];
	$P_Target = $_POST['P_Target'];
	$Cont = $_POST['Cont'];
	$P_Fname = $_POST['P_Fname'];
	$P_Fsize = $_POST['P_Fsize'];
	$Cnt = $_POST['Cnt'];
	$Wdate = $_POST['Wdate'];
	$Ip = $_POST['Ip'];
	$Pass = $_POST['Pass'];
	$Cont_type = $_POST['Cont_type'];



  ########################

  ################# 파일이 저장될 자료실의 디렉토리를 설정한다. 
  $savedir = "../../Adm/admin_board_01/data/";



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
 
  ################# 파일이 저장될 자료실의 디렉토리를 설정한다. 
  $savedir = "../../Adm/admin_board_01/data/";


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
 
 if (strcmp($File,"")){
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
	   strcmp($extension,"mp3") && strcmp($extension,"wav")&&strcmp($extension,"rm") && strcmp($extension,"wmv") && strcmp($extension,"PDF") && strcmp($extension,"pdf") && strcmp($extension,"ppt") && strcmp($extension,"PPT") && strcmp($extension,"dwg") && strcmp($extension,"DWG") && strcmp($extension,"XLSX") && strcmp($extension,"xlsx") &&
	   strcmp($extension,"pptx") &&
	   strcmp($extension,"PPTX")) 
	{ 
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
	
################### 등록하려는 파일을 현재 자료실의 지정디렉토리에 저장 ################## 
	
	if(!copy($File,"$xxx"))	{
   	error("UPLOAD_COPY_FAILURE");
   	exit;
	}
  
  ################ 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ################## 
	if(!unlink($File))	{
   	error("UPLOAD_DELETE_FAILURE");
   	exit;	}	

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
		
		$File1=thumbnail($srcFile,$targetFile,$imgsize,$imgsize_h,$img_type); 
	}
}

#################################################

 if (strcmp($File1,"")){
############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	
	$full_filename = explode(".", "$File1_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") 	&& strcmp($extension,"jpg")	&&
	   strcmp($extension,"JPG")&&strcmp($extension,"png") && strcmp($extension,"bmp") &&
	   strcmp($extension,"txt") && strcmp($extension,"hwp")&&strcmp($extension,"doc") && strcmp($extension,"xls") &&
	   strcmp($extension,"ppt") && strcmp($extension,"html")&&strcmp($extension,"exe") && strcmp($extension,"zip") &&	
	   strcmp($extension,"rar") && strcmp($extension,"swp")&&strcmp($extension,"mov") && strcmp($extension,"asf") &&
	   strcmp($extension,"html") && strcmp($extension,"htm") &&
	   strcmp($extension,"mp3") && strcmp($extension,"wav")&&strcmp($extension,"rm") && strcmp($extension,"wmv") && strcmp($extension,"PDF") && strcmp($extension,"pdf") && strcmp($extension,"ppt") && strcmp($extension,"PPT") && strcmp($extension,"dwg") && strcmp($extension,"DWG") && strcmp($extension,"XLSX") && strcmp($extension,"xlsx")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

	
  ##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$File_name1=$files . "." . $extension;
	//echo $File_name1;
	$xxx = $savedir . $File_name1;
	$countFileName = 0;
	$bExist=1;
   while (file_exists($xxx)) 
	 {
     	if (file_exists($xxx))
			{	
				
				$countFileName = $countFileName + 1;
        		 $File_name1 = $files . "_" . $countFileName . "." . $extension;
				//$File_name1 = $full_filename[0] . "_" . $countFileName . "." . $extension;
				$xxx = $savedir . $File_name1;
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
   	exit;	}	

}




 //========단 따음표나 쌍따음표 치환==================================
 $Sub_No=$Sub_No;
 $Name = addslashes($Name);				          
 $Title = addslashes($Title); 
 $Email = addslashes($Email);	
 $Homepage = addslashes($Homepage);	
 $Cont = addslashes($Cont);
 $Cnt="0";											
 $Ip=$REMOTE_ADDR; 
 $Wdate="now()";									
 $Pass = addslashes($Pass);					
 
 $Fname=$File_name;							$Fsize=$File_size;
 $Fname1=$File_name1;							$Fsize1=$File1_size;
 
 
 $No1="0";											$Cont_type;
 $B_Title;											$Secret;	
 if($Homepage=="http://") {$Homepage="";}

//====================================================================
 $Result="insert into $DBtable values";
				$Result=$Result."(";
				$Result=$Result."''"; #no 값이 들어 간다...자동 증가.
				$Result=$Result.",'$Sub_No'";
				$Result=$Result.",'$Name'";
				$Result=$Result.",'$Title'";
				$Result=$Result.",'$Email'";
				$Result=$Result.",'$Homepage'";
				$Result=$Result.",'$Cont'";
				$Result=$Result.",'$Cnt'";
				$Result=$Result.",'$Ip'";
				$Result=$Result.",$Wdate";
				$Result=$Result.",'$Pass'";
				$Result=$Result.",'$Fname'";
				$Result=$Result.",'$Fsize'";
				$Result=$Result.",'$Fname1'";
				$Result=$Result.",'$Fsize1'";
				$Result=$Result.",'$No1'";
				$Result=$Result.",'$Cont_type'";
				$Result=$Result.",'$B_Title'";
				$Result=$Result.",'$Secret'";
				$Result=$Result.")";

				
				$Rs_table= mysql_query($Result);
				//echo "$Result";
				
				//echo $Result."<br>";
					//답변글 No1 값 강제로 넣어준다...No 값으로
				$Result="update $DBtable set No1=No where No1=0";
					//echo $Result;
				$Rs_table= mysql_query($Result);
			
				$Rs=mysql_fetch_array(mysql_query("select max(No) as No from $DBtable")); 
				$No = $Rs[No];

				


				//echo "$No";
//=============================================================

	mysql_close($DB); 

if (!$Rs_table){
		echo "<h1>오류발생".$Result."</h1>"; 
	}else{

		echo "<meta http-equiv='refresh' content='1;url=view.php?No=$No&Sub_No=$Sub_No'>"; 
		exit;
	}




 ?>
