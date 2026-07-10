<?php
include "../common/dbconn.php";
include "../common/user_function.php";
require_once dirname(__FILE__) . '/../../include/site_settings_lib.php';

if (!isset($_SESSION["idok"]) || $_SESSION["idok"] !== "yes") {
	echo "<script>alert('관리자만 접근할 수 있습니다.');location.href='../login/login.php';</script>";
	exit;
}

$title = isset($_POST['footer_bank_title']) ? trim((string)$_POST['footer_bank_title']) : '';
$line1 = isset($_POST['footer_bank_line1']) ? trim((string)$_POST['footer_bank_line1']) : '';
$line2 = isset($_POST['footer_bank_line2']) ? trim((string)$_POST['footer_bank_line2']) : '';
$line3 = isset($_POST['payment_bank_line3']) ? trim((string)$_POST['payment_bank_line3']) : '';

if ($line1 === '') {
	echo "<script>alert('은행 표시 1행을 입력하세요.');history.back();</script>";
	exit;
}
if ($line2 === '') {
	echo "<script>alert('은행 표시 2행을 입력하세요.');history.back();</script>";
	exit;
}

$data = array(
	'footer_bank_title' => $title,
	'footer_bank_line1' => $line1,
	'footer_bank_line2' => $line2,
	'payment_bank_line1' => $line1,
	'payment_bank_line2' => $line2,
	'payment_bank_line3' => $line3,
);

if (!pkshop_site_settings_save($data)) {
	echo "<script>alert('계좌 정보 저장에 실패했습니다.');history.back();</script>";
	exit;
}

echo "<script>alert('계좌 정보가 저장되었습니다. 브랜드설정에도 반영되었습니다.');location.href='bank_change.php';</script>";
