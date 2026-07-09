<?
#####################################################################

include "../common/user_function.php";
include "../common/dbconn.php";


if($ydate1=='')  $ydate1=date('Y');
if($mdate1=='')  $mdate1=date('m');
if($ddate1=='')  $ddate1=date('d');

if($ydate2=='')  $ydate2=date('Y');
if($mdate2=='')  $mdate2=date('m');
if($ddate2=='')  $ddate2=date('d');

$wdate1 = mktime(0,0,0,$mdate1,$ddate1,$ydate1);
$wdate2 = mktime(23,59,59,$mdate2,$ddate2,$ydate2);

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>팍스엠</title>
<link rel="stylesheet" href="../image/style.css" type="text/css">

</head>

<body>
<center><br><br><br>

				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="4">
									<tr> 
										
										<td height="20"> 
											<select name="ydate1" class="formbox3">
											<? for($i=2013;$i<=Date("Y");$i++){?>
											<option value="<?=$i?>" <?if($ydate1==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select><span class="text2">년</span>&nbsp;

											<select name="mdate1" class="formbox3">
											<?for($i=1;$i<13;$i++){?>
											<option value="<?=$i?>" <?if($mdate1==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select><span class="text2">월</span>&nbsp;

											<select name="ddate1" class="formbox3">
											<?for($i=1;$i<32;$i++){?>
											<option value="<?=$i?>" <?if($ddate1==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select><span class="text2">일</span>&nbsp;
											~
											<select name="ydate2" class="formbox3">
											<? for($i=2013;$i<=Date("Y");$i++){?>
											<option value="<?=$i?>" <?if($ydate2==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select><span class="text2">년</span>&nbsp;

											<select name="mdate2" class="formbox3">
											<?for($i=1;$i<13;$i++){?>
											<option value="<?=$i?>" <?if($mdate2==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select><span class="text2">월</span>&nbsp;

											<select name="ddate2" class="formbox3">
											<?for($i=1;$i<32;$i++){?>
											<option value="<?=$i?>" <?if($ddate2==$i){?>selected<?}?>><?=$i?></option>
											<?}?>
											</select><span class="text2">일</span>&nbsp;

											&nbsp;&nbsp;
											<!-- <select name="keyfield">
											<option value="ip" <?if ($keyfield=='ip') echo("selected");?>>아이피</option>
											</select>
											<input type="text" name="key" value="<?=$key?>"size="16" maxlength="16" class="adminbttn"> -->
											
											<input type="button"  value="검색" class="adminbttn" onClick="javascript:go_search()">
										</td>
									</tr>
								</table>
				
				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr><td height=30></td></tr>
					<tr><td height=3></td></tr>
					<tr>
						<td>
							
							<table width="700" border='0' cellspacing='0' cellpadding='0'>

								<tr><td colspan=6 height=2 bgcolor='#88B7DA'></td></tr>
								<tr><td colspan=6 height=5></td></tr>
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
									<td width=282 height="30">
										<font face="돋움" size="2">&nbsp; 
										<?=$wdate1?> ~ <?=$wdate2?></font>
									</td>
									<td width=115 height="30"> 
										<div align="center"><font size="2" face="돋움">접속횟수</font></div>
									</td>
									<td width=100 height="30">
										<font face="돋움" size="2">&nbsp; 
										<?=$total_record?></font>
									</td>
								</tr>
								<tr><td colspan=6 height=1 bgcolor='#D2DEE8'></td></tr>
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
									<td width=479 height="30" colspan="5">
										<font face="돋움" size="2">&nbsp; 
										<?=$ip?> / <?=$signdate?></font>
									</td>
								</tr>
								<tr><td colspan=6 height=1 bgcolor='#D2DEE8'></td></tr>
								<?}?>
							</table>
						</td>
					</tr>

				</table> 
				<table width="600" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
					<tr><td height="30"></td></tr>
					<tr> 
						<td height="20" align="center"> 
							<a href="javascript:window.close();">[닫기]</a>
						</td>
					</tr>
				</table>
				<br><br>
</body>
</html>