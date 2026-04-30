<?
exit;
error_reporting( E_ALL );
ini_set( "display_errors", 1 );

include "../include/top_session.php";?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <title>Kona Summit Platform</title>

	<?
	
	// echo 11;
	// include '../../Adm/admin_board_01/db_config/mysql.php'; 
	// include '../../Adm/admin_board_01/db_config/dbcon.php';
	


# htm 셋팅 관련 파일 불러오기
// include '../../Adm/admin_board_01/htm_config/setting.php';?>
  <script src="../../Adm/admin_board_01/script/view.js"></script>
<?  if($Sub_No=='') $Sub_No='1';
else if($Sub_No=='ally') $Sub_No='';
else $Sub_No=$Sub_No;




// echo 11;

//게시물 총수
// $total_all=total_all();
//오늘 등록된 게시물
// $total_today=total_today();
?>	
<SCRIPT LANGUAGE="JavaScript">
<!--
function go_seatch() {
	frm = document.form1 
	frm.submit()
}

function Check() {
	alert("죄송합니다 내용을 확인 할수 없습니다.\n\n글이  이미 삭제 되었습니다.. ");
}

function go_del() {
	go=confirm('\n정말로 데이터를 삭제 하시겠습니까?\n')
	if(go==true){
		document.form.action="list_del.php?Sub_No=<?=$Sub_No?>";
		document.form.submit();
	}else{return false;}
}
function go_del1() {
	document.form.action="list_del.php?Sub_No=<?=$Sub_No?>";
	document.form.submit();
}
//-->
</SCRIPT>
 </head>
 <body>
	<div class="wrap">
		
		<!-- 상단 (top) -->

		<? include "../include/top.php"; ?>
		
		<!-- 상단 (top) 끝 -->

		<div class="sp50"></div>
		<div class="sub04_container">
			<!-- 카테고리 -->
			
			<? include "../include/category_contect_us.php"; ?>

			<!-- 카테고리 끝 -->



			<!-- 컨텐츠 시작 -->
			<div class="content">
				<div class="contect_us">
				<div class="page_title"><?if($Sub_No=="1"){?>공지사항<?}else if($Sub_No=="2"){?>질문과 답변<?}else{?>이벤트<?}?></div>
					<table class="board_table">
						<tr>
							<th width="5%">번호</th>
							<th width="59%">제목</th>
							<th width="12%">작성자</th>
							<th width="12%">작성일</th>
							<th width="12%">조회</th>
						</tr>
				<?
//리스트 디비 쿼리#####################################
$list_db_queiry=list_db_queiry($Rs,$tn);
$Rs=$list_db_queiry[0];
$tn=$list_db_queiry[1];
###################################################

//페이지 관련 변수 선언.##############################
$list_db_page=list_db_page();
//$tpage,$tchap,$page,$chap,$page2,$page1,$pagenext,$pageprev,$pagenextnext,$pageprevprev,$k2,$k1

$tpage=$list_db_page[0];					$tchap=$list_db_page[1];
$page=$list_db_page[2];					$chap=$list_db_page[3];
$page2=$list_db_page[4];					$page1=$list_db_page[5];
$pagenextnext=$list_db_page[6];		$pageprevprev=$list_db_page[7];
$k2=$list_db_page[8];						$k1=$list_db_page[9];

$k3=$k2-$k1+1;
$p=$tpage-$page+1; //page 변수 치환.
//echo "$page";
 ###################################################

//##################################공지글 빼오기
$B_Title_db_queiry=B_Title_db_queiry($Rs,$tn);
$B_Title_Rs=$B_Title_db_queiry[0];
$B_Title_tn=$B_Title_db_queiry[1];

if($B_Title_tn!=0){
	while($B_Title_query=mysql_fetch_array($B_Title_Rs)){
	//리스트 출력 내용
	$B_Title_db_value=B_Title_db_value($No,$Title,$Name,$W_time,$Cnt,$Files,$new,$Secret);
	$B_Title_No=$B_Title_db_value[0];					$B_Title_Title=$B_Title_db_value[1];
	$B_Title_Name=$B_Title_db_value[2];				$B_Title_W_time=$B_Title_db_value[3];
	$B_Title_Cnt=$B_Title_db_value[4];					$B_Title_Files=$B_Title_db_value[5];
	$B_Title_new=$B_Title_db_value[6];				
?>

			<tr class="board_table_line">
				<td><b><font color="#B0282C">공지</font></b></td>
				<? 
					if($select!=""){	   
						 $link_value="No=$B_Title_No&page=$p&sword=$sword&select=$select&Sub_No=$Sub_No";
					}else{
						$link_value="No=$B_Title_No&page=$p&Sub_No=$Sub_No";
					}										
				?>
				<td class="board_title">
					<a href="view.php?<?=$link_value?>" class="a_3"><b><?=$B_Title_Title?></b></a> <?=$B_Title_new?><?=$B_Title_Files?>

					<!--<input type="button" class="board_btn_com" value="처리완료" onclick="">
					 <input type="button" class="board_btn_com01" value="처리대기" onclick=""> -->
				</td>
				<td><b><?=$B_Title_Name?></b></td>
				<td class="c_brown"><b><?=$B_Title_W_time?></b></td>
				<td class="c_brown"><b><?=$B_Title_Cnt?></b></td>
			</tr>
<?	
	$B_Title_tn--; 
	}  #while 마감
} #if 마감

//게시판 내용 출력 하기
if($tn==0){
?>

									
			<tr class="board_table_line">
				<td colspan='6'  class="board_title_nodata"><br><br>현재 등록된 글이 없습니다.<br><br><br></td>
			</tr>
<?
}else{
$ii=0;
while($list_query=mysql_fetch_array($Rs)){
	if ($tn<=$k2 && $tn>=$k1 && $tn>0 ) { 

	//리스트 출력 내용
	$list_db_value=list_db_value($No,$Title,$Name,$W_time,$Cnt,$Files,$new,$Cont_type,$Secret,$No1,$Homepage,$Cont,$Dis);
	$No=$list_db_value[0];					$Title=$list_db_value[1];
	$Name=$list_db_value[2];				$W_time=$list_db_value[3];
	$Cnt=$list_db_value[4];				$Files=$list_db_value[5];
	$new=$list_db_value[6];				$Cont_type=$list_db_value[7];
	$Fname=$list_db_value[8];			$Secret=$list_db_value[9];
	$No1=$list_db_value[10];			$Homepage=$list_db_value[11];
	$Cont=$list_db_value[12];			$Dis=$list_db_value[13];

if($Secret=="1"){
	$Secret="<img src='images/icon_lock.gif' style='vertical-align:middle;'>";
	
}else{
	$Secret="";
}
	
	//해당 No 의 커맨드 수
	$Comm=Comm();

	if($Sub_No=="9"){
		
		$query2 = "SELECT cate1 FROM port_cate WHERE code1='$Name'";	
	
		$result2 = mysql_query($query2,$DB);
		if(!$result2) {
		error("QUERY_ERROR");
		exit;
		}	
		$row = mysql_fetch_row($result2);
		$cate_name = $row[0];
		$Name = stripslashes($cate_name);
	}
		if($select!=""){	   
			 $link_value="No=$No&page=$p&sword=$sword&select=$select&Sub_No=$Sub_No";
		}else{
			$link_value="No=$No&page=$p&Sub_No=$Sub_No";
		}
?>		
				<tr class="board_table_line">
					<td><?=$tn?></td>
					<td class="board_title">
						<?if($Secret!=""){?>
							<a href='#' onfocus='this.blur()' onClick="showPopup_secret('<?=$No?>');" class="a_3">
							<?=$Title?> <?=$Secret?>
						<?}else{?>
							<a href='view.php?<?=$link_value?>' class="a_3"><?=$Title?>
						<?}?>
						<?=$new?><?=$Files?>
					</td>
					<td><?=$Name?></td>
					<td class="c_brown"><?=$W_time?></td>
					<td class="c_brown"><?=$Cnt?></td>
				</tr>

<?
					
					
					?>
<?	
	$ii++;
	}; 
	$tn--; 
	}  #while 마감
} #else 마감
?>	

											

					</table>
					<div class="sp20"></div>

					<div class="btn_box">
						<div class="list_btn01">
					<input type="button" value="목 록" class="cart_btn01" onclick="location.href='list.php?Sub_No=<?=$Sub_No?>'">
				</div>
				<div class="list_page">
					<?
					if($select!="") $link_search="sword=$sword&select=$select";
					
					 //============================= 다음 chapter 처리  =========== 
					if($page2!=0){
						if ($page2 != 1) {	
							echo "<a href='$PHP_SELF?Sub_No=$Sub_No&page=1&$link_search' title='【 첫 페이지 】' class='a_3'>1..</a>&nbsp;";
							echo "<a href='$PHP_SELF?Sub_No=$Sub_No&page=$pageprevprev&$link_search' class='a_3'>◀</a>&nbsp;"; 
						}

						for ($i=$page2;  $i<=$page1; $i++)  { 
							if ($p==$i){
								echo "<b>[$i]</b>";
							}else {
								echo "<a href='$PHP_SELF?Sub_No=$Sub_No&page=$i&$link_search'  title='$i Page' class='a_3'>[$i]</a>&nbsp;";
							}																
						} 

						if ($page1 != $tpage)  {
							echo "<a href='$PHP_SELF?Sub_No=$Sub_No&page=$pagenextnext&$link_search' class='a_3'>▶</a>&nbsp;"; 
							echo"..&nbsp;&nbsp;<a href='$PHP_SELF?Sub_No=$Sub_No&page=$tpage&$link_search' title='【 마지막 페이지 】' class='a_3'>$tpage..</a>";
						}
					}
					//======================================================== 
				?>	 							
						</div>
							<div class="list_btn02">
					<?if($Sub_No=="2"){?><input type="button" value="글 작성하기" class="cart_btn03" onclick="location.href='write.php?Sub_No=<?=$Sub_No?>'"><?}?>
				</div>
					</div>

					<div class="sp10"></div>

					<form name="form1" method="post" action="./list.php"> 
		<input type="hidden" name="search" value="on"> 
			<input type="hidden"  name="Sub_No" value="<?=$Sub_No?>">
			<div class="list_search">
				<select name="select" class="list_select">
					<option value="T_itle" <?if($select=='T_itle') echo "selected";?>>제목</option>
					<option value="N_ame" <?if($select=='N_ame') echo "selected";?>>이름</option>
					<option value="C_ont" <?if($select=='C_ont') echo "selected";?>>내용</option>
					<option value="A_ll" <?if($select=='A_ll') echo "selected";?>>전체</option>
				</select>
				<input type="text" name="sword" value="<?=$sword?>" class="search_text">
				<input type="button" value="검 색" class="search_btn"  onclick="javascript:go_seatch();">
			</div>
					</form>

				</div>			
					
			</div>
	<!-- 컨텐츠 종료 -->
		</div>
		<div class="sp50"></div>
		<!--  footer 시작 -->

		<? include "../include/bottom.php"; ?>

		<!--  footer 끝 -->

	</div>
  <style>
#overlay_secret {
	display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; background: black; opacity: 0.8;
}
#popup_secret {
	visibility: hidden; overflow: hidden; position: absolute; z-index: 2; top: 70%; left: 50%; margin: -100px 0 0 -100px; width: auto; height: 0;
}
#popup_secret.show {
	visibility: visible; height: auto; transition: height 0.25s linear;
}
.pop_text{
	font-size:18px; padding-top:5px; padding-bottom:5px; padding-left:10px; color:#ec008b; text-align:left;
}

</style>

<script>
function showPopup_secret(no) {
	document.getElementById("nid").value=no;
	document.getElementById("overlay_secret").style.display = "block";
	document.getElementById("popup_secret").className = "show";
}

function hidePopup_secret() {
	document.getElementById("overlay_secret").style.display = "none";
	document.getElementById("popup_secret").className = "";
}
</script>
<div id="overlay_secret" onclick="hidePopup_secret();">
</div>
<div id="popup_secret">
	
	<form method="post" name="Secret">
	<input type="hidden" name="Edit" value="Edit_ok"><!-- pass_check 구분 변수 -->
	<input type="hidden" name="No" id="nid" value="">
	<input type="hidden" name="page" value="<?=$page?>">
		<input type="hidden" name="Sub_No" value="<?=$Sub_No?>">
	<div class="secret_box">
			<table class="serect_table">
				
				<tr>
					<th colspan="4" class="pop_text">√ 비밀글 확인</th>
				</tr>
				<tr>
					<th width="20%">비밀번호</th>
					<td width="52%"><input type="password" name="PassWord" class="input_secret" onKeypress="Key_Press_Edit()"></td>	
					<td width="3%"></td>
					<td width="25%"><input type="button" value="확인" class="secret_btn" onClick="Edit_Ok_Secret();"></td>
				</tr>
				<tr>
					<th colspan="4" class="secret_text">비밀글을 보기 위해서는 비밀번호를 입력해 주세요</th>
				</tr>
			</table>
		<div class="sp10"></div>
	</div>
	</form>	
</div>
</body>
</html>