
<?

// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

include "../common/dbconn.php";

###############FILE###############

	$imgb1 = $_FILES['imgb1']['tmp_name'];
	$imgb1_name = $_FILES['imgb1']['name'];
	$imgb1_size = $_FILES['imgb1']['size'];
	$imgb2 = $_FILES['imgb2']['tmp_name'];
	$imgb2_name = $_FILES['imgb2']['name'];
	$imgb2_size = $_FILES['imgb2']['size'];
	$imgb3 = $_FILES['imgb3']['tmp_name'];
	$imgb3_name = $_FILES['imgb3']['name'];
	$imgb3_size = $_FILES['imgb3']['size'];
	$imgb4 = $_FILES['imgb4']['tmp_name'];
	$imgb4_name = $_FILES['imgb4']['name'];
	$imgb4_size = $_FILES['imgb4']['size'];
	$imgb5 = $_FILES['imgb5']['tmp_name'];
	$imgb5_name = $_FILES['imgb5']['name'];
	$imgb5_size = $_FILES['imgb5']['size'];
	
	
	$title		= $_POST["title"];
	$info		= $_POST["info"];
	$detail		= $_POST["detail"];
	$company	= $_POST["company"];
	$home		= $_POST["home"];
	$shelf		= $_POST["shelf"];
	$feature	= $_POST["feature"];
	$code1		=$_POST["code1"];
	$code2		=$_POST["code2"];
	$code3		=$_POST["code3"];
	$code		=$_POST["code"];
    $color		=$_POST["color"];
	$size		=$_POST["size"];
	$theme		=$_POST["theme"];
	$event		=$_POST["event"];
	$event_str	=$_POST["event_str"];
	$new		=$_POST["new"];
	$pricec		=$_POST["pricec"];
	$prices		=$_POST["prices"];
	$priced		=$_POST["priced"];
	$coin		=$_POST["coin"];
	$pr_kind	=$_POST["pr_kind"];
	$point		=$_POST["point"];
	$point_dis	=$_POST["point_dis"];
	$currnum	=$_POST["currnum"];
	$warnnum	=$_POST["warnnum"];
	$imgl		=$_POST["imgl"];
	$dis		=$_POST["dis"];
	$fee		=$_POST["fee"];
	$c_pv		=$_POST["c_pv"];
	$country		=$_POST["country"];
	$onlypoint		=$_POST["onlypoint"];
	$imgm=$_POST["imgm"]; $soldout=$_POST["soldout"]; $rank=$_POST["rank"]; $option_t1=$_POST["option_t1"]; $option_n1=$_POST["option_n1"]; $option_p1=$_POST["option_p1"]; $option_k1=$_POST["option_k1"]; $option_t2=$_POST["option_t2"]; $option_n2=$_POST["option_n2"]; $option_p2=$_POST["option_p2"]; $option_k2=$_POST["option_k2"]; 
	$option_t3=$_POST["option_t3"]; $option_n3=$_POST["option_n3"]; $option_p3=$_POST["option_p3"]; $option_k3=$_POST["option_k3"]; 
	$option_t4=$_POST["option_t4"]; $option_n4=$_POST["option_n4"]; $option_p4=$_POST["option_p4"]; $option_k4=$_POST["option_k4"]; 
	$option_t5=$_POST["option_t5"]; $option_n5=$_POST["option_n5"]; $option_p5=$_POST["option_p5"]; $option_k5=$_POST["option_k5"]; 
	$order1=$_POST["order1"]; $order2=$_POST["order2"]; $order3=$_POST["order3"]; $color_opt=$_POST["color_opt"]; 
	$size_opt=$_POST["size_opt"]; $add_opt1=$_POST["add_opt1"]; $add_opt2=$_POST["add_opt2"]; $add_opt3=$_POST["add_opt3"]; 
	$add_opt4=$_POST["add_opt4"]; $add_opt5=$_POST["add_opt5"]; $relation=$_POST["relation"]; $price_dis=$_POST["price_dis"]; 
	$best=$_POST["best"]; $cut=$_POST["cut"]; $recommend=$_POST["recommend"]; $theme_g=$_POST["theme_g"]; $theme_n=$_POST["theme_n"]; 
	$theme_r=$_POST["theme_r"]; $theme_f=$_POST["theme_f"]; $theme_x=$_POST["theme_x"]; $theme_y=$_POST["theme_y"]; $theme_z=$_POST["theme_z"]; $rank_g=$_POST["rank_g"]; $rank_n=$_POST["rank_n"]; $rank_r=$_POST["rank_r"]; $rank_f=$_POST["rank_f"]; $rank_x=$_POST["rank_x"]; $rank_y=$_POST["rank_y"]; $rank_z=$_POST["rank_z"]; $opt_num=$_POST["opt_num"]; $opt_num_str=$_POST["opt_num_str"]; $theme_s=$_POST["theme_s"]; $rank_s=$_POST["rank_s"]; $code4=$_POST["code4"];$order4=$_POST["order4"]; $p_id=$_POST["p_id"];
#################################

$title = trim($title);
$title = addslashes($title);
$info = addslashes($info);
$detail = addslashes($detail);
$company = addslashes($company);
$home = addslashes($home);
$shelf = addslashes($shelf);
$feature = addslashes($feature);

########## 입력값에 대한 타당성 검사를 수행한다. ####################

include "../common/user_function.php";
$shop_img="../../upload/";
$signdate = time();
$esigndate = time();
$savedir = "$shop_img";
########## 데이터베이스에 연결한다. #################################

########## 새로운 상품의 중복을 결정한다. ###########################
$imgl = $_FILES['imgl']['tmp_name'];
$imgl_name = $_FILES['imgl']['name'];
$imgl_size = $_FILES['imgl']['size'];

#####리스트 이미지##################################################
if (strcmp($imgl,"")){
	$full_filename = explode(".", "$imgl_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") 	&& strcmp($extension,"jpg")	&&
	   strcmp($extension,"JPG")&&strcmp($extension,"png") && strcmp($extension,"PNG")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

	
  ##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$File_namel=$files . "." . $extension;
	//echo $File_name1;
	$xxx = $savedir . $File_namel;
	$countFileName = 0;
	$bExist=1;
   while (file_exists($xxx)) 
	 {
     	if (file_exists($xxx))
			{	
				
				$countFileName = $countFileName + 1;
        		 $File_namel = $files . "_" . $countFileName . "." . $extension;
				//$File_name1 = $full_filename[0] . "_" . $countFileName . "." . $extension;
				$xxx = $savedir . $File_namel;
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
   	exit;	}	

}
$imgm = $_FILES['imgm']['tmp_name'];
$imgm_name = $_FILES['imgm']['name'];
$imgm_size = $_FILES['imgm']['size'];
#####중간 이미지##################################################
if (strcmp($imgm,"")){
	$full_filename = explode(".", "$imgm_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") 	&& strcmp($extension,"jpg")	&&
	   strcmp($extension,"JPG")&&strcmp($extension,"png") && strcmp($extension,"PNG")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

	
  ##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$File_namem=$files . "." . $extension;
	//echo $File_name1;
	$xxx = $savedir . $File_namem;
	$countFileName = 0;
	$bExist=1;
   while (file_exists($xxx)) 
	 {
     	if (file_exists($xxx))
			{	
				
				$countFileName = $countFileName + 1;
        		 $File_namel = $files . "_" . $countFileName . "." . $extension;
				//$File_name1 = $full_filename[0] . "_" . $countFileName . "." . $extension;
				$xxx = $savedir . $File_namel;
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
   	exit;	}	

}


#####상세 이미지1##################################################
 if (strcmp($imgb1,"")){

############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	$full_filename = explode(".", "$imgb1_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") 	&& strcmp($extension,"jpg")	&&
	   strcmp($extension,"JPG")&&strcmp($extension,"png") && strcmp($extension,"PNG")) 
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
	
	if(!copy($imgb1,"$xxx"))	{
   	error("UPLOAD_COPY_FAILURE");
   	exit;
	}
  
  ################ 작업이 끝난후 임시디렉토리에 저장된 파일을 삭제한다. ################## 
	if(!unlink($imgb1))	{
   	error("UPLOAD_DELETE_FAILURE");
   	exit;	}	

}

#####상세 이미지2##################################################
 if (strcmp($imgb2,"")){

############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	$full_filename = explode(".", "$imgb2_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") 	&& strcmp($extension,"jpg")	&&
	   strcmp($extension,"JPG")&&strcmp($extension,"png") && strcmp($extension,"PNG")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

	
  ##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$File_name2=$files . "." . $extension;
	//echo $File_name1;
	$xxx = $savedir . $File_name2;
	$countFileName = 0;
	$bExist=1;
   while (file_exists($xxx)) 
	 {
     	if (file_exists($xxx))
			{	
				
				$countFileName = $countFileName + 1;
        		 $File_name2 = $files . "_" . $countFileName . "." . $extension;
				//$File_name1 = $full_filename[0] . "_" . $countFileName . "." . $extension;
				$xxx = $savedir . $File_name2;
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
   	exit;	}	

}

#####상세 이미지3##################################################
 if (strcmp($imgb3,"")){
############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	$full_filename = explode(".", "$imgb3_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") 	&& strcmp($extension,"jpg")	&&
	   strcmp($extension,"JPG")&&strcmp($extension,"png") && strcmp($extension,"PNG")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

	
  ##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$File_name3=$files . "." . $extension;
	//echo $File_name1;
	$xxx = $savedir . $File_name3;
	$countFileName = 0;
	$bExist=1;
   while (file_exists($xxx)) 
	 {
     	if (file_exists($xxx))
			{	
				
				$countFileName = $countFileName + 1;
        		 $File_name3 = $files . "_" . $countFileName . "." . $extension;
				//$File_name1 = $full_filename[0] . "_" . $countFileName . "." . $extension;
				$xxx = $savedir . $File_name3;
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
   	exit;	}	

}

#####상세 이미지4##################################################
 if (strcmp($imgb4,"")){
############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	$full_filename = explode(".", "$imgb4_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") 	&& strcmp($extension,"jpg")	&&
	   strcmp($extension,"JPG")&&strcmp($extension,"png") && strcmp($extension,"PNG")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

	
  ##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$File_name4=$files . "." . $extension;
	//echo $File_name1;
	$xxx = $savedir . $File_name4;
	$countFileName = 0;
	$bExist=1;
   while (file_exists($xxx)) 
	 {
     	if (file_exists($xxx))
			{	
				
				$countFileName = $countFileName + 1;
        		 $File_name4 = $files . "_" . $countFileName . "." . $extension;
				//$File_name1 = $full_filename[0] . "_" . $countFileName . "." . $extension;
				$xxx = $savedir . $File_name4;
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
   	exit;	}	

}

#####상세 이미지5##################################################
 if (strcmp($imgb5,"")){
############# 등록한 파일이 업로드가 허용되지 않는 확장자를 갖는 파일인지를 검사한다. #########
//$c = expode(a,$v) a문자를 기준으로 분리된 문자열들이 배열 $c에 저장
	$full_filename = explode(".", "$imgb5_name");
	$extension = $full_filename[sizeof($full_filename)-1];	
	$extension = strtolower($extension);	
	//echo"$extension";
	if(strcmp($extension,"gif") && strcmp($extension,"GIF") 	&& strcmp($extension,"jpg")	&&
	   strcmp($extension,"JPG")&&strcmp($extension,"png") && strcmp($extension,"PNG")) 
	{ 
   	error("NO_ACCESS_UPLOAD");
   	exit;
	}

	
  ##등록하려는 파일과 동일한 이름을 갖는 파일이 이미 존재하면 등록한 파일명을 자동으로 변경한다. 
	$files= rand(10000,100000000);
	$File_name5=$files . "." . $extension;
	//echo $File_name1;
	$xxx = $savedir . $File_name5;
	$countFileName = 0;
	$bExist=1;
   while (file_exists($xxx)) 
	 {
     	if (file_exists($xxx))
			{	
				
				$countFileName = $countFileName + 1;
        		 $File_name5 = $files . "_" . $countFileName . "." . $extension;
				//$File_name1 = $full_filename[0] . "_" . $countFileName . "." . $extension;
				$xxx = $savedir . $File_name5;
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
   	exit;	}	

}

$imgl=$File_namel;			$imgm=$File_namem;
$imgb1=$File_name1;		$imgb2=$File_name2;
$imgb3=$File_name3;		$imgb4=$File_name4;
$imgb5=$File_name5;



#################################################
//$theme=$theme_g.",".$theme_r.",".$theme_n.",".$theme_b.",".$theme_p;
//$event=$event1.",".$event2.",".$event3.",".$event4.",".$event5;
//$event_str=$event1_str.",".$event2_str.",".$event3_str.",".$event4_str.",".$event5_str;

$order1=="" ? $order1=99999 : $order1=$order1;
$order2=="" ? $order2=99999 : $order2=$order2;
$order3=="" ? $order3=99999 : $order3=$order3;



$relation = $relation1."-".$relation2."-".$relation3."-".$relation4;

/*if($imgl_copy !="" && $imgl=="") $imgl = $imgl_copy;
if($imgm_copy !="" && $imgm=="") $imgm = $imgm_copy;
if($imgb1_copy !="" && $imgb1=="") $imgb1 = $imgb1_copy;
if($imgb2_copy !="" && $imgb2=="") $imgb2 = $imgb2_copy;
if($imgb3_copy !="" && $imgb3=="") $imgb3 = $imgb3_copy;
if($imgb4_copy !="" && $imgb4=="") $imgb4 = $imgb4_copy;
if($imgb5_copy !="" && $imgb5=="") $imgb5 = $imgb5_copy;
*/

$soldout="N";
########## shop 데이터베이스에 입력값을 삽입한다. ###################

//	$query1 = "INSERT INTO $coin_goods";
//	$queyr1 = $query1."(";
//	$queyr1 = $query1."no,title,coin_price,signdate";
//	$query1 = $query1.") "
//	$query1 = $query1."VALUES"
//	$query1 = $query1." ("
//	$query1 = $query1." '', '$title', '$prices', '$signdate' "
//	$query1 = $query1." )"
//
//	$result1 = mysql_query($query1,$DBconn);
//	if(!$result1){
//		error("QUERY_ERROR");
//		exit;
//	}


	

				$query="INSERT INTO $shop_goods";
				$query=$query."(";
				$query=$query."No,code1,code2,code3,code,title,info,company,color,size,home,shelf,theme,event,event_str,new,pricec,priced,coin,prices,point,point_dis,currnum,warnnum,imgl,imgm,imgb1,imgb2,imgb3,imgb4,imgb5,detail,feature,signdate,soldout,rank,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,order1,order2,order3,color_opt,size_opt,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5,relation,price_dis,best,cut,recommend,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,rank_g,rank_n,rank_r,rank_f,rank_x,rank_y,rank_z,opt_num,opt_num_str,theme_s,rank_s,code4,order4,p_id,esigndate,pr_kind,c_pv,country,onlypoint,c_dis";
				$query=$query.")";
				$query=$query."VALUES";
				$query=$query."(";
				$query=$query."'','$code1','$code2','$code3','$code','$title','$info','$company','$color','$size','$home','$shelf','$theme','$event','$event_str','$new','$pricec','$priced','$coin','$prices','$point','$point_dis','$currnum','$warnnum','$imgl','$imgm','$imgb1','$imgb2','$imgb3','$imgb4','$imgb5','$detail','$feature','$signdate','$soldout','$rank','$option_t1','$option_n1','$option_p1','$option_k1','$option_t2','$option_n2','$option_p2','$option_k2','$option_t3','$option_n3','$option_p3','$option_k3','$option_t4','$option_n4','$option_p4','$option_k4','$option_t5','$option_n5','$option_p5','$option_k5','$order1','$order2','$order3','$color_opt','$size_opt','$add_opt1','$add_opt2','$add_opt3','$add_opt4','$add_opt5','$relation','$price_dis','$best','$cut','$recommend','$theme_g','$theme_n','$theme_r','$theme_f','$theme_x','$theme_y','$theme_z','$rank_g','$rank_n','$rank_r','$rank_f','$rank_x','$rank_y','$rank_z','$opt_num','$opt_num_str','$theme_s','$rank_s','$code4','$order4','$p_id','$esigndate','$pr_kind','$c_pv','$country','$onlypoint','$dis'";
				$query=$query.")";
		
				$DB->insert($shop_goods,"code1='$code1',code2='$code2',code3='$code3',code='$code',title='$title',info='$info',company='$company',color='$color',size='$size',home='$home',shelf='$shelf',theme='$theme',event='$event',event_str='$event_str',new='$new',pricec='$pricec',priced='$priced',coin='$coin',prices='$prices',point='$point',point_dis='$point_dis',currnum='$currnum',warnnum='$warnnum',imgl='$imgl',imgm='$imgm',imgb1='$imgb1',imgb2='$imgb2',imgb3='$imgb3',imgb4='$imgb4',imgb5='$imgb5',detail='$detail',feature='$feature',signdate='$signdate',soldout='$soldout',rank='$rank',option_t1='$option_t1',option_n1='$option_n1',option_p1='$option_p1',option_k1='$option_k1',option_t2='$option_t2',option_n2='$option_n2',option_p2='$option_p2',option_k2='$option_k2',option_t3='$option_t3',option_n3='$option_n3',option_p3='$option_p3',option_k3='$option_k3',option_t4='$option_t4',option_n4='$option_n4',option_p4='$option_p4',option_k4='$option_k4',option_t5='$option_t5',option_n5='$option_n5',option_p5='$option_p5',option_k5='$option_k5',order1='$order1',order2='$order2',order3='$order3',color_opt='$color_opt',size_opt='$size_opt',add_opt1='$add_opt1',add_opt2='$add_opt2',add_opt3='$add_opt3',add_opt4='$add_opt4',add_opt5='$add_opt5',relation='$relation',price_dis='$price_dis',best='$best',cut='$cut',recommend='$recommend',theme_g='$theme_g',theme_n='$theme_n',theme_r='$theme_r',theme_f='$theme_f',theme_x='$theme_x',theme_y='$theme_y',theme_z='$theme_z',rank_g='$rank_g',rank_n='$rank_n',rank_r='$rank_r',rank_f='$rank_f',rank_x='$rank_x',rank_y='$rank_y',rank_z='$rank_z',opt_num='$opt_num',opt_num_str='$opt_num_str',theme_s='$theme_s',rank_s='$rank_s',code4='$code4',order4='$order4',p_id='$p_id',esigndate='$esigndate',pr_kind='$pr_kind',onlypoint='$onlypoint',c_dis='$dis'");
				$DB->get("select max(No) as No from $shop_goods ",$rs,$rn);
				$No = $rs[0]["No"];
echo("<meta http-equiv='Refresh' content='0; URL=./pro_info.php?No=$No'>");   
?>
