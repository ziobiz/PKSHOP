<?
#####################################################################

include "../common/user_function.php";
include "../common/dbconn.php";
include "../inc/top_menu.php";
include "../inc/left_menu_member.php";

?>
				<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr><td height=30></td></tr>
					<tr><td height=3></td></tr>
				</table>	

<?
$encoded_key = urlencode($key);
$query = "SELECT No,Cid,Cont,Point,Wdate,Signdate FROM $shop_point ";

if($key != ""){
	$query = $query." where Cont LIKE '%$key%' ";
}


$query = $query."ORDER BY No DESC";	

//echo "$query";

$DB->get($query,$rs,$rn);

if ($page=="") $page=1;
$num_per_page = 20;
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
$article_num = $total_record - $num_per_page*($page-1);
$mode="keyfield=$keyfield&key=$encoded_key&sex=$sex&job=$job&dis=$dis&member_count=$member_count";

#####################################################################
?>
								<table class="pg-table pg-table-form" width="100%" border="0" cellspacing="0" cellpadding="4">
									<tr> 
										
										<td height="20" align="left"> 
											
											
											
											<a href="coin.php?key=">[전체]</a> <a href="coin.php?key=코인충전">[충전내역]</a>
										</td>
									</tr>
									</table>
				
							<table width='700'  border='0' cellpadding='0' cellspacing='0' align="center">
								<tr><td>
							
							<table width='800' border='0' cellpadding='0' cellspacing='0'>
								<tr><td colspan=7 height=3 bgcolor='#88B7DA'></td></tr>
									<tr align="center" bgcolor='#EBF0F4'> 
										<td width="100" height="30">아이디</td>
										<td width="100" height="30">코인</td>
										<td width="450" height="30">내역</td>
										<td width="150" height="30">날짜</td>
									</tr>
									<tr><td colspan=4 height=1 bgcolor='#D2DEE8'></td></tr>

<?
#####################################################################

$ii=0;
for($i = $first; $i <= $last; $i++) { 
	$No =$rs[$i][0];
	$Cid =$rs[$i][1];
	$Cont =$rs[$i][2];
	$Point =$rs[$i][3];
	$Wdate =$rs[$i][4];
	$Signdate =$rs[$i][5];

	
	
#####################################################################
?>
								<tr bgcolor='<?=$bg_back?>'>
									<td height='22'>&nbsp;&nbsp;<?=$Cid?> </td>
									<td height='22'>&nbsp;&nbsp;<?=$Point?> </td>

									<td><?=$Cont?></td>
									<td><?=$Wdate?></td>
								</tr>
								<tr><td colspan="4" height="1" bgcolor="#D2DEE8"></td></tr>
<?
				
	
   $article_num--;
   $ii++;
        
}              
$chk_num = $last-$first+1;
?>
								</table>
								</td></tr>
							</table>
							<table width="600" border="0" cellspacing="0" cellpadding="4" class="left_margin30">
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

if($page!='1'){
	echo "<a href=\"coin.php?$mode&page=1\" onMouseOver=\"status='';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">처음</a>&nbsp;";
}
 if ($page > 1) {
 	$page_num = $page - 1;
 	echo "<a href=\"coin.php?$mode&page=$page_num\" onMouseOver=\"status='이전페이지';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">◀</font></a>&nbsp;";
 }
 
 for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
 	if($page == $direct_page) {
 		echo "<font color=\"#666666\">&nbsp;<b>$direct_page</b></font>&nbsp;";
 	} else {
 		echo "&nbsp;<a href=\"coin.php?$mode&page=$direct_page\" onMouseOver=\"status='go to page $direct_page';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">$direct_page</font></a>&nbsp;";
 	}
 }
 
 if ($IsNext > 0) {
 	$page_num = $page + 1;
 	echo "&nbsp;<a href=\"coin.php?$mode&page=$page_num\" onMouseOver=\"status='다음페이지';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">▶</font></a>&nbsp;";
 }
if($page!=$total_page){
	echo "<a href=\"coin.php?$mode&page=$total_page\" onMouseOver=\"status='';return true;\" onMouseOut=\"status=''\"><font color=\"#666666\">마지막</a>";
}
 ?>
							</font> 
						</td>
					</tr>
					<input type="hidden" name="chk_num" value="<?echo($chk_num)?>">  
					</form>  
				</table>
							<BR><BR>
<? include "../inc/down_menu.php"; ?>
