<meta charset="utf-8">
<? 
	include "./db_config/dbcon.php";
	include "./error/error.inc";
  ##########POST##########

	$File_name = $_FILES['File']['name'];

	$File_size = $_FILES['File']['size'];
	$File_name1 = $_FILES['File1']['name'];
	$File_size1 = $_FILES['File1']['size'];
	$File = $_FILES['File']['tmp_name'];
	$File1 = $_FILES['File1']['tmp_name'];

	$Sub_No = $_POST['Sub_No'];
	$Name = $_POST['Name'];
	$P_Up = $_POST['P_Up'];
	$P_Name = $_POST['P_Name'];
	$P_Location = $_POST['P_Location'];
	$P_Size = $_POST['P_Size'];
	$P_Link = $_POST['P_Link'];
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
  $savedir = "./data/";

 IF($keynum>3){//광고글 차단

 if (strcmp($File,"")){
############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	
	$full_filename = explode(".", "$File_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") 	&& strcmp($extension,"jpg")	&&
	   strcmp($extension,"JPG")&&strcmp($extension,"png") && strcmp($extension,"bmp")) 
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


 if (strcmp($File1,"")){
############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	
	$full_filename = explode(".", "$File1_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") 	&& strcmp($extension,"jpg")	&&
	   strcmp($extension,"JPG")&&strcmp($extension,"png") && strcmp($extension,"bmp")) 
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
 $Name=stripslashes($Name);				$P_Name=stripslashes($P_Name);
$P_Link=stripslashes($P_Link);				$Cont=stripslashes($Cont);
$Pass=stripslashes($Pass);
 $Cnt="0";											
 $Ip=$REMOTE_ADDR; 
 $Wdate="now()";									
 $Pass = addslashes($Pass);					

 $P_Fname=$File_name;							$P_Fsize=$File_size;
 
 $Cont_type;											$P_Up;	
 if($P_Link=="http://") {$P_Link="";}

//====================================================================
 $Result="insert into $DBtable values";
				$Result=$Result."(";
				$Result=$Result."''"; #no 값이 들어 간다...자동 증가.
				$Result=$Result.",'$Sub_No'";
				$Result=$Result.",'$Name'";
				$Result=$Result.",'$P_Up'";
				$Result=$Result.",'$P_Name'";
				$Result=$Result.",'$P_Location'";
				$Result=$Result.",'$P_Size'";
				$Result=$Result.",'$P_Link'";
				$Result=$Result.",'$P_Target'";
				$Result=$Result.",'$Cont'";
				$Result=$Result.",'$P_Fname'";
				$Result=$Result.",'$P_Fsize'";
				$Result=$Result.",'$Cnt'";
				$Result=$Result.",'$Ip'";
				$Result=$Result.",$Wdate";
				$Result=$Result.",'$Pass'";
				$Result=$Result.",'$Cont_type'";
				$Result=$Result.")";

				
				$Rs_table= mysql_query($Result);
				//echo "$Result";
				
				$Rs=mysql_fetch_array(mysql_query("select max(No) as No from $DBtable")); 
				$No = $Rs[No];

				//echo "$No";
//=============================================================
 
	mysql_close($DB); 

if (!$Rs_table){
		echo "<h1>오류발생".$Result."</h1>"; 
	}else{
		echo "<meta http-equiv='refresh' content='1;url=list.php?No=$No&Sub_No=$Sub_No'>"; 
	}



}ELSE{
		echo "<meta http-equiv='refresh' content='0;url=list.php?Sub_No=$Sub_No'>"; 
}
 ?>
