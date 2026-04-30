<?
	include "com.php";

	$upsql = "c_name='$_POST[id]',c_date='$_POST[date]', c_charge='$_POST[charge]', c_tell='$_POST[tel]'";

	$DB->insert('center', $upsql);
	
	$tools->alertJavaGo('등록되었습니다.', 'main.php?menu=5&sub_menu=4');
?>