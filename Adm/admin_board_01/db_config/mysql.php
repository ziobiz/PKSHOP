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

global $DB , $Sub_No;
$DB->get("select count(*) as soo from $DB where Sub_No='$Sub_No'",$rs,$rn);

$total_all=$rs[0][soo];

return $total_all;
}
#####################################################

##########오늘 게시물수 구하기##############################
function total_today(){

global $DB , $Sub_No;

$DateM=date('Y-m-d');
$numresults1 = mysql_query("select count(*) as to_soo from $DB " . " where Wdate >='$DateM' and Sub_No='$Sub_No'");
//echo"select count(*) as to_soo from $DB" . "where Wdate >='$DateM'";
$row_num1 = mysql_fetch_array($numresults1);
$total_today=$row_num1[to_soo];

return $total_today;
}
#####################################################

##########게시판디비쿼리(일반)##############################
function list_db_queiry(){

global $DB,$Sub_No,$select,$sword;

if($select!=""){
	switch($select){
		case T_itle;
			$Result="select No,Name,Title,Cnt,Wdate,Fname,Fname1,No1,Cont_type,Secret from $DB where (Title like '%$sword%'  and Sub_No='$Sub_No')   and (B_Title<>'1')  order by No1 desc, wdate";  
		break;
		case N_ame;
			$Result="select No,Name,Title,Cnt,Wdate,Fname,Fname1,No1,Cont_type,Secret from $DB where (Name like '%$sword%' and Sub_No='$Sub_No')  and (B_Title<>'1')   order by No1 desc, wdate";  
		break;
		case C_ont;
			$Result="select No,Name,Title,Cnt,Wdate,Fname,Fname1,No1,Cont_type,Secret from $DB where (Cont like '%$sword%'  and Sub_No='$Sub_No')  and (B_Title<>'1')   order by No1 desc, wdate";  
		break;
		default;
			$Result="select No,Name,Title,Cnt,Wdate,Fname,Fname1,No1,Cont_type,Secret from $DB where ((Title like '%$sword%' or Cont like '%$sword%' or Name like '%$sword%') and Sub_No='$Sub_No') and (B_Title<>'1')  order by No1 desc, wdate"; 
	}
}else{
	$Result="select No,Name,Title,Cnt,Wdate,Fname,Fname1,No1,Cont_type,Secret from  $DB where (Sub_No='$Sub_No') and (B_Title<>'1')  order by No1 desc,Wdate";
}
//echo "$Result";
$Rs= mysql_query($Result);
$tn=mysql_num_rows($Rs);  

return array ($Rs,$tn);
}
#########################################################

##########게시판디비쿼리(공지)##############################
function B_Title_db_queiry(){

global $DB,$Sub_No,$top_size;

$B_Title_Result="select No,Name,Title,Cnt,Wdate,Fname,Fname1,No1,Cont_type,Secret from  $DB where (Sub_No='$Sub_No') and (B_Title='1') order by No1 desc,Wdate  LIMIT $top_size";
//echo "$B_Title_Result";
$B_Title_Rs= mysql_query($B_Title_Result);
$B_Title_tn=mysql_num_rows($B_Title_Rs);  
return array ($B_Title_Rs,$B_Title_tn);
}
#########################################################

##########리스트 내용 값###################################
function list_db_value(){

global $file_part,$line_part,$new_part,$list_query,$Sub_No ;

//=========================================================//
$No = $list_query[No];					$Name = $list_query[Name];
$Title=$list_query[Title];					$Cnt = $list_query[Cnt];
$Wdate=$list_query[Wdate];		
$Fname = $list_query[Fname];		$Fname1 = $list_query[Fname1];
$No1 = $list_query[No1];				$Cont_type = $list_query[Cont_type];			
$Secret = $list_query[Secret];

$Name=stripslashes($Name);			$Title=stripslashes($Title);	
//==========================================================//
											
if ($Fname != '' or $Fname1 !='') {
	$Files="$file_part";
} else {
	$Files='';
} 

//echo"$Wdate";
$Date=substr($Wdate,0,10);//date를 받아서 8번째부터...2글짜만 표시한당..(예 10 일)
$Y=substr($Date,0,4);	$M=substr($Date,5,2); 	$D=substr($Date,8,2);
if($Sub_No>2){
	$W_time="$M.$D";
}else{
	$W_time="$Y.$M.$D";
}

$dd=date('Y-m-d');
if($Date==$dd){
	$new=$new_part;
}else{
	$new='';	
}

//======타이틀 치환 하는 부분 입니다.======================//
$Title_Len=120;
If(strlen($Title)>$Title_Len){
	$klen=$Title_Len-1;
	while(ord($Title[$klen]) & 0x80) {$klen--;}
	$Title=substr($Title,0,$Title_Len-(($Title_Len+$klen+1)%3)).".....";
}else{
	$Title=$Title;
}

if($No!=$No1){
	$Title=$line_part.''.$Title ;
}else{
	$Title=$Title;
}

$Name_Len=10;
If(strlen($Name)>$Name_Len){
	$klen=$Name_Len-1;
	while(ord($Name[$klen]) & 0x80) {$klen--;}
	$Name=substr($Name,0,$Name_Len-(($Name_Len+$klen+1)%3))."...";
}else{
	$Name=$Name;
}
//======타이틀 치환 하는 부분 입니다.======================//

return array ($No,$Title,$Name,$W_time,$Cnt,$Files,$new,$Cont_type,$Fname,$Secret,$No1);
}
#########################################################

##########공지글출력 내용 값###################################
function B_Title_db_value(){

global $file_part,$line_part,$new_part,$B_Title_query,$Sub_No ;

//=========================================================//
$No = $B_Title_query[No];				$Name = $B_Title_query[Name];
$Title=$B_Title_query[Title];				$Cnt = $B_Title_query[Cnt];
$Wdate=$B_Title_query[Wdate];		
$Fname = $B_Title_query[Fname];		$Fname1 = $B_Title_query[Fname1];
$No1 = $B_Title_query[No1];			$Cont_type = $B_Title_query[Cont_type];
$Secret = $list_query[Secret];
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
if($Sub_No>2){
	$W_time="$M.$D";
}else{
	$W_time="$Y.$M.$D";
}

$dd=date('Y-m-d');
if($Date==$dd) $new=$new_part;
else $new='';	

//======타이틀 치환 하는 부분 입니다.======================//
$Title_Len=120;
If(strlen($Title)>$Title_Len){
	$klen=$Title_Len-1;
	while(ord($Title[$klen]) & 0x80) {$klen--;}
	$Title=substr($Title,0,$Title_Len-(($Title_Len+$klen+1)%3)).".....";
}else{
	$Title=$Title;
}

if($No!=$No1){
	$Title=$line_part.' [Re] '.$Title ;
}else{
	$Title=$Title;
}

$Name_Len=10;
If(strlen($Name)>$Name_Len){
	$klen=$Name_Len-1;
	while(ord($Name[$klen]) & 0x80) {$klen--;}
	$Name=substr($Name,0,$Name_Len-(($Name_Len+$klen+1)%3))."...";
}else{
	$Name=$Name;
}
//======타이틀 치환 하는 부분 입니다.======================//

return array ($No,$Title,$Name,$W_time,$Cnt,$Files,$new,$Cont_type,$Fname,$Secret);
}
#########################################################

##########커맨드 수 개산##############################
function Comm(){

global $DB2,$No;

//No 값에 에 글에 커맨드수를 개산한다.
$Comm_Result = "select count(*) as Comm_count from $DB2 where Board_No=$No";

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

global $DB,$pagesize,$chapsize,$tn,$page;

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

global $DB,$No;

mysql_query("update $DB set Cnt=Cnt+1 where No=$No");//조회수를 업한다...
}
#####################################################

##########글내용 출력 내용을 불러 온다.##############################
function Quiery_data(){

global $DB,$No,$line_part,$email_part,$mode;

$Result="select * from $DB where No=$No";
$Rs_table= mysql_query($Result);
$View_d=mysql_fetch_array($Rs_table); 

//==========================================================================//
$No = $View_d[No];								$Sub_No=$View_d[Sub_No];
$Name = $View_d[Name];						$Title=$View_d[Title];							
$Email = $View_d[Email];						$Homepage=$View_d[Homepage];
$Cont=$View_d[Cont];							$Cnt = $View_d[Cnt];
$Ip = $View_d[Ip];									$Wdate=$View_d[Wdate];	
$Pass=$View_d[Pass];							$Fname = $View_d[Fname];	
$Fsize = $View_d[Fsize];						$Fname1 = $View_d[Fname1];	
$Fsize1 = $View_d[Fsize1];					$No1 = $View_d[No1];			
$Cont_type = $View_d[Cont_type];			$B_Title = $View_d[B_Title];	
$Secret = $View_d[Secret];	

$Name=stripslashes($Name);						$Title=stripslashes($Title);
$Homepage=stripslashes($Homepage);		$Cont=stripslashes($Cont);
$Pass=stripslashes($Pass);						$Email=stripslashes($Email);		
//=============================================================================//

	if($mode=="edit"){

		if($Homepage==""){
			$Homepage="http://";
		}else{
			$Homepage=$Homepage;
		}

		return array ($Sub_No,$Name,$Pass,$Email,$Homepage,$Title,$Cont,$Cont_type,$Fname,$Fname1,$B_Title,$Secret,$Fsize,$Fsize1,$Secret);			

	}else if($mode=="reply"){
 
		$Cont1="\n\n\n\n\n\n▒▒▒ [이 전 글] ▒▒▒";
		$Cont="$Cont1\n\n$Cont";

		return array ($Cont,$No1,$Secret,$Pass);

	}else{
	
		# 데이터 치환 
		$Y=substr($Wdate,0,4);			$M=substr($Wdate,5,2); 		$D=substr($Wdate,8,2);
		$Si=substr($Wdate,11,2);		$Bn=substr($Wdate,14,2); 		$Cho=substr($Wdate,17,2);
		$Date_time=$Y."년".$M."월".$D."일(".$Si.":".$Bn.":".$Cho.")";
	
		if($No!=$No1){$Title=$line_part.' [Re] '.$Title ;}
					
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

		if ($Homepage != ""){	
			$Homepage="홈페이지 : <a href=$Homepage target=_blank>$Homepage</a>";
		}else{	
			$Homepage=""; 
		}
	
		if ($Fname != "") {
			$Files="<a href=/Adm/admin_board_01/data/$Fname target='_blank'>$Fname</a>($Fsize)";
			$Files_s="<a href=/Adm/admin_board_01/data/$Fname target='_blank' class='board02'>$Fname</a>";
		}else{
			$Files=""; 
			$Files_s=""; 
		}
	
		if ($Fname1 != ""){
			$Files1="<a href=/admin/admin_board_01/data/$Fname1 target='_blank'>$Fname1</a>($Fsize1)";
			$Files1_s="<a href=/admin/admin_board_01/data/$Fname1 target='_blank' class='board02'>$Fname1</a>";
		}else{
			$Files1=""; 
			$Files1_s=""; 
		}

		//이전버튼 구연
		$Result="select * from $DB where (No1>$No1  or (No1=$No1 and  No<$No)) and (Sub_No=$Sub_No) and (Cont_type<>'Del') order by No1,No desc";
		$Rs_table= mysql_query($Result);
		$Prev_d=mysql_fetch_array($Rs_table);  
		if (!$Prev_d) $Prev_d=$View_d;  $prevno=$Prev_d[No];

		//다음버튼구연
		$Result="select * from $DB where  (No1<$No1 or No1=$No1 and No>$No) and (Sub_No=$Sub_No) and (Cont_type<>'Del') order by No1 desc, Wdate";
		//echo "$Result";
		$Rs_table= mysql_query($Result);
		$Next_d=mysql_fetch_array($Rs_table);  
		if (!$Next_d)	$Next_d=$View_d;  $nextno=$Next_d[No];

		return array ($Sub_No,$Name,$Title,$Email,$Homepage,$Cont,$Cnt,$Ip,$Files,$Files1,$No1,$Date_time,$prevno,$nextno,$B_Title,$Fname,$Fname1,$Files_s,$Files1_s,$Secret);

	}//else  마감		
}
###############################################################

##########커맨드디비쿼리(일반)##############################
function comm_db_queiry(){

global $DB2,$No;

$Comm_Result = "select Comm_No,Comm_Writer,Comm_Cont,Comm_Wdate from $DB2";
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
?>