<!------#include file="../../include/config.asp"--------------->
<%
Set UploadForm = Server.CreateObject("DEXT.FileUpload")
UploadForm.DefaultPath = Server.Mappath(AdminDown)

Filename = UploadForm("Filename")

If Filename <> "" Then
	Filename = UploadForm.DefaultPath & "\" & UploadForm("Filename").FileName
	Filename = UpLoadForm("Filename").SaveAs(Filename, False)
	Filename = Right(Filename, Len(Filename) - InStrRev(Filename, "\"))
End If
Set UploadForm = Nothing
%>
<html>
<head>
<title>파일첨부</title>
</head>
<script language="javascript">
function MakeFile(objForm)
{
	var FileString='<a href="<%=Domain%>/<%=Mid(AdminDown, 7)%>/';
	
	FileString+=objForm.Filename.value;
	FileString+='" target=_blank>';
	FileString+=objForm.FileHelp.value;
	FileString+='</a>';

	if (window.opener.document.all.editBox == null) {
		window.opener.MakeImage(FileString);
	}
	else {
		window.opener.document.all.editBox.MakeImage(FileString);
	}
	window.close();
}
</script>
<body bgcolor="#dedede">
<form>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
	<TR>
		<TD>
			<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
				<TR>
					<TD style='font-family:verdana;font-size:8pt'>첨부파일명 : <%=Filename%><input type="hidden" name="Filename" value="<%=Filename%>" style='font-family:verdana;font-size:8pt'></TD>
				</TR>
				<TR>
					<TD style='font-family:verdana;font-size:8pt'>도움말 : <input type="text" name="FileHelp" size="40" style='font-family:verdana;font-size:8pt'></TD>
				</TR>
			</TABLE>
		</TD>
	</TR>
	<TR>
		<TD>
		<br>
			<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
				<TR>
					<TD>
						<input type="button" value="확인" onclick="MakeFile(this.form);" style='font-family:verdana;font-size:8pt' onfocus='this.blur()'>
						<input type="button" value="이전" onclick="history.back();" style='font-family:verdana;font-size:8pt' onfocus='this.blur()'>
						<input type="button" value="취소" onclick="self.close();" style='font-family:verdana;font-size:8pt' onfocus='this.blur()'>
					</TD>
				</TR>
			</TABLE>
		</TD>
	</TR>
</TABLE>
</form>
</body>
</html>
