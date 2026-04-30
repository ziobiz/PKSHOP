<!------#include file="../../include/config.asp"--------------->
<%


	PageSize	= 20	
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
<title>그림삽입</title>
</head>
<script language="javascript">
function MakeImage(Filename)
{
	var ImageString='<img src="<%=AdminDown%>/';
	
	ImageString+=Filename;
	ImageString+='">';

	if (window.opener.document.all.editBox == null) {
		window.opener.MakeImage(ImageString);
	}
	else {
		window.opener.document.all.editBox.MakeImage(ImageString);
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
					<TD><img src="<%=AdminDown%>/<%=Filename%>"></TD>
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
						<input type="button" value="확인" onclick="MakeImage('<%=Filename%>');" style='font-family:verdana;font-size:8pt' onfocus='this.blur()'>
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
