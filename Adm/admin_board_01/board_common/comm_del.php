<SCRIPT LANGUAGE="JavaScript">
<!--
function Comm_Ok()	{
	frm   = document.Comm_Delelt
	if(frm.PassWord.value == ""){
		alert("해당 커맨드 비밀번호를 입력해 주세요.");
		frm.PassWord.focus();
		return;
	}   

	frm.action = "pass_check.php"
	frm.submit()
}	

function Key_Press_Comm(){
	if(window.event.keyCode ==13)
	Comm_Ok();
}
//-->
</SCRIPT>
<link rel="stylesheet" href="../admin/admin_board_01/script/style.css" type="text/css">
<body topmargin="0" leftmargin="0">
	<table border=0 cellspacing=0 cellpadding=3 width=200>
		<tr bgcolor="#E0E0E0" >
   			<td>[√커맨드 삭제하기]</td>
		<td align="right"><div align="right"></div></td>
	</tr>
	<form method="post" name="Comm_Delelt">
	<tr>
		<td align="" colspan="2">
			비밀번호: <input type="password" name="PassWord" value="" size="11"  onKeypress="Key_Press_Comm()">  <input type="button" name="button" value="확인" onClick="Comm_Ok()" style="background-color:white; BORDER: #dddddd 1px solid; WIDTH:50; HEIGHT: 20">
			<input type="hidden" name="Memo" value="Y"><!-- pass_check 구분 변수 -->
			<input type="hidden" name="Comm_No" value="<?=$Comm_No?>">
			<input type="hidden" name="No" value="<?=$No?>">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="Cm_del" value="OK">
		</td>
   </tr>
   <tr>
		<td align="" colspan="2">
			<font color="#CE0005">&nbsp;&nbsp;* 해당 커맨드를 삭제 합니다. <BR>
			   &nbsp;&nbsp;&nbsp; &nbsp;비밀번호를 입력해 주세요</font>
		</td>
   </tr>
	</form>
	</table>
</body>