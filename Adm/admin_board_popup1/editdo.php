<? 
include "./db_config/dbcon.php";
include "./error/error.inc";

 
################# 파일이 저장될 자료실의 디렉토리를 설정한다. 
$savedir = "./data/";

### 파일 1번 업로드 ########################################################################
if (strcmp($File,"")){
	if($Old_file!=""){
		$img_name = $savedir . $Old_file;
		if(!unlink("$img_name")){
   			error("UPLOAD_DELETE_FAILURE");
   			exit;
		}
	}
	############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
	//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	
	$full_filename = explode(".", "$File_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"bmp")){ 
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
		if(!unlink("$edit_name"))	{
   			error("UPLOAD_DELETE_FAIL");
   			exit;
		}
	$File_name = "";
	$File_size="";

// 파일 저장도 삭제도 하지 않을때
	}else{
	$File_name = $Old_file;
	$File_size=$Old_size;
	}
} 

### 파일2 업로드 ######################################################################
if (strcmp($File1,"")){
	if($Old_file1!=""){
		$img_name2 = $savedir . $Old_file1;
		if(!unlink("$img_name2")){
   			error("UPLOAD_DELETE_FAILURE");
   			exit;
		}
	}
	
	############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
	//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	
	$full_filename = explode(".", "$File1_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") && strcmp($extension,"jpg") && strcmp($extension,"JPG") && strcmp($extension,"png") && strcmp($extension,"bmp")) { 
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
		if(!unlink("$edit_name1"))	{
   			error("UPLOAD_DELETE_FAIL");
   			exit;
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
 $Name=stripslashes($Name);				$P_Name=stripslashes($P_Name);
$P_Link=stripslashes($P_Link);				$Cont=stripslashes($Cont);
$Pass=stripslashes($Pass);
$Cont_type;										$Ip=$REMOTE_ADDR;										

$P_Fname=$File_name;							$P_Fsize=$File_size;

if($P_Link=="http://") {$P_Link="";}

//====================================================================
$Result="update $DBtable set ";
$Result=$Result." Sub_No='$Sub_No'";
$Result=$Result." ,Name='$Name'";
$Result=$Result.",P_Up='$P_Up'";
$Result=$Result.",P_Name='$P_Name'";
$Result=$Result.",P_Location='$P_Location'";
$Result=$Result.",P_Size='$P_Size'";
$Result=$Result.",P_Link='$P_Link'";
$Result=$Result.",P_Target='$P_Target'";
$Result=$Result.",Cont='$Cont'";
$Result=$Result.",P_Fname='$P_Fname'";
$Result=$Result.",P_Fsize='$P_Fsize'";
$Result=$Result.",Ip='$Ip'";
$Result=$Result.",Pass='$Pass'";
$Result=$Result.",Cont_type='$Cont_type' ";
$Result=$Result."where No='$No'";

$Rs_table= mysql_query($Result);
//echo "$Result";	
//=============================================================
 
mysql_close($DB); 

if (!$Rs_table){
	echo "<h1>오류발생".$Result."</h1>"; 
}else{
	echo "<meta http-equiv='refresh' content='1;url=view.php?No=$No&page=$page&Sub_No=$Sub_No'>"; 
}
?>