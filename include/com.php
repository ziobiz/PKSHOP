<? @session_start(); 
	
	include_once( $_SERVER["DOCUMENT_ROOT"]."/lib/config.php"); 
	include_once( $_SERVER["DOCUMENT_ROOT"]."/lib/basic_class.php");
	include_once( $_SERVER["DOCUMENT_ROOT"]."/lib/common_db.php");
	include_once( $_SERVER["DOCUMENT_ROOT"]."/lib/api_list.php"); 
	include_once( $_SERVER["DOCUMENT_ROOT"]."/lib/common.php");
	
	

	function popup_msg($msg) {
		echo("<script language=\"javascript\"> 
		<!--
		alert('$msg');
		history.back();
		//-->   
		</script>");
	 }


	if ($_SESSION['member_id'] == "")
	{
		//$tools->alertJavaGo('try again',"../login.php");		
	}
	
	date_default_timezone_set("Asia/Seoul");

/*
	if ($_SESSION['lang'] =="" ) { $_SESSION['lang'] = "en"; }
	else if ($_GET['lang'] != $_SESSION['lang'] && $_GET['lang'] != "") { $_SESSION['lang'] = $_GET['lang']; }

	$img = "";

	if ($_SESSION['lang'] == "en")		{include "../include/set_lang_en.php"; $img_lang = "../img/usa.png";  $title_lang="English";}
	else if ($_SESSION['lang'] == "kr") {include "../include/set_lang_kr.php"; $img_lang = "../img/korea.png"; $title_lang="Korea";}
	else if ($_SESSION['lang'] == "ch") {include "../include/set_lang_ch.php"; $img_lang = "../img/cny.png"; $title_lang="Chinese";}
	else if ($_SESSION['lang'] == "jp") {include "../include/set_lang_jp.php"; $img_lang = "../img/jpn.png"; $title_lang="Japanese";}
	else {include "../include/set_lang_en.php"; $img_lang = "../img/usa.png";  $title_lang="English";}

*/
include $_SERVER["DOCUMENT_ROOT"]."/include/set_lang_en.php";
?>