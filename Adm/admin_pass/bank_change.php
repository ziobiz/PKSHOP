include_once "../inc/admin_shell_lib.php";
<html>
<head>
<title>관리자모드</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../image/style.css" type="text/css">
<head>



<? include "../inc/top_menu.php"; 

$query = "SELECT * from su_info WHERE idx='1'";

$DB->get($query,$rs,$rn);
// print_r($rs)
?>
<?php pkshop_admin_auto_shell_begin(); ?>
<tr><td>
<table width='100%' border=0 cellpadding=0 cellspacing=0>
<tr>
	<td><!-- 컨텐츠 부분 -->
		<table width=1000 border=0 cellpadding=0 cellspacing=0 bgcolor='#ffffff'>
			<tr>
				<td width=170 bgcolor='#F1F1F1' valign=top rowspan=2><!-- 좌측 메뉴부분 -->
					<? include "../inc/left_menu.php"; ?>
<?php pkshop_admin_auto_shell_begin(); ?>
				</td>
				<td align=center valign=top><!-- 우측 컨텐츠 부분 -->

				<table width="800" border="0" cellspacing="0" cellpadding="0" class="left_margin30">
				<form name="form" method="post">
					<tr><td height=30></td></tr>
					<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>관리자변경</b></td>
								</tr>
							</table>
					</td></tr>
					<tr><td height=3></td></tr>
					<tr>
						<td>	
<script language="JavaScript">
<!--
function check()
{

	 if(!document.form.c_bank.value)
			{
				alert('은행명을 입력하세요!');
				document.form.c_bank.focus();
				return;
			}
	 if(!document.form.c_banknum.value)
			{
				alert('계좌번호를 입력하세요!');
				document.form.c_banknum.focus();
				return;
			}
	 if(!document.form.c_bankname.value)
			{
				alert('예금주를 입력하세요!');
				document.form.c_bankname.focus();
				return;
			}

		document.form.action = "bank_change_do.php";
		
		document.form.submit();
}
-->
</script>
<TABLE cellSpacing=0 borderColorDark=#ffffff cellPadding=1 width=420 align=center bgColor=#eeeeee borderColorLight=#000000 border=1>
  <TR>
		
    <TD width=400 > 
	<form name="form" method="post" >
      <TABLE cellSpacing=0 borderColorDark=#ffffff cellPadding=1 width=438 align=center borderColorLight=#999999 border=1>
        
		<input type="hidden" name="admin_cid" value="admin">
		<TR>
		    <TD  align=center height="46"  colspan=2><FONT SIZE=4><B>계좌번호 변경<B></FONT></TD>		
		</TR>

		<TR>
		    <TD width=146 align=center height="67" >은행명 설정</TD>		
		    <TD width=400 height=67 > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <input type="text" name="c_bank" value="<?=$rs[0]["c_bank"]?>"  style="HEIGHT:20; BORDER:gray 1px solid; WIDTH: 150"></TD>
		</TR>
		<TR>
		    <TD width=146 align=center height="67" >계좌번호 설정</TD>		
		    <TD width=400 height=67 > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <input type="text" name="c_banknum" value="<?=$rs[0]["c_banknum"]?>"  style="HEIGHT:20; BORDER:gray 1px solid; WIDTH: 150"></TD>
		</TR>
		<TR>
		    <TD width=146 align=center height="67" >예금주 설정</TD>		
		    <TD width=400 height=67 > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <input type="text" name="c_bankname"  value="<?=$rs[0]["c_bankname"]?>" style="HEIGHT:20; BORDER:gray 1px solid; WIDTH: 150"></TD>
		</TR>
		<TR>
		    <TD align=center height="67" colspan=2><input type="button" value=" 비밀번호 변경 " onclick="javascript:check();"></TD>
		</TR>
		
		</TABLE>
		</form>	
		</TD>
	</TR>
</TABLE>

<BR>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height=70 align=center bgcolor='#EFF3F6'>
					
				</td>
			</tr>
		</table>
	</td>
</tr>
</table>

</td></tr>
<?php pkshop_admin_shell_end(); ?>
<?php pkshop_admin_auto_shell_begin(); ?>
<!-- 전체 테이블 end -->
</div>
</body>
</html>