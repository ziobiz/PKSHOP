<?include "../include/top_session.php";?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <title>Kona Summit Platform</title>
  <? 
#디비관련 셋팅파일 불러 오기
include "../../Adm/common/dbconn.php";
include '../../Adm/admin_board_01/db_config/dbcon.php';
include '../../Adm/admin_board_01/db_config/mysql.php';

# htm 셋팅 관련 파일 불러오기
include '../../Adm/admin_board_01/htm_config/setting.php';

if($mode=="edit"||$mode=="reply"){
		//검색일때 페이지 셋팅(수정과 답변일때만 사용 된다.
		if($select!="") $page="$page&sword=$sword&select=$select";
}
?>	

<script src='../../Adm/admin_board_01/script/w_check.js'></script>
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
					<div class="page_title">질문과 답변</div>
<?if($mode==""){ ?>
				<form name='form1' method='post' <?=$uplode?> action='writedo.php'>
				
			<?}else if($mode=="edit"){?>
				<form name='form1' method='post' <?=$uplode?> action='editdo.php'>
				<?
			
					$Quiery_data=Quiery_data();
					$Sub_No=$Quiery_data[0];			$Name=$Quiery_data[1];
					$Pass=$Quiery_data[2];				$Email=$Quiery_data[3];
					$Homepage=$Quiery_data[4];		$Title=$Quiery_data[5];
					$Cont=$Quiery_data[6];				$Cont_type=$Quiery_data[7];
					$Fname=$Quiery_data[8];				$Fname1=$Quiery_data[9];
					$B_Title=$Quiery_data[10];			$P_up=$Quiery_data[11];
					$Fsize=$Quiery_data[12];				$Fsize1=$Quiery_data[13];
					$Secret=$Quiery_data[14];			$Cnt=$Quiery_data[15];
					$Dis=$Quiery_data[16];
					//$Cont = nl2br($Cont);
				
				?>
				<input type='hidden' name='No' value='<?=$No?>'> 
				
				<input type='hidden' name='Old_file'  value='<?=$Fname?>' size='19'>
				<input type='hidden' name='Old_size'  value='<?=$Fsize?>' size='19'>
				
				<input type='hidden' name='Old_file1'  value='<?=$Fname1?>' size='19'>
				<input type='hidden' name='Old_size1'  value='<?=$Fsize1?>' size='19'>
				<input type='hidden' name='page'  value='<?=$page?>' size='19'>

			<?
				}else if($mode=="reply"){
				$Quiery_data=Quiery_data();
				$Cont=$Quiery_data[0];   $No1=$Quiery_data[1];
				$Secret=$Quiery_data[2];	$Pass=$Quiery_data[3];
				$Pass="";

			?>
				<form name='form1' method='post' <?=$uplode?> action='replydo.php'>
				 <input type='hidden' name='No1' value='<?=$No1?>'> 
				 <input type='hidden' name='page'  value='<?=$page?>' size='19'>
			<?}?>
			<input type="hidden" name="keynum" >
			<input type="hidden" name="Sub_No" value="<?=$Sub_No?>">
			<input type="hidden" name="Cont_type" value="AUTO">
					<table class="board_write">
						<tr>
							<th width="15%" class="bg">제 목</th>
							<td class="bg"><input type="text" name="Title" value="<?=$Title?>" class="input_title"></td>
						</tr>
						<tr>
							<th>작성자</th>
							<td><input type="text" name="Name" value="<?=$Name?>" class="input_writer"></td>
						</tr>
						<tr>
							<th>비밀번호</th>
							<td><input type="password" name="Pass" value="<?=$Pass?>" onKeyDown="Cal_Key_num++;" class="input_writer"><input type="checkbox" name="Secret" checked value="1" class="input_writer_sc">비밀글</td>
						</tr>
						<tr>
							<th>연락처</th>
							<td><input type="text" name="Homepage"value="<?=$Homepage?>" class="input_writer"></td>
						</tr>
						<tr>
							<th>이메일</th>
							<td><input type="text"  name="Email" value="<?=$Email?>" class="input_writer"></td>
						</tr>
						<tr>
							<th>내 용</th>
							<td><textarea name="Cont" id="Cont" class="input_textarea"><?=$Email?></textarea></td>
						</tr>
						<tr>
							<th>첨부파일</th>
							<td><input type="file" name="File" class="write_file"></td>
						</tr>
					</table>

					<div class="sp20"></div>

					<div class="write_btn_box">
						<input type="button" value="확 인" class="cart_btn03" onclick="return check123(document.form1)">&nbsp;
						<input type="button" value="취 소" class="cart_btn01" onclick="location.href='list.php?page=<?=$page?>&Sub_No=<?=$Sub_No?>'">
					</div>
					</form>

					<div class="sp10"></div>
		
					
			</div>
	<!-- 컨텐츠 종료 -->

		</div>

		<div class="sp50"></div>


		<!--  footer 시작 -->

		<? include "../include/bottom.php"; ?>

		<!--  footer 끝 -->

	</div>
  
</body>
</html>