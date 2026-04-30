<?
$dbname="db008059";     
$DBid="webcom"; 
$DBpass="webcom2002"; 

$DB=mysql_connect("mysql2.direct.co.kr", $DBid, $DBpass);
mysql_select_db($dbname);  //디비 테이블 이름을 통해 디비 테이블을 선택한당,,
	$r=mysql_query("select * from newzip where dong like '$dong%'");
?>
<html>
<head>
<title>우편번호검색</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../image/style.css" type="text/css">
<style type="text/css">
<!--
-->
</style>
</head>
<script>
function pok(x,y)
{
opener.document.join.zipcorde.value=x
opener.document.join.addr.value=y
opener.document.join.addr.focus()
this.close(); 
}
</script>
<body bgcolor="EBEBEB" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width='301' border='0' cellspacing='0' cellpadding='0'>
  <tr> 
    <td colspan='3'><img src='images/zip_img01.gif' width='301' height='55'></td>
  </tr>
  
        <tr > 
          <td height="35" align="center" > ※ 검색결과 중 해당주소를 클릭하시면 됩니다. </td>
        </tr>
        <tr> 
          <td width='' >
		  
		  <table width='301%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='C7C7C7'>
              
			  <tr> 
                <td height="30" bgcolor="#FFFFFF"><?
	while($d=mysql_fetch_row($r))
	{
		$k="$d[1] $d[2] $d[3] $d[4] $d[5]";
		echo "&nbsp;&nbsp;&nbsp;<font face='돋음' size='2'><a href=\"javascript:pok('$d[0]','$k')\" class=A_F>$k</a></font><font face='돋음' size='2' color=red>[$d[0]]</font><br>";   //$d[0]=x, $k=y
	} 
	?></td>
              </tr>


            </table>
			
			
			</td>
        </tr>
        
      </table></td>
    <td width='5' background='images/right.gif' bgcolor='AEAEAE'>&nbsp;</td>
  </tr>
  
</table>







			 
</body>
</html>
<?	mysql_close($DB);?>