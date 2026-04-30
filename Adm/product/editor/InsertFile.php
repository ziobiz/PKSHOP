<html>
<head>
<title>파일첨부</title>
</head>
<body bgcolor="#dedede">
<form name="TableForm" method="post" action="InsertFileOk.asp" enctype="multipart/form-data">
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
	<TR>
		<TD>
			<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
				<TR>
					<TD>
						<input type="file" name="Filename" size="30" style='font-family:verdana;font-size:8pt'>
					</TD>
				</TR>
				<TR>
					<TD>
						<br>
						<input type="submit" value="확인" style='font-family:verdana;font-size:8pt'>
						<input type="button" value="취소" onclick="self.close();" style='font-family:verdana;font-size:8pt'>
					</TD>
				</TR>
			</TABLE>
		</TD>
	</TR>
</TABLE>
</form>
</body>
</html>
