<? 
#디비관련 셋팅파일 불러 오기
include '../common/dbconn.php';
include './db_config/mysql.php';

# htm 셋팅 관련 파일 불러오기
include './htm_config/setting.php';
include './htm_config/top.php';
include "../inc/set_com.php";



if($Sub_No=='') $Sub_No='1';
else if($Sub_No=='ally') $Sub_No='';
else $Sub_No=$Sub_No;

//게시물 총수
$total_all=total_all();
echo $total_all;exit;
//오늘 등록된 게시물
$total_today=total_today();

if(strlen($Board_Title)>6){
	$Board_Title=$Board_Title;
}else{
	$Board_Title=$Board_Title."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
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

function go_del() {
	go=confirm('\n정말로 데이터를 삭제 하시겠습니까?\n')
	if(go==true){
		document.form.action="list_del.php?Sub_No=<?=$Sub_No?>";
		document.form.submit();
	}else{return false;}
}
function go_del1() {
	document.form.action="list_del.php?Sub_No=<?=$Sub_No?>";
	document.form.submit();
}
//-->
</SCRIPT>

<script language='javascript'> 
<!--
	function select_all(status){ 
        for(var i=0; i<document.form.chk_num.value; i++){ 
			document.form.elements[ "check" + i ].checked=status; 
        } 
    }
	//-->
</script>

<script src="script/view.js"></script>

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
								<tr>
										<td height='29' align='right' colspan="6"><input type='button' value="전체해제" onclick='select_all(false)' onfocus=this.blur();>&nbsp;<input type='button' value="전체선택" onclick='select_all(true)' onfocus=this.blur();></td>
									</tr>
									<tr><td colspan='6' height='3' bgcolor='<?=$bg_line?>'></td></tr>	
									<tr bgcolor='<?=$bg_back?>'>
										<td width='80' height='29' align='center'>번 호</td>
										<td width='390' align='center'>제 목</td>
										<td width='80' align='center'>이 름</td>
										<td width='70' align='center'>날 짜</td>
										<td width='80' align='center'>조회수</td>
										<td width="59" height="26" align="center"><input type="button" value="선택삭제" class="adminbttn" onClick="javascript:go_del()" onfocus=this.blur();></td>
									</tr>

									<tr><td colspan='6' height='1' bgcolor='<?=$line_back?>'></td></tr>
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

									<tr bgcolor="#F2F5F8">
										<td height='27' align='center'><b><font color="#B0282C">공지</font></b></td>
										
										<? 
											if($select!=""){	   
											     $link_value="No=$B_Title_No&page=$p&sword=$sword&select=$select&Sub_No=$Sub_No";
											}else{
											    $link_value="No=$B_Title_No&page=$p&Sub_No=$Sub_No";
											}										
										?>
										<td align="left">&nbsp;&nbsp;<a href='view.php?<?=$link_value?>' onfocus='this.blur()'>&nbsp;&nbsp;<b><?=$B_Title_Title?></b></a> <?=$B_Title_new?><?=$B_Title_Files?></td>
									
										<td align='center'><b><?=$B_Title_Name?></b></td>
										<td align='center'><b><?=$B_Title_W_time?></b></td>
										<td align='center'><b><?=$B_Title_Cnt?></b></td>
										<td align='center'><b></b></td>
									</tr>
									<tr><td colspan='6' height='1' bgcolor='<?=$line_back?>'></td></tr>
<?	
	$B_Title_tn--; 
	}  #while 마감
} #if 마감

//게시판 내용 출력 하기
if($tn==0){
?>

									
									<tr>
										<td colspan='6' align='center' height='100'>현재 등록된 글이 없습니다.</td>
									</tr>
									<tr><td colspan='6' height='1' bgcolor='<?=$line_back?>'></td></tr>
<?
}else{
$ii=0;
while($list_query=mysql_fetch_array($Rs)){
	if ($tn<=$k2 && $tn>=$k1 && $tn>0 ) { 

	//리스트 출력 내용
	$list_db_value=list_db_value($No,$Title,$Name,$W_time,$Cnt,$Files,$new,$Cont_type,$Secret,$No1);
	$No=$list_db_value[0];					$Title=$list_db_value[1];
	$Name=$list_db_value[2];				$W_time=$list_db_value[3];
	$Cnt=$list_db_value[4];				$Files=$list_db_value[5];
	$new=$list_db_value[6];				$Cont_type=$list_db_value[7];
	$Fname=$list_db_value[8];			$Secret=$list_db_value[9];
	$No1=$list_db_value[10];

if($Secret=="1"){
	$Secret=" <font color='#F20000'>[비밀글]</font>";
	$Homepage_active = '활성';
}else{
	$Secret="";
	$Homepage_active = '비활성';
}
	if($Sub_No=='2') $Secret = "";

	//해당 No 의 커맨드 수
	$Comm=Comm();
?>		

									<tr>
										<td height='27' align='center'><?=$tn?></td>
										<? if($Cont_type=='Del')	{  ?>
										<td align="left">&nbsp;&nbsp;<a href='#' onclick='Check();' onfocus='this.blur()'><font color='#999999'><s><?=$Title?></font></s></a></td>
										<? }else{ 
											if($select!=""){	   
											     $link_value="No=$No&page=$p&sword=$sword&select=$select&Sub_No=$Sub_No";
											}else{
											    $link_value="No=$No&page=$p&Sub_No=$Sub_No";
											}
										
										?>
										<td align="left">&nbsp;&nbsp;<a href='view.php?<?=$link_value?>'>&nbsp;&nbsp;<?=$Title?><?=$Comm?><?=$Secret?></a>  <?=$new?><?=$Files?>

										<!--일반모드 <?if($Sub_No=="1"){?>
											<?if($Secret!=""){?>
												<a href='#' onfocus='this.blur()' onClick="MM_showHideLayers_secret('secret','','show',<?=$No?>)"><?=$Title?><?=$Comm?><?=$Secret?></a>
											<?}else{?>
												<a href='board01_view.htm?<?=$link_value?>'><?=$Title?><?=$Comm?></a>
											<?}?>
										<?}else{?>
												<a href='board01_view.htm?<?=$link_value?>'><?=$Title?><?=$Comm?></a>				
										<?}?><?=$new?><?=$Files?>-->
										</td>
										<?}?>

										<td align='center'><?=$Name?></td>
										<td align='center'><?=$W_time?></td>
										<td align='center'><?=$Cnt?></td>
										<td align='center'><!-- 관리자모드 전체삭제용 -->
										<input type="checkbox" name="check<?=$ii?>" value="<?=$No?>">
										<input type="hidden" name="check<?=$ii?>_r" value="<?=$No1?>">
										</td>
									</tr>
									<tr><td colspan='6' height='1' bgcolor='<?=$line_back?>'></td></tr>

<?	
	$ii++;
	}; 
	$tn--; 
	}  #while 마감
} #else 마감
?>	
									<input type="hidden" name="chk_num" value="<?=$k3?>">  
									</form>

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
											<select name='select' style='width:50;font-size:9pt;' >
											<option value="T_itle" <?if($select=='T_itle') echo "selected";?>>제목</option>
											<option value="N_ame" <?if($select=='N_ame') echo "selected";?>>이름</option>
											<option value="C_ont" <?if($select=='C_ont') echo "selected";?>>내용</option>
											<option value="A_ll" <?if($select=='A_ll') echo "selected";?>>전체</option>
											</select>
											<input type='text'  size='15'  name='sword' value='<?=$sword?>'>
											<input type='hidden'  name='Sub_No' value='<?=$Sub_No?>'>
											<input type='button' value=' 검색 ' onclick='go_seatch();'>
											<!-- 검색 버튼 <img src="images/search_btn.jpg" alt="검색" border="0" align="absmiddle"  onclick="go_seatch();" style="cursor:hand;" > -->
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

<!-- 비밀글 보기 레이어 실행 -->
<div id="secret" style="position:absolute; width:200px; height:80px; z-index:1; left: 420px; top: 280px; visibility: hidden; border: 1px solid black; background: white">
<table border="0" cellspacing="0" cellpadding="3" width="200">
	<tr bgcolor="#E0E0E0" onMouseOut="drag=0" onMouseOver="dragObj=secret; drag=1;move=0" class="">
   		<td>[비밀글 보기]</td>
		<td align="right"><a href="#" onClick="MM_showHideLayers('secret','','hide')"><img src="./img/close.gif" width="12" height="11" alt="" border="0"></a></td>
	</tr>
	<form method="post" name="Secret">
	<tr class="">
		<td align="" colspan="2">
			비밀번호: <input type="password" name="PassWord" value="" size="11"  onKeypress="Key_Press_Edit()">  <input type="button" name="button" value="확 인" onClick="Edit_Ok_Secret()" style="background-color:white; BORDER: #dddddd 1px solid; WIDTH:50; HEIGHT: 20" class=""> 
			<input type="hidden" name="Edit" value="Edit_ok"><!-- pass_check 구분 변수 -->
			<input type="hidden" name="No" id="nid" value="">
			<input type="hidden" name="page" value="<?=$page?>">
		</td>
   </tr>
    <tr class="">
		<td align="" colspan="2">
			<font color="#CE0005">&nbsp;&nbsp;* 비밀글을 보기 위해서는 <BR>
			   &nbsp;&nbsp;&nbsp; &nbsp;비밀번호를 입력해 주세요</font>
		</td>
   </tr>
	</form>
</table>
</div>