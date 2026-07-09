<?
#####################################################################
include "../common/user_function.php";
include "../common/dbconn.php";
include_once "../inc/admin_shell_lib.php";
#####################################################################
?>
<?php pkshop_admin_auto_shell_begin(); ?>
<html>
<head>
<title>관리자모드</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../image/style.css" type="text/css">
<head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor='#EFF3F6'>
<div align=left valign=top>
<!-- 전체 테이블 begin -->
<table width='100%' border=0 cellpadding=0 cellspacing=0>
<tr>
	<td><!-- 컨텐츠 부분 -->
		<table width=1000 border=0 cellpadding=0 cellspacing=0 bgcolor='#ffffff'>
			<tr>
				<td width=170 bgcolor='#F1F1F1' valign=top rowspan=2><!-- 좌측 메뉴부분 -->
					<? include "../inc/admin_left_counter.php"; ?>
				</td>
				<td align=center valign=top><!-- 우측 컨텐츠 부분 -->

				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0" class="left_margin30">

					<tr><td height=30 align="center"><iframe src="../nalog507/admin_counter.php?counter=<?=$counter?>" width="800" height="900" frameborder="0"></iframe></td></tr>
					
				</table>
				</td>
			</tr>
			<tr><td height=40></td></tr>
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
<!-- 전체 테이블 end -->
</div>
</body>
</html>
