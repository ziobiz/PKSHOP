<?
#####################################################################
include "../common/dbconn.php";
include "../common/user_function.php";
?>
<head>
<title>관리자 모드</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../image/style.css" type="text/css">

<head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?

################# 파일이 저장될 자료실의 디렉토리를 설정한다. 
$savedir = "./data/";

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
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"bmp") && strcmp($extension,"txt") && strcmp($extension,"hwp") && strcmp($extension,"doc") && strcmp($extension,"xls") && strcmp($extension,"ppt") && strcmp($extension,"html") && strcmp($extension,"exe") && strcmp($extension,"zip") && strcmp($extension,"rar") && strcmp($extension,"swp") && strcmp($extension,"mov") && strcmp($extension,"asf") && strcmp($extension,"html") && strcmp($extension,"htm") && strcmp($extension,"mp3") && strcmp($extension,"wav") && strcmp($extension,"rm") && strcmp($extension,"wmv") && strcmp($extension,"PDF") && strcmp($extension,"pdf") && strcmp($extension,"ppt") && strcmp($extension,"PPT")){ 
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
}else {  //	파일은 저장하지 않고 이전 파일 삭제시~
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

$jumin = $Birth_year ."-". $Birth_month ."-". $Birth_day;

$Fname=$File_name;


//데이터베이스에 입력값을 삽입한다
	$query = "UPDATE $member_p SET ";
	$query = $query . "id='$id',name='$name',jumin='$jumin',sex='$sex',email='$email',handphone='$handphone',zip='$zipcorde',address='$address',info='$info',Fname='$Fname',admail='$admail',adsms='$adsms'";
	$query = $query . " WHERE no = '$no'";
	//echo "$query";
	//exit;
	//no,id,name,jumin,sex,email,handphone,zip,address,info,signdate,Fname,admail,adsms
$DB->get($query,$rs,$rn);
if($result) {



// 리스트 출력화면으로 이동한다
	$encoded_key = urlencode($key);
	echo("<meta http-equiv='Refresh' content='0; URL=member.php?keyfield=$keyfield&key=$encoded_key&page=$page&id=$id'>");   
} else {
   	error("QUERY_ERROR");
	exit;
}


?>
