<? 
#디비관련 셋팅파일 불러 오기
include './db_config/dbcon.php';
include './db_config/mysql.php';

# htm 셋팅 관련 파일 불러오기
include './htm_config/setting.php';
include './htm_config/top.php';

if($Sub_No=='') $Sub_No='1';
else if($Sub_No=='ally') $Sub_No='';
else $Sub_No=$Sub_No;

//게시물 총수
$total_all=total_all();
//오늘 등록된 게시물
$total_today=total_today();
?>	

<SCRIPT LANGUAGE="JavaScript">
<!--
function go_seatch() {
	frm = document.form1 
	frm.submit()
}

function Check() {
	alert("죄송합니다 내용을 확인 할수 없습니다.\n\n글이  이미 삭제 되었습니다.. ");
}
//-->
</SCRIPT>

				<table width='<?=$main_table_width?>'   border='0' cellpadding='0' cellspacing='0'>
					<tr><td height='30'></td></tr>					
					
					<tr><!-- 게시판 타이틀설정 -->
						<td>
							<table width='100%' border='0' cellpadding='0' cellspacing='0'>
								<tr>
									<td align='right' width="10%"><?=$titlegrim?></td>
									<td class='td14' align="left">&nbsp;<b><?=$Board_Title?></b></td>
								</tr>
								<tr>
									<td colspan='2' align='right'>
										<font color="#B0282C"><b>ALL: <?=$total_all?>&nbsp;&nbsp;NEW: <?=$total_today?></b></font>&nbsp;
									</td>
								</tr>
							</table>
						</td>
					</tr><!-- 게시판 타이틀설정 끝 -->

					<tr><td height='3'></td></tr>
					<tr>
						<td valign='top'>
							<table width='<?=$T_width?>' height='<?=$T_height?>'  border='0' cellpadding='0' cellspacing='0'>
								<tr><td colspan='6' height='3' bgcolor='<?=$bg_line?>'></td></tr>									
									
									<tr bgcolor='<?=$bg_back?>'>
										<td width='60' height='29' align='center'>번 호</td>
										<td width='150' align='center'>제품코드</td>
										<td width='220' align='center'>내용</td>
										<td width='80' align='center'>작성자</td>
										<td width='70' align='center'>날 짜</td>
										<td width='80' align='center'>평가</td>
									</tr>

									<tr><td colspan='6' height='1' bgcolor='<?=$line_back?>'></td></tr>
									

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

$p=$tpage-$page+1; //page 변수 치환.
//echo "$page";
 ###################################################


//게시판 내용 출력 하기
if($tn==0){
?>

									
									<tr>
										<td colspan='6' align='center' >현재 등록된 글이 없습니다.</td>
									</tr>
									<tr><td colspan='6' height='1' bgcolor='<?=$line_back?>'></td></tr>
<?
}else{

while($list_query=mysql_fetch_array($Rs)){
	if ($tn<=$k2 && $tn>=$k1 && $tn>0 ) { 

	//리스트 출력 내용
	$list_db_value=list_db_value($No,$Title,$Name,$W_time,$Cnt,$Files,$new,$Cont_type,$Fname,$Cont);
	$No=$list_db_value[0];					$Title=$list_db_value[1];
	$Name=$list_db_value[2];				$W_time=$list_db_value[3];
	$Cnt=$list_db_value[4];				$Files=$list_db_value[5];
	$new=$list_db_value[6];				$Cont_type=$list_db_value[7];
	$Cont=$list_db_value[9];


include "../common/dbconn.php";
$query="select title FROM $shop_goods where code='$Title'";  
													//echo "$query";
$result= mysql_query($query,$DB);
	
$title=$rs[0][0];
		

	
?>									
									<tr>
										<td height='27' align='center'><?=$tn?></td>

										<td>&nbsp;<?=$Title?><br>&nbsp;<?=$title?> <?=$new?><?=$Files?></td>

										<? if($Cont_type=='Del')	{  ?>
										<td>&nbsp;<a href='#' onclick='Check();' onfocus='this.blur()'><font color='#999999'><s><?=$Cont?></s></font></a></td>
										<? }else{ 
											if($select!=""){	   
											     $link_value="No=$No&page=$p&sword=$sword&select=$select";
											}else{
											    $link_value="No=$No&page=$p";
											}
										
										?>
										<td>&nbsp;<a href='view.php?<?=$link_value?>' onfocus='this.blur()'><?=$Cont?></a></td>
										<?}?>
										<td align='center'><?=$Name?></td>
										<td align='center'><?=$W_time?></td>
										<td align='center'><?=$Cnt?></td>
									</tr>
									<tr><td colspan='6' height='1' bgcolor='<?=$line_back?>'></td></tr>
<?	
	}; 
	$tn--; 
}  #while 마감
} #else 마감
?>
									<tr>
										<td colspan='6' height='5' align='center'>
										<?
											if($select!="") $link_search="sword=$sword&select=$select";
											
											 //============================= 다음 chapter 처리  =========== 
											if($page2!=0){
												if ($page2 != 1) {	
													echo "<a href='$PHP_SELF?Sub_No=$Sub_No&page=1&$link_search' title='【 첫 페이지 】' class='page'>1</a>&nbsp;..";
													echo "<a href='$PHP_SELF?Sub_No=$Sub_No&page=$pageprevprev&$link_search' class='page'><STRONG><small>◀</small></STRONG></a></small>"; 
												}
			
												for ($i=$page2;  $i<=$page1; $i++)  { 
													if ($p==$i){
														echo "&nbsp;<font color=silver>  $i </font>";
													}else {
														echo "&nbsp;<a href='$PHP_SELF?Sub_No=$Sub_No&page=$i&$link_search'  title='$i Page' class='page'>$i </a>";
													}																
												} 

												if ($page1 != $tpage)  {
													echo "<a href='$PHP_SELF?Sub_No=$Sub_No&page=$pagenextnext&$link_search' class='page'><STRONG><small>▶</small></STRONG></a>"; 
													echo"..&nbsp;&nbsp;<a href='$PHP_SELF?Sub_No=$Sub_No&page=$tpage&$link_search' title='【 마지막 페이지 】' class='page'>$tpage</a>";
												}
											}
											//======================================================== 
										?>	  
										
										</td>
									</tr>
									<form name='form1' method='post' action='<?=$PHP_SELF?>'> 
									<input type='hidden' name='search' value='on'> 
									<tr>
										<td colspan='3'>
											<select name='select' style='width:100;font-size:9pt;' >
											<option value="T_itle" selected>제품코드</option>
											<option value="N_ame">이름</option>
											<option value="C_ont">내용</option>
											<option value="A_ll">전체</option>
											</select>
											<input type='text'  size='15'  name='sword'>
											<input type='hidden'  name='Sub_No' value='<?=$Sub_No?>'>
											<input type='button' value=' 검색 ' onclick='go_seatch();'>
										</td>
										<td colspan='3' align='right'>
											<?if($select!=""){?>
											<a href='list.php?Sub_No=<?=$Sub_No?>' onfocus='this.blur()'>리스트</a>&nbsp;
											<?}?>
											<a href='write.php?Sub_No=<?=$Sub_No?>' onfocus='this.blur()'>글쓰기</a>&nbsp;
										</td>
									</tr>
								</table>
								</form>
								<!-- 게시판 end -->


<?include './htm_config/down.php';?>