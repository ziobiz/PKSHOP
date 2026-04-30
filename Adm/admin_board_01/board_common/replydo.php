<?
include "../admin/admin_board_01/db_config/dbcon.php";
include "../admin/admin_board_01/error/error.inc";

   IF($keynum>3){//광고글 차단
################# 파일이 저장될 자료실의 디렉토리를 설정한다. 
$savedir = "../admin/admin_board_01/data/";

### 파일1 등록 ####################################################################
if (strcmp($File,"")){

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
}

### 파일 2 등록 #################################################################
if (strcmp($File1,"")){

	############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
	//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	$full_filename = explode(".", "$File1_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"bmp") && strcmp($extension,"txt") && strcmp($extension,"hwp") && strcmp($extension,"doc") && strcmp($extension,"xls") && strcmp($extension,"ppt") && strcmp($extension,"html") && strcmp($extension,"exe") && strcmp($extension,"zip") && strcmp($extension,"rar") && strcmp($extension,"swp") && strcmp($extension,"mov") && strcmp($extension,"asf") && strcmp($extension,"html") && strcmp($extension,"htm") && strcmp($extension,"mp3") && strcmp($extension,"wav") && strcmp($extension,"rm") && strcmp($extension,"wmv") && strcmp($extension,"PDF") && strcmp($extension,"pdf") && strcmp($extension,"ppt") && strcmp($extension,"PPT")){ 
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
	while (file_exists($xxx)) {
		if (file_exists($xxx)){	
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
	   	exit;	
	}	

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
 
$No1;												$Cont_type;
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
//echo $Result."<br>";

$Rs=mysql_fetch_array(mysql_query("select max(No) as No from $DBtable")); 
$No = $Rs[No];
//=============================================================
 
mysql_close($DB); 

if (!$Rs_table){
	echo "<h1>오류발생".$Result."</h1>"; 
}else{
	echo "<meta http-equiv='refresh' content='1;url=board01_view.htm?No=$No&page=$page'>"; 
}


}ELSE{
		echo "<meta http-equiv='refresh' content='0;url=board01_view.php?Sub_No=$Sub_No'>"; 
}
 ?>