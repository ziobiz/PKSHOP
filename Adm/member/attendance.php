<?
#####################################################################

include "../common/user_function.php";
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_attendance.php";

if($ydate1=='')  $ydate1=date('Y');
if($mdate1=='')  $mdate1=date('m');
if($ddate1=='')  $ddate1=date('d');

if($ydate2=='')  $ydate2=date('Y');
if($mdate2=='')  $mdate2=date('m');
if($ddate2=='')  $ddate2=date('d');

$wdate1 = mktime(0,0,0,$mdate1,$ddate1,$ydate1);
$wdate2 = mktime(23,59,59,$mdate2,$ddate2,$ydate2);

if($mdate1!='' || $ddate1!='' || $ydate1!=''){
	$where_date1 = " where signdate > '$wdate1'";
}else{
	$where_date1 = "";
}

if($mdate2!='' || $ddate2!='' || $ydate2!=''){
	if($where_date1==''){
		$where_date2 = " where signdate < '$wdate2'";
	}else{
		$where_date2 = " and signdate < '$wdate2'";
	}
}else{
	$where_date2 = "";
}


$encoded_key = urlencode($key);
$query = "SELECT no,id,max(signdate) as signdate,count(ip) as icnt FROM $attendance $where_date1 $where_date2 group by id ";

if($key != ""){
	$query = $query." having $keyfield LIKE '%$key%' ";
}

$query = $query." ORDER BY icnt DESC";	

//echo $query;
$DB->get($query,$rs,$rn);

if ($page=="") $page=1;
$num_per_page = 10;
$page_per_block = 10;

if(!$total_record) {
 	$first = 1;
 	$last = 0;   
} else {
 	$first = $num_per_page*($page-1);
 	$last = $num_per_page*$page;
 
 	$IsNext = $total_record - $last;
 	if($IsNext > 0) {
 		$last -= 1;
 	} else {
 		$last = $total_record - 1;
 	}      
}
 
$total_page = ceil($total_record/$num_per_page);
$article_num = $num_per_page*($page-1) + 1;
$mode="keyfield=$keyfield&key=$encoded_key&sex=$sex&job=$job&dis=$dis&ydate1=$ydate1&mdate1=$mdate1&ddate1=$ddate1&ydate2=$ydate2&mdate2=$mdate2&ddate2=$ddate2";

#####################################################################
?>

<script language="javascript">
<!--
function go_del() {
	ans = confirm('정말로 삭제하시겠습니까?');
	if (ans == true ) {
		document.form.action="attendance_del.php";
		document.form.submit();
	}	
}

function go_search() {
	document.form.action="attendance.php";
	document.form.submit();
}

function go_mail(tmp_mail) {
	document.location = "mailing.php?to_name=" + tmp_mail;
}
//-->
</script>

				<table width="800" border="0" cellspacing="0" cellpadding="0" class="left_margin30">
				<form name="form" method="post">
					<tr><td height=30></td></tr>
					<tr><td>
							<table border=0 cellpadding=0 cellspacing=0>
								<tr>
									<td width=60 align=center><img src="../image/icon2.gif" width=45 height=35 border=0></td>
									<td class='td14'><b>접속자IP관리</b></td>
								</tr>
							</table>
					</td></tr>
					<tr><td height=3></td></tr>
					<tr>
						<td>							 
								<table width="800" border="0" cellspacing="0" cellpadding="4">
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
									<tr>
										<td>&nbsp;</td>
									</tr>
								</table>
								<table width="800" border='0' cellspacing='0' cellpadding='0'>
									<tr><td colspan=6 height=3 bgcolor='#88B7DA'></td></tr>
									<tr align="center" bgcolor='#EBF0F4'> 
										<td width="100" height="30">순위</td>
										<td width="500" height="30" colspan="2">상품명</td>
										<td width="100" height="30">접속횟수</td>
										<td width="100" height="30">접속일</td>
										<td width="50" height="30"> 
											<input type="button" value="삭제" class="adminbttn" onClick="javascript:go_del('attendance_del.php?<?=$mode?>&page=<?=$page?>')">
										</td>
									</tr>
									<tr><td colspan=6 height=1 bgcolor='#D2DEE8'></td></tr>
									<tr><td colspan=6 height=3></td></tr>
<?
#####################################################################

$ii=0;
for($i = $first; $i <= $last; $i++) { 
	$no =$rs[$i][0];
	$id =$rs[$i][1];
	$signdate =$rs[$i][2];
	$icnt =$rs[$i][3];

	$signdate = date("Y-m-d",$signdate);


	$ip_link = "?id=$id&wdate1=$wdate1&wdate2=$wdate2&icnt=$icnt";
#####################################################################
?>
								<tr align="center"> 
									<td height="30"><?=$article_num?></td>


								<?
								$query_t="select title FROM $shop_goods where code='$id'";  
								//echo "$query_t";
								$result_t= mysql_query($query_t,$DBconn);
								$row_t = mysql_fetch_row($result_t);	
								$title=$row_t[0];
								?>				
								
									<td height="30" colspan="2"><a href="attendance_list.php<?=$ip_link?>"><?=$title?>(<?=$id?>)</a></td>
									<td height="30"><?=$icnt?></td>
									<td height="30"><?=$signdate?></td>
									<td height="30"> 
										<input type="checkbox" name="check<?=$ii?>" value="<?=$no?>">
									</td>
								</tr>
								<tr><td colspan=6 height=1 bgcolor='#D2DEE8'></td></tr>

<?
   $article_num++;
   $ii++;
        
}              
$chk_num = $last-$first+1;
?>
							</table>
						</td>
					</tr>
				</table> 
				<table width="800" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
					<tr> 
						<td height="20" align="center"><font color="#666666">
<?
#####################################################################
$total_block = ceil($total_page/$page_per_block);
$block = ceil($page/$page_per_block);
$first_page = ($block-1)*$page_per_block;
$last_page = $block*$page_per_block;
if($total_block <= $block) {
	$last_page = $total_page;
}
 
 if ($page > 1) {
 	$page_num = $page - 1;
 	echo "<a href=\"attendance.php?$mode&page=$page_num&dis=$dis\" onMouseOver=\"status='이전페이지';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">◀</font></a>";
 }
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
 		echo "<font color=\"#666666\">&nbsp;<b>$direct_page</b></font>";
 	} else {
 		echo "&nbsp;<a href=\"attendance.php?$mode&page=$direct_page&dis=$dis\" onMouseOver=\"status='go to page $direct_page';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">$direct_page</font></a>";
 	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
 	echo "&nbsp;<a href=\"attendance.php?$mode&page=$page_num&dis=$dis\" onMouseOver=\"status='다음페이지';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">▶</font></a>";
 }
 ?>
							</font> 
						</td>
					</tr>
					<input type="hidden" name="chk_num" value="<?echo($chk_num)?>">  
					</form>  
				</table>
				<br><br>
<? include "../inc/down_menu.php"; ?>