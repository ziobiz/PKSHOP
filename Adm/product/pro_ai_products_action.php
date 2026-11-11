<?
include "../common/dbconn.php";
include "../common/user_function.php";

if (!isset($_SESSION["idok"]) || $_SESSION["idok"] !== "yes") {
	echo "<script>alert('관리자만 접근할 수 있습니다.');location.href='../login/login.php';</script>";
	exit;
}

$action = isset($_POST['bulk_action']) ? trim($_POST['bulk_action']) : '';
$chk_num = isset($_POST['chk_num']) ? intval($_POST['chk_num']) : 0;
$keyfield = isset($_POST['keyfield']) ? $_POST['keyfield'] : 'title';
$key = isset($_POST['key']) ? trim($_POST['key']) : '';
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$view = isset($_POST['view']) ? $_POST['view'] : 'active';

$allowed_actions = array('delete', 'hide', 'show', 'save_themes');
if (!in_array($action, $allowed_actions, true)) {
	echo "<script>alert('잘못된 요청입니다.');history.back();</script>";
	exit;
}

// 추천/베스트/HOT 일괄 저장 — 목록에 표시된 상품 기준
if ($action === 'save_themes') {
	$theme_nos = array();
	if (isset($_POST['theme_nos']) && is_array($_POST['theme_nos'])) {
		foreach ($_POST['theme_nos'] as $raw_no) {
			$n = intval($raw_no);
			if ($n > 0) {
				$theme_nos[] = $n;
			}
		}
	}
	$theme_nos = array_values(array_unique($theme_nos));
	if (count($theme_nos) < 1) {
		echo "<script>alert('저장할 상품이 없습니다.');history.back();</script>";
		exit;
	}

	$done = 0;
	foreach ($theme_nos as $no) {
		$DB->get("SELECT No, p_id FROM $shop_goods WHERE No='$no' LIMIT 1", $rows, $rn);
		if ($rn < 1 || $rows[0]['p_id'] !== 'admin_ai') {
			continue;
		}
		$theme_n = (!empty($_POST['theme_n_' . $no]) && $_POST['theme_n_' . $no] === 'n') ? 'n' : '';
		$theme_r = (!empty($_POST['theme_r_' . $no]) && $_POST['theme_r_' . $no] === 'r') ? 'r' : '';
		$theme_f = (!empty($_POST['theme_f_' . $no]) && $_POST['theme_f_' . $no] === 'f') ? 'f' : '';
		$DB->update(
			$shop_goods,
			"theme_n='" . addslashes($theme_n) . "',theme_r='" . addslashes($theme_r) . "',theme_f='" . addslashes($theme_f) . "' WHERE No='$no' AND p_id='admin_ai'"
		);
		$done++;
	}

	$redirect = 'pro_ai_products.php?view=' . urlencode($view)
		. '&keyfield=' . urlencode($keyfield)
		. '&key=' . urlencode($key)
		. '&page=' . intval($page);
	$msg = $done . '건의 추천/베스트/HOT 설정이 저장되었습니다.';
	echo "<script>alert('" . addslashes($msg) . "');location.href='" . $redirect . "';</script>";
	exit;
}

if ($chk_num < 1) {
	echo "<script>alert('처리할 상품을 선택해 주세요.');history.back();</script>";
	exit;
}

$selected_nos = array();
for ($i = 0; $i < $chk_num; $i++) {
	$tmpchk = 'check' . $i;
	if (!empty($_POST[$tmpchk])) {
		$selected_nos[] = intval($_POST[$tmpchk]);
	}
}
$selected_nos = array_values(array_unique(array_filter($selected_nos)));

if (count($selected_nos) < 1) {
	echo "<script>alert('처리할 상품을 선택해 주세요.');history.back();</script>";
	exit;
}

function pkshop_ai_delete_images($savedir, $row) {
	$fields = array('imgl', 'imgm', 'imgb1', 'imgb2', 'imgb3', 'imgb4', 'imgb5');
	foreach ($fields as $field) {
		if (empty($row[$field])) {
			continue;
		}
		$img_path = $savedir . $row[$field];
		if (file_exists($img_path)) {
			@unlink($img_path);
		}
	}
}

$savedir = dirname(__FILE__) . '/../../upload/';
$done = 0;

foreach ($selected_nos as $no) {
	$DB->get("SELECT No, p_id, soldout, imgl, imgm, imgb1, imgb2, imgb3, imgb4, imgb5 FROM $shop_goods WHERE No='$no' LIMIT 1", $rows, $rn);
	if ($rn < 1 || $rows[0]['p_id'] !== 'admin_ai') {
		continue;
	}
	$row = $rows[0];

	if ($action === 'delete') {
		pkshop_ai_delete_images($savedir, $row);
		$DB->delete($shop_goods, " No='$no' AND p_id='admin_ai'");
		$done++;
	} elseif ($action === 'hide') {
		$DB->update($shop_goods, "soldout='Y' WHERE No='$no' AND p_id='admin_ai'");
		$done++;
	} elseif ($action === 'show') {
		$DB->update($shop_goods, "soldout='N' WHERE No='$no' AND p_id='admin_ai'");
		$done++;
	}
}

if ($done < 1) {
	echo "<script>alert('처리된 상품이 없습니다. AI 상품만 선택할 수 있습니다.');history.back();</script>";
	exit;
}

$msg = '처리되었습니다.';
if ($action === 'delete') {
	$msg = $done . '건의 AI 상품이 삭제되었습니다.';
} elseif ($action === 'hide') {
	$msg = $done . '건의 AI 상품이 비공개 처리되었습니다.';
} elseif ($action === 'show') {
	$msg = $done . '건의 AI 상품이 공개 처리되었습니다.';
	$view = 'active';
}

$redirect = 'pro_ai_products.php?view=' . urlencode($view)
	. '&keyfield=' . urlencode($keyfield)
	. '&key=' . urlencode($key)
	. '&page=' . intval($page);

echo "<script>alert('" . addslashes($msg) . "');location.href='" . $redirect . "';</script>";
?>
