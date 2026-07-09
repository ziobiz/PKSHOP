include_once "../inc/admin_shell_lib.php";
<? 
?>
<?php pkshop_admin_auto_shell_begin(); ?>
<script language="javascript">
 <!--
 function checkIt(path) {
 	if(!document.form.from_name.value) {
 		alert('이름을 입력하세요!');
 		document.form.from_name.focus();
 		return;
 	}
 	if(!document.form.title.value) {
 		alert('제목을 입력하세요!');
 		document.form.title.focus();
 		return;
 	}
 	if(!document.form.doc.value) {
 		alert('내용을 입력하세요!');
 		document.form.doc.focus();
 		return;
 	}
 	document.form.action = "mailing_ok.php";
 	document.form.submit();
 }
 //-->
 </script>
				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr><td height=30></td></tr>
						<tr><td height=3></td></tr>
					<tr>
						<td> 
							
							<table class="pg-table pg-table-form" width="100%" border='0' cellspacing='0' cellpadding='0'>
							<form name="form" method="post" action="./mailing_ok.php" ENCTYPE="multipart/form-data">
								<tr><td colspan=2 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=2 height=5></td></tr>
								<tr> 
									<td height="30" width="115" align="center">보내는이</td>
									<td height="30" align="left" width="474">
										&nbsp; 
										<input type="text" name="from_name" size="40" maxlength="40" class="adminbttn">
									</td>
								</tr>
								<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td height="30" width="115" align="center">받는이</td>
									<td height="30" align="left" width="474">
										&nbsp; 
										<input type="radio" name="kind" value="p" checked>
										개별회원&nbsp; 
										<input type="radio" name="kind" value="a">
										전체회원&nbsp; 	(조건 선택시는 전체회원에 적용됩니다.)								
									</td>
								</tr>
								<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td height="30" rowspan="6" width="115" align="center">조건선택</td>
									<td height="30" align="left" width="474">
									가입일별 : 
									<select name="m_year">
									<option value="0">무관
									<?for($i=date('Y');$i>1990;$i--){?>
									<option value="<?=$i?>"><?=$i?>
									<?}?>
									</select>년
									<select name="m_month">
									<option value="0">무관
									<?for($i=1;$i<13;$i++){?>
									<option value="<?=$i?>"><?=$i?>
									<?}?>
									</select>월
									<select name="m_day">
									<option value="0">무관
									<?for($i=1;$i<32;$i++){?>
									<option value="<?=$i?>"><?=$i?>
									<?}?>
									</select>일
									&nbsp;~&nbsp;
									<select name="m_year1">
									<option value="0">무관
									<?for($i=date('Y');$i>1990;$i--){?>
									<option value="<?=$i?>"><?=$i?>
									<?}?>
									</select>년
									<select name="m_month2">
									<option value="0">무관
									<?for($i=1;$i<13;$i++){?>
									<option value="<?=$i?>"><?=$i?>
									<?}?>
									</select>월
									<select name="m_day3">
									<option value="0">무관
									<?for($i=1;$i<32;$i++){?>
									<option value="<?=$i?>"><?=$i?>
									<?}?>
									</select>일
									</td>
								</tr>
								<tr><td height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 									
									<td height="30" align="left" width="474">
									성별 :	
									<select name="sex">
									<option value="0">무관</option>
									<option value="M" <?if ($sex=='M') echo("selected");?>>남</option>
									<option value="F" <?if ($sex=='F') echo("selected");?>>여</option>
									</select>
									</td>
								</tr>
								<tr><td height=1 bgcolor='#D2DEE8'></td></tr>								
								<tr> 									
									<td height="30" align="left" width="474">
									직업 : 
									<select size="1" name="job">
									<option value="0">무관</option>
									<option value="01" <?if ($job=='01') echo("selected");?>>회사원</option> 
									<option value="02" <?if ($job=='02') echo("selected");?>>학생</option> 
									<option value="03" <?if ($job=='03') echo("selected");?>>공무원</option> 
									<option value="04" <?if ($job=='04') echo("selected");?>>전문직</option> 
									<option value="05" <?if ($job=='05') echo("selected");?>>자영업</option> 
									<option value="06" <?if ($job=='06') echo("selected");?>>교직자</option> 
									<option value="07" <?if ($job=='07') echo("selected");?>>의료인</option> 
									<option value="08" <?if ($job=='08') echo("selected");?>>법조인</option> 
									<option value="09" <?if ($job=='09') echo("selected");?>>주부</option> 
									<option value="10" <?if ($job=='10') echo("selected");?>>종교/언론/예술 종사자</option> 
									<option value="11" <?if ($job=='11') echo("selected");?>>농/축/수산/광업</option> 
									<option value="12" <?if ($job=='12') echo("selected");?>>무직</option> 
									<option value="13" <?if ($job=='13') echo("selected");?>>기타</option> 
									</select>
									</td>
								</tr>
								<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td height="30" width="115" align="center">메일주소</td>
									<td height="30" align="left" width="474">
										&nbsp; 
										<input type="text" name="to_name" value="<?=$to_name?>" size="40" maxlength="40" class="adminbttn">
										<font color="#003366">* 개인에게 보낼경우만 사용 ( ;사용 )</font>
									</td>
								</tr>
								<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td height="30" width="115" align="center">제목</td>
									<td height="30" align="left" width="474">
										&nbsp; 
										<input type="text" name="title" size="56" maxlength="56" class="adminbttn">
										&nbsp; 
										<input type="checkbox" name="htmlyn" value="Y" checked> HTML
									</td>
								</tr>
								<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td height="30" width="115" align="center">내용</td>
									<td height="30" align="left" width="474">
										&nbsp; 
										<textarea name="doc" cols="70"  rows="20"></textarea>
									</td>
								</tr>
								<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td height="30" width="115" align="center">첨부</td>
									<td height="30" align="left" width="474">
										&nbsp; 
										<input type="file" name="userfile" value="찾아보기" class="adminbttn">
									</td>
								</tr>
								<tr><td colspan=2 height=1 bgcolor='#D2DEE8'></td></tr>
								<tr> 
									<td colspan="2" height="40" align="center"> 
										<input type="button" onClick="javascript:checkIt()" value="발송" class="adminbttn">
									</td>
								</tr>
								</form>  
							</table>
						</td>
					</tr>
				</table> 
				<br>
<?php pkshop_admin_shell_end(); ?>				
