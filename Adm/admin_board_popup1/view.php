<?
// 조회수 한번 읽은 글은 No 값 쿠키 선언해서 조회수 업을 막는다..(하루)
if($board_cook==""){
	$count=$board_cook.$No."/";
	setcookie("board_cook","$count",0,"/");
	$hit="up";
}else{
	$coki=explode('/',$board_cook);
	$coki_soo=count($coki)-1;
	for($n=0;$n<$coki_soo;$n++){
		$Noo=$coki[$n];  $Noo=(int)$Noo; $No=(int)$No;
		//echo "<font color=white>$Noo</font><br>";
		if($No==$Noo){
			$hit="noup"; break; 
		} 
  	}//for 문
}

if($hit!="noup"){
	$count=$board_cook.$No."/";
	setcookie("board_cook","$count",0,"/");
	$hit="up";
}

#디비관련 셋팅파일 불러 오기
include './db_config/dbcon.php';
include './db_config/mysql.php';

# htm 셋팅 관련 파일 불러오기
include './htm_config/setting.php';
include './htm_config/top.php';
 
//조회수를 업한다. 쿠키 값이 없을때..
if($hit=="up")  $Cnt_count=Cnt_count();

# 데이타를 불러 온다.   이전글 과 다음글 번호 까지(귀차니즘 ㅡㅡ;) 
$Quiery_data=Quiery_data();
$Sub_No=$Quiery_data[0];			$Name=$Quiery_data[1];
$P_Up=$Quiery_data[2];				$P_Name=$Quiery_data[3];
$P_Location=$Quiery_data[4];		$P_Size=$Quiery_data[5];
$P_Link=$Quiery_data[6];				$P_Target=$Quiery_data[7];
$Cont=$Quiery_data[8];				$Cnt=$Quiery_data[9];
$Ip=$Quiery_data[10];					$Files=$Quiery_data[11];
$Date_time=$Quiery_data[12];		$prevno=$Quiery_data[13];
$nextno=$Quiery_data[14];			$P_Fname=$Quiery_data[15];

//검색일때 페이지 셋팅
if($select!="") $page="$page&sword=$sword&select=$select";
if($page=="") $page="1";
?>	

<script src="script/view.js"></script>

					<table width='<?=$main_table_width?>'   border='0' cellpadding='0' cellspacing='0'>
					<tr><td height='30'></td></tr>
					
					<tr><!-- 게시판 타이틀설정 -->
						<td>
							<table border='0' cellpadding='0' cellspacing='0'>
								<tr>
									<td width='60' align='center'><?=$titlegrim?></td>
									<td class='td14'>&nbsp;<b><?=$Board_Title?></b></td>
								</tr>
							</table>
						</td>
					</tr><!-- 게시판 타이틀설정 끝 -->

					<tr><td height='3'></td></tr>
					<tr>
						<td valign='top'>
							
							<table width='<?=$T_width?>'   border='0' cellpadding='0' cellspacing='0'>
								<tr><td colspan='2' height='10' align="right"></td></tr>
								<tr><td colspan='2' height='3' bgcolor='<?=$bg_line?>'></td></tr>
								<tr><td colspan='2' height='2' bgcolor='<?=$bg_back?>'></td></tr>

								
								<!-- <tr bgcolor='<?=$bg_back?>'>
									<td height='25'>&nbsp;&nbsp;&nbsp;조회수 : <?=$Cnt?></td>
									<td align='right'>작성일 : <?=$Date_time?>&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr>
									<td  height='25' bgcolor='<?=$bg_back?>'>&nbsp;&nbsp;&nbsp;작성자 : <?=$Name?></td>
									<td align='right' bgcolor='<?=$bg_back?>'>아이피 : <?=$Ip?>&nbsp;&nbsp;&nbsp;</td>
								</tr> -->

								<tr bgcolor='<?=$bg_back?>'>
									<td colspan="2" height='25' align="left">&nbsp;&nbsp;&nbsp;<b>사용여부 :</b> <?if($P_Up=='1'){?>O<?}else{?>X<?}?>&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr><td colspan='2' height='5' bgcolor='<?=$bg_back?>'></td></tr>
								<tr><td colspan='2' height='1' bgcolor='<?=$line_back?>'></td></tr>

								<tr bgcolor='<?=$bg_back?>'>
									<td colspan="2" height='25' align="left">&nbsp;&nbsp;&nbsp;<b>팝업이름 :</b> <?=$P_Name?>&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr><td colspan='2' height='5' bgcolor='<?=$bg_back?>'></td></tr>
								<tr><td colspan='2' height='1' bgcolor='<?=$line_back?>'></td></tr>
								
								<tr bgcolor='<?=$bg_back?>'>
									<td colspan="2" height='25' align="left">&nbsp;&nbsp;&nbsp;<b>팝업위치 :</b> <?=$P_Location?>&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr><td colspan='2' height='5' bgcolor='<?=$bg_back?>'></td></tr>
								<tr><td colspan='2' height='1' bgcolor='<?=$line_back?>'></td></tr>	
								
								<tr bgcolor='<?=$bg_back?>'>
									<td colspan="2" height='25' align="left">&nbsp;&nbsp;&nbsp;<b>팝업크기 :</b> <?=$P_Size?>&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr><td colspan='2' height='5' bgcolor='<?=$bg_back?>'></td></tr>
								<tr><td colspan='2' height='1' bgcolor='<?=$line_back?>'></td></tr>

								<tr bgcolor='<?=$bg_back?>'>
									<td colspan="2" height='25' align="left">&nbsp;&nbsp;&nbsp;<b>링&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;크 :</b> <?=$P_Link?>&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr><td colspan='2' height='5' bgcolor='<?=$bg_back?>'></td></tr>
								<tr><td colspan='2' height='1' bgcolor='<?=$line_back?>'></td></tr>

								<tr bgcolor='<?=$bg_back?>'>
									<td colspan="2" height='25' align="left">&nbsp;&nbsp;&nbsp;<b>열릴 &nbsp;창 :</b> <?if($P_Target=='_blank'){?>새로운 창으로 열기<?}else if($P_Target=='_self'){?>현재창에서 열기<?}else if($P_Target=='_parent'){?>현재창을 호출한 부모창에서 열기<?}else if($P_Target=='_top'){?>최상위창에서 열기<?}?>&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr><td colspan='2' height='5' bgcolor='<?=$bg_back?>'></td></tr>
								<tr><td colspan='2' height='1' bgcolor='<?=$line_back?>'></td></tr>

								<tr bgcolor='<?=$bg_back?>'>
									<td colspan="2" height='25' align="left">&nbsp;&nbsp;&nbsp;<b>이미지 &nbsp; :</b> <?=$Files?>&nbsp;&nbsp;&nbsp;</td>
								</tr>
								<tr><td colspan='2' height='5' bgcolor='<?=$bg_back?>'></td></tr>
								<tr><td colspan='2' height='1' bgcolor='<?=$line_back?>'></td></tr>
								
								<tr><td colspan='2' height='18'></td></tr>
								 <tr>
									<td colspan='2' align='center' valign='top'>
									<table width='670' border='0' cellpadding='0' cellspacing='1'>
										<tr>
											<td bgcolor='#ffffff' style='padding:10; padding-left:15' align="left"><?=$Cont?></td>
										</tr>
									</table> 
									</td>
								</tr>
									
								<tr><td colspan='2' height='20'></td></tr>
								<tr><td colspan='2' height='1' bgcolor='<?=$line_back?>'></td></tr>
								<tr><td colspan='2' height='5'></td></tr>							
																		
								<tr>
									<td align="left">
										&nbsp;&nbsp;
										<?if($B_Title!=1){?>
										<a href='view.php?No=<?=$prevno?>&Sub_No=<?=$Sub_No?>' onfocus='this.blur()'>이전글</a>
										<a href='view.php?No=<?=$nextno?>&Sub_No=<?=$Sub_No?>' onfocus='this.blur()'>다음글</a>
										<?}?>
									</td>
											
									<td  align='right'>
										<a href='list.php?page=<?=$page?>&Sub_No=<?=$Sub_No?>' onfocus='this.blur()'>리스트</a>&nbsp;&nbsp;
										<a href='write.php?Sub_No=<?=$Sub_No?>' onfocus='this.blur()'>글쓰기</a>&nbsp;&nbsp;
										<a href='write.php?No=<?=$No?>&mode=edit&page=<?=$page?>' onfocus='this.blur()' >글수정</a>&nbsp;&nbsp;
										<!-- 일반모드일때 <a href='#' onfocus='this.blur()' onClick="MM_showHideLayers('edit','','show')">글수정</a>&nbsp;&nbsp;  -->
										<?if($B_Title!=1){?>
										<!-- <a href='write.php?No=<?=$No?>&Sub_No=<?=$Sub_No?>&mode=reply&page=<?=$page?>' onfocus='this.blur()'>답변</a>&nbsp;&nbsp; -->
										<?}?>
										<a href='#' onfocus='this.blur()' onclick="return admin_del('<?=$No?>')">삭제</a>&nbsp;&nbsp
										<!-- 일반모드일때<a href='#' onfocus='this.blur()' onClick="MM_showHideLayers('Del','','show')">삭제</a>&nbsp;&nbsp -->
									</td>
								</tr>
							</table>
							<!-- 게시판 end -->
					<?include './htm_config/down.php';?>

<!-- 글 수정 하기 레이어 실행 -->
<div id="edit" style="position:absolute; width:200px; height:80px; z-index:1; left: 420px; top: 280px; visibility: hidden; border: 1 solid black; background: white">

<table border="0" cellspacing="0" cellpadding="3" width="200">
	<tr bgcolor="#E0E0E0" onMouseOut="drag=0" onMouseOver="dragObj=edit; drag=1;move=0">
   		<td>[√글 수정하기]</td>
		<td align="right"><a href="#" onClick="MM_showHideLayers('edit','','hide')"><img src="./img/close.gif" width="12" height="11" alt="" border="0"></a></td>
	</tr>
	<form method="post" name="Edit">
	<tr>
		<td align="" colspan="2">
			비밀번호: <input type="password" name="PassWord" value="" size="11"  onKeypress="Key_Press_Edit()">  <input type="button" name="button" value="확 인" onClick="Edit_Ok()" style="background-color:white; BORDER: #dddddd 1px solid; WIDTH:50; HEIGHT: 20"> 
			<input type="hidden" name="Edit" value="Edit_ok"><!-- pass_check 구분 변수 -->
			<input type="hidden" name="No" value="<?=$No?>">
			<input type="hidden" name="page" value="<?=$page?>">
		</td>
   </tr>
    <tr>
		<td align="" colspan="2">
			<font color="#CE0005">&nbsp;&nbsp;* 해당 글 을 수정 합니다. <BR>
			   &nbsp;&nbsp;&nbsp; &nbsp;비밀번호를 입력해 주세요</font>
		</td>
   </tr>
	</form>
</table>
</div>


<!-- 글 삭제 하기 레이어 실행 -->
<div id="Del" style="position:absolute; width:200px; height:80px; z-index:1; left: 420px; top: 280px; visibility: hidden; border: 1 solid black; background: white"> 
	<table border=0 cellspacing=0 cellpadding=3 width=200>
		<tr bgcolor="#E0E0E0" onMouseOut="drag=0" onMouseOver="dragObj=Del; drag=1;move=0">
   			<td>[√글 삭제하기]</td>
		<td align="right"><div align="right"><a href="#" onClick="MM_showHideLayers('Del','','hide')"><img src="./img/close.gif" width="12" height="11" alt="" border="0"></a></div></td>
	</tr>
	<form method="post" name="Delete">
	<tr>
		<td align="" colspan="2">
			비밀번호: <input type="password" name="PassWord" value="" size="11"  onKeypress="Key_Press_Del()">  <input type="button" name="button" value="확인" onClick="Del_Ok()" style="background-color:white; BORDER: #dddddd 1px solid; WIDTH:50; HEIGHT: 20">
			<input type="hidden" name="Del_ok" value="ok"><!-- pass_check 구분 변수 -->
			<input type="hidden" name="No" value="<?=$No?>">
		</td>
   </tr>
   <tr>
		<td align="" colspan="2">
			<font color="#CE0005">&nbsp;&nbsp;* 해당 글 을 삭제 합니다. <BR>
			   &nbsp;&nbsp;&nbsp; &nbsp;비밀번호를 입력해 주세요</font>
		</td>
   </tr>
	</form>
	</table>
</div>

