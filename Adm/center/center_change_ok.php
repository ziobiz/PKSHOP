<?
	include "com.php";

	$upsql = "c_name='$_POST[id]',c_date='$_POST[date]', c_charge='$_POST[charge]', c_tell='$_POST[tel]' where idx='$_POST[idx]'";
	$DB->update('center', $upsql);
	
	$tools->alertJavaGo('수정되었습니다.', 'main.php?menu=5&sub_menu=4');
?>