<?

include "../common/dbconn.php";

include "../common/user_function.php";

require_once dirname(__FILE__) . '/../../include/site_settings_lib.php';



if (!isset($_SESSION["idok"]) || $_SESSION["idok"] !== "yes") {

	echo "<script>alert('관리자만 접근할 수 있습니다.');location.href='../login/login.php';</script>";

	exit;

}



$action = isset($_POST['action']) ? trim($_POST['action']) : 'add';

$list = pkshop_main_all_categories_list();



if ($action === 'clear') {

	if (!pkshop_main_all_save_categories_list(array())) {

		echo "<script>alert('설정 저장에 실패했습니다. include 폴더 쓰기 권한을 확인해 주세요.');location.href='pro_all.php';</script>";

		exit;

	}

	echo "<script>alert('메인 All PRODUCTS 노출 카테고리가 초기화되었습니다.');location.href='pro_all.php';</script>";

	exit;

}



if ($action === 'remove') {

	$index = isset($_POST['index']) ? intval($_POST['index']) : -1;

	if ($index < 0 || !isset($list[$index])) {

		echo "<script>alert('삭제할 카테고리를 찾을 수 없습니다.');location.href='pro_all.php';</script>";

		exit;

	}

	unset($list[$index]);

	$list = array_values($list);

	if (!pkshop_main_all_save_categories_list($list)) {

		echo "<script>alert('설정 저장에 실패했습니다. include 폴더 쓰기 권한을 확인해 주세요.');location.href='pro_all.php';</script>";

		exit;

	}

	echo "<script>alert('카테고리가 삭제되었습니다.');location.href='pro_all.php';</script>";

	exit;

}



$sel_cate = isset($_POST['sel_cate']) ? trim($_POST['sel_cate']) : '';

$sel_code1 = isset($_POST['sel_code1']) ? trim($_POST['sel_code1']) : '';

$sel_code2 = isset($_POST['sel_code2']) ? trim($_POST['sel_code2']) : '';

$sel_code3 = isset($_POST['sel_code3']) ? trim($_POST['sel_code3']) : '';

$sel_code4 = isset($_POST['sel_code4']) ? trim($_POST['sel_code4']) : '';



$new_entry = pkshop_main_all_entry_from_codes($sel_cate, $sel_code1, $sel_code2, $sel_code3, $sel_code4);



if ($new_entry['code1'] === '') {

	echo "<script>alert('1차 카테고리를 선택하세요.');location.href='pro_all.php';</script>";

	exit;

}



$new_key = pkshop_main_all_entry_key($new_entry);

foreach ($list as $item) {

	if (pkshop_main_all_entry_key($item) === $new_key) {

		echo "<script>alert('이미 등록된 카테고리입니다.');location.href='pro_all.php';</script>";

		exit;

	}

}



$list[] = $new_entry;



if (!pkshop_main_all_save_categories_list($list)) {

	echo "<script>alert('설정 저장에 실패했습니다. include 폴더 쓰기 권한을 확인해 주세요.');location.href='pro_all.php';</script>";

	exit;

}



echo "<script>alert('카테고리가 추가되었습니다. 메인에는 카테고리별 4개씩 순서대로 노출됩니다.');location.href='pro_all.php';</script>";

?>
