<?
###게시판 테이블관련 설정########################
$main_table_width="700"; 
$T_width="700"; //게시판 크기 설정
$T_height="400";

$bg_line="#88B7DA";   // 첫번째 구분선
$bg_back="#EBF0F4";   // 구분 컬러 
$line_back="#D2DEE8";  //글구분 선 bg
$line_w_back="#e6e6e6";   // 구분 선 (글 쓰기,수정,답변)

$Board_Title = "사용후기"; //게시판이름
if($Sub_No=="1"){
	$Board_Title = "사용후기";
}else if($Sub_No=="2"){
	$Board_Title = "궁금해요";
}
$file_uplode="Y";
if ($file_uplode=="Y"){$uplode="enctype='multipart/form-data'";}	

####이미지 관련 설정

$titlegrim="<img src='../image/icon1.gif' width='45' height='35' border='0'>";   // 제목타이틀 그림

$write_part="<img src=./img/write.gif border=0 alt='쓰기' align=middle name='Image100'>";
$write_part1="<img src=./img/write.gif border=0 alt='쓰기' align=middle name='Image101'>";

$submit_part="<img src=./img/submit.gif border=0 alt='전송' align=middle name='Images100'>";

$list_part="<img src=./img/list.gif  border=0 alt='목록' align=middle name='Image102'>";
$list_part1="<img src=./img/list.gif  border=0 alt='목록' align=middle name='Image103'>";

$edit_part="<img src=./img/modify.gif border=0 alt='수정' align=middle name='Image104'>";
$edit_part1="<img src=./img/modify.gif border=0 alt='수정' align=middle name='Image105'>";

$reply_part="<img src=./img/reply.gif border=0 alt='답변' align=middle name='Image106'>";
$reply_part1="<img src=./img/reply.gif border=0 alt='답변' align=middle name='Image107'>";


$erase_part="<img src=./img/delete.gif border=0 alt='지움' align=middle name='Image108'>";
$prev_part="<img src=./img/prev.gif border=0 alt='앞에글' align=middle name='Image109'>";
$next_part="<img src=./img/next.gif border=0 alt='뒤에글'  align=middle name='Image110'>";
$search_part="<img src=./img/sh.gif border=0 alt='검색' align=middle height=20 name='Image111'>";

$send_part="<img src=./img/send.gif border=0 alt='보네기' align=middle name='Image112'>";

$delet_part="<img src=./img/d_img_03.gif border=0 alt='확인' align=middle name='Image113'>"; //글삭제페이지
$delet1_part="<img src=./img/d_img_04.gif border=0 alt='' align=middle >";//글삭제페이지 | 라인
$delet2_part="<img src=./img/d_img_05.gif border=0 alt='취소' align=middle name='Image114'>"; //글삭제페이지

$email_part="<img src=/Adm/admin_board_01/img/send_mail.gif border=0 align=middle>";
$print_part="<img src=./img/print.gif border=0 align=middle>";
$file_part="<img src=/Adm/admin_board_01/img/file.gif border=0 align=middel>";
$new_part="<img src=/Adm/admin_board_01/img/new.gif border=0 align=middel>";
$line8_part="./img/line8.gif";  //라인 이미지
$line_part="<img src=/Adm/admin_board_01/img/line.gif border=0>";  //답변 라인 이미지
//$bar="<img src=./img/bar.gif border=0  align=middle >";//버튼 경계 | 이모양이야...
$loading="<img src=./img/loading.gif border=0  align=middle >";

####마우스 오버 이미지를 사용할 것인가....? 설정 Y 사용...#######
//현제 목록과 글쓰기 사용중입니다.
$MouseOver="Y";

if($MouseOver=="Y"){		
		$W_rite="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image100','','./img/write_r.gif',1)";
		$W_rite1="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image101','','./img/write_r.gif',1)";			

		$submit="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Images100','','./img/submit_r.gif',1)";

		$L_ist="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image102','','./img/list_r.gif',1)";
		$L_ist1="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image103','','./img/list_r.gif',1)";
		
		$E_dit="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image104','','./img/modify_r.gif',1)";
		$E_dit1="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image105','','./img/modify_r.gif',1)";
		
		$R_eply="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image106','','./img/reply_r.gif',1)";
		$R_eply1="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image107','','./img/reply_r.gif',1)";
		
		$E_rase="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image108','','./img/delete_r.gif',1)";
		$P_rev="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image109','','./img/prev_r.gif',1)";
		$N_ext="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image110','','./img/next_r.gif',1)";
		$S_eatch="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image111','','./img/sh_r.gif',1)";
		$S_end="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image112','','./img/send_r.gif',1)";
		$D_el="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image113','','./img/d_img_03r.gif',1)";
		$D_el1="onMouseOut=MM_swapImgRestore() 								onMouseOver=MM_swapImage('Image114','','./img/d_img_05r.gif',1)";
}
?>