<?
#####################################################################

include "../common/user_function.php";
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_attendance.php";

$query = "SELECT id,ip,signdate FROM $attendance WHERE id='$id' and signdate>'$wdate1' and signdate<'$wdate2' order by signdate desc";
$DB->get($query,$rs,$rn);
if(!$result) {
  	error("QUERY_ERROR");
  	exit;
}
$row=mysql_fetch_assoc($result);
$total_record = $rn;

$wdate1_tmp=$wdate1;
$wdate2_tmp=$wdate2;

if($wdate1< 1354201200){
	$wdate1 = " ";
}else{
	$wdate1 = date("Y-m-d",$wdate1);
}

if($wdate2< 1354201200){
	$wdate2 = " ";
}else{
	$wdate2 = date("Y-m-d",$wdate2);
}




#####################################################################
?>
				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr><td height=30></td></tr>
					<tr><td height=3></td></tr>
					<tr>
						<td>
							
							<table class="pg-table pg-table-form" width="100%" border='0' cellspacing='0' cellpadding='0'>

								<tr><td colspan=4 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=4 height=5></td></tr>
								<tr>
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">상품명</font></div>
									</td>

									<?
									$query_t="select title FROM $shop_goods where code='$id'";  
									//echo "$query_t";
									$result_t= mysql_query($query_t,$DBconn);
									$row_t = mysql_fetch_row($result_t);	
									$title=$row_t[0];
									?>
									<td width=182 height="30">
										<font face="돋움" size="2">&nbsp; <b>
										<?=$title?>(<?=$id?>)</b></font>
									</td>
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">접속기간</font></div>
									</td>
									<td width=182 height="30">
										<font face="돋움" size="2">&nbsp; 
										<?=$wdate1?> ~ <?=$wdate2?></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<?
								for($i = 0; $i < $total_record; $i++) { 
									$id =$rs[$i][0];
									$ip =$rs[$i][1];
									$signdate =$rs[$i][2];
									$signdate = date("Y-m-d H:i:s",$signdate);										
								?>
								<tr>
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">접속일</font></div>
									</td>
									<td width=479 height="30" colspan="3">
										<font face="돋움" size="2">&nbsp; 
										<?=$ip?> / <?=$signdate?></font>
									</td>
								</tr>
								<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>
								<?}?>
							</table>
						</td>
					</tr>

				</table> 
				<table width="600" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
					<tr><td height="30"></td></tr>
					<tr> 
						<td height="20" align="center"> 
							<a href="attendance.php">[목록]</a>
						</td>
					</tr>
				</table>
				<br><br>
<? include "../inc/down_menu.php"; ?>
