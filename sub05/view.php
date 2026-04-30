<?include "../include/top_session.php";?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
 <?
 include "../../Adm/common/dbconn.php";
// 조회수 한번 읽은 글은 No 값 쿠키 선언해서 조회수 업을 막는다..(하루)
//if($board_cook==""){
//	$count=$board_cook.$No."/";
//	setcookie("board_cook","$count",0,"/");
//	$hit="up";
//}else{
//	$coki=explode('/',$board_cook);
//	$coki_soo=count($coki)-1;
//	for($n=0;$n<$coki_soo;$n++){
//		$Noo=$coki[$n];  $Noo=(int)$Noo; $No=(int)$No;
//		//echo "<font color=white>$Noo</font><br>";
//		if($No==$Noo){
//			$hit="noup"; break; 
//		} 
//  	}//for 문
//}
//
//if($hit!="noup"){
//	$count=$board_cook.$No."/";
//	setcookie("board_cook","$count",0,"/");
//	$hit="up";
//}

#디비관련 셋팅파일 불러 오기
include '../../Adm/admin_board_01/db_config/dbcon.php';
include '../../Adm/admin_board_01/db_config/mysql.php';

# htm 셋팅 관련 파일 불러오기
include '../../Adm/admin_board_01/htm_config/setting.php';
 
//조회수를 업한다. 쿠키 값이 없을때..
if($hit=="up")  $Cnt_count=Cnt_count();

//exit;
 
# 데이타를 불러 온다.   이전글 과 다음글 번호 까지(귀차니즘 ㅡㅡ;) 
$Quiery_data=Quiery_data();

$Sub_No=$Quiery_data[0];
$Name=$Quiery_data[1];					$Title=$Quiery_data[2];
$Email=$Quiery_data[3];					$Homepage=$Quiery_data[4];
$Cont=$Quiery_data[5];					$Cnt=$Quiery_data[6];
$Ip=$Quiery_data[7];					$Files=$Quiery_data[8];
$Files1=$Quiery_data[9];				$No1=$Quiery_data[10];
$Date_time=$Quiery_data[11];			$prevno=$Quiery_data[12];
$nextno=$Quiery_data[13];				$B_Title=$Quiery_data[14];
$Fname=$Quiery_data[15];				$Fname1=$Quiery_data[16];
$Files_s=$Quiery_data[17];				$Files1_s=$Quiery_data[18];
$Secret=$Quiery_data[19];				$Dis=$Quiery_data[20];
//$Cont = nl2br($Cont);

////비밀글 확인
//if($Secret=="1"){
//	if($Secret_ok!="Ok"){
//?>
	<script type="text/javascript">
//	<!--
//		alert("잘못된 경로 입니다");
//		history.back();
//	//-->
//	</script>
<?
//	exit;
//	}
//}

//검색일때 페이지 셋팅
if($select!="") $page="$page&sword=$sword&select=$select";
if($page=="") $page="1";

//타이틀 간격 조절
if(strlen($Board_Title)>6){
	$Board_Title=$Board_Title;
}else{
	$Board_Title=$Board_Title."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}

//$Date_time=substr($Date_time,0,14);
//$Y=substr($Date_time,0,4);			$M=substr($Date_time,6,2); 		$D=substr($Date_time,10,2);
//$Date_time=$Y."-".$M."-".$D;

//타이틀 길이 조절
/*
$Title_Len=77;
If(strlen($Title)>$Title_Len){
	$klen=$Title_Len-1;
	while(ord($Title[$klen]) & 0x80) {$klen--;}
	$Title=substr($Title,0,$Title_Len-(($Title_Len+$klen+1)%2)).".....";
}else{
	$Title=$Title;
}
//이름 길이 조절
$Name_Len=6;
If(strlen($Name)>$Name_Len){
	$klen=$Name_Len-1;
	while(ord($Name[$klen]) & 0x80) {$klen--;}
	$Name=substr($Name,0,$Name_Len-(($Name_Len+$klen+1)%2))."...";
}else{
	$Name=$Name;
}
*/


?>	
<script src="../../Adm/admin_board_01/script/view.js"></script>
 </head>
 <body>
	<div class="wrap">
		
		<!-- 상단 (top) -->

		<? include "../include/top.php"; ?>
		
		<!-- 상단 (top) 끝 -->

		<div class="sp50"></div>
		<div class="sub04_container">
			<!-- 카테고리 -->
			
			<? include "../include/category_contect_us.php"; ?>

			<!-- 카테고리 끝 -->


			<div class="content">
				<div class="page_title"><?if($Sub_No=="1"){?>공지사항<?}else if($Sub_No=="2"){?>질문과 답변<?}else{?>이벤트<?}?></div>

					<table class="board_view">
						<tr>
							<th colspan="6"><?=$Title?></th>
						</tr>
						<tr class="board_table_line">
							<td width="8%" class="font_b">작성자</td>
							<td width="8%"><?=$Name?></td>
							<td width="8%" class="font_b">작성일</td>
							<td><?=$Date_time?></td>
							<td width="8%" class="font_b">조회수</td>
							<td width="8%"><?=$Cnt?></td>
						</tr>
						<tr class="board_table_line">
							<td colspan="6" class="view_text"><?=$Cont?>
						<?
						$comm_db_queiry=comm_db_queiry($Comm_Rs,$Comm_tn);
						$Comm_Rs=$comm_db_queiry[0];
						$Comm_tn=$comm_db_queiry[1];
						
						if($Comm_tn!=0) {
						while($comm_query=mysql_fetch_array($Comm_Rs)){
							$comm_db_value=comm_db_value ($Comm_No,$Comm_Writer,$Comm_Cont,$Comm_Date);
							$Comm_No=$comm_db_value[0];					$Comm_Writer=$comm_db_value[1];
							$Comm_Cont=$comm_db_value[2];				$Comm_Date=$comm_db_value[3];
						?>
						<br><br>###### 답변내용 ##########################################################################<br><br>
						<?=$Comm_Cont?>
						<br><br>
						<?}}?>
							</td>
						</tr>
						<tr class="board_table_line">
					<?$No_dis=$No;?>
							<td width="8%" class="font_b">첨부파일</td>
							<td colspan="5"><?=$Files?>&nbsp;<?=$Files1?></td>
						</tr>
					</table>

					<div class="sp20"></div>

					<div class="btn_box">
						<div class="list_btn01">
							<input type="button" value="목 록" class="cart_btn01" onclick="location.href='list.php?page=<?=$page?>&Sub_No=<?=$Sub_No?>'">
						</div>
						<div class="list_btn03">
					<?if($Sub_No=="2" ){?><input type="button" value="글 작성하기" class="cart_btn03" onclick="location.href='write.php'">&nbsp;
					<!-- <input type="button" value="답 변" class="cart_btn01" onclick="location.href='write.php?No=<?=$No?>&Sub_No=<?=$Sub_No?>&mode=reply&page=<?=$page?>'">&nbsp; -->
					<input type="button" value="수 정" class="cart_btn01" onClick="showPopup_edit();">&nbsp;
					<input type="button" value="삭 제" class="cart_btn01" onClick="showPopup_Del();">
					<?}?>			
						</div>
					</div>

						<div class="sp40"></div>
						<table class="board_table">
							<tr>
								<th width="5%">번호</th>
								<th width="59%">제목</th>
								<th width="12%">작성자</th>
								<th width="12%">작성일</th>
								<th width="12%">조회</th>
							</tr>
<?
//리스트 디비 쿼리#####################################
$list_db_queiry=list_db_queiry($Rs,$tn);
$Rs=$list_db_queiry[0];
$tn=$list_db_queiry[1];
###################################################

//페이지 관련 변수 선언.##############################
$list_db_page=list_db_page();
//$tpage,$tchap,$page,$chap,$page2,$page1,$pagenext,$pageprev,$pagenextnext,$pageprevprev,$k2,$k1

$tpage=$list_db_page[0];					$tchap=$list_db_page[1];
$page=$list_db_page[2];					$chap=$list_db_page[3];
$page2=$list_db_page[4];					$page1=$list_db_page[5];
$pagenextnext=$list_db_page[6];		$pageprevprev=$list_db_page[7];
$k2=$list_db_page[8];						$k1=$list_db_page[9];

$k3=$k2-$k1+1;
$p=$tpage-$page+1; //page 변수 치환.
//echo "$page";
 ###################################################

//##################################공지글 빼오기
$B_Title_db_queiry=B_Title_db_queiry($Rs,$tn);
$B_Title_Rs=$B_Title_db_queiry[0];
$B_Title_tn=$B_Title_db_queiry[1];

if($B_Title_tn!=0){
	while($B_Title_query=mysql_fetch_array($B_Title_Rs)){
	//리스트 출력 내용
	$B_Title_db_value=B_Title_db_value($No,$Title,$Name,$W_time,$Cnt,$Files,$new,$Secret);
	$B_Title_No=$B_Title_db_value[0];					$B_Title_Title=$B_Title_db_value[1];
	$B_Title_Name=$B_Title_db_value[2];				$B_Title_W_time=$B_Title_db_value[3];
	$B_Title_Cnt=$B_Title_db_value[4];					$B_Title_Files=$B_Title_db_value[5];
	$B_Title_new=$B_Title_db_value[6];				
?>

			<tr class="board_table_line">
				<td><b><font color="#B0282C">공지</font></b></td>
				<? 
					if($select!=""){	   
						 $link_value="No=$B_Title_No&page=$p&sword=$sword&select=$select&Sub_No=$Sub_No";
					}else{
						$link_value="No=$B_Title_No&page=$p&Sub_No=$Sub_No";
					}										
				?>
				<td class="board_title">
					<a href="view.php?<?=$link_value?>" class="a_3"><b><?=$B_Title_Title?></b></a> <?=$B_Title_new?><?=$B_Title_Files?>

					<!--<input type="button" class="board_btn_com" value="처리완료" onclick="">
					 <input type="button" class="board_btn_com01" value="처리대기" onclick=""> -->
				</td>
				<td><b><?=$B_Title_Name?></b></td>
				<td class="c_brown"><b><?=$B_Title_W_time?></b></td>
				<td class="c_brown"><b><?=$B_Title_Cnt?></b></td>
			</tr>
<?	
	$B_Title_tn--; 
	}  #while 마감
} #if 마감

//게시판 내용 출력 하기
if($tn==0){
?>

									
			<tr class="board_table_line">
				<td colspan='6'  class="board_title_nodata"><br><br>현재 등록된 글이 없습니다.<br><br><br></td>
			</tr>
<?
}else{
$ii=0;
while($list_query=mysql_fetch_array($Rs)){
	if ($tn<=$k2 && $tn>=$k1 && $tn>0 ) { 

	//리스트 출력 내용
	$list_db_value=list_db_value($No,$Title,$Name,$W_time,$Cnt,$Files,$new,$Cont_type,$Secret,$No1,$Homepage,$Cont,$Dis);
	$No2=$list_db_value[0];					$Title=$list_db_value[1];
	$Name=$list_db_value[2];				$W_time=$list_db_value[3];
	$Cnt=$list_db_value[4];				$Files=$list_db_value[5];
	$new=$list_db_value[6];				$Cont_type=$list_db_value[7];
	$Fname=$list_db_value[8];			$Secret=$list_db_value[9];
	$No1=$list_db_value[10];			$Homepage=$list_db_value[11];
	$Cont=$list_db_value[12];			$Dis=$list_db_value[13];

if($Secret=="1"){
	$Secret="<img src='images/icon_lock.gif' style='vertical-align:middle;'>";
	
}else{
	$Secret="";
}

?>		

									
				<tr class="board_table_line">
					<td><?=$tn?></td>
					<?if($Cont_type=='Del'){?>
					<td class="board_title">
						<a href="#" onclick="Check();" onfocus="this.blur()" class="a_3"><font color="#999999"><s><?=$Title?></font></s></a>

						<!--<input type="button" class="board_btn_com" value="처리완료" onclick="">
						 <input type="button" class="board_btn_com01" value="처리대기" onclick=""> -->
					</td>
					<? 
					}else{ 
						if($select!=""){	   
							 $link_value="No=$No2&page=$p&sword=$sword&select=$select&Sub_No=$Sub_No";
						}else{
							$link_value="No=$No2&page=$p&Sub_No=$Sub_No";
						}
					
					?>
					<td class="board_title">
						
						<?if($Secret!=""){?>
							<a href='#' onfocus='this.blur()' onClick="showPopup_secret('<?=$No2?>');" class="a_3"><?if($Sub_No=="3"){?>[<?=$Dis?>]<?}?><?=$Title?> <?=$Secret?>
						<?}else{?>
							<a href='view.php?<?=$link_value?>' class="a_3"><?if($Sub_No=="3"){?>[<?=$Dis?>]<?}?><?=$Title?>
						<?}?>
						<?=$new?><?=$Files?>

					</td>
					<?}?>
					<td><?=$Name?></td>
					<td class="c_brown"><?=$W_time?></td>
					<td class="c_brown"><?=$Cnt?></td>
				</tr>
<?	
	$ii++;
	}; 
	$tn--; 
	}  #while 마감
} #else 마감
?>	
				
						</table>
					<div class="sp20"></div>

					<div class="btn_box">
						<div class="list_btn01">
							<input type="button" value="목 록" class="cart_btn01" onclick="location.href='./list01.php'">
						</div>
						<div class="list_page">
							<b>[1]</b>	 					
						</div>
						<div class="list_btn02"></div>
					</div>

					<div class="sp10"></div>

					<form name="form1" method="post" action="/pc/board/view.php"> 
						<input type="hidden" name="search" value="on"> 
						<input type="hidden"  name="Sub_No" value="1">
						<div class="list_search">
							<select name="select" class="list_select">
								<option value="T_itle" >제목</option>
								<option value="N_ame" >이름</option>
								<option value="C_ont" >내용</option>
								<option value="A_ll" >전체</option>
							</select>
							<input type="text" name="sword" value="" class="search_text">
							<input type="button" value="검 색" class="search_btn">
						</div>
					</form>

				</div>
			</div>
		<!-- 컨텐츠 종료 -->

		</div>

		<div class="sp50"></div>


		<!--  footer 시작 -->

		<? include "../include/bottom.html"; ?>

		<!--  footer 끝 -->

	</div>
  
</body>
</html>