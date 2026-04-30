<meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />

		<title>Admin / HCBRS Concept Global</title>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
HCBRS Concept Global Shopping Mall
<link href="../images/style.css" rel="stylesheet" type="text/css" />
<? 
include "../common/dbconn.php";

$url_title=ucfirst("$url_check[2]") ;
/*################ 관리자 아이디 자동 생성 ################################*/



?>
<script language="JavaScript">
<!--
function loginP(j)
{
	if(j=="i")
		{
		  if(!document.form.id.value)
			{
				alert('아이디를 입력하세요!');
				document.form.id.focus();
				return;
			}
          if(!document.form.password.value)
			{
				alert('패스워드를 입력하세요!');
				document.form.password.focus();
				return;
			}
			document.form.action = "login_do.php";
		} 
		else 
			{
				document.form.action = "logout.php";
			}
		document.form.submit();
}
function EnterCheck(i) {
   if(event.keyCode ==13 && i==1) 
   { 
       document.form.password.focus(); 
   }
   if(event.keyCode ==13 && i==2) 
   { 
      document.form.action = "login_do.php?j=i";
      document.form.submit();
   } 
}
-->
</script>
</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="151" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="142" height="89">&nbsp;</td>
<!--     <td><img src="../img/paxmlogo_03.gif" width="157" height="89" border="0" /></td> -->
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" bgcolor="#ffc104"><table width="504" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td rowspan="7"><img src="../img/login_title.gif" width="157" height="218" /></td>
        <td width="69">&nbsp;</td>
        <td width="278" height="55" colspan="2">&nbsp;</td>
      </tr>

	  <form name="form" method="post" >
      <tr>
        <td>&nbsp;</td>
        <td colspan="2"><label for="ID"></label>
          <input type='text' name="id" size="45" maxlength="10" tabindex='1' OnKeyDown="EnterCheck(1);" class="formbox"></td>
      </tr>
      <tr>
        <td></td>
        <td height="7" colspan="2"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2"><input  type="password" name="password" tabindex='2' size="45" maxlength="20" OnKeyDown="EnterCheck(2);" class="formbox"></td>
      </tr>
      <tr>
        <td></td>
        <td height="12" colspan="2"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td align="right"><a href="javascript:loginP('i')" onMouseOver="status=''; return true;"><img src="../img/login.gif" width="84" height="33" border="0"></td>
      </tr>
	  </form>
      <tr>
        <td>&nbsp;</td>
        <td height="47" colspan="2" align="right" class="text2"></td>
      </tr>
    </table></td>
  </tr>
 
</table>
</body>
</html>


									