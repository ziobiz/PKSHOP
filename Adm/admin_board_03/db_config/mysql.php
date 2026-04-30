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

global $DBtable,$Sub_No,$select,$sword;

if($select!=""){
	switch($select){
		case T_itle;
			$Result="select No,Name,Title,Cont,Cnt,Wdate,Fname,Fname1,No1,Cont_type from $DBtable where (Title like '%$sword%'  and Sub_No='$Sub_No')   and (B_Title<>'1')  order by No1 desc, wdate";  
		break;
		case N_ame;
			$Result="select No,Name,Title,Cont,Cnt,Wdate,Fname,Fname1,No1,Cont_type from $DBtable where (Name like '%$sword%' and Sub_No='$Sub_No')  and (B_Title<>'1')   order by No1 desc, wdate";  
		break;
		case C_ont;
			$Result="select No,Name,Title,Cont,Cnt,Wdate,Fname,Fname1,No1,Cont_type from $DBtable where (Cont like '%$sword%'  and Sub_No='$Sub_No')  and (B_Title<>'1')   order by No1 desc, wdate";  
		break;
		default;
			$Result="select No,Name,Title,Cont,Cnt,Wdate,Fname,Fname1,No1,Cont_type from $DBtable where ((Title like '%$sword%' or Cont like '%$sword%' or Name like '%$sword%') and Sub_No='$Sub_No') and (B_Title<>'1')  order by No1 desc, wdate"; 
	}
}else{
	$Result="select No,Name,Title,Cont,Cnt,Wdate,Fname,Fname1,No1,Cont_type from  $DBtable where (Sub_No='$Sub_No') and (B_Title<>'1')  order by No1 desc,Wdate";
}
//echo "$Result";
$Rs= mysql_query($Result);
$tn=mysql_num_rows($Rs);  

return array ($Rs,$tn);
}
#########################################################


##########리스트 내용 값###################################
function list_db_value(){

global $file_part,$line_part,$new_part,$list_query ;

//=========================================================//
$No = $list_query[No];					$Name = $list_query[Name];
$Title=$list_query[Title];					$Cnt = $list_query[Cnt];
$Wdate=$list_query[Wdate];		
$Fname = $list_query[Fname];		$Fname1 = $list_query[Fname1];
$No1 = $list_query[No1];				$Cont_type = $list_query[Cont_type];	
$Cont = $list_query[Cont];

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
$W_time="$Y.$M.$D";
$dd=date('Y-m-d');
if($Date==$dd){
	$new=$new_part;
}else{
	$new='';	
}

$Cont_1=$Cont;
//======타이틀 치환 하는 부분 입니다.======================//
If(strlen($Cont)>27){
	$klen=27-1;
	while(ord($Cont[$klen]) & 0x80) {$klen--;}
	$Cont=substr($Cont,0,27-((27+$klen+1)%3)).".....";
}else{
	$Cont=$Cont;
}

if($No!=$No1){
	$Cont=$line_part.''.$Cont ;
}else{
	$Cont=$Cont;
}

If(strlen($Name)>15){
	$klen=15-1;
	while(ord($Name[$klen]) & 0x80) {$klen--;}
	$Name=substr($Name,0,15-((15+$klen+1)%2))."...";
}else{
	$Name=$Name;
}
//======타이틀 치환 하는 부분 입니다.======================//

return array ($No,$Title,$Name,$W_time,$Cnt,$Files,$new,$Cont_type,$Fname,$Cont,$Cont_1);
}
#########################################################


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
$Name = $View_d[Name];						$Title=$View_d[Title];							
$Email = $View_d[Email];						$Homepage=$View_d[Homepage];
$Cont=$View_d[Cont];							$Cnt = $View_d[Cnt];
$Ip = $View_d[Ip];									$Wdate=$View_d[Wdate];	
$Pass=$View_d[Pass];							$Fname = $View_d[Fname];	
$Fsize = $View_d[Fsize];						$Fname1 = $View_d[Fname1];	
$Fsize1 = $View_d[Fsize1];					$No1 = $View_d[No1];			
$Cont_type = $View_d[Cont_type];			$B_Title = $View_d[B_Title];	
$P_up = $View_d[P_up];	

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

		return array ($Sub_No,$Name,$Pass,$Email,$Homepage,$Title,$Cont,$Cont_type,$Fname,$Fname1,$B_Title,$P_up,$Fsize,$Fsize1,$Cnt);			

	}else if($mode=="reply"){
 
		$Cont1="\n\n\n\n\n\n▒▒▒ [이 전 글] ▒▒▒";
		$Cont="$Cont1\n\n$Cont";

		return array ($Cont,$No1,$Title);

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
			$Files="<a href=../../admin/admin_board_01/data/$Fname target='_blank'>$Fname</a>($Fsize)";
		}else{
			$Files=""; 
		}
	
		if ($Fname1 != ""){
			$Files1="<a href=../../admin/admin_board_01/data/$Fname1 target='_blank'>$Fname1</a>($Fsize1)";
		}else{
			$Files1=""; 
		}

		//이전버튼 구연
		$Result="select * from $DBtable where (No1>$No1  or (No1=$No1 and  No<$No)) and (Sub_No=$Sub_No) and (Cont_type<>'Del') order by No1,No desc";
		$Rs_table= mysql_query($Result);
		$Prev_d=mysql_fetch_array($Rs_table);  
		if (!$Prev_d) $Prev_d=$View_d;  $prevno=$Prev_d[No];

		//다음버튼구연
		$Result="select * from $DBtable where  (No1<$No1 or No1=$No1 and No>$No) and (Sub_No=$Sub_No) and (Cont_type<>'Del') order by No1 desc, Wdate";
		//echo "$Result";
		$Rs_table= mysql_query($Result);
		$Next_d=mysql_fetch_array($Rs_table);  
		if (!$Next_d)	$Next_d=$View_d;  $nextno=$Next_d[No];

		return array ($Sub_No,$Name,$Title,$Email,$Homepage,$Cont,$Cnt,$Ip,$Files,$Files1,$No1,$Date_time,$prevno,$nextno,$B_Title,$Fname,$Fname1);

	}//else  마감		
}
###############################################################


?>