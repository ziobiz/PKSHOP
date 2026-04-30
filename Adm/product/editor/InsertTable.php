<html>
<head>
<title>표삽입</title>
</head>
<script language="javascript">
function MakeTable(objForm)
{
	var TableString='<table';
	
	if(objForm.TableWidth.value!='') TableString+=' width='+objForm.TableWidth.value;
	if(objForm.TableHeight.value!='') TableString+=' height='+objForm.TableHeight.value;
	if(objForm.TableCellpadding.value!='') TableString+=' cellpadding='+objForm.TableCellpadding.value;
	if(objForm.TableCellspacing.value!='') TableString+=' cellspacing='+objForm.TableCellspacing.value;
	if(objForm.TableBorder.value!='') TableString+=' border='+objForm.TableBorder.value;
	if(objForm.TableAlign.value!='') TableString+=' align='+objForm.TableAlign.value;
	if(objForm.TableBorderColor.value!='') TableString+=' bordercolor='+objForm.TableBorderColor.value;
	if(objForm.TableBgcolor.value!='') TableString+=' bgcolor='+objForm.TableBgcolor.value;
	TableString+='>\n';
	for(var rows=0; rows < objForm.TableRows.value; rows++)
	{
		TableString+='\t<tr>\n';
		for(var columns=0; columns < objForm.TableColumns.value; columns++)
		{
			TableString+='\t\t<td></td>\n';
		}
		TableString+='\t</tr>\n';
	}
	TableString+='</table>\n';
	window.returnValue=TableString;
	self.close();
	return true;
}
</script>
<body bgcolor="#dedede">
<form name="TableForm">
<TABLE WIDTH=90% height=100% align=center BORDER=0 CELLSPACING=0 CELLPADDING=0>
	<TR>
		<TD>
			<TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=1>
				<TR>
					<TD style='font-family:verdana;font-size:8pt'>열갯수</TD>
					<TD style='font-family:verdana;font-size:8pt'>
						<select name="TableColumns" style='font-family:verdana;font-size:8pt'>
<?For($i=1;$i<11;$i++){?>
							<option value="<?=$i?>" <?if($i=="3"){?>selected<?}?>><?=$i?></option>
<?}?>
						</select>개
					</TD>
					<TD style='font-family:verdana;font-size:8pt'>행갯수</TD>
					<TD style='font-family:verdana;font-size:8pt'>
						<select name="TableRows" style='font-family:verdana;font-size:8pt'>
<?For($i=1;$i<11;$i++){?>
							<option value="<?=$i?>" <?if($i=="3"){?>selected<?}?>><?=$i?></option>
<?}?>
						</select>개
					</TD>
				</TR>
				<TR>
					<TD style='font-family:verdana;font-size:8pt'>넓이</TD>
					<TD style='font-family:verdana;font-size:8pt'>
						<select name="TableWidth" style='font-family:verdana;font-size:8pt'>
							<option value="">기본값</option>
<?For($i=10;$i<101;$i++){?>
							<option value="<?=$i?>" <?if($i=="50"){?>selected<?}?>><?=$i?></option>
<?}?>
						</select>%
					</TD>
					<TD style='font-family:verdana;font-size:8pt'>높이</TD>
					<TD style='font-family:verdana;font-size:8pt'>
						<select name="TableHeight" style='font-family:verdana;font-size:8pt'>
							<option value="">기본값</option>
<?For($i=10;$i<101;$i++){?>
							<option value="<?=$i?>"><?=$i?></option>
<?}?>
						</select>%
					</TD>
				</TR>
				<TR>
					<TD style='font-family:verdana;font-size:8pt'>셀여백</TD>
					<TD style='font-family:verdana;font-size:8pt'>
						<select name="TableCellpadding" style='font-family:verdana;font-size:8pt'>
							<option value="">기본값</option>
<?For($i=1;$i<11;$i++){?>
							<option value="<?=$i?>" <?if($i=="1"){?>selected<?}?>><?=$i?></option>
<?}?>
						</select>Pixel
					</TD>
					<TD style='font-family:verdana;font-size:8pt'>셀간격</TD>
					<TD style='font-family:verdana;font-size:8pt'>
						<select name="TableCellspacing" style='font-family:verdana;font-size:8pt'>
							<option value="">기본값</option>
<?For($i=1;$i<11;$i++){?>
							<option value="<?=$i?>" <?if($i=="1"){?>selected<?}?>><?=$i?></option>
<?}?>
						</select>Pixel
					</TD>
				</TR>
				<TR>
					<TD style='font-family:verdana;font-size:8pt'>외곽선굵기</TD>
					<TD style='font-family:verdana;font-size:8pt'>
						<select name="TableBorder" style='font-family:verdana;font-size:8pt'>
							<option value="">기본값</option>
<?For($i=1;$i<11;$i++){?>
							<option value="<?=$i?>" <?if($i=="1"){?>selected<?}?>><?=$i?></option>
<?}?>
						</select>Pixel
					</TD>
					<TD style='font-family:verdana;font-size:8pt'>표정렬</TD>
					<TD style='font-family:verdana;font-size:8pt'>
						<select name="TableAlign" style='font-family:verdana;font-size:8pt'>
							<option value="">기본값</option>
							<option value="left">왼쪽</option>
							<option value="center">가운데</option>
							<option value="right">오른쪽</option>
						</select>
					</TD>
				</TR>
				<TR>
					<TD style='font-family:verdana;font-size:8pt'>수평정렬</TD>
					<TD style='font-family:verdana;font-size:8pt'>
						<select name="TableHorizontalAlign" style='font-family:verdana;font-size:8pt'>
							<option value="">기본값</option>
							<option value="left">왼쪽</option>
							<option value="center">가운데</option>
							<option value="right">오른쪽</option>
						</select>
					</TD>
					<TD style='font-family:verdana;font-size:8pt'>수직정렬</TD>
					<TD style='font-family:verdana;font-size:8pt'>
						<select name="TableVerticalAlign" style='font-family:verdana;font-size:8pt'>
							<option value="">기본값</option>
							<option value="top">위</option>
							<option value="middle">중앙</option>
							<option value="bottom">아래</option>
						</select>
					</TD>
				</TR>
				<TR>
					<TD style='font-family:verdana;font-size:8pt'>테두리색</TD>
					<TD style='font-family:verdana;font-size:8pt'>
						<select name="TableBorderColor" style='font-family:verdana;font-size:8pt'>
							<option value="">기본값</option>
							<option value='white'>흰색</option>
							<option value='gray'>회색</option>
							<option value='#ffff90'>연한노랑</option>
							<option value='#ffffcf'>베이지</option>
							<option value='#cf9000'>황토색</option>
							<option value='maroon'>적갈색</option>
							<option value='#ff9000'>주황색</option>
							<option value='red'>빨간색</option>
							<option value='#9090ff'>연보라색</option>
							<option value='#902fcf'>보라색</option>
							<option value='#cfffff'>옅은하늘색</option>
							<option value='0099cc'>옅은파란색</option>
							<option value='#6666FF'>파란색</option>
							<option value='#2fff2f'>연두색</option>
							<option value='green'>녹색</option>
							<option value='black'>검정색</option>
						</select>
					</TD>
					<TD style='font-family:verdana;font-size:8pt'>배경색</TD>
					<TD style='font-family:verdana;font-size:8pt'>
						<select name="TableBgcolor">
							<option value="">기본값</option>
							<option value='black'>검정색</option>
							<option value='green'>녹색</option>
							<option value='#2fff2f'>연두색</option>
							<option value='#6666FF'>파란색</option>
							<option value='0099cc'>옅은파란색</option>
							<option value='#cfffff'>옅은하늘색</option>
							<option value='#902fcf'>보라색</option>
							<option value='#9090ff'>연보라색</option>
							<option value='red'>빨간색</option>
							<option value='#ff9000'>주황색</option>
							<option value='maroon'>적갈색</option>
							<option value='#cf9000'>황토색</option>
							<option value='#ffffcf'>베이지</option>
							<option value='#ffff90'>연한노랑</option>
							<option value='gray'>회색</option>
							<option value='white'>흰색</option>
						</select>
					</TD>
				</TR>
				<TR>
					<TD colspan=4 style='font-family:verdana;font-size:8pt' align=center>
						<input type="button" value="확인" onclick="MakeTable(this.form);" onfocus='this.blur()' style='font-family:verdana;font-size:8pt'>
						<input type="button" value="취소" onclick="self.close();" onfocus='this.blur()' style='font-family:verdana;font-size:8pt'>
					</TD>
				</TR>
			</TABLE>
		</TD>
	</TR>
</TABLE>
</form>
</body>
</html>