<? 
#디비관련 셋팅파일 불러 오기
include './db_config/dbcon.php';
include './db_config/mysql.php';

# htm 셋팅 관련 파일 불러오기
include './htm_config/setting.php';
include './htm_config/top.php';


if($mode=="edit"||$mode=="reply"){
		//검색일때 페이지 셋팅(수정과 답변일때만 사용 된다.
		if($select!="") $page="$page&sword=$sword&select=$select";
}
?>	
			<script src='script/w_check.js'></script>
			<script type="text/javascript" src="se2/js/HuskyEZCreator.js" charset="utf-8"></script>
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
							<table width='<?=$T_width?>' height='<?=$T_height?>'  border='0' cellpadding='0' cellspacing='0'>
							
							<?if($mode==""){ $P_Link="http://";  $Name="관리자"; ?>
								<form name='form1' method='post' <?=$uplode?> action='writedo.php'>
								
							<?}else if($mode=="edit"){?>
								<form name='form1' method='post' <?=$uplode?> action='editdo.php'>
								<?
							
									$Quiery_data=Quiery_data();
									$Sub_No=$Quiery_data[0];			$Name=$Quiery_data[1];
									$P_Up=$Quiery_data[2];				$P_Name=$Quiery_data[3];
									$P_Location=$Quiery_data[4];		$P_Size=$Quiery_data[5];
									$P_Link=$Quiery_data[6];				$P_Target=$Quiery_data[7];
									$Cont=$Quiery_data[8];				$Pass=$Quiery_data[9];
									$Cont_type=$Quiery_data[10];		$P_Fname=$Quiery_data[11];
									$P_Fsize=$Quiery_data[12];

								?>
								<input type='hidden' name='No' value='<?=$No?>'> 
								
								<input type='hidden' name='Old_file'  value='<?=$P_Fname?>' size='19'>
								<input type='hidden' name='Old_size'  value='<?=$P_Fsize?>' size='19'>
								
								<input type='hidden' name='page'  value='<?=$page?>' size='19'>

							<?
								}else if($mode=="reply"){
								$Quiery_data=Quiery_data();
								$Cont=$Quiery_data[0];   $No1=$Quiery_data[1];
								$Homepage="http://";
							?>
								<form name='form1' method='post' <?=$uplode?> action='replydo.php'>
								 <input type='hidden' name='No1' value='<?=$No1?>'> 
								 <input type='hidden' name='page'  value='<?=$page?>' size='19'>
							<?}?>
							
								<input type="hidden" name="keynum">
							
								 <tr><td colspan='3' height='10'></td></tr>
								 <tr><td colspan='3' height='3' bgcolor='<?=$bg_line?>'></td></tr>
								 <tr><td colspan='3' height='2'></td></tr>
								
								 
								 <!-- 카타고리 -->
								 <tr>
									<td width='170' height='35' align='right'>* 팝업설정&nbsp;</td>
									<td width='20'></td>
									<td width='610' align="left">
										<!-- &nbsp;<? include './select_board.php';?> &nbsp;-->
										<input type="hidden" name="Sub_No" value="<?=$Sub_No?>">
										&nbsp;<input type='checkbox' name='P_Up' <? if($P_Up==1){?>checked<?}?> value='1' style='border:0;background-color: #FFFFFF ;'>팝업 사용 (체크하시면 메인에 팝업창이 나타납니다.)
									</td>
								</tr>								
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>
								 
								 
								 <!-- 작성자 -->
								 <tr>
									<td width='170' height='35' align='right'>* 작성자&nbsp;</td>
									<td width='20'></td>
									<td width='610' align="left">&nbsp;<input type='text' name='Name' value='<?=$Name?>' size='30' ></td>
								</tr>								
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>

								<!-- 비밀번호 -->
								 <tr>
									<td width='170' height='35' align='right'>* 비밀번호&nbsp;</td>
									<td width='20'></td>
									<td width='610' align="left">&nbsp;<input type='password' name='Pass' onKeyDown="Cal_Key_num++;" value='<?=$Pass?>' size='30' ></td>
								</tr>								
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>
								
								<!-- 팝업명 -->
								<tr>
									<td height='35' align='right'>* 팝업명&nbsp;</td>
									<td width='20'></td>
									<td width='610' align="left">&nbsp;<input type='text' name='P_Name' value='<?=$P_Name?>' size='75'></td>
								</tr>
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>

								
								<!-- 팝업위치 -->
								<tr>
									<td height='35' align='right'>팝업위치&nbsp;</td>
									<td width='20'></td>
									<td width='610' align="left">&nbsp;<input type='text' name='P_Location' value='<?=$P_Location?>' size='40'> 예시:100-200[가로-세로]<br /></td>
								</tr>
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>

								<!-- 팝업크기 -->
								<tr>
									<td height='35' align='right'>팝업크기&nbsp;</td>
									<td width='20'></td>
									<td width='610' align="left">&nbsp;<input type='text' name='P_Size' value='<?=$P_Size?>' size='40'> 예시:300-600[가로-세로]<br /> (이미 완성된 이미지를 첨부하여 내용을 나타낼때는 필요없습니다.)</td>
								</tr>
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>
								
								<!-- 팝업링크 -->
								<tr>
									<td height='35' align='right'>팝업링크&nbsp;</td>
									<td width='20'></td>
									<td width='610' align="left">&nbsp;<input type='text' name='P_Link' value='<?=$P_Link?>' size='75'></td>
								</tr>
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>
								
								<!-- 링크 창열기 -->
								<tr>
									<td height='35' align='right'>링크열기&nbsp;</td>
									<td width='20'></td>
									<td width='610' align="left">&nbsp;<input type='radio' name='P_Target' size='75' value="_blank" <?if($P_Target==""){?>checked<?}?>>새창으로&nbsp;
									<input type='radio' name='P_Target' size='75' value="_parent" <?if($P_Target=="" || $P_Target=="_parent"){?>checked<?}?>>부모창으로&nbsp;
									<!-- <input type='radio' name='P_Target' size='75' value="_self" <?if($P_Target=="_self"){?>checked<?}?>>현재창으로&nbsp;
									<input type='radio' name='P_Target' size='75' value="_top" <?if($P_Target=="_top"){?>checked<?}?>>최상위창으로&nbsp; --><br />
									(<b>새창으로</b>의 연결은 외부사이트로의 연결시에 선택하여주세요) </td>
								</tr>
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>
								
								<tr><td colspan='3' height='11'></td></tr>
								
								<!-- 설명 -->
								<tr>
									<td height='35' align='right'>&nbsp;</td>
									<td width='20'></td>
									<td width='610' style="padding-left:20px;" align="left">&nbsp;<b>내용은 에디터툴을 이용해 직접 작성하시거나<br />&nbsp;미리 제작된 이미지를 첨부하여 주세요.</b></td>
								</tr>
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>

								<!-- 내 용 -->
								<tr>
									<td colspan="3">
										<textarea name="Cont" id="Cont" rows="10" cols="100"><?=$Cont?></textarea>
									</td>
								</tr>
								<script type="text/javascript">
									var oEditors = [];
									nhn.husky.EZCreator.createInIFrame({
										oAppRef: oEditors,
										elPlaceHolder: "Cont",
										sSkinURI: "se2/SmartEditor2Skin.html",
										fCreator: "createSEditor2"
									});
								</script>
								
								<tr><td colspan='3' height='11'></td></tr>
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>

								
								<input type="hidden" name="Cont_type" value="AUTO">
								

										<!-- 파 일-->
								
								<tr>
									<td height='35' align='right'>내용에 이미지 첨부&nbsp;</td>
									<td width='20'></td>
									<td width='610' align="left">
										<input type='file' name='File' size='60'>
										<BR>
										<? if($mode=="edit" and $P_Fname!=""){ ?>
											<?=$P_Fname?> <input type='checkbox' name='F_del' value='0'>삭제	
										<?}?>
									</td>
								</tr>
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>		
								
								
								<tr><td colspan='3' height='12'></td></tr>
								<tr><td colspan='3' height='2' bgcolor='<?=$bg_line?>'></td></tr>
								<tr><td colspan='3' height='5'></td></tr>
								
								<tr>
									<td colspan='3'>&nbsp;</td>
								</tr>
								<tr><td colspan='3' height='5'></td></tr>
								<tr>
									<td colspan='3' align='center'>
										
										<a href='#' onclick='return check(document.form1)'>[확 인]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<a href='list.php?Sub_No=<?=$Sub_No?>'>[취 소]</a>
									</td>
								</tr>
								<tr><td colspan=3 height=10></td></tr>
							</form>
							</table><!-- 게시판 end -->
							




<?include './htm_config/down.php';?>