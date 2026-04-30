<? 
#디비관련 셋팅파일 불러 오기
include './db_config/dbcon.php';
include './db_config/mysql.php';

# htm 셋팅 관련 파일 불러오기
include './htm_config/setting.php';
include './htm_config/top.php';

$Sub_No = $_GET[$Sub_No];

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

function go_use() {
	go=confirm('\n정말로 적용하시겠습니까?\n')
	if(go==true){
		document.form.action="pop_change.php?Sub_No=<?=$Sub_No?>";
		document.form.submit();
	}else{return false;}
}

function pop_use(num){ 
	var ox="ox"+num;
	if(document.getElementById(ox).value=='O'){
		document.getElementById(ox).value='X';
	}else if(document.getElementById(ox).value=='X'){
		document.getElementById(ox).value='O';
	} 
}
//-->
</SCRIPT>

				<table width='<?=$main_table_width?>'   border='0' cellpadding='0' cellspacing='0'>
					<tr><td height='30'></td></tr>					
					
					<tr><!-- 게시판 타이틀설정 -->
						<td>
							<table width='100%' border='0' cellpadding='0' cellspacing='0'>
								<tr>
									<td width='60' align='center'><?=$titlegrim?></td>
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
								<tr><td colspan='5' height='3' bgcolor='<?=$bg_line?>'></td></tr>									
									
									<tr bgcolor='<?=$bg_back?>'>
										<td width='80' height='29' align='center'>번 호</td>
										<td width='170' align='center' >팝업명</td>
										<td width='300' align='center'>링크주소</td>
										<td width='80' align='center'><input type="button" value="[적용]" class="adminbttn" onClick="javascript:go_use()" onfocus=this.blur(); style="cursor:hand;"></td>
										<td width='70' align='center'>날 짜</td>
									</tr>

									<tr><td colspan='5' height='1' bgcolor='<?=$line_back?>'></td></tr>
									<form name="form" method="post">

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

//$k3=$k2-$k1+1;
$p=$tpage-$page+1; //page 변수 치환.
//echo "$page";
 ###################################################


//게시판 내용 출력 하기
if($tn==0){
?>

									
									<tr>
										<td colspan='5' align='center' >현재 등록된 글이 없습니다.</td>
									</tr>
									<tr><td colspan='5' height='1' bgcolor='<?=$line_back?>'></td></tr>
<?
}else{
$ii=0;
while($list_query=mysql_fetch_array($Rs)){
	if ($tn<=$k2 && $tn>=$k1 && $tn>0 ) { 

	//리스트 출력 내용
	$list_db_value=list_db_value($No,$P_Up,$P_Name,$P_Link,$W_time,$Cnt,$Files,$new,$Cont_type,$Fname,$P_Ups);
	$No=$list_db_value[0];					$P_Up=$list_db_value[1];
	$P_Name=$list_db_value[2];			$P_Link=$list_db_value[3];
	$W_time=$list_db_value[4];			$Cnt=$list_db_value[5];
	$Files=$list_db_value[6];				$new=$list_db_value[7];
	$Cont_type=$list_db_value[8];		$Fname=$list_db_value[9];
	$P_Ups=$list_db_value[10];
	

?>									
									<tr>
										<td height='27' align='center'><?=$tn?></td>	
										<?
											if($select!=""){	   
											     $link_value="No=$No&page=$p&sword=$sword&select=$select";
											}else{
											    $link_value="No=$No&page=$p";
											}
										?>
										<td align="left">&nbsp;&nbsp;<a href='view.php?<?=$link_value?>' onfocus='this.blur()'>&nbsp;&nbsp;<?=$P_Name?></a> <?=$new?><?=$Files?></td>
										<td align='center'><a href="<?=$P_Link?>" target="_blank"><?=$P_Link?></a></td>
										<td align='center' onclick='pop_use(<?=$ii?>)'><input name="P_Up<?=$ii?>" id="ox<?=$ii?>" type='text' value="<?if($P_Up=='1'){?>O<?}else{?>X<?}?>" onfocus=this.blur();   style="border:0;cursor:hand;width:10px;"></td>
										<input type="hidden" name="check<?=$ii?>" value="<?=$No?>">
										<td align='center'><?=$W_time?></td>
									</tr>
									<tr><td colspan='5' height='1' bgcolor='<?=$line_back?>'></td></tr>
<?	
	$ii++;
	}
	$tn--; 
}  #while 마감
} #else 마감

?>
									<input type="hidden" name="chk_num" value="<?=$k2?>">  
									</form>
									<tr><td colspan='5' align="right" valign="top">('O, X' 를 눌러 팝업창의 사용 여부를 결정 후 상단의 <b>[적용]</b>을 눌러주세요.<br> 'O'로 표시된 것은 현재 메인화면에 팝업창이 나타나고 있습니다.)</td></tr>
									<tr>
										<td colspan='5' height='5' align='center'>
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
										<td colspan='3' align="left">
											<select name='select' style='width:100;font-size:9pt;' >
											<option value="P_N_ame" <?if($select=='P_N_ame') echo "selected";?>>팝업명</option>
											<option value="P_C_ont" <?if($select=='P_C_ont') echo "selected";?>>내용</option>
											<option value="A_ll" <?if($select=='A_ll') echo "selected";?>>전체</option>
											</select>
											<input type='text'  size='15'  name='sword'>
											<input type='hidden'  name='Sub_No' value='<?=$Sub_No?>'>
											<input type='button' value=' 검색 ' onclick='go_seatch();'>
										</td>
										<td colspan='2' align='right'>
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