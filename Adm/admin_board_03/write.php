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
							
							
							
							<?if($mode==""){ $Homepage="http://"; ?>
								<form name='form1' method='post' <?=$uplode?> action='writedo.php'>
								
							<?}else if($mode=="edit"){?>
								<form name='form1' method='post' <?=$uplode?> action='editdo.php'>
								<?
							
									$Quiery_data=Quiery_data();
									$Sub_No=$Quiery_data[0];			$Name=$Quiery_data[1];
									$Pass=$Quiery_data[2];				$Email=$Quiery_data[3];
									$Homepage=$Quiery_data[4];		$Title=$Quiery_data[5];
									$Cont=$Quiery_data[6];				$Cont_type=$Quiery_data[7];
									$Fname=$Quiery_data[8];				$Fname1=$Quiery_data[9];
									$B_Title=$Quiery_data[10];			$P_up=$Quiery_data[11];
									$Fsize=$Quiery_data[12];				$Fsize1=$Quiery_data[13];
									$Cnt=$Quiery_data[14];
								
								
								?>
								<input type='hidden' name='No' value='<?=$No?>'> 
								
								<input type='hidden' name='Old_file'  value='<?=$Fname?>' size='19'>
								<input type='hidden' name='Old_size'  value='<?=$Fsize?>' size='19'>
								
								<input type='hidden' name='Old_file1'  value='<?=$Fname1?>' size='19'>
								<input type='hidden' name='Old_size1'  value='<?=$Fsize1?>' size='19'>
								<input type='hidden' name='page'  value='<?=$page?>' size='19'>

							<?
								}else if($mode=="reply"){
								$Quiery_data=Quiery_data();
								$Cont=$Quiery_data[0];   $No1=$Quiery_data[1];
								$Title=$Quiery_data[2];
								$Homepage="http://";
							?>
								<form name='form1' method='post' <?=$uplode?> action='replydo.php'>
								 <input type='hidden' name='No1' value='<?=$No1?>'> 
								 <input type='hidden' name='page'  value='<?=$page?>' size='19'>
							<?}?>
							
								<input type="hidden" name="keynum" >
							
								 <tr><td colspan='3' height='10'></td></tr>
								 <tr><td colspan='3' height='3' bgcolor='<?=$bg_line?>'></td></tr>
								 <tr><td colspan='3' height='2'></td></tr>
								
								 
								 <!-- 카타고리 -->
								 <tr>
									<td width='170' height='35' align='right'>* 카테고리&nbsp;</td>
									<td width='20'></td>
									<td width='610' align="left">
										&nbsp;<? include './select_board.php';?>
										
									</td>
								</tr>								
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>
								 
								 <tr>
									<td width='170' height='35' align='right'>* 제품코드&nbsp;</td>
									<td width='20'></td>
									<td width='610' align="left">
										&nbsp;<? include './product_board.php';?>
										
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
								
								<!-- 이메일 
								<tr>
									<td height='35' align='right'>E-Mail&nbsp;</td>
									<td width='20'></td>
									<td width='610'>&nbsp;<input type='text' name='Email' value='<?=$Email?>' size='60'  ></td>
								</tr>
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>-->

								<!-- 홈페이지-->
								<tr>
									<td height='35' align='right'>평가&nbsp;</td>
									<td width='20'></td>
									<td width='610' align="left">&nbsp;<select name="Cnt">
										<option value="0" <?if($Cnt=="0"){?>selected<?}?>>0</option>
										<option value="1" <?if($Cnt=="1"){?>selected<?}?>>1</option>
										<option value="2" <?if($Cnt=="2"){?>selected<?}?>>2</option>
										<option value="3" <?if($Cnt=="3"){?>selected<?}?>>3</option>
										<option value="4" <?if($Cnt=="4"){?>selected<?}?>>4</option>
										<option value="5" <?if($Cnt=="5"){?>selected<?}?>>5</option>
										</select>
									
									</td>
								</tr>
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr> 
																
								<tr><td colspan='3' height='11'></td></tr>
								
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

								<!-- 파 일
								<tr>
									<td height='35' align='right'>파 일&nbsp;</td>
									<td width='20'></td>
									<td width='610'>
										<input type='file' name='File' size='60'>
										<BR>
										<? if($mode=="edit" and $Fname!=""){ ?>
											<?=$Fname?> <input type='checkbox' name='F_del' value='0'>삭제	
										<?}?>
									</td>
								</tr>
								<tr><td colspan='3' height='1' bgcolor='<?=$line_w_back?>'></td></tr>	-->							
								
								
								<!-- 파 일
								<tr>
									<td height='35' align='right'>파 일&nbsp;</td>
									<td width='20'></td>
									<td width='610'>
										<input type='file' name='File1' size='60'>
										<BR>
										<?  if($mode=="edit" and $Fname1!=""){ ?>
											<?=$Fname1?> <input type='checkbox' name='F1_del' value='0'>삭제	
										<?}?>
									
									</td>
								</tr>-->

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