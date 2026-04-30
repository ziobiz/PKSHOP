<?
##########샐행시간구하기################################
function time_check(){
	 $timeparts = explode(" " , microtime());
	 $starttime = $timepart[1].substr($timeparts[0],1);
	 
return $starttime;
}
####################################################

##########총 게시물수 구하기##############################
function total_all(){

global $DBtable , $Sub_No;

$numresults = mysql_query("select count(*) as soo from $DBtable where Sub_No='$Sub_No'");
$row_num = mysql_fetch_array($numresults);
$total_all=$row_num[soo];

return $total_all;
}
#####################################################

##########오늘 게시물수 구하기##############################
function total_today(){

global $DBtable , $Sub_No;

$DateM=date('Y-m-d');
$numresults1 = mysql_query("select count(*) as to_soo from $DBtable " . " where Wdate >='$DateM' and Sub_No='$Sub_No'");
//echo"select count(*) as to_soo from $DBtable" . "where Wdate >='$DateM'";
$row_num1 = mysql_fetch_array($numresults1);
$total_today=$row_num1[to_soo];

return $total_today;
}
#####################################################


##########게시판디비쿼리(일반)##############################
function list_db_queiry(){

global $DBtable,$Sub_No,$select,$sword,$sword1,$sword2,$sword3,$sword4;
if($select!=""){
	switch($select){
		case P_N_ame;
			$Result="select No,P_Up,P_Name,P_Link,Cnt,Wdate,Cont_type from $DBtable where (P_Name like '%$sword%'  and Sub_No='$Sub_No')  order by P_Name";  
		break;
		case P_C_ont;
			$Result="select No,P_Up,P_Name,P_Link,Cnt,Wdate,Cont_type from $DBtable where (Cont like '%$sword%'  and Sub_No='$Sub_No')  order by P_Name";  
		break;

		default;
			$Result="select No,P_Up,P_Name,P_Link,Cnt,Wdate,Cont_type from $DBtable where ((P_Name like '%$sword%' or P_Up like '%$sword%' or Cont like '%$sword%') and Sub_No='$Sub_No') order by P_Name"; 
	}
}else{
	$Result="select No,P_Up,P_Name,P_Link,Cnt,Wdate,Cont_type from  $DBtable where (Sub_No='$Sub_No') order by P_Name";
}
//echo "$Result";
$Rs= mysql_query($Result);
$tn=mysql_num_rows($Rs);  

return array ($Rs,$tn);
}
#########################################################

##########게시판디비쿼리(공지)##############################
function B_Title_db_queiry(){

global $DBtable,$Sub_No,$top_size;

$B_Title_Result="select No,Name,Title,Cnt,Wdate,Fname,Fname1,No1,Cont_type,Homepage from  $DBtable where (Sub_No='$Sub_No') and (B_Title='1') order by No1 desc,Wdate  LIMIT $top_size";
//echo "$B_Title_Result";
$B_Title_Rs= mysql_query($B_Title_Result);
$B_Title_tn=mysql_num_rows($B_Title_Rs);  
return array ($B_Title_Rs,$B_Title_tn);
}
#########################################################

##########리스트 내용 값###################################
function list_db_value(){

global $file_part,$line_part,$new_part,$list_query ;

//=========================================================//
$No = $list_query[No];					$P_Up = $list_query[P_Up];
$P_Name=$list_query[P_Name];		$P_Link=$list_query[P_Link];
$Cnt = $list_query[Cnt];
$Wdate=$list_query[Wdate];		

$P_Fname = $list_query[P_Fname];

$Cont_type = $list_query[Cont_type];		

$P_Name=stripslashes($P_Name);			$P_Link=stripslashes($P_Link);	
//==========================================================//
											
if ($Fname != '') {
	$P_Fname="$file_part";
} else {
	$P_Fname='';
} 

if ($P_Up == '1') {
	$P_Ups="[사용중]";
} else {
	$P_Ups='[미사용]';
} 

//echo"$Wdate";
$Date=substr($Wdate,0,10);//date를 받아서 8번째부터...2글짜만 표시한당..(예 10 일)
$Y=substr($Date,0,4);	$M=substr($Date,5,2); 	$D=substr($Date,8,2);
$W_time="$Y.$M.$D";
$dd=date('Y-m-d');
if($Date==$dd){
	$new=$new_part;
}else{
	$new='';	
}

//======타이틀 치환 하는 부분 입니다.======================//
If(strlen($P_Link)>45){
	$klen=45-1;
	while(ord($P_Link[$klen]) & 0x80) {$klen--;}
	$P_Link=substr($P_Link,0,45-((45+$klen+1)%2)).".....";
}else{
	$P_Link=$P_Link;
}

If(strlen($P_Name)>20){
	$klen=20-1;
	while(ord($P_Name[$klen]) & 0x80) {$klen--;}
	$P_Name=substr($P_Name,0,20-((20+$klen+1)%2))."...";
}else{
	$P_Name=$P_Name;
}
//======타이틀 치환 하는 부분 입니다.======================//

return array ($No,$P_Up,$P_Name,$P_Link,$W_time,$Cnt,$Files,$new,$Cont_type,$Fname,$P_Ups);
}
#########################################################

##########공지글출력 내용 값###################################
function B_Title_db_value(){

global $file_part,$line_part,$new_part,$B_Title_query ;

//=========================================================//
$No = $B_Title_query[No];				$Name = $B_Title_query[Name];
$Title=$B_Title_query[Title];				$Cnt = $B_Title_query[Cnt];
$Wdate=$B_Title_query[Wdate];		

$Fname = $B_Title_query[Fname];		$Fname1 = $B_Title_query[Fname1];

$No1 = $B_Title_query[No1];			$Cont_type = $B_Title_query[Cont_type];
$Homepage = $B_Title_query[Homepage];

$Name=stripslashes($Name);				$Title=stripslashes($Title);
//==========================================================//
											
if ($Fname != '' or $Fname1 !='') {
	$Files="$file_part";
} else {
	$Files='';
} 
//echo"$Wdate";

$Date=substr($Wdate,0,10);//date를 받아서 8번째부터...2글짜만 표시한당..(예 10 일)
$Y=substr($Date,0,4);	$M=substr($Date,5,2); 	$D=substr($Date,8,2);
$W_time="$Y.$M.$D";
$dd=date('Y-m-d');
if($Date==$dd) $new=$new_part;
else $new='';	

//======타이틀 치환 하는 부분 입니다.======================//
If(strlen($Title)>47){
	$klen=47-1;
	while(ord($Title[$klen]) & 0x80) {$klen--;}
	$Title=substr($Title,0,47-((47+$klen+1)%2)).".....";
}else{
	$Title=$Title;
}

if($No!=$No1){
	$Title=$line_part.' [Re] '.$Title ;
}else{
	$Title=$Title;
}

If(strlen($Name)>6){
	$klen=6-1;
	while(ord($Name[$klen]) & 0x80) {$klen--;}
	$Name=substr($Name,0,6-((6+$klen+1)%2))."...";
}else{
	$Name=$Name;
}
//======타이틀 치환 하는 부분 입니다.======================//

return array ($No,$Title,$Name,$W_time,$Cnt,$Files,$new,$Cont_type,$Fname,$Homepage);
}
#########################################################

##########커맨드 수 개산##############################
function Comm(){

global $DBtable2,$No;

//No 값에 에 글에 커맨드수를 개산한다.
$Comm_Result = "select count(*) as Comm_count from $DBtable2 where Board_No=$No";

$Comm_Rs= mysql_query($Comm_Result);										
$Comm_d=mysql_fetch_array($Comm_Rs);
$Comm_count = $Comm_d[Comm_count];

if($Comm_count==0){
   $Comm='';	
}else{
	$Comm='['.$Comm_count.']';	
}

return $Comm;
}
#########################################################

##########페이지 관련 변수셋팅##############################
function list_db_page(){

global $DBtable,$pagesize,$chapsize,$tn,$page;

	$tpage=ceil($tn/$pagesize); 
	$tchap=ceil($tpage/$chapsize); 

	if ($page==""){
		$page=$tpage; 
	} else {
		$page=$tpage-$page+1;	
	}

	$chap=$tchap-floor(($tpage-$page)/$chapsize);								
	$page2 = ($tchap-$chap) * $chapsize+1;
	$page1 = $page2 + $chapsize-1;  if ($page1> $tpage) $page1 = $tpage; 
	//$pagenext=$page-1; if ($page<1)      $page=1; 									
	//$pageprev=$page+1; if ($page>$tpage) $page=$tpage; 
	$pagenextnext=$page1+1; if ($page1<1)  $page1=1; 
	$pageprevprev=$page2-1; if ($page2>$tpage) $page2=$tpage; 
	$k2= $tn - ($tpage-$page)*$pagesize;      
	$k1= $k2- $pagesize + 1;  if ($k1<1) $k1=1;       

return array ($tpage,$tchap,$page,$chap,$page2,$page1,$pagenextnext,$pageprevprev,$k2,$k1);

}
#########################################################

##########조회수를 없한다.##############################
function Cnt_count(){

global $DBtable,$No;

mysql_query("update $DBtable set Cnt=Cnt+1 where No=$No");//조회수를 업한다...
}
#####################################################

##########글내용 출력 내용을 불러 온다.##############################
function Quiery_data(){

global $DBtable,$No,$line_part,$email_part,$mode;

$Result="select * from $DBtable where No=$No";
$Rs_table= mysql_query($Result);
$View_d=mysql_fetch_array($Rs_table); 

//==========================================================================//
	$No = $View_d[No];								$Sub_No=$View_d[Sub_No];
	$Name = $View_d[Name];						$P_Up=$View_d[P_Up];							
	$P_Name = $View_d[P_Name];				$P_Location=$View_d[P_Location];
	$P_Size = $View_d[P_Size];					$P_Link=$View_d[P_Link];
	$P_Target = $View_d[P_Target];				$Cont=$View_d[Cont];
	$Cnt = $View_d[Cnt];							$Ip = $View_d[Ip];
	$Wdate=$View_d[Wdate];						$Pass=$View_d[Pass];	
	$P_Fname = $View_d[P_Fname];			$P_Fsize = $View_d[P_Fsize];						
	$Cont_type = $View_d[Cont_type];		

	$Name=stripslashes($Name);				$P_Name=stripslashes($P_Name);
	$P_Link=stripslashes($P_Link);				$Cont=stripslashes($Cont);
	$Pass=stripslashes($Pass);
//=============================================================================//

	if($mode=="edit"){

		if($P_Link==""){
			$P_Link="http://";
		}else{
			$P_Link=$P_Link;
		}

		return array ($Sub_No,$Name,$P_Up,$P_Name,$P_Location,$P_Size,$P_Link,$P_Target,$Cont,$Pass,$Cont_type,$P_Fname,$P_Fsize);			

	}else if($mode=="reply"){
 
		$Cont1="\n\n\n\n\n\n▒▒▒ [이 전 글] ▒▒▒";
		$Cont="$Cont1\n\n$Cont";

		return array ($Cont,$No1);

	}else{
	
		# 데이터 치환 
		$Y=substr($Wdate,0,4);			$M=substr($Wdate,5,2); 		$D=substr($Wdate,8,2);
		$Si=substr($Wdate,11,2);		$Bn=substr($Wdate,14,2); 		$Cho=substr($Wdate,17,2);
		$Date_time=$Y."년".$M."월".$D."일(".$Si.":".$Bn.":".$Cho.")";
	
		if ($Cont_type == "AUTO"){ 
			$Cont = preg_replace("/\r/", "", $Cont);
			$Cont = preg_replace("/(\>[ ]*)\n/", ">\n", $Cont);
			$Cont = preg_replace("/((font|span|a)\>[ ]*|[^\>])\n/i", "\\1<br />\n", $Cont);
		}
		if ($Cont_type == "HTML"){
			$Cont=$Cont;  //html 일때는 구냥 구연 하면 테그가 먹는다.
		}
		if ($Cont_type == "TEXT"){
			$Cont="<xmp>$Cont</xmp>"; //xmp는 html 테그로서 테그가 안 먹게 하는 효과를 준다
		}
 
		if ($P_Link != ""){	
			$P_Link="링크 : <a href=$P_Link target=_blank>$P_Link</a>";
		}else{	
			$P_Link=""; 
		}
	
		if ($P_Fname != "") {
			$Files="<a href=../../Adm/admin_board_popup/data/$P_Fname target='_blank'>$P_Fname</a>($P_Fsize)";
		}else{
			$Files=""; 
		}
	
		//이전버튼 구연
		$Result="select * from $DBtable where (Sub_No=$Sub_No) order by No desc";
		$Rs_table= mysql_query($Result);
		$Prev_d=mysql_fetch_array($Rs_table);  
		if (!$Prev_d) $Prev_d=$View_d;  $prevno=$Prev_d[No];

		//다음버튼구연
		$Result="select * from $DBtable where (Sub_No=$Sub_No) order by No desc, Wdate";
		//echo "$Result";
		$Rs_table= mysql_query($Result);
		$Next_d=mysql_fetch_array($Rs_table);  
		if (!$Next_d)	$Next_d=$View_d;  $nextno=$Next_d[No];

		return array ($Sub_No,$Name,$P_Up,$P_Name,$P_Location,$P_Size,$P_Link,$P_Target,$Cont,$Cnt,$Ip,$Files,$Date_time,$prevno,$nextno,$P_Fname);

		

	}//else  마감		
}
###############################################################

##########커맨드디비쿼리(일반)##############################
function comm_db_queiry(){

global $DBtable2,$No;

$Comm_Result = "select Comm_No,Comm_Writer,Comm_Cont,Comm_Wdate from $DBtable2";
$Comm_Result = $Comm_Result." where Board_No=$No order by Comm_No asc,Comm_Wdate";
$Comm_Rs= mysql_query($Comm_Result);
$Comm_tn=mysql_num_rows($Comm_Rs);
//echo "$Comm_Result";
$Comm_count = $Comm_d[Comm_count];

return array ($Comm_Rs,$Comm_tn);
}
#########################################################

##########커맨드 내용 값###################################
function comm_db_value(){

global $comm_query ;

	//------------------------------------------
	$Comm_No = $comm_query[Comm_No];			
	$Comm_Writer = $comm_query[Comm_Writer];
	$Comm_Cont = $comm_query[Comm_Cont];		
	$Comm_Wdate = $comm_query[Comm_Wdate];
					
	//+++++++++++++++++++++++++++++++++++
	$Comm_Writer=stripslashes($Comm_Writer);
	$Comm_Cont=stripslashes($Comm_Cont);
	//+++++++++++++++++++++++++++++++++++
	
	$Comm_Cont = preg_replace("/\r/", "", $Comm_Cont);
	$Comm_Cont = preg_replace("/(\>[ ]*)\n/", ">\n", $Comm_Cont);
	$Comm_Cont = preg_replace("/((font|span|a)\>[ ]*|[^\>])\n/i", "\\1<br />\n", $Comm_Cont);
	
	$Comm_Y=substr($Comm_Wdate,0,4);	
	$Comm_M=substr($Comm_Wdate,5,2); 	
	$Comm_D=substr($Comm_Wdate,8,2);
	$Comm_Date=$Comm_Y.":".$Comm_M.":".$Comm_D;
	//------------------------------------------

return array ($Comm_No,$Comm_Writer,$Comm_Cont,$Comm_Date);

}
#########################################################

##########사용자 정보 가져오기##############################
function user_member($user_name,$user_email){

global $members , $cid ;

$numresults2 = mysql_query("select Name,Email from $member_tables " . " where ID ='$cid'");
//echo "select Name,Email from $member_tables " . " where ID='$cid'" ;
$row_num2 = mysql_fetch_array($numresults2);
$user_name = $row_num2[Name]; $user_email = $row_num2[Email];		

return array($user_name,$user_email);

}
?>