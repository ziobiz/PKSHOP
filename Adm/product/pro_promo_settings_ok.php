<?
include "../common/dbconn.php";
include "../common/user_function.php";
require_once dirname(__FILE__) . '/../../include/site_settings_lib.php';
require_once dirname(__FILE__) . '/../../include/pkshop_promo_lib.php';

if (!isset($_SESSION["idok"]) || $_SESSION["idok"] !== "yes") {
	echo "<script>alert('관리자만 접근할 수 있습니다.');location.href='../login/login.php';</script>";
	exit;
}

$opts = pkshop_promo_rotate_interval_options();
$fields = array('promo_rotate_best', 'promo_rotate_recommended', 'promo_rotate_all');
$data = array();

foreach ($fields as $field) {
	$val = isset($_POST[$field]) ? trim((string)$_POST[$field]) : '30';
	if (!isset($opts[$val])) {
		echo "<script>alert('지원하지 않는 순환 시간입니다.');history.back();</script>";
		exit;
	}
	$data[$field] = $val;
}

if (!pkshop_site_settings_save($data)) {
	echo "<script>alert('설정 저장에 실패했습니다.');history.back();</script>";
	exit;
}

echo "<script>alert('홍보설정이 저장되었습니다.');location.href='pro_site_settings.php?tab=promo';</script>";
?>
