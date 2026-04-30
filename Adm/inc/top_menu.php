<? 
include "../common/dbconn.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>관리자</title>
<link rel="stylesheet" href="../image/style.css" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<? 
$idok = $_SESSION["idok"];
if($PATH_TRANSLATED!='../Adm/login/login.html'){

if($idok!="yes"){?>
<SCRIPT LANGUAGE="JavaScript">
<!--
alert("관리자만 접근하실수 있습니다.");
location="../login/login.php";
//-->
</SCRIPT>
<?
exit;	
}
}?>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="194" height="73" bgcolor="#ffc105">
<!-- 	<img src="../image/logo3.png" width="194" height="73" /> -->
	</td>
    <td colspan="2" align="right" valign="bottom" bgcolor="#ffc105"><span class="headtext"></span><a href='../login/logout.php'><img src="../img/logout.gif" width="56" height="20" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
   <tr>
    <td height="49" colspan="3" bgcolor="#dfdfdd"><table width="980" border="0" align="left" cellpadding="0" cellspacing="0">
     <tr>
        <td width="194" height="49" align="center" bgcolor="#dfdfdd"><a href='../product/category.php'><B>상품관리</B></a></td>
        <td width="2" height="49"><img src="img/pawm_line.gif" width="2" height="49" /></td>
		<td width="194" height="49" align="center" bgcolor="#dfdfdd"><a href='../product/pro_order.php?sel_status=주문접수'><B>주문배송관리</B></a></td>
        <td width="2" height="49"><img src="img/pawm_line.gif" width="2" height="49" /></td>
		<td width="194" height="49" align="center" bgcolor="#dfdfdd"><a href='../product/order_day.php'><B>매출관리</B></a></td>
        <!-- <td width="2" height="49"><img src="img/pawm_line.gif" width="2" height="49" /></td>
		<td width="194" height="49" align="center" bgcolor="#dfdfdd"><a href='https://admin7.allthegate.com/chaMng/login/login.jsp' target="_blank"><B>카드결제확인</B></a></td>
        <td width="2" height="49"><img src="img/pawm_line.gif" width="2" height="49" /></td>
		<td width="194" height="49" align="center" bgcolor="#dfdfdd"><a href='../admin_board_03/list.php'><B>후기관리</B></a></td> -->
        <td width="2" height="49"><img src="img/pawm_line.gif" width="2" height="49" /></td>        
        <td width="194" height="49" align="center" bgcolor="#dfdfdd"><a href='../member/member.php?dis=0'><B>회원관리</B></a></td>
        <td width="2" height="49"><img src="img/pawm_line.gif" width="2" height="49" /></td>
        <!-- <td width="194" height="49" align="center" bgcolor="#dfdfdd"><a href='../admin_board_01/list.php'><B>게시판관리</B></a></td> 
		<td width="2" height="49"><img src="img/pawm_line.gif" width="2" height="49" /></td> -->
        <!-- <td width="194" height="49" align="center" bgcolor="#dfdfdd"><a href='../admin_board_popup/list.php'><B>팝업창관리</B></a></td>
		<td width="2" height="49"><img src="img/pawm_line.gif" width="2" height="49" /></td> -->
        <td width="194" height="49" align="center" bgcolor="#dfdfdd"><a href='../admin_pass/bank_change.php'><B>계좌변경</B></a></td>

		<!--<td width="194" height="49" align="center" bgcolor="#dfdfdd"><a href='../center/center
		_list.php'><B>센터등록</B></a></td>-->
        <td width="2" bgcolor="#dfdfdd"><img src="img/pawm_line.gif" width="2" height="49" /></td>
      </tr>
    </table></td>
  </tr>