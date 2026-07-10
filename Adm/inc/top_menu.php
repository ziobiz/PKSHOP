<?php
include "../common/dbconn.php";
require_once __DIR__ . '/admin_shell_lib.php';
require_once dirname(__FILE__) . '/../../include/site_settings_lib.php';

$idok = isset($_SESSION["idok"]) ? $_SESSION["idok"] : '';
if ($PATH_TRANSLATED != '../Adm/login/login.html') {
    if ($idok != "yes") {
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
alert("관리자만 접근하실수 있습니다.");
location="../login/login.php";
//-->
</SCRIPT>
<?php
        exit;
    }
}

$ADM_SHELL_CTX = adm_shell_resolve_context();
$ADM_SHELL_MENU_JSON = adm_shell_json_menu_info();
?>
<!DOCTYPE html>
<html lang="ko" data-shell-theme="default">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?=adm_shell_h($ADM_SHELL_CTX['title'])?> — Pentakleva Admin</title>
<?=pkshop_admin_favicon_head_html()?>
<link rel="stylesheet" href="../image/style.css" type="text/css" />
<link rel="stylesheet" href="../image/pg_admin.css?v=20260710logofix" type="text/css" />
<link rel="stylesheet" href="../image/admin-modern.css?v=20260710cards" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
window.PKSHOP_SHELL_INIT = <?=json_encode($ADM_SHELL_CTX, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP)?>;
window.PKSHOP_MENU_INFO = <?=json_encode($ADM_SHELL_MENU_JSON, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP)?>;
</script>
<script src="../inc/admin_shell.js?v=20260710fileui" defer></script>
<script src="../inc/pkshop_date_picker.js?v=20260710datepicker" defer></script>
</head>
<body class="pg-admin">
<div class="pg-shell">
<?php adm_shell_render_sidebar(); ?>
<div class="pg-workspace">
<?php adm_shell_render_session_bar(); ?>
<div id="pg-tab-bar" class="pg-tab-bar"></div>
<main class="pg-main">
<div class="pg-frame">
<?php adm_shell_render_frame_head($ADM_SHELL_CTX); ?>
<div class="pg-frame-body">
<div class="adm-content-panel pg-admin-content">
